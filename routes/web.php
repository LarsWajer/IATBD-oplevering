<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OppasserController;
use App\Http\Controllers\AangebodenHuisdierController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AanmeldingController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Home page, alleen toegankelijk als je ingelogd bent
Route::get('/', [WelcomeController::class, 'index'],function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('home');

// Dashboard, na het inloggen word je doorgestuurd naar het dashboard (of de welcome screen)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (alleen toegankelijk voor ingelogde gebruikers)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/huisdieren', [AangebodenHuisdierController::class, 'index'])->name('huisdieren.index');
    Route::post('/huisdieren', [AangebodenHuisdierController::class, 'store'])->name('huisdieren.store');
    Route::delete('/huisdieren/{id}', [AangebodenHuisdierController::class, 'destroy'])->name('huisdieren.destroy');
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/huisdieren', [AdminController::class, 'showAllHuisdieren'])->name('admin.huisdieren');
    Route::delete('/admin/huisdier/{id}', [AdminController::class, 'deleteHuisdier'])->name('admin.deleteHuisdier');
    
    Route::get('/admin/users', [AdminController::class, 'showAllUsers'])->name('admin.users');
    Route::delete('/admin/user/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
});

Route::get('/aanmeldingen/create', [AanmeldingController::class, 'create'])->name('aanmeldingen.create');
Route::post('/aanmeldingen', [AanmeldingController::class, 'store'])->name('aanmeldingen.store');
Route::post('/aanmeldingen/{id}/accept', [AanmeldingController::class, 'accept'])->name('aanmeldingen.accept');
Route::post('/aanmeldingen/{id}/reject', [AanmeldingController::class, 'reject'])->name('aanmeldingen.reject');
Route::get('/aanmeld-beheer', [AanmeldingController::class, 'beheer'])->name('aanmeldingen.beheer');

Route::get('/oppassers', [AanmeldingController::class, 'oppassers'])->name('oppassers.index');
// Oppassers routes inclusief reviews
Route::post('/oppassers/{oppasser}/reviews', [OppasserController::class, 'storeReview'])->name('oppassers.storeReview');


// Oppasser routes
Route::resource('oppassers', OppasserController::class);

// Authenticatie routes
require __DIR__.'/auth.php';




