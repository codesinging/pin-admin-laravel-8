<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Middleware;

use Illuminate\Http\Request;

class Guest
{
    public function handle(Request $request, \Closure $next, string $name)
    {
        return $next($request);
    }
}