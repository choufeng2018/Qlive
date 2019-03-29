<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/29
 * Time: 8:54
 * Dedicated to my wife and daughter
 */

namespace app\qlive\controller;


use app\home\controller\Home;

/**
 * Class Room
 * @package app\qlive\controller
 * 直播间详情
 */
class Room extends Home
{
    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        $room_id = \input('room_id', 1);
        $this->assign([
            'current_user' => $this->currentUser,
            'room_id' => $room_id
        ]);
//        \halt(\session(''));
//        \dump(\session(''));
        return $this->fetch();
    }
}
