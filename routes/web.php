<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\Auth\LoginRegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buku', [BukuController::class, 'index']);
Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
Route::get('/buku/edit/{id}}', [BukuController::class, 'edit'])->name('buku.edit');
Route::post('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');

Route::controller (LoginRegisterController::class)->group (function () {
Route::get('/register', 'register')->name('register');
Route::post('/store', 'store')->name('store');
Route::get('/login', 'login')->name('login');
Route::post('/authenticate', 'authenticate')->name('authenticate');
Route::get('/dashboard', 'dashboard')->name('dashboard');
Route::post('/logout', 'logout')->name('logout');
});