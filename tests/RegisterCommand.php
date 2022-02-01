<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests;

use Illuminate\Console\Application;

trait RegisterCommand
{
    /**
     * 创建一个仅供测试的命令
     *
     * @param string $command
     *
     * @return void
     */
    protected function registerCommand(string $command)
    {
        Application::starting(function (Application $artisan) use ($command) {
            $artisan->add(app($command));
        });
    }
}