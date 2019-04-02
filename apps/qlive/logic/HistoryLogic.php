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
            ->order('hits desc')
            ->select();
        foreach ($list as $k => $value) {
            $list[$k]['logo'] = \getImagePathById($value['logo']);
            $list[$k]['category'] = \getCategoryNameById($value['category']);
        }
        return $list;
    }
}
