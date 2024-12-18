<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backstage\AdminController;
use App\Http\Controllers\Backstage\Admin\LogController as AdminLogController;
use App\Http\Controllers\Backstage\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Backstage\Admin\InfoController as AdminInfoController;
use App\Http\Controllers\Backstage\System\InfoController as SystemInfoController;

Route::middleware(['auth:admin'])->group(function () {

    // 管理员路由组
    Route::prefix('admin')->name('admin.')->group(function () {

        // 管理员相关
        Route::controller(
            AdminController::class
        )->group(function () {
            Route::post('login', 'login')->name('login')->withoutMiddleware(['auth:admin']);
            Route::post('logout', 'logout')->name('name');
            Route::post('account', 'account')->name('account');
            Route::post('email', 'email')->name('email');
            Route::post('pass', 'pass')->name('pass');
            Route::get('info', 'info')->name('info');
        })->withoutMiddleware(['backstage.ability']);

        // 管理员信息相关
        Route::controller(
            AdminInfoController::class
        )->name('info')->prefix('info')->group(function () {
            Route::get('paging', 'paging')->name('paging');
            Route::get('select', 'select')->name('select');
            Route::post('append', 'append')->name('append');
            Route::post('modify', 'modify')->name('modify');
        });

        // 管理员角色相关
        Route::controller(
            AdminRoleController::class
        )->name('role')->prefix('role')->group(function () {
            Route::get('paging', 'paging')->name('paging');
            Route::get('select', 'select')->name('select');
            Route::post('append', 'append')->name('append');
            Route::post('modify', 'modify')->name('modify');
            Route::post('ability', 'ability')->name('ability');
        });

        // 管理员日志相关
        Route::controller(
            AdminLogController::class
        )->name('log')->prefix('log')->group(function () {
            Route::get('paging', 'paging')->name('paging');
        });
    });

    // 系统相关
    Route::prefix('system')->name('system.')->group(function () {

        // 信息相关
        Route::controller(SystemInfoController::class)->group(function () {
            Route::get('base', 'base')->name('base');
        })->name('info')->prefix('info');

    })->withoutMiddleware(['backstage.ability']);

});
