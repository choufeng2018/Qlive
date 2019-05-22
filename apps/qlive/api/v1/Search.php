<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/8
 * Time: 14:32
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;
use think\Db;

/**
 * Class Search
 * @package app\qlive\api\v1
 * 首页搜索
 */
class Search extends RestBase
{
    /**
     *
     */
    public function index()
    {
        $keyword = \input('keyword');
        $page = \input('page', 1);
        $map = [];
        if ($keyword) {
            $map['title|anchor'] = ['like', '%' . $keyword . '%'];
            $map['open_time'] = ['> time', \time()];
        }
        //根据直播名称和主播搜索到的开播记录
        $live_list = \logic('HistoryLogic')->searchLiveHistory($map, $page);

        $live_res = [];
        foreach ($live_list as $k => $v) {
            $live_res[$k]['id'] = $v['id'];
            $live_res[$k]['title'] = $v['title'];
            $live_res[$k]['is_living'] = $v['is_living'];
        }
        //2019年5月16日添加：根据视频名称和主播搜索到的视频列表
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
            $video_res[$k]['is_living'] = false;
        }
        $res = \array_merge($live_res, $video_res);
        $this->success('Ok', $res);
    }

    public function index2()
    {
        $keyword = \input('keyword');
        $map = [];
        if ($keyword) {
            $map['title|anchor'] = ['like', '%' . $keyword . '%'];
        }
        $list = Db::field('id,title')
            ->name('QliveLiveHistory')
            ->where($map)
            ->union(function ($query) use ($map) {
                $query->field('live_id,title')
                    ->where($map)
                    ->name('QliveVideoList');
            })
            ->select();
        $this->success('OK', $list);
    }
}
