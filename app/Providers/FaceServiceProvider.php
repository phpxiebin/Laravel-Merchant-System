<?php

namespace App\Providers;

use App\Services\Face\FaceManager;
use Illuminate\Support\ServiceProvider;

/**
 * Face服务提供者
 * Class FaceServiceProvider
 * @package App\Providers
 */
class FaceServiceProvider extends ServiceProvider
{
    /**
     * 在容器中注册绑定
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Face', function(){
            return new FaceManager();
        });
    }
}
