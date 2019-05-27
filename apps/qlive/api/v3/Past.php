<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/5/25
 * Time: 14:14
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v3;


use app\rest\controller\RestBase;
use think\Db;

/**
 * Class Past
 * @package app\qlive\api\v3
 * 往期
 */
class Past extends RestBase
{
    /**
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 往期直播
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
            $map['live_type'] = \input('type');
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
                    $order = 'open_time desc';
                    break;
            }
        }
        if (\input('range')) {
            switch (\input('range')) {
                case 1:
                    $range = 'w';
                    break;
                case 2:
                    $range = 'm';
                    break;
                case 3:
                    $range = '-3 months';
                    break;
                case 4:
                    $range = 'y';
                    break;
                default:
                    $range = '-100 years';
                    break;
            }
        } else {
            $range = '-100 years';
        }
        $list = Db::name('QliveLiveHistory')
            ->where($map)
            ->whereTime('open_time', $range)
            ->field('id as live_id,logo,title,open_time,anchor,price')
            ->order($order)
            ->page($page, 9)
            ->select();
        foreach ($list as $k => $value) {
            $list[$k]['logo'] = \get_file_complete_path($value['logo']);
        }
        $count = Db::name('QliveLiveHistory')
            ->where($map)
            ->whereTime('open_time', $range)
            ->count();
        $res = [
            'count' => $count,
            'list' => $list
        ];
        $this->success('OK', $res);
    }
}
