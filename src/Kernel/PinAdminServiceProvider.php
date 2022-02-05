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
use CodeSinging\PinAdmin\Middleware\Auth;
use CodeSinging\PinAdmin\Middleware\Boot;
use CodeSinging\PinAdmin\Middleware\Guest;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
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
     *
     * @var array|string[]
     */
    protected array $middlewares = [
        'admin.boot' => Boot::class,
        'admin.auth' => Auth::class,
        'admin.guest' => Guest::class,
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
            $this->exportConfiguration();
        }

        if (!$this->app->routesAreCached()) {
            $this->loadRoutes();
        }

        $this->loadViews();

        $this->registerMiddlewares();
        $this->configureAuthentication();
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
        $applications = Admin::apps();
        foreach ($applications as $application) {
            $this->loadRoutesFrom($application->path('routes.php'));
        }
    }

    /**
     * 加载应用视图
     *
     * @return void
     */
    protected function loadViews()
    {
        $this->loadViewsFrom(Admin::packagePath('resources', 'views'), Admin::label());
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

    /**
     * 配置授权认证的守卫和提供者
     *
     * @return void
     */
    protected function configureAuthentication()
    {
        $applications = Admin::apps();

        foreach ($applications as $name => $application) {
            Config::set('auth.guards.' . $application->guard(), $application->config('auth_guard'));
            Config::set('auth.providers.' . $application->config('auth_guard.provider'), $application->config('auth_provider'));
        }
    }

    /**
     * 导出配置文件
     *
     * @return void
     */
    protected function exportConfiguration()
    {
        $this->publishes([
            Admin::packagePath('config/admin.php') => config_path(Admin::label('php', '.')),
        ], Admin::label('config', '-'));
    }
}