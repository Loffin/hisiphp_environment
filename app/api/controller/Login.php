<?php
namespace app\api\controller;

use think\Controller;
use think\Config;
class Login extends Controller
{
    protected $code;
    protected $appid;
    protected $appsecret;
    public $openid;
    public $session_key;

    public function login()
    {
        $this->code =   input('code');
        $this->appid    =  Config::get('appid');
        $this->appsecret    =   Config::get('appsecret');
        $url    =   "https://api.weixin.qq.com/sns/jscode2session?appid=" . $this->appid . "&secret=" . $this->appsecret . "&js_code=" . $this->code . "&grant_type=authorization_code";
        $res    =   $this->httpGet($url);
        $this->openid   =   $res['openid'];
        $this->session_key  =   $res['session_key'];
    }

    public function httpGet($url)
    {
        $ch =   curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_TIMEOUT,15*60);
        curl_setopt($ch,CURLOPT_POST,false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        $result =   curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}