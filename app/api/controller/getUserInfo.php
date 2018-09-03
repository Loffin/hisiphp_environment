<?php
/**
 * Declaration:
 * @param: $value
 * @return: mixed
 * @Author: Loffin
 * Date&Time: 2018/9/4-上午12:55
 */
namespace app\api\controller;

use think\Config;
use app\api\model\UserInfo;
class getUserInfo
{
    public function index()
    {
        $appid  =   Config::get('appid');
        $appsecret  =   Config::get('appsecret');
        if (isset($_GET['code'])){
            $code   =   $_GET['code'];
        }else{
            die('no code..');
        }
        $obj    =   new UserInfo();
        $res    =   $obj->access_token($appid,$appsecret,$code);
        $userInfo = $obj->userInfo($res->access_token,$res->openid);
        print_r($userInfo);
    }
}