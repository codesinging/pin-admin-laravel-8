<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

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
     * @param string $name
     * @param array $options
     */
    public function __construct(string $name, array $options = [])
    {
        $this->name = $name;
        $this->options = $options;
        $this->directory = self::BASE_DIRECTORY . DIRECTORY_SEPARATOR . ($this->options['directory'] ?? Str::studly($name));
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
     * 获取 PinAdmin 配置值
     *
     * @param string|null $key
     * @param null|mixed $default
     *
     * @return array|mixed
     */
    public function config(string $key = null, $default = null)
    {
        $name = Admin::label($this->name(), '.');
        if (is_null($key)) {
            return config($name);
        }

        return config($name . '.' . $key, $default);
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
}