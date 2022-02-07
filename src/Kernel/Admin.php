<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

use Closure;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string label(string $suffix = null, string $separator = '_')
 * @method static string packagePath(...$paths)
 * @method static string baseAppDirectory(...$paths)
 * @method static string baseAppPath(...$paths)
 * @method static string baseAssetDirectory(...$paths)
 * @method static string baseAssetPath(...$paths)
 * @method static string baseResourceDirectory(...$paths)
 * @method static string baseResourcePath(...$paths)
 * @method static boolean isInstalled()
 * @method static array indexes()
 * @method static PinAdmin load(string $name = null, array $options = [])
 * @method static PinAdmin boot(string $name)
 * @method static Application app(string $name = null)
 * @method static Application[] apps()
 * @method static string template(string $path)
 * @method static Factory|View view(string $view = null, array $data = [], array $mergeData = [])
 * @method static Factory|View page(string $view = null, array $data = [])
 * @method static JsonResponse success($message = null, $data = null)
 * @method static JsonResponse error(string $message = null, int $code = -1, $data = null)
 * @method static Application routeGroup(Closure $closure, bool $auth = true)
 * @method static string name()
 * @method static string directory(...$paths)
 * @method static string path(...$paths)
 * @method static string getNamespace(...$paths)
 * @method static mixed|Repository|Application config($key = null, $default = null)
 * @method static Guard|StatefulGuard auth()
 * @method static Authenticatable|null user()
 * @method static int|string|null userId()
 * @method static string routePrefix()
 * @method static string link(string $path = '', array $parameters = [])
 * @method static string resourceDirectory(...$paths)
 * @method static string resourcePath(...$paths)
 * @method static string assetDirectory(...$paths)
 * @method static string assetPath(...$paths)
 * @method static string asset(string $path = '')
 * @method static string mix(string $path)
 */
class Admin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PinAdmin::LABEL;
    }
}