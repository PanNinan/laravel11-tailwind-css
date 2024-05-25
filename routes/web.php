<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/setting', [IndexController::class, 'setting'])->name('setting');
Route::post('/setting', [IndexController::class, 'settingStore'])->name('put-setting');

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/detail/{id}', [IndexController::class, 'show'])->name('detail');

