<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Middleware;

use Closure;
use CodeSinging\PinAdmin\Kernel\Admin;
use Illuminate\Http\Request;

class Boot
{
    public function handle(Request $request, Closure $next, string $name)
    {
        Admin::boot($name);

        return $next($request);
    }
}