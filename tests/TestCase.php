<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests;

use CodeSinging\PinAdmin\Kernel\PinAdminServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            PinAdminServiceProvider::class,
        ];
    }
}