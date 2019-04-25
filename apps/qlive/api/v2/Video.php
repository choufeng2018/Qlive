<?php

namespace app\qlive\api\v2;


use app\rest\controller\RestBase;
use think\Db;

/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/25
 * Time: 10:50
 * Dedicated to my wife and daughter
 */
class Video extends RestBase
{
    /**
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 视频列表和总条数
     */
    public function index()
    {
        $page = \input('page', 1,'intval');
        $list = Db::name('QliveVideoList')
            ->where('status', 'eq', 1)
            ->page($page, 10)
            ->select();
        foreach ($list as $k => $value) {
            $list[$k]['live_info'] = Db::name('QliveLiveHistory')->where('id', 'eq', $value['live_id'])->find();
            $list[$k]['live_info']['logo'] = \get_file_complete_path($list[$k]['live_info']['logo']);
            $list[$k]['url'] = \get_file_complete_path($value['url']);
        }
        $count = Db::name('QliveVideoList')
            ->where('status', 'eq', 1)->count();
        $res['count'] = $count;
        $res['list'] = $list;
        $this->success('OK', $res);
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 视频详情
     */
    public function detail()
    {
        $video_id = \input('id','','intval');
        $video_info = Db::name('QliveVideoList')
            ->where('id', 'eq', $video_id)
            ->find();
        if (empty($video_info)) {
            $this->error('该信息不存在');
        }
        //对应直播的记录
        $live_info = Db::name('QliveLiveHistory')->where('id', 'eq', $video_info['live_id'])->find();
        $video_info['url'] = \get_file_complete_path($video_info['url']);
        $live_info['logo'] = \get_file_complete_path($live_info['logo']);
        $res = [
            'video_info' => $video_info,
            'live_info' => $live_info,
        ];
        $this->success('OK', $res);
    }
}
