<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string label(string $suffix = null, string $separator = '_')
 * @method static string packagePath(...$paths)
 * @method static string baseDirectory(...$paths)
 * @method static string basePath(...$paths)
 * @method static boolean isInstalled()
 * @method static array indexes()
 * @method static Application boot(string $name = null)
 * @method static Application application()
 * @method static Application[] applications()
 * @method static string name()
 * @method static string directory(...$paths)
 * @method static string path(...$paths)
 * @method static string getNamespace(...$paths)
 * @method static string routePrefix()
 * @method static string link(string $path = '', array $parameters = [])
 * @method static array|mixed config(string $key = null, $default = null)
 */
class Admin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PinAdmin::LABEL;
    }
}