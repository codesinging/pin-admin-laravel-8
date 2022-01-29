<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Console\Commands;

use CodeSinging\PinAdmin\Console\Commands\ListCommand;
use Tests\TestCase;

class ListCommandTest extends TestCase
{
    public function testCommand()
    {
        $this->artisan('admin:list')->assertExitCode(0);
    }
}
