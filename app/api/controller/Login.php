<?php
/**
 * Declaration:
 * @param: $value
 * @return: mixed
 * @Author: Loffin
 * Date&Time: 2018/9/3-下午7:10
 */
namespace app\api\controller;

use think\Config;
use think\Controller;
class Login extends Controller
{
    //小程序调用server获取token接口, 传入code, rawData, signature, encryptData.
    public function wxLogin()
    {
        dump(Config::get('appid'));
    }
}