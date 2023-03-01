<?php

namespace app\index\controller;

use app\admin\model\dynasty\Year;
use app\common\controller\Frontend;
use think\Db;

class Event extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        $data = [];
        $people = Db::name('people')->select();
        foreach ($people as $key => $value) {
            if (mb_substr($value['name'], 0, 1) == $value['surnames']) {
                $name = $value['name'];
            } else {
                $name = $value['surnames'] . $value['name'];
            }
            $birthYear = substr($value['birthday'], 0, 4);
            if ($birthYear) {
                $data[$birthYear][strtotime($value['birthday'])][] = date('n月j日', strtotime($value['birthday'])) . ' ' . $name . '出生';
            }
            $deathYear = substr($value['deathday'], 0, 4);
            if ($deathYear) {
                $data[$deathYear][strtotime($value['deathday'])][] = date('n月j日', strtotime($value['deathday'])) . ' ' . $name . '去世';
            }
        }
//        dump($data);
        $event = Db::name('event')
            ->join('fa_people', 'fa_event.people_id = fa_people.id', 'LEFT')->select();
        foreach ($event as $key => $value) {
            if (mb_substr($value['name'], 0, 1) == $value['surnames']) {
                $name = $value['name'];
            } else {
                $name = $value['surnames'] . $value['name'];
            }
            $year = substr($value['solar_time'], 0, 4);
            $data[$year][strtotime($value['solar_time'])][] = date('n月j日', strtotime($value['solar_time'])) . ' ' . $name . ':' . $value['content'];
        }
        ksort($data);
        foreach ($data as &$value) {
            ksort($value);
        }


//        dump($data);

//        $yearDesc = [];
//
        $live = [];
        $death = [];
        $years = array_keys($data);

        foreach ($years as $y) {
            foreach ($people as $key => $value) {
                if (mb_substr($value['name'], 0, 1) == $value['surnames']) {
                    $name = $value['name'];
                } else {
                    $name = $value['surnames'] . $value['name'];
                }
                $birthYear = substr($value['birthday'], 0, 4);
                $deathYear = substr($value['deathday'], 0, 4);

                if ($birthYear <= $y && $deathYear >= $y) {
                    $live[$y][] = $name . ($y - $birthYear + 1) . '岁';
                } elseif($deathYear < $y) {
                    $death[$y][] = $name;
                }
            }
        }
//
//        $yearModel = new Year();
//        foreach ($years as $y) {
//            $yearDesc[$y] = $yearModel->desc($y . '-01-01');
//        }
//        dump($yearDesc);

//        dump($death);

        $this->assign('event', $data);
        $this->assign('live', $live);
        $this->assign('death', $death);
        return $this->view->fetch();
    }

}
