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

    public function index()
    {
        //置顶项目：开播申请>正在直播>往期视频
        $top = [

        ];

        //开播申请
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
        if (!empty($living_room_list)) {
            foreach ($living_room_list as $list) {
                $top_living = \arraySort($list, 'update_time');
            }
        }

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
            $this->success('OK', $top);
        } elseif (empty($top_apply) && !empty($top_living)) {
            $top = [
                'live_id' => $top_living['id'],
                'title' => $top_living['title'],
                'image' => \get_file_complete_path($top_living['logo']),
                'lecturer' => $top_living['anchor'],
                'category' => $top_living['category'],
                'live_type' => $top_living['live_type'],
                'start_time' => $top_living['open_time'],
                'short_content' => $top_living['description'],
                'flag' => $top_living['flag'],
            ];
            $this->success('OK', $top);
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
            $this->success('OK', $top);
        } else {
            $this->error('后台未指定数据', 'null');
        }
    }
}
