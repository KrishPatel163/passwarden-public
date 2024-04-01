<?php

namespace App\Http\Controllers;

use App\Mail\DemoMail;
use Illuminate\Http\Request;
use App\Models\UsersPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class PasswordController extends Controller
{
    public function deletePassword(UsersPassword $password, Request $request)
    {
        $expiryTime = session('expiry');
        if (now()->lessThanOrEqualTo($expiryTime)) {
            $request->validate([
                'password' => 'required',
                'otp' => 'required',
            ]);
            $decryptedPassword = Crypt::decryptString($password->password);

            if ($decryptedPassword === $request->password && $request->otp === session('otp')) {
                $password->delete();
                session()->forget(['otp', 'expiry']);
                return redirect('/home')->with('success','Password deleted successfully');
            } else {
                return "not matched";
            }
        } else {
            return "Otp is expired request new one";
        }
    }
    public function showDeleteForm(UsersPassword $password)
    {
        if ($this->authorize('delete', $password)) {
            $otp = $this->generateOTP(7);

            $mailData = [
                'to' => auth()->user()->email,
                'from' => env('MAIL_FROM_ADDRESS'),
                'title' => 'Password Delete Request Invoked',
                'body' => 'A One Time Password (OTP) to delete your password ',
                'otp' => $otp,
            ];
            session(['otp' => $otp, 'expiry' => now()->addMinutes(5)]);
            $mailData = Mail::to(auth()->user()->email)->send(new DemoMail($mailData));

            return view('delete', ['password' => $password, 'mailData' => $mailData]);
        }
    }
    public function updatePassword(UsersPassword $password, Request $request)
    {
        $expiryTime = session('expiry');
        if (now()->lessThanOrEqualTo($expiryTime)) {
            if ($request->otp === session('otp')) {
                $Fields = $request->validate([
                    'account_name' => 'required',
                    'password' => 'required'
                ]);

                $Fields['account_name'] = strip_tags($Fields['account_name']);
                $Fields['password'] = Crypt::encryptString($Fields['password'], env('ENC_KEY'));

                $result = $password->update($Fields);
                session()->forget(['otp', 'expiry']);
                return redirect('/home')->with('success','Password updated successfully');
                // return [$Fields, Crypt::decryptString($Fields['password']),env('ENC_KEY')];
            } else {
                return "otp not correct";
            }
        } else {
            return "otp expired";
        }
    }
    public function showUpdateForm(UsersPassword $password)
    {
        if ($this->authorize('update', $password)) {

            $otp = $this->generateOTP(7);

            $mailData = [
                'to' => auth()->user()->email,
                'from' => env('MAIL_FROM_ADDRESS'),
                'title' => 'Password Update Invoked',
                'body' => 'A One Time Password (OTP) to update your password ',
                'otp' => $otp,
            ];

            session(['otp' => $otp, 'expiry' => now()->addMinutes(5)]);
            $Mail = Mail::to(auth()->user()->email)->send(new DemoMail($mailData));

            return view('update', ['password' => $password, 'mailData' => $mailData]);
        }
    }
    public function storePassword(Request $request)
    {
        $fields = $request->validate([
            'website' => 'required',
            'account_name' => 'required',
            'password' => 'required',
        ]);

        $fields['website'] = strip_tags($fields['website']);
        $fields['password'] = strip_tags($fields['password']);

        $fields['password'] = Crypt::encryptString($fields['password'], env('ENC_KEY'));

        $fields['users_id'] = auth()->id();

        // return [$fields, Crypt::decryptString($fields['password'],env('ENC_KEY'))];
        $stored = UsersPassword::create($fields);
        return back()->with('success','Password Stored Successfully');
    }

    public function decryptPassword(Request $request)
    {
        $decryptedPassword = Crypt::decryptString($request['pass'], env('ENC_KEY'));
        return response()->json(['password' => $decryptedPassword]);
    }
    public static function generateOTP($length =  6)
    {
        // Ensure the length is at least  1
        $length = max(1, $length);

        // Define the characters that can be used in the OTP
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // Generate a random OTP
        $otp = '';
        for ($i =  0; $i < $length; $i++) {
            // Generate a random index for the characters string
            $index = random_int(0, strlen($characters) -  1);
            // Append the character at the random index to the OTP
            $otp .= $characters[$index];
        }

        return $otp;
    }
}
