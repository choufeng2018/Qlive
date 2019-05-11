<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/5/11
 * Time: 13:54
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v2;


use app\rest\controller\RestBase;
use think\Db;

class Index extends RestBase
{
    public function index()
    {
        //首页第一个轮播图，排序方式：时间最近，order最小的
        $list1 = Db::name('QliveLiveHistory')
            ->where('status', 'eq', 1)
            ->whereTime('open_time', '>', \time())
            ->order('open_time,order')
            ->field('id,title,logo,anchor,category,live_type,open_time,description')
            ->find();
        $list1['live_id'] = $list1['id'];
        unset($list1['id']);
        $list1['image'] = \get_file_complete_path($list1['logo']);
        unset($list1['logo']);
        $list1['lecturer'] = $list1['anchor'];
        unset($list1['anchor']);
        $list1['start_time'] = $list1['open_time'];
        unset($list1['open_time']);
        $list1['short_content'] = $list1['description'];
        unset($list1['description']);

        //即将开播列表

        $list = [
            $list1,
        ];
        $this->success('ok', $list);
    }
}
