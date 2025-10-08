<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectCaseController;
use App\Http\Controllers\ContactController;

// Публичные роуты
Route::get('/', [HomeController::class, 'index'])->name('home');

// Обратная связь
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
