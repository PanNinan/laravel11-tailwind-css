<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/setting', static function () {
    return view('setting');
})->name('setting');

Route::get('/', static function () {
    return view('index');
})->name('index');

Route::get('/detail/{id}', static function ($id) {
    return view('detail', ['id' => $id]);
})->name('detail');

Route::get('/msg', [IndexController::class, "addQueue"]);
