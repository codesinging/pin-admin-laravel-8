<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

use Closure;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string label(string $suffix = null, string $separator = '_')
 * @method static string packagePath(...$paths)
 * @method static string baseDirectory(...$paths)
 * @method static string basePath(...$paths)
 * @method static boolean isInstalled()
 * @method static array indexes()
 * @method static PinAdmin load(string $name = null, array $options = [])
 * @method static PinAdmin boot(string $name = null)
 * @method static Application app(string $name = null)
 * @method static Application[] apps()
 * @method static PinAdmin authRoutes(Closure $closure)
 * @method static PinAdmin guestRoutes(Closure $closure)
 * @method static string name()
 * @method static string directory(...$paths)
 * @method static string path(...$paths)
 * @method static string getNamespace(...$paths)
 * @method static mixed|Repository|Application config($key = null, $default = null)
 * @method static string routePrefix()
 * @method static string link(string $path = '', array $parameters = [])
 */
class Admin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PinAdmin::LABEL;
    }
}