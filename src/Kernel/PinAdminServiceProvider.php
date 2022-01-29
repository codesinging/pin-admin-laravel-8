<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

use Illuminate\Support\ServiceProvider;

class PinAdminServiceProvider extends ServiceProvider
{
    /**
     * 注册 PinAdmin 服务
     * @return void
     */
    public function register()
    {
        $this->registerBinding();
    }

    /**
     * 启动 PinAdmin 服务
     * @return void
     */
    public function boot()
    {

    }

    /**
     * 绑定服务到容器
     * @return void
     */
    public function registerBinding()
    {
        $this->app->singleton(PinAdmin::LABEL, PinAdmin::class);
    }
}