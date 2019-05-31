<?php

namespace app\api\service;


use app\api\model\Users;

class UserToken extends Token
{
    protected $app_id;
    protected $app_secret;
    protected $wx_login_url;

    public $code;
    public $uid;
    public $openid;
    public $phone_model;
    public $phone_mac;
    public $phone_system;
    public $wechat_user_info;
    public $jp_id;

    public function __construct($code ,$phone_model,$phone_mac,$phone_system,$jp_id)
    {
        $this->code         = $code;
        $this->phone_model  = $phone_model;
        $this->phone_mac    = $phone_mac;
        $this->phone_system  = $phone_system;
        $this->app_id       = config('wx_wantupai')['appid'];
        $this->app_secret   = config('wx_wantupai')['AppSecre'];
        $this->wx_login_url = sprintf(config('wx_login_url'),$this->app_id,$this->app_secret,$code);
        $this->jp_id        = $jp_id;
    }

    public function get($xg_deviceid) {
        $result = $this->curl_get($this->wx_login_url);
        //  var_dump($result);die;
        //      $result = '{
        // "access_token":"ACCESS_TOKEN",
        // "expires_in":7200,
        // "refresh_token":"REFRESH_TOKEN",
        // "openid":"OPENID",
        // "scope":"SCOPE",
        // "unionid":"o6_bmasdasdsad6_2sgVt7hMZOPfL"
        // }';
        // $result = '{"access_token":"11__NT9txMtHMopaeatxT864DdxppEjjjkrD71eBZCIEUVC7EU7b5l_1eEIzFl4B5QqYrwYDnuz9B13dycQKWIKwgFd4sw3BQcm7Utg1TEYNgY","expires_in":7200,"refresh_token":"11_SlxbaOOP7NX2nIKBVNyYwuUqXOpuqns-jMLZPeaKnrqpqadESNcVmkontMKitxb3RpfazxUN9HYWOzV551_TG20P8CKMRDIOVZ_2L7qCkto","openid":"obK_Q0-1cN1j3-ehIiju8e3IkzWU","scope":"snsapi_userinfo","unionid":"oZL2T1XK1MMrbmu-UL1PMs1iorLo"}';
        //  $result = '{"access_token":"11_Yry2zxqnvUnRNYDuVCBRGuqxyC6B8JQTJkvD0kentUi11tK4eYzo8RUANBOjKgZy3laHVfzvyGSChS-ZMvfXCU3WtLt_WIaHA18hGjkwufs","expires_in":7200,"refresh_token":"11_KMi4HBaXy-zqDds5PxAHwKTWjWwc9NspjRaztpNHohUTnQrMOaN5L9t7mXMkU1IlKcmZaW-2Lbi8-cLPvOZ3LT3hk72K29IV8vLgh9gRFlw","openid":"obK_Q050ih9yuGk0zCYRkM96udAw","scope":"snsapi_userinfo","unionid":"oZL2T1bE4GG60ZIM6iGNHq0mZtgQ"}';
        $result = json_decode($result,true);


        if(!$result) {
            throw new \Exception('获取openID失败', 30002);
        }else {
            if(array_key_exists('errcode',$result)){
                $this->processLoginError($result);
            }else {
                $this->wechat_user_info = $result;
                $result['xg_deviceid']  = $xg_deviceid;
                return $this->grantToken($result);
            }
        }
    }

