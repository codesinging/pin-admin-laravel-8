<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Kernel;

use CodeSinging\PinAdmin\Kernel\Application;
use Illuminate\Config\Repository;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testName()
    {
        self::assertEquals('admin', (new Application('admin'))->name());
    }

    public function testAppDirectory()
    {
        $application = new Application('admin');

        self::assertEquals(Application::BASE_APP_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin', $application->appDirectory());
        self::assertEquals(Application::BASE_APP_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers', $application->appDirectory('Controllers'));
        self::assertEquals(Application::BASE_APP_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'IndexController.php', $application->appDirectory('Controllers', 'IndexController.php'));
    }

    public function testAppPath()
    {
        $application = new Application('admin');

        self::assertEquals(app_path(Application::BASE_APP_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin'), $application->appPath());
        self::assertEquals(app_path(Application::BASE_APP_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers'), $application->appPath('Controllers'));
        self::assertEquals(app_path(Application::BASE_APP_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'IndexController.php'), $application->appPath('Controllers', 'IndexController.php'));
    }

    public function testNamespace()
    {
        self::assertEquals('App\\PinAdmin\\Admin', (new Application('admin'))->getNamespace());
        self::assertEquals('App\\PinAdmin\\Admin\\Controllers', (new Application('admin'))->getNamespace('Controllers'));
        self::assertEquals('App\\PinAdmin\\Admin\\Controllers\\IndexController.php', (new Application('admin'))->getNamespace('Controllers', 'IndexController.php'));
    }

    public function testConfig()
    {
        $application = new Application('admin');

        $application->config(['title' => 'Title']);

        self::assertInstanceOf(Repository::class, $application->config());
        self::assertEquals('Title', $application->config('title'));
        self::assertEquals('Default', $application->config('message', 'Default'));
        self::assertNull($application->config('name'));
    }

    public function testRoutePrefix()
    {
        self::assertEquals('admin', (new Application('admin'))->routePrefix());
    }

    public function testLink()
    {
        self::assertEquals('/admin', (new Application('admin'))->link());
        self::assertEquals('/admin/home', (new Application('admin'))->link('home'));
        self::assertEquals('/admin/home?id=1', (new Application('admin'))->link('home', ['id' => 1]));
    }

    public function testResourceDirectory()
    {
        $app = new Application('admin');

        self::assertEquals('pin-admin/admin', $app->resourceDirectory());
        self::assertEquals('pin-admin/admin/js', $app->resourceDirectory('js'));
    }

    public function testAssetDirectory()
    {
        $app = new Application('admin');

        self::assertEquals('static/pin-admin/admin', $app->assetDirectory());
        self::assertEquals('static/pin-admin/admin/images', $app->assetDirectory('images'));
    }

    public function testAsset()
    {
        $app = new Application('admin');

        self::assertEquals('/static/pin-admin/admin/js/app.js', $app->asset('js/app.js'));
    }
}
