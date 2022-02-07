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
        self::assertEquals(PinAdmin::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'admin', $admin->baseDirectory('admin'));
        self::assertEquals(PinAdmin::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'config', $admin->baseDirectory('admin', 'config'));
    }

    public function testBasePath()
    {
        $admin = new PinAdmin();

        self::assertEquals(base_path(PinAdmin::BASE_DIRECTORY), $admin->basePath());
        self::assertEquals(base_path(PinAdmin::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'admin'), $admin->basePath('admin'));
        self::assertEquals(base_path(PinAdmin::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'config'), $admin->basePath('admin', 'config'));
    }

    public function testBaseAppDirectory()
    {
        $admin = new PinAdmin();

        self::assertEquals(PinAdmin::BASE_APP_DIRECTORY, $admin->baseAppDirectory());
        self::assertEquals(PinAdmin::BASE_APP_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin', $admin->baseAppDirectory('Admin'));
        self::assertEquals(PinAdmin::BASE_APP_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers', $admin->baseAppDirectory('Admin', 'Controllers'));
    }

    public function testBaseAppPath()
    {
        $admin = new PinAdmin();

        self::assertEquals(app_path(PinAdmin::BASE_APP_DIRECTORY), $admin->baseAppPath());
        self::assertEquals(app_path(PinAdmin::BASE_APP_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin'), $admin->baseAppPath('Admin'));
        self::assertEquals(app_path(PinAdmin::BASE_APP_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers'), $admin->baseAppPath('Admin', 'Controllers'));
    }

    public function testBasePublicDirectory()
    {
        $admin = new PinAdmin();

        self::assertEquals('pin-admin', $admin->basePublicDirectory());
        self::assertEquals('pin-admin/admin', $admin->basePublicDirectory('admin'));
        self::assertEquals('pin-admin/admin/images', $admin->basePublicDirectory('admin', 'images'));
    }

    public function testBasePublicPath()
    {
        $admin = new PinAdmin();

        self::assertEquals(public_path('pin-admin'), $admin->basePublicPath());
        self::assertEquals(public_path('pin-admin/admin'), $admin->basePublicPath('admin'));
        self::assertEquals(public_path('pin-admin/admin/images'), $admin->basePublicPath('admin', 'images'));
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
        self::assertEquals(Application::BASE_APP_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin', $admin->appDirectory());

        self::assertEquals('App\\PinAdmin\\Admin', $admin->getNamespace());
        self::assertEquals('App\\PinAdmin\\Admin\\Controllers', $admin->getNamespace('Controllers'));
        self::assertEquals('App\\PinAdmin\\Admin\\Controllers\\IndexController.php', $admin->getNamespace('Controllers', 'IndexController.php'));
    }
}
