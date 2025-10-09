<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectCaseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PagesController;

// Публичные роуты
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [PagesController::class, 'about'])->name('about');

// Обратная связь
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
