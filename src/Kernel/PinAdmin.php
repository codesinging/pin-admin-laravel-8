<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

class PinAdmin
{
    /**
     * PinAdmin 版本号
     */
    const VERSION = '0.2.0';

    /**
     * PinAdmin 标记
     */
    const LABEL = 'admin';

    /**
     * PinAdmin 品牌名称
     */
    const BRAND = 'PinAdmin';

    /**
     * PinAdmin 品牌 Slogan
     */
    const SLOGAN = 'A Laravel package to rapidly build administrative applications';

    /**
     * PinAdmin 应用基础目录，相对于 `app`
     */
    const BASE_DIRECTORY = 'PinAdmin';

    /**
     * 应用索引文件名
     *
     * @var string
     */
    protected static string $indexFilename = 'indexes.php';

    /**
     * 所有的 PinAdmin 应用实例
     *
     * @var Application[]
     */
    protected array $applications = [];

    /**
     * 当前路由所在的 PinAdmin 应用
     *
     * @var Application
     */
    protected Application $application;

    /**
     * 获取 PinAdmin 标记
     *
     * @param string|null $suffix
     * @param string $separator
     *
     * @return string
     */
    public function label(string $suffix = null, string $separator = '_'): string
    {
        return self::LABEL . ($suffix ? $separator . $suffix : '');
    }

    /**
     * 获取 PinAdmin 包路径
     *
     * @param ...$paths
     *
     * @return string
     */
    public function packagePath(...$paths): string
    {
        array_unshift($paths, dirname(__DIR__, 2));
        return implode(DIRECTORY_SEPARATOR, $paths);
    }

    /**
     * 返回 PinAdmin 基础目录，相对于 `app`
     *
     * @param ...$paths
     *
     * @return string
     */
    public function baseDirectory(...$paths): string
    {
        array_unshift($paths, self::BASE_DIRECTORY);
        return implode(DIRECTORY_SEPARATOR, $paths);
    }

    /**
     * 返回 PinAdmin 的基础路径
     *
     * @param ...$paths
     *
     * @return string
     */
    public function basePath(...$paths): string
    {
        return app_path($this->baseDirectory(...$paths));
    }

    /**
     * 是否已经安装 PinAdmin 包
     *
     * @return bool
     */
    public function isInstalled(): bool
    {
        return file_exists($this->basePath(self::$indexFilename));
    }

    /**
     * 返回应用索引数据
     *
     * @return array
     */
    public function indexes(): array
    {
        if ($this->isInstalled()) {
            return include($this->basePath(self::$indexFilename));
        }
        return [];
    }

    /**
     * 启动指定名称的 PinAdmin 应用
     *
     * @param string $name
     * @param array $configs
     *
     * @return $this
     */
    public function boot(string $name, array $configs = []): self
    {
        empty($this->applications[$name]) and $this->applications[$name] = new Application($name, $configs);
        $this->application = $this->applications[$name];
        return $this;
    }

    /**
     * 返回当前 PinAdmin 应用
     *
     * @return Application
     */
    public function application(): Application
    {
        return $this->application;
    }

    /**
     * 返回所有 PinAdmin 应用
     *
     * @return Application[]
     */
    public function applications(): array
    {
        return $this->applications;
    }

    /**
     * 初始化所有应用
     *
     * @return void
     */
    protected function initialize()
    {
        foreach ($this->indexes() as $name => $options) {
            if ($options['status']) {
                $this->boot($name, $options);
            }
        }
    }

    /**
     * 调用 PinAdmin 应用的方法
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->application->$name(...$arguments);
    }
}