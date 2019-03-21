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

class QliveRoomList extends Base
{
    public function getAnchorIdAttr($anchor_id)
    {
        $name = Db::name('QliveAnchorList')
            ->where('id', 'eq', $anchor_id)
            ->value('name');
        return $name;
    }
}
