<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorAvailabilityController;
use App\Http\Controllers\DoctorProfileController;
use App\Http\Controllers\PatientMedicalProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/signup', [AuthController::class, 'signupForm'])->name('signup');

Route::post('/signup', [AuthController::class, 'register'])->name('signup.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors');

Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::post('/admin/doctors', [AdminDoctorController::class, 'store'])->name('admin.doctors.store');
    Route::put('/admin/doctors/{doctor}', [AdminDoctorController::class, 'update'])->name('admin.doctors.update');
    Route::delete('/admin/doctors/{doctor}', [AdminDoctorController::class, 'destroy'])->name('admin.doctors.destroy');

    Route::get('/doctor/dashboard', [DashboardController::class, 'doctor'])->name('doctor.dashboard');
    Route::put('/doctor/profile', [DoctorProfileController::class, 'update'])->name('doctor.profile.update');
    Route::post('/doctor/availability', [DoctorAvailabilityController::class, 'store'])->name('doctor.availability.store');
    Route::delete('/doctor/availability/{availability}', [DoctorAvailabilityController::class, 'destroy'])->name('doctor.availability.destroy');

    Route::get('/patient/dashboard', [DashboardController::class, 'patient'])->name('patient.dashboard');
    Route::put('/patient/medical-profile', [PatientMedicalProfileController::class, 'update'])->name('patient.medical-profile.update');
    Route::post('/patient/appointments/{doctor}', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');

});
