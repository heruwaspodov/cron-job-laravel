<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('users.index');
Route::delete('/destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/redis', function () {
    try {
        Redis::ping();
        return 'Redis is connected.';
    } catch (Exception $e) {
        return 'Failed to connect to Redis: ' . $e->getMessage();
    }
});
