<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/2
 * Time: 16:44
 * Dedicated to my wife and daughter
 */

namespace app\qlive\logic;


use app\common\logic\Base as BaseLogic;
use think\Db;

/**
 * Class AppriseLogic
 * @package app\qlive\logic
 * 直播预告逻辑层
 */
class AppriseLogic extends BaseLogic
{
    /**
     * @param string $flag
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取直播预告列表
     */
    public function getAppriseList($flag = '')
    {
        $list = Db::name('QliveAppriseList')
            ->whereTime('start_time', '>', \date('Y-m-d H:i:s'))
            ->where('status', 'eq', 1)
            ->where('flag', 'eq', $flag)
            ->field('create_time,update_time,status', true)
            ->select();
        foreach ($list as $k => $value) {
            $list[$k]['image'] = \get_file_complete_path($value['image']);
            $list[$k]['lecturer'] = \get_file_complete_path($value['lecturer']);
        }
        return $list;
    }
}
