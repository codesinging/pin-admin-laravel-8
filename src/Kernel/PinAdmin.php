<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

/**
 * @method string name()
 * @method string directory(...$paths)
 * @method string appDirectory(...$paths)
 * @method string publicDirectory(...$paths)
 * @method string path(...$paths)
 * @method string appPath(...$paths)
 * @method string publicPath(...$paths)
 * @method string getNamespace(...$paths)
 * @method array|mixed config(string $key = null, $default = null)
 * @method Guard|StatefulGuard auth()
 * @method Authenticatable|null user()
 * @method int|string|null userId()
 * @method string routePrefix()
 * @method Application routeGroup(Closure $closure, bool $auth = true)
 * @method string link(string $path = '', array $parameters = [])
 * @method string asset(string $path = '')
 * @method string mix(string $path)
 * @method string homeUrl(boolean $withDomain = false)
 */
class PinAdmin
{
    /**
     * PinAdmin 版本号
     */
    const VERSION = '0.3.0';

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
     * PinAdmin 应用基础目录，相对于 `base_path`
     */
    const BASE_DIRECTORY = 'admin';

    /**
     * PinAdmin 应用类基础目录，相对于 `app_path`
     */
    const BASE_APP_DIRECTORY = 'PinAdmin';

    /**
     * PinAdmin 应用公共文件基础目录，相对于 `public_path`
     */
    const BASE_PUBLIC_DIRECTORY = 'pin-admin';

    /**
     * 所有的 PinAdmin 应用实例
     *
     * @var Application[]
     */
    protected array $apps = [];

    /**
     * 当前路由所在的 PinAdmin 应用
     *
     * @var Application
     */
    protected Application $app;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->initialize();
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
                $this->load($name, $options);
            }
        }
    }

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
     * 返回 PinAdmin 应用基础目录，相对于 `base_path`
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
     * 返回 PinAdmin 应用类基础目录，相对于 `app_path`
     *
     * @param ...$paths
     *
     * @return string
     */
    public function baseAppDirectory(...$paths): string
    {
        array_unshift($paths, self::BASE_APP_DIRECTORY);
        return implode(DIRECTORY_SEPARATOR, $paths);
    }

    /**
     * 返回 PinAdmin 应用基础路径
     *
     * @param ...$paths
     *
     * @return string
     */
    public function basePath(...$paths): string
    {
        return base_path($this->baseDirectory(...$paths));
    }

    /**
     * 返回 PinAdmin 应用类基础路径
     *
     * @param ...$paths
     *
     * @return string
     */
    public function baseAppPath(...$paths): string
    {
        return app_path($this->baseAppDirectory(...$paths));
    }

    /**
     * 返回应用的公共文件基础目录，相对于 `public_path`
     *
     * @param ...$paths
     *
     * @return string
     */
    public function basePublicDirectory(...$paths): string
    {
        array_unshift($paths, self::BASE_PUBLIC_DIRECTORY);
        return implode('/', $paths);
    }

    /**
     * 返回应用的公共文件基础路径
     *
     * @param ...$paths
     *
     * @return string
     */
    public function basePublicPath(...$paths): string
    {
        return public_path($this->basePublicDirectory(...$paths));
    }

    /**
     * 是否已经安装 PinAdmin 包
     *
     * @return bool
     */
    public function isInstalled(): bool
    {
        return file_exists($this->basePath('apps.php'));
    }

    /**
     * 返回应用索引数据
     *
     * @return array
     */
    public function indexes(): array
    {
        if ($this->isInstalled()) {
            return include($this->basePath('apps.php'));
        }
        return [];
    }

    /**
     * 初始化指定名称的 PinAdmin 应用
     *
     * @param string $name
     * @param array $options
     *
     * @return $this
     */
    public function load(string $name, array $options = []): PinAdmin
    {
        if (empty($this->apps[$name])) {
            $this->apps[$name] = new Application($name, $options);
        }
        return $this;
    }

    /**
     * 启动指定名称的 PinAdmin 应用
     *
     * @param string $name
     *
     * @return $this
     */
    public function boot(string $name): PinAdmin
    {
        $this->app = $this->load($name)->apps[$name];
        return $this;
    }

    /**
     * 返回指定或者当前 PinAdmin 应用
     *
     * @param string|null $name
     *
     * @return Application
     */
    public function app(string $name = null): Application
    {
        return is_null($name) ? $this->app : $this->apps[$name];
    }

    /**
     * 返回所有 PinAdmin 应用
     *
     * @return Application[]
     */
    public function apps(): array
    {
        return $this->apps;
    }

    /**
     * 返回 PinAdmin 视图模板文件名
     *
     * @param string $path
     *
     * @return string
     */
    public function template(string $path): string
    {
        return $this->label($path, '::');
    }

    /**
     * 返回 PinAdmin 视图内容
     *
     * @param string|null $view
     * @param array $data
     * @param array $mergeData
     *
     * @return Factory|View
     */
    public function view(string $view = null, array $data = [], array $mergeData = [])
    {
        empty($view) or $view = $this->template($view);
        return view($view, $data, $mergeData);
    }

    /**
     * 返回 PinAdmin 的 Vue 组件形式的视图内容
     *
     * @param string $page
     *
     * @return Factory|View
     */
    public function page(string $page)
    {
        return $this->view('public/page', compact('page'));
    }

    /**
     * 返回正确的 json 响应信息
     *
     * @param string|array|Collection|Model $message
     * @param $data
     *
     * @return JsonResponse
     */
    public function success($message = null, $data = null): JsonResponse
    {
        $code = 0;
        is_string($message) or list($data, $message) = [$message, $data];
        return response()->json(compact('code', 'message', 'data'));
    }

    /**
     * 返回错误的 json 响应信息
     *
     * @param string|null $message
     * @param int $code
     * @param null $data
     *
     * @return JsonResponse
     */
    public function error(string $message = null, int $code = -1, $data = null): JsonResponse
    {
        return response()->json(compact('message', 'code', 'data'));
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
        return $this->app->$name(...$arguments);
    }
}