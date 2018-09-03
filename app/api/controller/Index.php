<?php
namespace app\api\controller;
use app\api\model\Cate;
use app\api\model\Weight;
use app\common\controller\Common;
use app\api\model\User;

class Index extends Common
{
    public function index()
    {
        $data = [];
        $cate = Cate::where('status',1)->column('cate_name');
        $weight = Weight::where('status',1)->column('weight');
        dump($weight);
    }
}