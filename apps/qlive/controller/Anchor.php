<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2019/2/20
 * Time: 14:58
 */

namespace app\qlive\controller;


use app\home\controller\Home;

class Anchor extends Home
{
    public function index()
    {
        $res = \logic('QliveLogic')->listAllStreams();
        \halt($res);
    }
}