    /**
     * @param $result
     * @return string
     * 分配token
     */
    public function grantToken($wechat_result) {
        $openid = $wechat_result['openid'];
        $unionid = isset($wechat_result['unionid'])?$wechat_result['unionid']:'';
        $sql = "SELECT * FROM wtp_users where wx_openid = '{$openid}'";
        $userinfo = Users::query($sql);

        if(empty($userinfo)){
            $uid = $this->newUser($wechat_result);
            $cache_user['id'] = $uid;
        }else{
            $uid = $userinfo['0']['id'];
        }
        $cache_user = array();
        $this->openid  = $openid;
        $cache_user['wx_openid']    = $openid;
        $cache_user['unionid']      = $unionid;
        $cache_user['access_token']  = $wechat_result['access_token'];
        $cache_user['expires_in']   = $wechat_result['expires_in'];
        $cache_user['scope']        = $wechat_result['scope'];
        $saveData   =   $this->updateUser($openid,$wechat_result['access_token']);
        $tokenkey   =   $this->saveToCache(array_merge($saveData,$cache_user));
        $user_token =   $this->saveUidToCache($uid);
        $returndata['uid']          = $uid;
        $returndata['wx_openid']    = $openid;
        $returndata['token']        = $tokenkey;
        $returndata['user_token']   = $user_token;

        return array_merge($returndata,$saveData);
    }

    public function updateUser($openid,$access_token){
        $wx_userinfo_url = sprintf(config('wx_userinfo_url'),$access_token,$openid);
        $result = $this->curl_get($wx_userinfo_url);
//                $result = '{
//  "openid":"OPENID",
//  "nickname":"NICKNAME",
//  "sex":1,
// "province":"PROVINCE",
//  "city":"CITY",
// "country":"COUNTRY",
//  "headimgurl": "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
//  "privilege":[
//  "PRIVILEGE1",
//  "PRIVILEGE2"
//  ],
//  "unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"
//  }';
        $result = json_decode($result,true);
        $saveData = array();

        if(!$result) {
            throw new \Exception('获取用户信息失败', 30002);
        }else {
            if (array_key_exists('errcode', $result)) {
                $this->processLoginError($result);
            } else {
                $saveData['nickname'] = $result['nickname'];
                $saveData['avatar'] = $result['headimgurl'];
                $saveData['sex']  = $result['sex'];
                $saveData['province']  = $result['province'];
                $saveData['city']  = $result['city'];
                $saveData['country']  = $result['country'];
                $saveData['unionid']  = $result['unionid'];
                $saveData['phone_model']  = $this->phone_model;
                $saveData['phone_mac'] = $this->phone_mac;
                $saveData['phone_system']  = $this->phone_system;
                $saveData['jp_id']  = $this->jp_id;
                $rs = Users::where(array('wx_openid'=>$openid))->update($saveData);
            }
        }
        return $saveData;
    }

    /**
     * @param $user
     * @return string
     * 保存到缓存中
     */
    public function saveToCache($user) {
        $key = $this->generateToken($this->openid);
        $user['token']  = $key;
        $value = json_encode($user);
        $expire_in = config('setting')['token_expire_in'];
        $res = cache($this->openid,$value,$expire_in);
        if(!$res) {
            throw new \Exception('缓存失败，请查看系统日志', 10003);
        }
        return $key;
    }

    public function saveUidToCache($user){
        $key = md5($this->openid);
        $value = json_encode($user);
        $res = cache($key,$value);
        if(!$res) {
            throw new \Exception('缓存失败，请查看系统日志', 10003);
        }
        return $key;

    }

    /**
     * @param $openId
     * @return mixed
     * 创造新的用户
     */
    public function newUser($result) {
        $insert_data = [];
        $insert_data['wx_openid'] = $result['openid'];
        $insert_data['xg_deviceid']  = $result['xg_deviceid'];
        $insert_data['jp_id']  = $this->jp_id;
        $insert_data['unionid'] = isset($result['unionid']) ? $result['unionid'] : '';
        $insert_data['create_time'] = time();
        $user = Users::create($insert_data);
        return $user->id;
    }

    /**
     * @param $result
     * 处理微信登录的错误
     */
    public function processLoginError($result) {

        throw new \Exception($result['errmsg'], $result['errcode']);
    }


    public function curl_get($url)
    {
        $ch =   curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_TIMEOUT,15*60);
        $result =   curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}