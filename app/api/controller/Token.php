<?php

namespace app\api\service;

use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    /**
     * @return string
     * 生成token
     */
    public function generateToken($uid)
    {
        $time = $_SERVER['REQUEST_TIME'];
        $prefix = config('secure.prefix');
        $str = getRandChars(32);
        return $uid . '_' .md5($time.$prefix.$str);
    }


    /**
     * @param $key
     * @return mixed
     * @throws Exception
     * @throws TokenException
     * 根据变量获取缓存token里面的内容，例如：uid，openid,session_key
     */
    public static function getCurrentTokenVar($key)
    {
        //获取token
        $token = Request::instance()->header('token');
        if(empty($token)){
            $token = input('token');
        }
        if (empty($token)){
            write_log('无请求token' , $token, 'token_msg');
            throw new Exception('token为空', config('errapi.token_invalid'));
        }
        $vars = Cache::get($token);
        if(!$vars) {
            write_log('cache中找不到token' , $token, 'token_msg');
            throw new Exception('缓存中Token无效或已过期,token:'.$token.',URL:'.$_SERVER['REQUEST_URI'], config('errapi.token_invalid'));
        }else {
            if(!is_array($vars)) {
                $vars = json_decode($vars,true);
            }
            if(array_key_exists($key,$vars)) {
                return $vars[$key];
            }else {
                throw new \Exception('尝试获取token的变量不存在', 30001);
            }
        }
    }

    /**
     * @param 登录的时候更新缓存里面的userid
     * @解决两个账号同时登录找不到缓存找不到uid 的问题
     */
    public  static  function updateUserId($uid){

        //获取token
        $token = Request::instance()->header('token');
        if(empty($token)){
            $token = input('token');
        }
        if (empty($token)){
            write_log($token, 'token_msg');
            throw new Exception('token为空', config('errapi.token_invalid'));
        }
        $vars = Cache::get($token);
        if(!$vars) {
            write_log($token, 'token_msg');
            throw new Exception('缓存中Token无效或已过期,token:'.$token.',URL:'.$_SERVER['REQUEST_URI'], config('errapi.token_invalid'));
        }
        if(!is_array($vars)){
            $vars = json_decode($vars,true);
        }
        if(!isset($vars['id'])){
            $vars['id']  = $uid;
            $vars = json_encode($vars);
            $expire_in = config('setting.token_expire_in');
            $res = cache($token,$vars,$expire_in);
            if(!$res) {
                throw new \Exception('缓存失败，请查看系统日志', 10004);
            }
            return true;
        }else{
            return true;
        }
    }

    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('id');
        return $uid;
    }

    public static function getCurrentOpenid()
    {
        $openid = self::getCurrentTokenVar('openid');
        return $openid;
    }

    public static function getCurrentSessionKey(){
        $session_key = self::getCurrentTokenVar('session_key');
        return $session_key;
    }


}