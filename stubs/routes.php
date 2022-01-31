<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

use CodeSinging\PinAdmin\Kernel\Admin;
use Illuminate\Support\Facades\Route;

Admin::boot('__DUMMY_NAME__')->guestRoutes(function () {

    Route::get('/auth', [__DUMMY_NAMESPACE__\Controllers\AuthController::class, 'index']);

});

Admin::boot('__DUMMY_NAME__')->authRoutes(function () {

    Route::get('/', [__DUMMY_NAMESPACE__\Controllers\IndexController::class, 'index']);

});