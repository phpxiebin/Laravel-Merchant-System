<?php


namespace App\Models;

use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Model extends BaseModel
{
    use SoftDeletes;

    /**
     * @title 是否自增长
     * @var bool
     */
    public $incrementing = false;

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * 不可被批量赋值的属性。
     * @var array
     */
    protected $guarded = [];

    /**
     * 模型日期列的存储格式
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * 应被转换为日期的属性。
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Perform a model insert operation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  array $options
     * @return bool
     */
    protected function performInsert(Builder $query, array $options = [])
    {
        if ($this->incrementing == false && !array_key_exists($this->primaryKey, $this->attributes)) {
            $this->attributes = array_merge($this->attributes, [$this->primaryKey => Uuid::uuid()]);
        }
        parent::performInsert($query, $options);
    }

}