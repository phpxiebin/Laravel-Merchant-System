<?php
namespace App\Services\Face;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * 人脸服务端接口基类
 * User: phpxiebin
 * Date: 17/7/10
 * Time: 下午5:31
 */
abstract class FaceBace
{
    //请求接口地址
    const API_URL = 'http://139.196.125.22';

    //api调用API Key
    protected $app_id;
    //api调用API Secret
    protected $app_secret;

    //错误信息
    protected $error;

    /**
     * FaceManager constructor.
     * @param array $option 初始化参数
     */
    public function __construct($option = [])
    {
        $this->app_id = $option['app_id'] ?? 'user';
        $this->app_secret = $option['app_secret'] ?? '123456';
    }

    /**
     * 统一处理URL
     * @param $url 原始URL
     * @return string 处理后的URL
     */
    protected function setUrl($url)
    {
        return sprintf($url . "?app_id=%s&app_secret=%s", $this->app_id, $this->app_secret);
    }

    /**
     * 统一处理返回的Responses
     * @param $response 原始Responses
     * @return array|img_source 返回处理结果
     */
    protected function setResponses($response)
    {
        //todo 根据响应的content_type判断
        $content_type = $response->getHeader('content-type')[0] ?? '';
        switch ($content_type) {
            //如果是图片
            case 'image/jpeg':
                $result = $response->getBody()->getContents();
                header("content-type: image/jpeg");
                exit($result);
                break;
            default:
                $result = json_decode($response->getBody()->getContents(), true);
        }
        return $result;
    }

    /**
     * 统一处理返回的Result信息
     * @param $result 原始Result信息
     * @return bool|array 返回处理结果
     * todo 如果是查询结果返回原始数据 否则返回bool
     */
    protected function setResponsesResult($result)
    {
        if (array_has($result, 'faces')) {//图片识别类

        } elseif (array_has($result, 'rows')) { //列表查询类

        } elseif (array_has($result, 'score')) { //识别类

        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * 统一POST请求
     * @param $url 请求URL地址
     * @param $form_params 参数
     * @return bool 返回结果
     */
    protected function httpPost($url, $form_params)
    {
        try {
            $client = new Client();
            $response = $client->request('POST', $url, [
                'headers' => [
                    'Content-type' => 'application/x-www-form-urlencoded'
                ],
                'form_params' => $form_params
            ]);
            $result = $this->setResponses($response);
            //todo 成功状态result为0
            if (isset($result['result']) && $result['result'] === 0) {
                return $this->setResponsesResult($result);
            } else {
                $this->error = ['code' => $result['result'], 'info' => $result['info']];
                return false;
            }
        } catch (ClientException $e) {
            $this->error = ['code' => $e->getCode(), 'info' => $e->getMessage()];
            return false;
        }
    }

    /**
     * 统一GET请求
     * @param $url 请求URL地址
     * @param $param 参数
     * @return bool 返回结果
     */
    protected function httpGet($url, $param)
    {
        dd('GET请求方式待完善...');
    }

    /**
     * 各种处理
     * @param $action 接口动作
     * @param array $param 接口参数
     * @param string $method 接口请求方式
     * @return bool 返回结果
     */
    public function processing($action, $param=[], $method = 'post')
    {
        $action = strtoupper($action);
        if (!defined("static::{$action}")) {
            dd('接口请求动作不存在!');
        }
        $method = "http" . studly_case(strtolower($method));
        if (!method_exists($this, $method)) {
            dd('接口请求方式不存在!');
        }
        $result = $this->$method($this->setUrl(self::API_URL . trim(constant("static::{$action}"), '/')), $param);
        return $result;
    }

    /**
     * 获取错误信息
     * @return mixed 返回错误信息
     */
    public function getError()
    {
        return ['code' => $this->error['code'], 'msg' => $this->errorMeaasge($this->error['code']), 'info' => $this->error['info']];
    }

    /**
     * 翻译code信息
     * @param $code
     * @return string
     */
    public function errorMeaasge($code)
    {
        $config = config('face_code', []);
        return array_has($config, $code) ? $config[$code] : '未知错误';
    }
}