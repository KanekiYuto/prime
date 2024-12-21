<?php

use App\Http\Controllers\DevOps\AbilityController;
use App\Http\Controllers\DevOps\Admin\InfoController as AdminInfoController;
use App\Http\Controllers\DevOps\Admin\LogController as AdminLogController;
use App\Http\Controllers\DevOps\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\DevOps\AdminController;
use App\Http\Controllers\DevOps\System\InfoController as SystemInfoController;
use Illuminate\Support\Facades\Route;

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
        )->name('info.')->prefix('info')->group(function () {
            Route::get('paging', 'paging')->name('paging');
            Route::get('select', 'select')->name('select');
            Route::post('append', 'append')->name('append');
            Route::post('modify', 'modify')->name('modify');
        });

        // 管理员角色相关
        Route::controller(
            AdminRoleController::class
        )->name('role.')->prefix('role')->group(function () {
            Route::get('paging', 'paging')->name('paging');
            Route::get('select', 'select')->name('select');
            Route::post('append', 'append')->name('append');
            Route::post('modify', 'modify')->name('modify');
            Route::post('ability', 'ability')->name('ability');
        });

        // 管理员日志相关
        Route::controller(
            AdminLogController::class
        )->name('log.')->prefix('log')->group(function () {
            Route::get('paging', 'paging')->name('paging');
        });
    });

    // 系统相关
    Route::prefix('system')->name('system.')->group(function () {

        // 信息相关
        Route::controller(
            SystemInfoController::class
        )->name('info.')->prefix('info')->group(function () {
            Route::get('base', 'base')->name('base');
        });

    })->withoutMiddleware(['backstage.ability']);

    Route::controller(
        AbilityController::class
    )->prefix('ability')->name('ability.')->group(function () {

        Route::get('rely', 'rely')->name('rely');
        Route::get('abilities', 'abilities')->name('abilities');
        Route::get('groups', 'groups')->name('groups');

    });

});
