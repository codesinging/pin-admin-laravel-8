<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Kernel;

use CodeSinging\PinAdmin\Kernel\PinAdmin;
use Tests\TestCase;

class PinAdminServiceProviderTest extends TestCase
{
    public function testService()
    {
        self::assertInstanceOf(PinAdmin::class, app(PinAdmin::LABEL));
    }

    public function testSingleton()
    {
        self::assertSame(app(PinAdmin::LABEL), app(PinAdmin::LABEL));
    }
}
