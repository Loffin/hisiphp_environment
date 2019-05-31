<?php
/**
 * Declaration:
 * @param: $value
 * @return: mixed
 * @Author: Loffin
 * Date&Time: 2018/9/3-下午5:24
 */
namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Session;
class Payorder extends Controller
{
    protected $user;
    protected $cate;
    protected $address;
    protected $phone_num;
    protected $weight;

    public function __construct(Request $request = null)
    {

    }
}