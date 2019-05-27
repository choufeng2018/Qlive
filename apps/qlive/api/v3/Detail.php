<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/5/25
 * Time: 14:33
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v3;


use app\rest\controller\RestBase;
use think\Db;

/**
 * Class Detail
 * @package app\qlive\api\v3
 * 根据直播记录id获取直播记录数据
 */
class Detail extends RestBase
{
    /**
     * @throws \think\exception\DbException
     * 根据直播记录id获取直播记录数据
     */
    public function index()
    {
        $live_id = \input('live_id');
        if (empty($live_id)) {
            $this->error('请传入直播id');
        }
        //直播记录信息
        $live_info = Db::name('QliveLiveHistory')
            ->where('id', 'eq', $live_id)
            ->field('id as live_id,anchor_id,anchor,title,logo,category,live_type,room_id,schedule,description,content,price,open_time')
            ->find();
        if (empty($live_info)) {
            $this->error('请求的数据不存在');
        }
        $live_info['logo'] = \get_file_complete_path($live_info['logo']);
        $live_info['category'] = \getCategoryNameById($live_info['category']);
        $live_info['live_type'] = \getLiveTypeNameById($live_info['live_type']);
        //这个房间的播放地址
        $live_info['playerUrls'] = \getPlayUrlByRoomId($live_info['room_id']);
        //评分,四舍五入取整
        $live_info['rate'] = \round(\logic('RateLogic')->getLiveRate($live_id), 0);
        //对应直播的头像
        $live_info['avatar'] = \get_file_complete_path(\get_user_avatar_by_uid(\getUidByAnchorId($live_info['anchor_id'])));
        //直播对应的直播流
        $stream = \getStreamNameByRoomId($live_info['room_id']);
        //当前直播流的状态，在直播status=true
        $stream_status = \logic('QliveLogic')->getLiveStatus($stream);
//        \halt($stream_status);
        //直播对应的视频信息
        $video_info = \getVideoByLiveId($live_id);

        //该直播的状态（1=还未开播，2=正在直播，3=直播结束无视频，4=直播结束有视频）
        //3状态难以判断，所以设置为默认
        $live_status = 3;
        //状态=1的情况，开播时间大于现在时间
        if (\strtotime($live_info['open_time']) > \time()) {
            $live_status = 1;
        }
        //状态=2,开播时间在一定时段之内，并且stream是直播状态+不存在对应视频（因为直播流和开播记录是一对多关系，所以只能检查在某个范围内的状态）
        $s_time = \time() - 60 * 60 * 2;    //人为设置时间段
        if (($s_time < \strtotime($live_info['open_time'])) && (\strtotime($live_info['open_time']) < \time()) && ($stream_status === true) && empty($video_info)) {
            $live_status = 2;
        }

        //状态=4，存在视频信息肯定就是了
        if (!empty($video_info)) {
            $live_status = 4;
        }

        //需要返回的数据
        $res = [
            'live_status' => $live_status,
            'live_info' => $live_info,
            'video_info' => $video_info,
        ];
        $this->success('OK', $res);
    }
}
