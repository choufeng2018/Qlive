<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/8
 * Time: 14:32
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;

/**
 * Class Search
 * @package app\qlive\api\v1
 * 首页搜索
 */
class Search extends RestBase
{
    /**
     *
     */
    public function index()
    {
        $keyword = \input('keyword');
        $page = \input('page', 1);
        $map = [];
        if ($keyword) {
            $map['title|anchor'] = ['like', '%' . $keyword . '%'];
        }
        $list = \logic('HistoryLogic')->searchLiveHistory($map, $page);
        $this->success('Ok', $list);
    }
}
