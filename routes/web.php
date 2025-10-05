<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectCaseController;

// Публичные роуты
Route::get('/', [HomeController::class, 'index'])->name('home');

// Проекты (кейсы)
Route::get('/projects', [ProjectCaseController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectCaseController::class, 'show'])->name('projects.show');
