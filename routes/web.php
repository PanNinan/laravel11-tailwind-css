<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response('Hello World');
});

Route::get('/msg', [IndexController::class, "addQueue"]);
