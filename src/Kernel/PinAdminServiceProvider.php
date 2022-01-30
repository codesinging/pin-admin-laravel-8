<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

use CodeSinging\PinAdmin\Console\Commands\AdminCommand;
use CodeSinging\PinAdmin\Console\Commands\ApplicationsCommand;
use CodeSinging\PinAdmin\Console\Commands\CreateCommand;
use CodeSinging\PinAdmin\Console\Commands\ListCommand;
use CodeSinging\PinAdmin\Middleware\Boot;
use Illuminate\Routing\Router;
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
        ApplicationsCommand::class,
        CreateCommand::class,
        ListCommand::class,
    ];

    /**
     * PinAdmin 应用中间件
     * @var array|string[]
     */
    protected array $middlewares = [
        'admin.boot' => Boot::class,
    ];

    /**
     * 应用中间件组
     *
     * @var array
     */
    protected array $middlewareGroups = [

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
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }

        if (!$this->app->routesAreCached()){
            $this->loadRoutes();
        }

        $this->registerMiddlewares();
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

    /**
     * 加载应用路由
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $applications = Admin::applications();
        foreach ($applications as $application) {
            $this->loadRoutesFrom($application->path('routes.php'));
        }
    }

    /**
     * 注册中间件
     *
     * @return void
     */
    protected function registerMiddlewares(): void
    {
        /** @var Router $router */
        $router = $this->app['router'];

        foreach ($this->middlewares as $key => $middleware) {
            $router->aliasMiddleware($key, $middleware);
        }

        foreach ($this->middlewareGroups as $key => $middlewareGroup) {
            $router->middlewareGroup($key, $middlewareGroup);
        }
    }
}