<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/19
 * Time: 17:07
 * Dedicated to my wife and daughter
 */

namespace app\qlive\model;


use app\common\model\Base;

/**
 * Class QliveReplyList
 * @package app\qlive\model
 * 回复列表模型
 */
class QliveReplyList extends Base
{
    /**
     * @param $from_uid
     * @return mixed
     * 返回发布者的用户名
     */
    public function getFromUidAttr($from_uid)
    {
        $name = \getUserNameById($from_uid);
        return $name;
    }
}
