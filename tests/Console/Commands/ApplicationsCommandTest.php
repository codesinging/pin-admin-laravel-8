<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Console\Commands;

use CodeSinging\PinAdmin\Console\Commands\ApplicationsCommand;
use Tests\TestCase;

class ApplicationsCommandTest extends TestCase
{
    public function testCommand()
    {
        $this->artisan('admin:apps')->assertExitCode(0);
    }
}
