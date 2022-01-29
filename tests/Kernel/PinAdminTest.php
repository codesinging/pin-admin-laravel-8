<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Kernel;

use CodeSinging\PinAdmin\Kernel\PinAdmin;
use Tests\TestCase;

class PinAdminTest extends TestCase
{
    public function testLabel()
    {
        $admin = new PinAdmin();

        self::assertEquals(PinAdmin::LABEL, $admin->label());
        self::assertEquals(PinAdmin::LABEL . '_user', $admin->label('user'));
        self::assertEquals(PinAdmin::LABEL . '-config', $admin->label('config', '-'));
    }
}
