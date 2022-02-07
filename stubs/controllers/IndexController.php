<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace __DUMMY_NAMESPACE__\Controllers;

use CodeSinging\PinAdmin\Routing\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return page('index.index');
    }
}