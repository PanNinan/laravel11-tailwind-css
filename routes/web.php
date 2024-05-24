<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/setting', [IndexController::class, 'setting'])->name('setting');

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/detail/{id}', [IndexController::class, 'show'])->name('detail');

