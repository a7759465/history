<?php

namespace app\admin\model;

use think\Model;


class People extends Model
{

    

    

    // 表名
    protected $name = 'people';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'sex_text'
    ];
    

    
    public function getSexList()
    {
        return ['男' => __('男'), '女' => __('女')];
    }


    public function getSexTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['sex']) ? $data['sex'] : '');
        $list = $this->getSexList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function family()
    {
        return $this->belongsTo('Family', 'family_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
