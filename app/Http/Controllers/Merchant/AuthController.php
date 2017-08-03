<?php

namespace App\Http\Controllers\Merchant;

use App\Models\FcUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    use AuthenticatesUsers;

    /**
     * 自定义 商户后台Guard
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard($this->guard);
    }

    /**
     * 使用username替代原始的email
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * 修改原始跳转链接
     * @return string
     */
    protected function redirectTo()
    {
        return '/merchant';
    }

    /**
     * 打开登录页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function authenticate(){
        return view('merchant.auth.login');
    }

    /**
     * 注册
     * @return mixed
     */
    public function register()
    {
        $salt = genSalt();
        $password = '123456';

        return FcUsers::create([
            'username' => 'face',
            'password' => bcrypt($password . $salt),
            'salt' => $salt
        ]);
    }

    /**
     * 检测登录是否正常
     * @return \Illuminate\Http\JsonResponse
     */
    public function check()
    {
        $data = ($this->guard()->check()) ? ['auth' => 'Authenticated'] : ['auth' => 'Unauthenticated'];
        return response()->json($data);
    }

    /**
     * 用户退出
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();
        return redirect('merchant/auth/login');
    }
}
