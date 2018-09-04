<?php
/**
 * Declaration:
 * @param: $value
 * @return: mixed
 * @Author: Loffin
 * Date&Time: 2018/9/4-上午1:02
 */
namespace app\api\model;

use think\Model;
class UserInfo extends Model
{
    //获取access_token和openid
    public function access_token($appid,$appsecret,$code)
    {
        $url    =   "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $res = json_decode($this->httpGet($url));
        return $res;
    }

    public function userInfo($access_token,$openid)
    {
        $userUrl = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        $res = json_decode($this->httpGet($userUrl));
        return $res;
    }
    //curl方式获取返回值
    public function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
}