<?php
namespace app\api\controller;
use app\api\model\Cate;
use app\common\controller\Common;
use app\api\model\User;

class Index extends Common
{
    public function index()
    {
        $data = [];
        $cate = Cate::where('status',1)->column('cate_name');
        dump($cate);
    }
}