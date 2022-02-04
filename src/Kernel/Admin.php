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
 * @method static Application boot(string $name)
 * @method static Application app(string $name = null)
 * @method static Application[] apps()
 * @method static Application routeGroup(Closure $closure, bool $auth = true)
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