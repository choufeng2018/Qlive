<?php

/**
 * Project:www.live.gov
 * Editor:xpwsg
 * Time:10:17
 * Date:2019/4/11
 * Dedicated to my wife and daughter
 */

use think\Db;

if (!function_exists('getRegionList')) {
    /**
     * @param int $pid
     * @return false|PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 返回行政区划
     */
    function getRegionList($pid = 0)
    {
        $list = Db::name('Region')
            ->where('parent_code', 'eq', $pid)
            ->field('create_time,update_time', true)
            ->select();
        return $list;
    }
}
