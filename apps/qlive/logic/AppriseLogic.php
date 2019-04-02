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

class AppriseLogic extends BaseLogic
{
    public function getAppriseList($flag = '')
    {
        $list = Db::name('QliveAppriseList')
            ->whereTime('start_time', '>', \date('Y-m-d H:i:s'))
            ->where('status', 'eq', 1)
            ->where('flag', 'eq', $flag)
            ->field('create_time,update_time,status', true)
            ->select();
        foreach ($list as $k => $value) {
            $list[$k]['lecturer'] = \getAnchorNameById($value['lecturer']);
        }
        return $list;
    }
}
