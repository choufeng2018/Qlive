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
     *导航栏“直播“里的数据
     * 包含：1，正在直播的；
     *      2，即将开播的；
     */
    public function index()
    {
        //直播中列表
        $list['living'] = \logic('HistoryLogic')->getLivingRoomList();
        //即将开播列表
        $list['coming'] = \logic('HistoryLogic')->getLiveHistory('>');
        if ($list) {
            $this->success('OK', $list);
        } else {
            $this->error('暂无数据');
        }
    }
}
