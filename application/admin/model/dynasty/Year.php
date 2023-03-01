<?php

namespace app\admin\model\dynasty;

use think\Model;


class Year extends Model
{


    // 表名
    protected $name = 'dynasty_year';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    private $range;

    // 追加属性
    protected $append = [

    ];

    /**
     * Created By SonjTse  sonj@passfeed.info Time 2022/9/13 20:04
     * DESC
     * @param $date 阳历
     */
    public function desc($date)
    {
        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date));
        $day = date('j', strtotime($date));
        $lunar = SolarToLunar($year, $month, $day);

        $year = $lunar->lunarYear;

        if (!$this->range) {
            $data = $this->field('name,daterange')->select();
            foreach ($data as $key => $value) {
                list($st, $en) = explode(' - ', $value['daterange']);
                $this->range[$value['name']] = [substr($st, 0, 4), substr($en, 0, 4)];
            }
        }

        $interval = 0;
        foreach ($this->range as $key => $value) {
            if ($year >= $value[0] && $year <= $value[1]) {
                $interval = $year - $value[0] + 1;
                break;
            }
        }

        return $key .  $interval . '年';
    }


}
