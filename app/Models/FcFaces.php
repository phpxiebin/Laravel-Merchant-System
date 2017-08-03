<?php

namespace App\Models;

class FcFaces extends Model
{
    /**
     * 获取与人脸关联的分组
     */
    public function group()
    {
        return $this->belongsTo('App\Models\FcGroups', 'group_id', 'id');
    }

    /**
     * 根据分组查询
     * @param $query
     * @param $group_id
     * @return mixed
     */
    public function scopeOfGroup($query, $group_id)
    {
        if (strlen($group_id) > 0) {
            return $query->where('group_id', $group_id);
        }
        return $query;
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
            return $query->where('face_no', 'LIKE', "%{$no_or_info}%")
                ->orWhere('face_info', 'LIKE', "%{$no_or_info}%");
        }
        return $query;
    }

    /**
     * 根据云从faceId查询
     * @param $query
     * @param $yc_face_ids
     * @return mixed
     */
    public function scopeOfYcFaceId($query, $yc_face_ids)
    {
        if (is_array($yc_face_ids)) {
            return $query->whereIn('yc_face_id', $yc_face_ids);
        }else{
            return $query->where('yc_face_id', $yc_face_ids);
        }
        return $query;
    }
}
