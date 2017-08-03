<?php
namespace App\Traits;
use Illuminate\Support\Facades\Validator;

/**
 * 分页统一处理
 * User: xiebin
 * Date: 17/7/13
 * Time: 下午2:08
 */
trait PageTrait
{
    /**
     * 获取分页参数
     * @return array
     * @throws \ErrorException
     */
    public function getParameter()
    {
        $validator = Validator::make(Request()->all(), [
            'page' => 'integer|min:1|max:1000',
            'limit' => 'integer|min:1',
        ]);
        if ($validator->fails()) {
            throw new \ErrorException($validator->errors()->first());
        }
        $paging = ['page' => Request()->input('page', 1), 'limit' => Request()->input('limit', 10)];
        return $paging;
    }
}