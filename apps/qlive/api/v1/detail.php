<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/3
 * Time: 15:54
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;
use think\Db;

/**
 * Class detail
 * @package app\qlive\api\v1
 * (开播记录)直播/历史直播详情
 *
 */
class detail extends RestBase
{
    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 直播记录的详情
     */
    public function index()
    {
        $id = \input('id');
        $live_info = Db::name('QliveLiveHistory')
            ->where('id', 'eq', $id)
            ->field('create_time,update_time,apprise_id', true)
            ->find();
        if (empty($live_info)) {
            $this->error('该直播信息不存在');
        } else {
            $live_info['logo'] = \getImagePathById($live_info['logo']);
            $live_info['category'] = \getCategoryNameById($live_info['category']);
            $live_info['live_type'] = \getLiveTypeNameById($live_info['live_type']);
            //这个房间的播放地址
            $live_info['playerUrls'] = \getPlayUrlByRoomId($live_info['room_id']);
        }
        $this->success('OK', $live_info);
    }
}
