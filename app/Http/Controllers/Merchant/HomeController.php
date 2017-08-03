<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Http\Request;

/**
 * 商户控制台主页
 * Class HomeController
 * @package App\Http\Controllers\Merchant
 */
class HomeController extends BaseController
{
    /**
     * 商户控制台
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('merchant.home');
    }
}
