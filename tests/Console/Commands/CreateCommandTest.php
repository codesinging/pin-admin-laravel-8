<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Console\Commands;

use CodeSinging\PinAdmin\Console\Commands\CreateCommand;
use CodeSinging\PinAdmin\Kernel\Admin;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class CreateCommandTest extends TestCase
{
    protected function tearDown(): void
    {
        File::deleteDirectory(Admin::basePath());
    }

    public function testCreate()
    {
        $this->artisan('admin:create admin');

        Admin::boot('admin');

        self::assertDirectoryExists(Admin::basePath());
        self::assertFileExists(Admin::basePath('indexes.php'));
        self::assertArrayHasKey('admin', Admin::indexes());

        self::assertDirectoryExists(Admin::path());
        self::assertFileExists(Admin::path('routes.php'));
        self::assertFileExists(Admin::path('config.php'));

        self::assertEquals('Admin', Admin::config('name'));
    }
}
