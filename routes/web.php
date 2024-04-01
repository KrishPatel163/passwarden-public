<?php

use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\UsersPassword;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//View Routes Are Here
Route::get('/register', function () {
    return view('register');
})->middleware('guest');
Route::get('/', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::get('/home', [UserController::class, 'showHomePage'])->middleware('auth');

// Login Register routes
Route::post('/register', [UserController::class, 'actionRegister'])->middleware('guest');

Route::post('/login', [UserController::class, 'actionLogin'])->middleware('guest');

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//Password Related Routes
Route::post('/create-pass', [PasswordController::class, 'storePassword'])->middleware('auth');
Route::post('/decrypt', [PasswordController::class, 'decryptPassword'])->middleware('auth');

Route::get('/updating/{password}',[PasswordController::class,'showUpdateForm'])->middleware(['auth', 'throttle: 1,5']);
Route::put('/update-userpass/{password}',[PasswordController::class,'updatePassword']);

Route::get('/deleteing/{password}',[PasswordController::class,'showDeleteForm'])->middleware(['auth', 'throttle: 1,5']);
Route::delete('/delete/{password}',[PasswordController::class,'deletePassword']);

Route::get('/sendMail',[UserController::class,'sendMail'])->middleware('throttle: 1,5');
Route::get('/sm', [UserController::class,'test']);