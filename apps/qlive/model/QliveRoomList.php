<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2019/2/19
 * Time: 13:45
 */

namespace app\qlive\model;


use app\common\model\Base;
use think\Db;

/**
 * Class QliveRoomList
 * @package app\qlive\model
 */
class QliveRoomList extends Base
{
    /**
     * @param $value
     * @param $data
     * @return mixed
     * 显示主播姓名
     */
    public function getAnchorTextAttr($value, $data)
    {
        $list = Db::name('QliveAnchorList')
            ->column('id,name');
        return $list[$data['anchor_id']];
    }
}
