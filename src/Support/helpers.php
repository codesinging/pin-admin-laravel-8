<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

use CodeSinging\PinAdmin\Kernel\Admin;
use CodeSinging\PinAdmin\Kernel\PinAdmin;
use Illuminate\Contracts\Foundation\Application;
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
        is_null($name) or $admin->load($name)->boot($name);
        return $admin;
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
     * @return Application|Factory|View
     */
    function admin_view(string $view = null, array $data = [], array $mergeData = [])
    {
        if ($view) {
            $view = Admin::name() . '.' . $view;
        }
        return view($view, $data, $mergeData);
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