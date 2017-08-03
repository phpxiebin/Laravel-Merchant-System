<?php
/**
 * 自定义辅助函数
 * Created by PhpStorm.
 * User: xiebin
 * Date: 17/7/10
 * Time: 下午3:42
 */
if (!function_exists('img2Base64')) {
    /**
     * 图片Base64编码
     * @param $filePath 图片路径
     * @return string Base64结果
     */
    function img2Base64($filePath)
    {
        //判断是否是远程链接
        if (!checkUrl($filePath)) {
            $result = file_get_contents($filePath);
        } else {
            $result = getCurl($filePath);
        }

        return base64_encode($result);
    }
}

if (!function_exists('genSalt')) {

    /**生成用户密码salt
     * @return string 返回salt
     */
    function genSalt()
    {
        return substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(), mt_rand()))), 0, 22);
    }
}

if (!function_exists('assetStorage')) {

    /**
     * 获取Storage资源地址
     * @param $path 原始路径
     * @return string 资源路径
     */
    function assetStorage($path)
    {
        if (strpos($path, 'http') !== false) {
            return $path;
        }

        if (env('APP_ENV') == 'production') {
            $start = "https://";
        } else {
            $start = request()->getScheme() . '://';
        }

        return $start . config('app.storage_domain') . '/' . trim($path, '/');
    }
}

if (!function_exists('getCurl')) {
    /**
     * curl GET获取数据
     * @param $url URL链接地址
     * @return mixed 返回数据
     */
    function getCurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

if (!function_exists('checkUrl')) {
    /**
     * 判断字符串是否为正常的链接地址
     * @param $url 字符串链接地址
     * @return bool 返回布尔结果
     */
    function checkUrl($url)
    {
        $bool = true;
        if (strpos($url, 'http://') === false && strpos($url, 'https://') === false) {
            $bool = false;
        }
        return $bool;
    }
}

if (!function_exists('getCurrentAction')) {
    /**
     * 获取当前控制器与方法
     * @return array 返回结果数组
     */
    function getCurrentAction()
    {
        $action = \Route::currentRouteAction();
        list($class, $method) = explode('@', $action);
        $edit_name = ['store' => '添加', 'update' => '修改'];
        $method_name = array_has($edit_name, $method) ? $edit_name[$method] : $method;
        return ['controller' => $class, 'method' => $method, 'method_name' => $method_name];
    }
}

if (!function_exists('randId')) {
    /**
     * 生成随机ID
     * @param string $prefix 前缀标识
     * @param int $len 生成长度
     * @return string 返回字符串
     */
    function randId($prefix = '', $len = 10)
    {
        return $prefix . '-' . str_random($len);
    }
}

