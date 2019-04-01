<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/27
 * Time: 14:03
 * Dedicated to my wife and daughter
 */

namespace app\qlive\controller;


use app\qlive\model\QliveLiveHistory;
use app\rest\controller\RestUserBase;

/**
 * Class Center
 * @package app\qlive\controller
 * 个人中心
 */
class Center extends RestUserBase
{

    public function index()
    {
        return $this->fetch();
    }

    public function live_apply()
    {
        return $this->fetch();
    }

    /**
     *提交开播申请
     */
    public function do_live_apply()
    {
        $param = \input();
        $model = new QliveLiveHistory();
        $res = $model->allowField(true)->save($param);
        if ($res) {
            $this->success('开播申请提交成功', \url('live_apply'));
        } else {
            $this->error('提交失败');
        }
    }
}
