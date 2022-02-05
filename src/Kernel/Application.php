<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

use Closure;
use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Application
{
    /**
     * PinAdmin 应用的基础目录
     */
    const BASE_DIRECTORY = PinAdmin::BASE_DIRECTORY;

    /**
     * 应用名称
     *
     * @var string
     */
    protected string $name;

    /**
     * 应用守卫
     *
     * @var string
     */
    protected string $guard;

    /**
     * @var string 应用目录
     */
    protected string $directory;

    /**
     * 应用启动参数
     *
     * @var array
     */
    protected array $options = [];

    /**
     * 应用配置仓库
     *
     * @var Repository
     */
    protected Repository $config;

    /**
     * @param string $name
     * @param array $options
     */
    public function __construct(string $name, array $options = [])
    {
        $this->name = $name;
        $this->options = $options;
        $this->guard = $this->options['guard'] ?? $this->name;
        $this->directory = self::BASE_DIRECTORY . DIRECTORY_SEPARATOR . ($this->options['directory'] ?? Str::studly($name));
        $this->initConfig();
    }

    /**
     * 返回应用名
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * 返回应用守卫
     *
     * @return string
     */
    public function guard(): string
    {
        return $this->guard;
    }

    /**
     * 获取应用目录，相对于 `app` 目录
     *
     * @param ...$paths
     *
     * @return string
     */
    public function directory(...$paths): string
    {
        array_unshift($paths, $this->directory);
        return implode(DIRECTORY_SEPARATOR, $paths);
    }

    /**
     * 获取应用的路径
     *
     * @param ...$paths
     *
     * @return string
     */
    public function path(...$paths): string
    {
        return app_path($this->directory(...$paths));
    }

    /**
     * 获取应用的命名空间
     *
     * @param ...$paths
     *
     * @return string
     */
    public function getNamespace(...$paths): string
    {
        return implode('\\', ['App', str_replace('/', '\\', $this->directory(...$paths))]);
    }

    /**
     * 初始化配置
     *
     * @return void
     */
    protected function initConfig()
    {
        if (file_exists($file = $this->path('config.php'))) {
            $items = require($file);
        }
        $this->config = new Repository($items ?? []);
    }

    /**
     * 获取 PinAdmin 配置值
     *
     * @param string|array|null $key
     * @param null|mixed $default
     *
     * @return mixed|Repository|self
     */
    public function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->config;
        }
        if (is_array($key)) {
            $this->config->set($key);
            return $this;
        }
        return $this->config->get($key, $default);
    }

    /**
     * 返回授权认证的实例
     *
     * @return Guard|StatefulGuard
     */
    public function auth()
    {
        return Auth::guard($this->guard());
    }

    /**
     * 返回认证用户
     *
     * @return Authenticatable|null
     */
    public function user(): ?Authenticatable
    {
        return $this->auth()->user();
    }

    /**
     * 返回认证用户ID
     *
     * @return int|string|null
     */
    public function userId()
    {
        return $this->auth()->id();
    }

    /**
     * 获取应用的路由前缀
     *
     * @return string
     */
    public function routePrefix(): string
    {
        return $this->config('route_prefix', $this->name());
    }

    /**
     * 添加 PinAdmin 应用的路由组
     *
     * @param Closure $closure
     * @param bool $auth
     *
     * @return $this
     */
    public function routeGroup(Closure $closure, bool $auth = true): Application
    {
        $middlewares = array_merge(
            $this->config('middlewares'),
            $auth ? $this->config('auth_middlewares') : $this->config('guest_middlewares')
        );

        Route::middleware($middlewares)
            ->prefix($this->routePrefix())
            ->group(function () use ($closure) {
                call_user_func($closure);
            });

        return $this;
    }

    /**
     * 获取应用的绝对链接地址
     *
     * @param string $path
     * @param array $parameters
     *
     * @return string
     */
    public function link(string $path = '', array $parameters = []): string
    {
        $link = '/' . $this->routePrefix();
        $path and $link .= Str::start($path, '/');
        $parameters and $link .= '?' . http_build_query($parameters);

        return $link;
    }

    /**
     * 返回当前应用的静态文件路径
     *
     * @param string $path
     *
     * @return string
     */
    public function asset(string $path = ''): string
    {
        if (Str::startsWith($path, ['https://', 'http://', '//', '/'])) {
            return $path;
        }

        return '/static/' . Str::kebab($this->directory($path));
    }

    /**
     * 返回带版本号的静态资源文件路径
     *
     * @param string $path
     *
     * @return string
     * @throws Exception
     */
    public function mix(string $path): string
    {
        return mix($path, rtrim($this->asset(), '/'));
    }
}