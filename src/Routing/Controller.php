<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Routing;

use CodeSinging\PinAdmin\Kernel\Admin;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 解析 views 目录中当前应用目录下的模板，并返回渲染后的内容
     *
     * @param string|null $view
     * @param array $data
     * @param array $mergeData
     *
     * @return Factory|View
     */
    protected function view(string $view = null, array $data = [], array $mergeData = [])
    {
        is_null($view) or $view = Admin::name() . '.' . $view;
        return view($view, $data, $mergeData);
    }

    /**
     * 解析当前应用的单文件组件，并返回渲染后的内容
     *
     * @param string $page
     * @param array $data
     *
     * @return Factory|View
     */
    protected function page(string $page, array $data = [])
    {
        return Admin::page($page, $data);
    }

    protected function success($message = null, $data = null)
    {
        return
    }
}