<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Kernel;

use CodeSinging\PinAdmin\Kernel\Application;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testName()
    {
        self::assertEquals('admin', (new Application('admin'))->name());
    }

    public function testDirectory()
    {
        $application = new Application('admin');

        self::assertEquals(Application::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin', $application->directory());
        self::assertEquals(Application::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers', $application->directory('Controllers'));
        self::assertEquals(Application::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'IndexController.php', $application->directory('Controllers', 'IndexController.php'));
    }

    public function testPath()
    {
        $application = new Application('admin');

        self::assertEquals(app_path(Application::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin'), $application->path());
        self::assertEquals(app_path(Application::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers'), $application->path('Controllers'));
        self::assertEquals(app_path(Application::BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'IndexController.php'), $application->path('Controllers', 'IndexController.php'));
    }

    public function testNamespace()
    {
        self::assertEquals('App\\PinAdmin\\Admin', (new Application('admin'))->getNamespace());
        self::assertEquals('App\\PinAdmin\\Admin\\Controllers', (new Application('admin'))->getNamespace('Controllers'));
        self::assertEquals('App\\PinAdmin\\Admin\\Controllers\\IndexController.php', (new Application('admin'))->getNamespace('Controllers', 'IndexController.php'));
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
}
