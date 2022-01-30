<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

use CodeSinging\PinAdmin\Kernel\Admin;
use Illuminate\Support\Facades\Route;

Admin::boot('__DUMMY_NAME__')->guestRoutes(function () {

    Route::get('/', function () {
        dump(Admin::config()->all());
    });

});

Admin::boot('__DUMMY_NAME__')->authRoutes(function () {

});