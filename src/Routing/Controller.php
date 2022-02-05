<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Routing;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;

class Controller extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 返回视图内容
     *
     * @param string|null $view
     * @param array $data
     * @param array $mergeData
     *
     * @return Factory|View
     */
    protected function view(string $view = null, array $data = [], array $mergeData = [])
    {
        return admin_view($view, $data, $mergeData);
    }

    /**
     * 返回正确的 json 响应信息
     *
     * @param $message
     * @param $data
     *
     * @return JsonResponse
     */
    protected function success($message = null, $data = null): JsonResponse
    {
        return success($message, $data);
    }

    /**
     * 返回错误的 json 响应信息
     *
     * @param $message
     * @param int $code
     * @param $data
     *
     * @return JsonResponse
     */
    protected function error($message = null, int $code = -1, $data = null): JsonResponse
    {
        return error($message, $code, $data);
    }
}