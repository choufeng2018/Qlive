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
     * 视频列表,带条件筛选
     */
    public function index()
    {
        //筛选条件
        $map = [
            'status' => 1,
        ];
        //排序条件
        $order = [];

        $page = \input('page', 1);
        //直播分类
        if (\input('category')) {
            $map['category'] = \input('category');
        }
        //直播类型
        if (\input('type')) {
            $map['type'] = \input('type');
        }
        //是否付费
        if (\input('price')) {
            $mark = \input('price') == 1 ? '>' : '=';
            $map['price'] = [$mark, 0];
        }
        if (\input('order')) {
            switch (\input('order')) {
                case 1:
                    $order = 'price asc';
                    break;
                case 2:
                    $order = 'price desc';
                    break;
                case 3:
                    $order = 'sales asc';
                    break;
                case 4:
                    $order = 'sales desc';
                    break;
                case 5:
                    $order = 'hits asc';
                    break;
                case 6:
                    $order = 'hits desc';
                    break;
                default:
                    $order = 'update_time desc';
                    break;
            }
        }
        $list = Db::name('QliveVideoList')
            ->where($map)
            ->order($order)
            ->page($page, 10)
            ->select();
        foreach ($list as $k => $value) {
            $list[$k]['live_info'] = Db::name('QliveLiveHistory')->where('id', 'eq', $value['live_id'])->find();
            $list[$k]['live_info']['logo'] = \get_file_complete_path($list[$k]['live_info']['logo']);
            $list[$k]['url'] = \get_file_complete_path($value['url']);
        }
        $count = Db::name('QliveVideoList')
            ->where($map)
            ->count();
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
        $video_id = \input('id', '', 'intval');
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

    /**
     * @throws \think\Exception
     * 视频增加点击数
     */
    public function addHits()
    {
        $video_id = \input('id');
        $res = Db::name('QliveVideoList')
            ->where('id', 'eq', $video_id)
            ->setInc('hits');
        if ($res) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }
}
