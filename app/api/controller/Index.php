<?php
namespace app\api\controller;
use app\api\model\Cate;
use app\api\model\Weight;
use app\common\controller\Common;
use app\api\model\User;
use think\Config;
class Index extends Common
{
    //基础类别、价格信息
    public function index()
    {
        $cate   = Cate::where('status',1)->column('cate_name,low_price,high_price','id');
        $weight = Weight::where('status',1)->column('weight','id');
        $data = [
            'cate'      =>  $cate,
            'weight'    =>  $weight,
        ];
        return json($data);
    }
    //微信网页授权跳转获取code值
    public function jumpToCode()
    {
        $appid  =   Config::get('appid');
        $redirect_uri   =   urlencode('http://hisiphp.io/index.php/api/GetUserInfo/index');
        $url    =   "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header("location:$url");
        exit;
    }
}