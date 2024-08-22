<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('/user', UserController::class);
Route::get('/login', function () {
    return view('login');
});
Route::post('authLogin', [LoginController::class, 'login']);
Route::post('ajaxLogin', [LoginController::class, 'ajaxLogin']);
Route::get('/forget', function () {
    return view('forget');
});
Route::post('/forget-password', [LoginController::class, 'passwordReset']);
Route::get('password/reset/{token}', [LoginController::class, 'showResetForm'])->name('resetPassword');
Route::get('/dataView', [LoginController::class, 'dataView'])->name('dataview');
Route::delete('/deleteUser/{id}', [UserController::class, 'delete'])->name('deleteUser');
