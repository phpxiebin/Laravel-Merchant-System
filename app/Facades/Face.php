<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Face门面
 * Class Face
 * @package App\Facades
 */
class Face extends Facade
{
    /**
     * 获取组件在容器中注册的名称。
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Face';
    }
}