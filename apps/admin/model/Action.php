<?php

namespace app\admin\model;

use app\common\model\Base;

/**
 * Class Action
 * @package app\admin\model
 * 行为模型
 */
class Action extends Base
{

    /**
     * 获取状态显示
     * @param  [type] $value [description]
     * @param  [type] $data [description]
     * @return [type] [description]
     * @date   2018-02-08
     * @author 心云间、凝听 <981248356@qq.com>
     */
    protected function getStatusTextAttr($value, $data)
    {
        $status = array(-1 => '删除', 0 => '禁用', 1 => '正常');
        return $status[$data['status']];
    }

    /**
     * @param $value
     * @param $data
     * @return mixed
     * 获取操作类型显示
     */
    protected function getActionTypeTextAttr($value, $data)
    {
        //执行类型。1自定义操作，2记录操作
        $text = [1 => '自定义操作', 2 => '记录操作'];
        return $text[$data['action_type']];
    }

}
