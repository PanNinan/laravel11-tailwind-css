<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('index');
})->name('index');
Route::get('/demo', static function () {
    return view('demo');
});

Route::get('/detail/{id}', static function ($id) {
    return view('detail', ['id' => $id]);
})->name('detail');

Route::get('/msg', [IndexController::class, "addQueue"]);
