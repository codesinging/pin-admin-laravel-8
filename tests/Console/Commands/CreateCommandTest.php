<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Console\Commands;

use CodeSinging\PinAdmin\Kernel\Admin;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class CreateCommandTest extends TestCase
{
    protected function tearDown(): void
    {
        File::deleteDirectory(Admin::baseAppPath());
        File::deleteDirectory(Admin::baseAssetDirectory());
    }

    public function testCreate()
    {
        $configFile = config_path(Admin::label('php', '.'));
        if (File::exists($configFile)){
            File::delete($configFile);
        }
        self::assertFileDoesNotExist($configFile);


        $this->artisan('admin:create admin');

        Admin::load('admin')->boot('admin');

        self::assertDirectoryExists(Admin::baseAppPath());
        self::assertFileExists(Admin::baseAppPath('indexes.php'));
        self::assertArrayHasKey('admin', Admin::indexes());

        self::assertDirectoryExists(Admin::appPath());
        self::assertFileExists(Admin::appPath('routes.php'));
        self::assertFileExists(Admin::appPath('config.php'));

        self::assertEquals('Admin', Admin::config('name'));
        self::assertEquals('admin', Admin::config('route_prefix'));

        Admin::config(['route_prefix' => 'admin123']);
        self::assertEquals('admin123', Admin::config('route_prefix'));

        self::assertFileExists($configFile);

        self::assertFileExists(Admin::assetPath('images/logo.svg'));
    }
}
