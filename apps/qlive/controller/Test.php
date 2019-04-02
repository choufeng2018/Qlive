<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/2
 * Time: 10:26
 * Dedicated to my wife and daughter
 */

namespace app\qlive\controller;


use app\home\controller\Home;
use think\Request;

class Test extends Home
{
    public function index()
    {
        $sign_key = \config('sign_key');
        $server_sign = \md5(\md5($sign_key) . \md5($sign_key));
        \halt($server_sign);
    }
}
