<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace __DUMMY_NAMESPACE__\Controllers;

use CodeSinging\PinAdmin\Kernel\Admin;
use CodeSinging\PinAdmin\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return page('auth/index');
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required']
        ]);

        if (Admin::auth()->attempt($credentials)) {
            return $this->success('登录成功');
        }

        if (!Admin::user()['status']) {
            return $this->error('用户状态异常');
        }

        return $this->error('账号和密码不匹配');
    }
}