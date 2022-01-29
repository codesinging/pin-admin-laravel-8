<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Console\Commands;

use CodeSinging\PinAdmin\Console\Commands\AdminCommand;
use Tests\TestCase;

class AdminCommandTest extends TestCase
{
    public function testCommand()
    {
        $this->artisan('admin')->assertExitCode(0);
    }
}
