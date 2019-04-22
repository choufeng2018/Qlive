<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/30
 * Time: 16:08
 * Dedicated to my wife and daughter
 */

namespace app\qlive\controller;


use app\home\controller\Home;

class Queue extends Home
{
    public function queue()
    {
        $data = [
            'a',
            'b',
            'c',

        ];
        $name = '哈哈哈';
//        \think\Queue::later('2', 'app\qlive\controller\Work', $data, '');
        // 执行 Work 的 send 方法
        //\think\Queue::push('app\qlive\controller\Work@send',$data);
        // 默认执行 Work 的 fire 方法
        \think\Queue::push('app\qlive\controller\Work', $name);

        echo '加入队列成功了';
    }
}
