<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

use CodeSinging\PinAdmin\Kernel\Admin;
use Illuminate\Support\Facades\Route;

Admin::boot('__DUMMY_NAME__')
    ->routeGroup(function () {

        Route::get('auth', [__DUMMY_NAMESPACE__\Controllers\AuthController::class, 'index']);
        Route::post('auth/login', [__DUMMY_NAMESPACE__\Controllers\AuthController::class, 'login']);

    }, false)
    ->routeGroup(function () {

        Route::get('/', [__DUMMY_NAMESPACE__\Controllers\IndexController::class, 'index']);

    }, true);
