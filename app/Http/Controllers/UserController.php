<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\DemoMail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function test()
    {
        $user = User::find(auth()->user()->id);
        $passwords = $user->userPasswords()->orderBy('website', 'asc')->latest()->get();
        $groupedBy = $passwords->groupBy(function($password){
            return $password->website[0];
        });
        $countPass = $passwords->count();
        return view('test', [
            'groupedBy' => $groupedBy,
            'data' => $passwords,
            'count' => $countPass,
        ]);
    }
    public function checkOtp(Request $request)
    {
        $sessionOTP = session('otp');
        $userOTP = $request['otp'];

        // return [$sessionOTP, $userOTP];

        if ($sessionOTP === $userOTP) {
            return "success";
        } else {
            return "failed";
        }
    }
    public function sendMail(Request $request)
    {
        $otp = PasswordController::generateOtp(7);

        $mailData = [
            'to' => auth()->user()->email,
            'from' => env('MAIL_FROM_NAME'),
            'title' => 'Password change One Time Password Request Invoked',
            'body' => 'a one time password to change your password ',
            'otp' => $otp,
        ];
        session(['otp' => $otp]);
        $mail = Mail::to(auth()->user()->email)->send(new DemoMail($mailData));

        // dd($mail);

        return view('test', ['maildata' => $mailData]);
    }
    public function showHomePage()
    {
        $user = User::find(auth()->user()->id);
        $passwords = $user->userPasswords()->latest()->get();
        $countPass = $passwords->count();
        return view('home', [
            'data' => $passwords,
            'count' => $countPass,
        ])->with('success', "Hello " . auth()->user()->name . ",welcome to passwarden");
    }
    public function actionLogin(Request $request)
    {
        $Fields = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt(['name' => $Fields['name'], 'password' => $Fields['password']])) {
            $request->session()->regenerate();
            return redirect('/home')->with('success', "Hello " . auth()->user()->name . ",welcome to passwarden");
        } else {
            return back()->with('failed', "invalid credentials");
        }
        // return $request;
    }


    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }


    public function actionRegister(Request $request)
    {
        // return $request;
        $Fields = $request->validate([
            'name' => ['required', 'min: 3', 'max:10', Rule::unique('user', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['confirmed', 'required', 'min:3', 'max:200']
        ]);

        $Fields['password'] = bcrypt($Fields['password']);
        $user = User::create($Fields);
        auth()->login($user);

        return redirect('/home');
    }
}
