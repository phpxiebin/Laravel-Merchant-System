<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Traits\PageTrait;

/**
 * 商户后台统一控制器
 * Class BaseController
 * @package App\Http\Controllers\Merchant
 */
class BaseController extends Controller
{
    use PageTrait;

    // 设置商户后台guard
    public $guard = 'merchant';

    /**
     * 获取用户信息
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return auth($this->guard)->user();
    }

    /**
     * 成功提示
     * @param string $message 消息
     * @return $this
     */
    public function okTips($message = '')
    {
        return back()->with(['message' => $message, 'status' => 0]);
    }

    /**
     * 错误提示
     * @param string $message 消息
     * @return $this
     */
    public function errorTips($message = '')
    {
        return back()->with(['message' => $message, 'status' => 1]);
    }

    /**
     * 云从随机脸部ID
     * @return string
     */
    public function randYunCongFaceId()
    {
        return randId($this->user()->id . '-face');
    }

    /**
     * 云从随机组ID
     * @return string
     */
    public function randYunCongGroupId()
    {
        return randId($this->user()->id . '-group');
    }
}
