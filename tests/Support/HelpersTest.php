<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Support;

use CodeSinging\PinAdmin\Kernel\PinAdmin;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    public function test_admin()
    {
        self::assertInstanceOf(PinAdmin::class, admin());
        self::assertSame(admin(), admin());

        self::assertEquals('admin', admin('admin')->name());
    }
}