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
class Detail extends RestBase
{
    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 直播记录的详情
     * 如果还未开播就是直播间详情,如果已经结束那就是录播详情
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
            //评分,四舍五入取整
            $live_info['rate'] = \round(\logic('RateLogic')->getLiveRate($id), 0);
        }
        $this->success('OK', $live_info);
    }

    /**
     * @throws \think\Exception
     * 添加点击数
     */
    public function hits()
    {
        if ($this->request->isPost()) {
            $id = \input('id');
            $res = Db::name('QliveLiveHistory')
                ->where('id', 'eq', $id)
                ->setInc('hits');
            if ($res) {
                $this->success('ok');
            } else {
                $this->error('fail');
            }
        } else {
            $this->error('提交方式不正确');
        }
    }
}
