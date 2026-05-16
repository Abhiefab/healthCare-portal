<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/signup', [AuthController::class, 'register'])->name('signup.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/doctors', function () {
    return view('doctors.index');
})->name('doctors');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', fn () => abort(404))->name('admin.dashboard');
    Route::get('/doctor/dashboard', fn () => abort(404))->name('doctor.dashboard');
    Route::get('/patient/dashboard', fn () => abort(404))->name('patient.dashboard');
});
