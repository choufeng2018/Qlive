<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/9
 * Time: 10:33
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;

/**
 * Class LiveList
 * @package app\qlive\api\v1
 * 直播相关控制器
 */
class LiveList extends RestBase
{
    /**
     *获取正在直播的房间列表
     */
    public function index()
    {
        $list = \logic('HistoryLogic')->getLivingRoomList();
        $this->success('OK', $list);
    }
}
