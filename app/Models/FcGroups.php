<?php

namespace App\Models;

class FcGroups extends Model
{
    /**
     * 获取分组列表
     * @return mixed
     */
    public static function getItems()
    {
        return self::orderBy('created_at', 'desc')->pluck('group_info', 'id');
    }

    /**
     * 获取与分组关联的人脸
     */
    public function face()
    {
        return $this->hasMany('App\Models\FcFaces', 'group_id', 'id');
    }

    /**
     * 根据查询编号或信息查询
     * @param $query
     * @param $no_or_info
     * @return mixed
     */
    public function scopeOfNoOrInfo($query, $no_or_info)
    {
        if (strlen($no_or_info) > 0) {
            return $query->where('group_no', 'LIKE', "%{$no_or_info}%")
                ->orWhere('group_info', 'LIKE', "%{$no_or_info}%");
        }
        return $query;
    }
}
