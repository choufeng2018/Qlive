<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/11
 * Time: 10:11
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;

/**
 * Class Region
 * @package app\qlive\api\v1
 * 中国行政区划
 */
class Region extends RestBase
{
    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据上级id获取下级行政区
     */
    public function index()
    {
        $pid = \input('pid', 0);
        $list = \getRegionList($pid);
        $this->success('OK', $list);
    }
}
