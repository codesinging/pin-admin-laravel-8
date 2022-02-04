<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Kernel;

use CodeSinging\PinAdmin\Kernel\Application;
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

    public function testPackagePath()
    {
        $admin = new PinAdmin();

        self::assertEquals(dirname(__DIR__), $admin->packagePath('tests'));
        self::assertEquals(__DIR__, $admin->packagePath('tests', 'Kernel'));
    }

    public function testBaseDirectory()
    {
        $admin = new PinAdmin();

        self::assertEquals(PinAdmin::BASE_DIRECTORY, $admin->baseDirectory());
        self::assertEquals(PinAdmin::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin', $admin->baseDirectory('Admin'));
        self::assertEquals(PinAdmin::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers', $admin->baseDirectory('Admin', 'Controllers'));
    }

    public function testBasePath()
    {
        $admin = new PinAdmin();

        self::assertEquals(app_path(PinAdmin::BASE_DIRECTORY), $admin->basePath());
        self::assertEquals(app_path(PinAdmin::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin'), $admin->basePath('Admin'));
        self::assertEquals(app_path(PinAdmin::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers'), $admin->basePath('Admin', 'Controllers'));
    }

    public function testIsInstalled()
    {
        self::assertIsBool((new PinAdmin())->isInstalled());
    }

    public function testIndexes()
    {
        self::assertIsArray((new PinAdmin())->indexes());
    }

    public function testBoot()
    {
        $admin = new PinAdmin();

        self::assertEmpty($admin->apps());

        $admin->load('admin')->boot('admin');
        self::assertCount(1, $admin->apps());
        self::assertArrayHasKey('admin', $admin->apps());
    }

    public function testApp()
    {
        $admin = new PinAdmin();
        $admin->load('shop');
        $admin->load('admin')->boot('admin');
        self::assertInstanceOf(Application::class, $admin->app());
        self::assertEquals('admin', $admin->app()->name());
        self::assertInstanceOf(Application::class, $admin->app('shop'));
        self::assertEquals('shop', $admin->app('shop')->name());
    }

    public function testApplications()
    {
        $admin = new PinAdmin();

        self::assertEmpty($admin->apps());

        $admin->load('admin')->boot('admin');
        self::assertCount(1, $admin->apps());
        self::assertArrayHasKey('admin', $admin->apps());

        $admin->load('user')->boot('user');
        self::assertCount(2, $admin->apps());
        self::assertArrayHasKey('user', $admin->apps());
    }

    public function testCall()
    {
        $admin = new PinAdmin();
        $admin->load('admin')->boot('admin');

        self::assertEquals('admin', $admin->name());
        self::assertEquals(Application::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin', $admin->directory());

        self::assertEquals('App\\PinAdmin\\Admin', $admin->getNamespace());
        self::assertEquals('App\\PinAdmin\\Admin\\Controllers', $admin->getNamespace('Controllers'));
        self::assertEquals('App\\PinAdmin\\Admin\\Controllers\\IndexController.php', $admin->getNamespace('Controllers', 'IndexController.php'));
    }
}
