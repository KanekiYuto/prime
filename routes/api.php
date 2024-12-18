<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backstage\AdminController;

Route::controller(
    AdminController::class
)->prefix('test')->name('test')->group(function () {

    Route::get('info', 'info');

});
