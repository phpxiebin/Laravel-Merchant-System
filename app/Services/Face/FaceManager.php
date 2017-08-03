<?php
namespace App\Services\Face;

/**
 * 人脸信息管理相关类
 * User: xiebin
 * Date: 17/7/10
 * Time: 下午1:31
 */
class FaceManager extends FaceBace
{
    //添加人脸
    const STORE_FACE = 'face/clustering/face/create';
    //删除人脸
    const DESTROY_FACE = 'face/clustering/face/delete';
    //修改人脸
    const UPDATE_FACE = 'face/clustering/face/edit';

    //添加组
    const STORE_GROUP = 'face/clustering/group/create';
    //删除组
    const DESTROY_GROUP = 'face/clustering/group/delete';

    //根据图片进行组识别
    const IDENTIFY_GROUP = 'face/recog/group/identify';
}