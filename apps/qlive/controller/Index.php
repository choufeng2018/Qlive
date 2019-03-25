<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/25
 * Time: 14:19
 * Dedicated to my wife and daughter
 */

namespace app\qlive\controller;


use app\common\controller\Base;
use think\Db;

/**
 * Class Index
 * @package app\qlive\controller
 * 直播模块首页
 */
class Index extends Base
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
        //正在直播的房间列表(从七牛获取)
        $liveList = \logic('QliveLogic')->listLiveStream();
        $liveList = $liveList['keys'];
        $allLiveRoomInfo = [];  //所有在直播中的房间详情
        //根据推流码查询直播间的详情
        foreach ($liveList as $k => $v) {
            $allLiveRoomInfo[$k]['room_info'] = Db::name('QliveRoomList')
                ->where('stream', 'eq', $v)
                ->field('stream,create_time,update_time', true)
                ->find();
        }
        \halt($allLiveRoomInfo);
        return $this->fetch();
    }

    public function test()
    {

    }
}
