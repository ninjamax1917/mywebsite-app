<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

//Публичные роуты
Route::get('/', [HomeController::class, 'index']);
