<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/5/23
 * Time: 10:58
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;
use think\Db;

class Search extends RestBase
{
    public function index()
    {
        $keyword = \input('keyword');
        $page = \input('page', 1);

        $map = [];
        if ($keyword) {
            $map['title|anchor'] = ['like', '%' . $keyword . '%'];
            $map['open_time'] = ['> time', \time()];
        }
        //未开播的列表
        //根据直播名称和主播搜索到的开播记录
        $live_list = \logic('HistoryLogic')->searchLiveHistory($map, $page);

        $live_res = [];
        foreach ($live_list as $k => $v) {
            $live_res[$k]['id'] = $v['id'];
            $live_res[$k]['title'] = $v['title'];
            $live_res[$k]['living_status'] = 1;
        }
        //正在直播中的列表

        $living_res = $this->getLivingRoomList($map);
        if (empty($living_res)) {
            $living_res = [];
        }
//        \halt($living_res);
        //视频列表
        unset($map['open_time']);
        $video_list = Db::name('QliveVideoList')
            ->where($map)
            ->where('status', 'eq', 1)
            ->field('live_id,title')
            ->select();
        $video_res = [];
        foreach ($video_list as $k => $v) {
            $video_res[$k]['id'] = $v['live_id'];
            $video_res[$k]['title'] = $v['title'];
            $video_res[$k]['living_status'] = 3;
        }
        $res = \array_merge($live_res, $living_res, $video_res);
        $this->success('Ok', $res);
    }

    function getLivingRoomList($map)
    {
        unset($map['open_time']);
        //从七牛获取到正在直播的stream
        $livingStream = \logic('QliveLogic')->listLiveStream();
        $livingStream = $livingStream['keys'];
        //获取正在直播的房间id
        if (!empty($livingStream)) {
            $room_list = [];
            foreach ($livingStream as $k => $value) {
                $room_list[$k] = Db::name('QliveLiveHistory')
                    ->alias('a')
                    ->join('QliveRoomList b', 'a.room_id=b.id')
                    ->where('b.stream', 'eq', $value)
                    ->where('b.status', 'eq', 1)
                    ->where($map)
                    ->whereTime('a.open_time', 'd')
                    ->field('a.id,a.title')
                    ->order('a.open_time desc')
                    ->find();
                $room_list[$k]['living_status'] = 2;
            }
            return $room_list;
        }
    }
}
