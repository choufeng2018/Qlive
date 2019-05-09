<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/17
 * Time: 15:36
 * Dedicated to my wife and daughter
 */

namespace app\qlive\model;


use app\common\model\Base;

/**
 * Class QliveBill
 * @package app\qlive\model
 * 订单模型
 */
class QliveBill extends Base
{
    /**
     * @var array
     * 自动完成新增字段
     */
    protected $insert = ['order_time', 'order_ip'];
    /**
     * @var array
     * 自动完成更新字段
     */
    protected $update = ['pay_time', 'pay_ip'];

    /**
     * @return false|string
     * 自动写入支付时间
     */
    protected function setOrderTimeAttr()
    {
        return \date('Y-m-d H:i:s');
    }

    /**
     * @return mixed
     * 自动完成下单ip
     */
    protected function setOrderIpAttr()
    {
        return \request()->ip();
    }

    /**
     * @return false|string
     * 自动更新支付时间
     */
    protected function setPayTimeAttr()
    {
        return \date('Y-m-d H:i:s');
    }

    /**
     * @return mixed
     * 自动更新支付ip
     */
    protected function setPayIpAttr()
    {
        return \request()->ip();
    }

}
