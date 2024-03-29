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
            ->order('open_time')
            ->select();
        if (!empty($list)) {
            foreach ($list as $k => $value) {
                $list[$k]['logo'] = \getImagePathById($value['logo']);
                $list[$k]['category'] = \getCategoryNameById($value['category']);
            }
            return $list;
        } else {
            return null;
        }
    }


    /**
     * @param $map
     * @param $page
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 搜索开播记录
     */
    public function searchLiveHistory($map, $page)
    {
        $map['status'] = 1;
        $list = Db::name('QliveLiveHistory')
            ->where($map)
            ->field('create_time,update_time', true)
            ->order('open_time desc,hits desc')
            ->page($page, 10)
            ->select();

        foreach ($list as $k => $value) {
            $list[$k]['logo'] = \get_file_complete_path($value['logo']);
            $list[$k]['category'] = \getCategoryNameById($value['category']);
            $list[$k]['is_living'] = \isLivingRoom($value['room_id']);
        }
        return $list;
    }


    /**
     * @return array|bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 从七牛获取正在直播的流并获取直播间信息
     * 如果live_room_info=null,检查open_time是否是今天
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
                    ->where('a.status', 'eq', 1)
                    ->whereTime('a.open_time', 'd')
                    ->field('a.id,a.title,a.anchor,a.open_time,a.logo,a.description,a.flag,a.update_time')
                    ->find();
                $room_list[$k]['live_room_info']['logo'] = \get_file_complete_path($room_list[$k]['live_room_info']['logo']);
            }
            return $room_list;
        } else {
            return null;
        }
    }


    /**
     * @param $map  筛选条件
     * @param $order    排序
     * @param $page     页码
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据条件筛选往期视频
     */
    public function getLivedList($map, $order, $page)
    {
        $where = [
            //开播时间小于现在时间的
            'create_time' => ['<=', \time()],
        ];
        //直播分类
        if (!empty($map['category'])) {
            $where['category'] = $map['category'];
        }
        //直播类型
        if (!empty($map['type'])) {
            $where['live_type'] = $map['type'];
        }
        //是否付费
        if (!empty($map['price'])) {
            $mark = $map['price'] == 1 ? '>' : '=';
            $where['price'] = [$mark, 0.00];
        }

        //排序,目前只支持按照价格,销量,点击数分别排序
        //默认排序
        $default_order = 'update_time desc';
        if (!empty($order)) {
            switch ($order) {
                case 1:
                    $default_order = 'price asc';
                    break;
                case 2:
                    $default_order = 'price desc';
                    break;
                case 3:
                    $default_order = 'sales asc';
                    break;
                case 4:
                    $default_order = 'sales desc';
                    break;
                case 5:
                    $default_order = 'hits asc';
                    break;
                case 6:
                    $default_order = 'hits desc';
                    break;
                default:
                    $default_order = 'update_time desc';
                    break;
            }
        }

        if (empty($map['range'])) {
            $data = Db::name('QliveLiveHistory')
                ->where($where)
                ->field('id,logo,title,open_time,anchor,price,sales,hits')
                ->page($page, 6)
                ->order($default_order)
                ->select();
        } else {
            switch ($map['range']) {
                case 1;
                    $map['range'] = 'w';
                    break;
                case 2:
                    $map['range'] = '-1 month';
                    break;
                case 3:
                    $map['range'] = '-3 month';
                    break;
                case 4:
                    $map['range'] = 'year';
                    break;
            }
            $data = Db::name('QliveLiveHistory')
                ->where($where)
                ->whereTime('open_time', $map['range'])
                ->field('id,logo,title,open_time,anchor,price,sales,hits')
                ->order($default_order)
                ->page($page, 6)
                ->select();
        }
        foreach ($data as $k => $v) {
            $data[$k]['logo'] = \get_file_complete_path($v['logo']);
        }
        return $data;
    }


    /**
     * @param int $length
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 随机获取往期的N条直播记录
     */
    public function getRecommendList($length = 5)
    {
        //数据库中存在的id
        $num_arr = Db::name('QliveLiveHistory')->column('id');
        //id的长度
        $num_arr_length = \sizeof($num_arr);
        if ($num_arr_length > 0) {

            $ids = [];
            while (\count($ids) < $length) {
                //随机产生一个id的下标
                $key = \mt_rand(0, $num_arr_length - 1);
                //取出这个id值
                $ids[] = $num_arr[$key];
                $ids = \array_unique($ids);
            }
            $info = Db::name('QliveLiveHistory')
                ->where('id', 'in', $ids)
                ->whereTime('open_time', '<', \time())
                ->select();

            foreach ($info as $k => $v) {
                $info[$k]['logo'] = \get_file_complete_path($v['logo']);
            }
            return $info;
        } else {
            return null;
        }
    }
}
