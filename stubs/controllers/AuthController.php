<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace __DUMMY_NAMESPACE__\Controllers;

use CodeSinging\PinAdmin\Routing\Controller;

class AuthController extends Controller
{
    public function index(): string
    {
        return $this->view('auth.index');
    }
}