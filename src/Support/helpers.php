<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

use CodeSinging\PinAdmin\Kernel\Application;
use CodeSinging\PinAdmin\Kernel\PinAdmin;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

if (!function_exists('admin')) {
    /**
     * 返回 PinAdmin 实例
     *
     * @param string|null $name
     *
     * @return PinAdmin
     */
    function admin(string $name = null): PinAdmin
    {
        /** @var PinAdmin $admin */
        $admin = app(PinAdmin::LABEL);
        is_null($name) or $admin->boot($name);
        return $admin;
    }
}

if (!function_exists('admin_app')) {
    /**
     * 返回当前或指定应用的实例
     *
     * @param string|null $name
     *
     * @return Application
     */
    function admin_app(string $name = null): Application
    {
        return admin()->app($name);
    }
}

if (!function_exists('admin_config')) {
    /**
     * 设置或获取 PinAdmin 应用配置值
     *
     * @param $key
     * @param $default
     *
     * @return Application|Repository|mixed
     */
    function admin_config($key = null, $default = null)
    {
        return admin_app()->config($key, $default);
    }
}

if (!function_exists('admin_auth')) {
    /**
     * 返回授权认证的实例
     *
     * @return Guard|StatefulGuard
     */
    function admin_auth()
    {
        return admin_app()->auth();
    }
}

if (!function_exists('admin_user')) {
    /**
     * 返回认证用户
     *
     * @return Authenticatable|null
     */
    function admin_user(): ?Authenticatable
    {
        return admin_app()->user();
    }
}

if (!function_exists('admin_user_id')) {
    /**
     * 返回认证用户ID
     *
     * @return int|string|null
     */
    function admin_user_id(): ?Authenticatable
    {
        return admin_app()->userId();
    }
}

if (!function_exists('admin_view')) {
    /**
     * 返回 PinAdmin 应用视图内容
     *
     * @param string|null $view
     * @param array $data
     * @param array $mergeData
     *
     * @return Factory|View
     */
    function admin_view(string $view = null, array $data = [], array $mergeData = [])
    {
        return admin()->view($view, $data, $mergeData);
    }
}

if (!function_exists('admin_template')) {
    /**
     * 获取 PinAdmin 视图模板文件名
     *
     * @param string $path
     *
     * @return string
     */
    function admin_template(string $path): string
    {
        return admin()->template($path);
    }
}

if (!function_exists('success')) {
    /**
     * 返回正确的 json 响应信息
     *
     * @param $message
     * @param $data
     *
     * @return JsonResponse
     */
    function success($message = null, $data = null): JsonResponse
    {
        $code = 0;
        is_string($message) or list($data, $message) = [$message, $data];
        return response()->json(compact('code', 'message', 'data'));
    }
}

if (!function_exists('error')) {
    /**
     * 返回错误的 json 响应信息
     *
     * @param $message
     * @param int $code
     * @param $data
     *
     * @return JsonResponse
     */
    function error($message = null, int $code = -1, $data = null): JsonResponse
    {
        return response()->json(compact('message', 'code', 'data'));
    }
}