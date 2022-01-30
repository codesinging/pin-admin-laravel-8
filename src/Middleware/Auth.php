<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Middleware;

use Closure;
use CodeSinging\PinAdmin\Kernel\Admin;
use Exception;
use Illuminate\Auth\Middleware\Authenticate;

class Auth extends Authenticate
{
    /**
     * @throws Exception
     */
    protected function redirectTo($request): ?string
    {
        if ($request->expectsJson()) {
            throw new Exception('Not authenticated');
        }

        return Admin::link('auth');
    }
}