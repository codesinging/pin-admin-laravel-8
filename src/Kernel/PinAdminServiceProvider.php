<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

use CodeSinging\PinAdmin\Console\Commands\AdminCommand;
use CodeSinging\PinAdmin\Console\Commands\ListCommand;
use Illuminate\Support\ServiceProvider;

class PinAdminServiceProvider extends ServiceProvider
{
    /**
     * 控制台命令
     *
     * @var array
     */
    protected array $commands = [
        AdminCommand::class,
        ListCommand::class,
    ];

    /**
     * 注册 PinAdmin 服务
     *
     * @return void
     */
    public function register()
    {
        $this->registerBinding();
    }

    /**
     * 启动 PinAdmin 服务
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()){
            $this->registerCommands();
        }
    }

    /**
     * 绑定服务到容器
     *
     * @return void
     */
    protected function registerBinding()
    {
        $this->app->singleton(PinAdmin::LABEL, PinAdmin::class);
    }

    /**
     * 注册控制台命令
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->commands($this->commands);
    }
}