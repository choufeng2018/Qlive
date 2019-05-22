<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/5/11
 * Time: 13:54
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v2;


use app\rest\controller\RestBase;
use think\Db;

/**
 * Class Index
 * @package app\qlive\api\v2
 */
class Index extends RestBase
{

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 首页数据
     */
    public function index()
    {
        //置顶数据：开播申请>正在直播>往期视频

        //即将开播
        $top_apply = Db::name('QliveLiveHistory')
            ->whereTime('open_time', '>', \time())
            ->where('status', 'eq', '1')
            ->where('flag', 'eq', 2)
            ->order('update_time desc')
            ->field('id,title,open_time,logo,anchor,category,live_type,description,flag')
            ->find();

        //正在直播
        //直播中的房间列表
        $top_living = [];
        $living_room_list = \logic('HistoryLogic')->getLivingRoomList();
//        \dump($living_room_list);
        if (!empty($living_room_list)) {
            foreach ($living_room_list as $v) {
                $top_living = \arraySort($v, 'update_time');
            }
        }
//        \dump($top_living);
        //往期视频
        $video = Db::name('QliveVideoList')
            ->where('status', 'eq', 1)
            ->order('order,update_time desc')
            ->find();

        //按照顺序进行选择
        if (!empty($top_apply)) {
            $top = [
                'live_id' => $top_apply['id'],
                'title' => $top_apply['title'],
                'image' => \get_file_complete_path($top_apply['logo']),
                'lecturer' => $top_apply['anchor'],
                'category' => $top_apply['category'],
                'live_type' => $top_apply['live_type'],
                'start_time' => $top_apply['open_time'],
                'short_content' => $top_apply['description'],
                'flag' => $top_apply['flag'],
            ];
        } elseif (empty($top_apply) && !empty($top_living)) {
            $top = [
                'live_id' => $top_living['live_room_info']['id'],
                'title' => $top_living['live_room_info']['title'],
                'image' => $top_living['live_room_info']['logo'],
                'lecturer' => $top_living['live_room_info']['anchor'],
//                'category' => $top_living['live_room_info']['category'],
//                'live_type' => $top_living['live_room_info']['live_type'],
                'start_time' => $top_living['live_room_info']['open_time'],
                'short_content' => $top_living['live_room_info']['description'],
                'flag' => $top_living['live_room_info']['flag'],
            ];
        } elseif (empty($top_apply) && empty($top_living)) {
            $top = [
                'live_id' => $video['live_id'],
                'title' => $video['title'],
                'image' => \get_file_complete_path($video['logo']),
                'lecturer' => $video['anchor'],
                'category' => $video['category'],
                'live_type' => $video['type'],
                'start_time' => $video['create_time'],
                'short_content' => $video['description'],
                'flag' => $video['flag'],
            ];
        } else {
            $top = [];
        }

        //近期开播数据
        $immediate_list = Db::name('QliveLiveHistory')
            ->whereTime('open_time', '>', \time())
            ->where('status', 'eq', '1')
            ->where('flag', 'neq', 2)
            ->order('open_time')
            ->field('id,title,open_time,logo,anchor,category,live_type,description,flag,price')
            ->limit(3)
            ->select();
        if (!empty($immediate_list)) {
            foreach ($immediate_list as $k => $v) {
                $immediate_list[$k]['logo'] = \get_file_complete_path($v['logo']);
                $immediate_list[$k]['category'] = \get_live_category_name_by_id($v['category']);
                $immediate_list[$k]['live_type'] = \get_live_type_name_by_id($v['live_type']);
            }
        }

        //强力推荐
        $recommend_list = Db::name('QliveVideoList')
            ->where('status', 'eq', 1)
            ->where('is_recommend', 'eq', 1)
            ->order('order,update_time desc')
            ->field('id,title,anchor,live_id,category,logo,type,price,live_time,description')
            ->limit(3)
            ->select();
        if (!empty($recommend_list)) {
            foreach ($recommend_list as $k => $v) {
                $recommend_list[$k]['logo'] = \get_file_complete_path($v['logo']);
            }
        }

        //往期热门
        $hot_list = Db::name('QliveVideoList')
            ->where('status', 'eq', 1)
            ->order('hits desc')
            ->field('id,title,anchor,live_id,category,logo,type,price,live_time,description')
            ->limit(6)
            ->select();
        if (!empty($hot_list)) {
            foreach ($hot_list as $k => $v) {
                $hot_list[$k]['logo'] = \get_file_complete_path($v['logo']);
            }
        }


        $data = [
            'top' => $top,
            'immediate_list' => $immediate_list,
            'recommend_list' => $recommend_list,
            'hot_list' => $hot_list,
        ];
        $this->success('OK', $data);
    }
}
