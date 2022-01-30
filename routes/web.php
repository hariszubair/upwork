<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/invitation', [App\Http\Controllers\AdminController::class, 'invitation'])->name('invitation');
Route::post('/send_invitation', [App\Http\Controllers\AdminController::class, 'send_invitation'])->name('send_invitation');
Route::get('/invitation_link/{id}', [App\Http\Controllers\InvitationController::class, 'invitation_link'])->name('invitation_link');
Route::post('/send_pin', [App\Http\Controllers\InvitationController::class, 'send_pin'])->name('send_pin');
Route::post('/sign_up', [App\Http\Controllers\InvitationController::class, 'sign_up'])->name('sign_up');
Route::post('/profile_update', [App\Http\Controllers\UserController::class, 'profile_update'])->name('profile_update');
