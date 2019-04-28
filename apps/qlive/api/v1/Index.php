<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/1
 * Time: 15:47
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;

/**
 * Class Index
 * @package app\qlive\api\v1
 * 首页接口
 */
class Index extends RestBase
{
    /**
     *首页接口
     */
    public function index()
    {
        //顶部的预告
        $list1 = \logic('AppriseLogic')->getAppriseList(2);
        //强力推荐
        $list2 = \logic('AppriseLogic')->getAppriseList(4);
        //即将开播
        $list3 = \logic('HistoryLogic')->getLiveHistory('>');
        //往期热门
        $list4 = \logic('HistoryLogic')->getLiveHistory('<');
        //往期热门
        //$list4 = \logic('VideoLogic')->getVideoByCondition();
        $list = [
            $list1,
            $list2,
            $list3,
            $list4
        ];
        $this->success('OK', $list);
    }

    /**
     *获取推荐视频/猜你喜欢
     */
    public function randRecommend()
    {
        $length = \input('length', 5);
        $list = \logic('HistoryLogic')->getRecommendList($length);
        $this->success('OK', $list);
    }
}
