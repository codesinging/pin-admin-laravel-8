<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Routing;

use CodeSinging\PinAdmin\Kernel\Admin;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

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
     * @return Application|Factory|View
     */
    protected function view(string $view = null, array $data = [], array $mergeData = [])
    {
        if ($view) {
            $view = Admin::name() . '.' . $view;
        }
        return view($view, $data, $mergeData);
    }
}