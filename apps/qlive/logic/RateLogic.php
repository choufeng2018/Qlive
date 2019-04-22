<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/11
 * Time: 15:22
 * Dedicated to my wife and daughter
 */

namespace app\Qlive\logic;

use app\common\logic\Base as BaseLogic;
use think\Db;

/**
 * Class RateLogic
 * @package app\Qlive\logic
 * 评分逻辑层
 */
class RateLogic extends BaseLogic
{
    /**
     * @param $live_id
     * @return float|int
     * 获取对应直播/视频的评分平均分
     */
    public function getLiveRate($live_id)
    {
        $rate = Db::name('QliveRate')
            ->where('live_id', 'eq', $live_id)
            ->avg('rate');
        if (empty($rate)) {
            $rate = 0;
        }
        return $rate;
    }
}
