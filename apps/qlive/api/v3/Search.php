<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/5/25
 * Time: 13:59
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v3;


use app\rest\controller\RestBase;
use think\Db;

/**
 * Class Search
 * @package app\qlive\api\v3
 * 首页搜索
 */
class Search extends RestBase
{
    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 首页搜索
     */
    public function index()
    {
        $keyword = \input('keyword');
        $map = [
            'status' => 1,
            'anchor|title' => ['like', '%' . $keyword . '%'],
        ];
        $list = Db::name('QliveLiveHistory')
            ->where($map)
            ->field('id as live_id,title')
            ->select();
        $this->success('OK', $list);
    }
}
