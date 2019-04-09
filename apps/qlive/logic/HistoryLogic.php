<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/2
 * Time: 16:53
 * Dedicated to my wife and daughter
 */

namespace app\qlive\logic;


use app\common\logic\Base as BaseLogic;
use think\Db;

/**
 * Class HistoryLogic
 * @package app\qlive\logic
 * 开播记录控制器
 */
class HistoryLogic extends BaseLogic
{
    /**
     * @param $flag
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取即将开播或者往期记录
     */
    public function getLiveHistory($flag)
    {
        $list = Db::name('QliveLiveHistory')
            ->where('status', 'eq', 1)
            ->whereTime('open_time', $flag, \date('Y-m-d H:i:s'))
            ->field('create_time,update_time', true)
            ->order('hits desc')
            ->select();
        foreach ($list as $k => $value) {
            $list[$k]['logo'] = \getImagePathById($value['logo']);
            $list[$k]['category'] = \getCategoryNameById($value['category']);
        }
        return $list;
    }

    /**
     * @param $map
     * @param $page
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 搜索开播记录
     */
    public function searchLiveHistory($map, $page)
    {
        $list = Db::name('QliveLiveHistory')
            ->where($map)
            ->field('create_time,update_time', true)
            ->order('hits desc')
            ->page($page, 10)
            ->select();
        foreach ($list as $k => $value) {
            $list[$k]['logo'] = \getImagePathById($value['logo']);
            $list[$k]['category'] = \getCategoryNameById($value['category']);
        }
        return $list;
    }


    /**
     * @return array|bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 从七牛获取正在直播的流并获取直播间信息
     */
    public function getLivingRoomList()
    {
        //从七牛获取到正在直播的stream
        $livingStream = \logic('QliveLogic')->listLiveStream();
        $livingStream = $livingStream['keys'];
        //获取正在直播的房间id
        if (!empty($livingStream)) {
            $room_list = [];
            foreach ($livingStream as $k => $value) {
                $room_list[$k]['live_room_info'] = Db::name('QliveLiveHistory')
                    ->alias('a')
                    ->join('QliveRoomList b', 'a.room_id=b.id')
                    ->where('b.stream', 'eq', $value)
                    ->where('b.status', 'eq', 1)
                    ->whereTime('a.open_time', 'd')
                    ->field('a.id,a.title,a.anchor,a.open_time,a.logo,a.description')
                    ->find();
            }
            return $room_list;
        } else {
            return false;
        }

    }
}
