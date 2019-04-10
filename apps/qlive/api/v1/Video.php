<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/9
 * Time: 16:06
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;

class Video extends RestBase
{
    public function index()
    {
        $map = [
            'category' => \input('category', ''),
            'type' => \input('type', ''),
            'range' => \input('range', ''),
            'price' => \input('price', 0),
        ];
        $order = \input('order', '');
        $page = \input('page', 1);
        $data['list'] = \logic('HistoryLogic')->getLivedList($map, $order, $page);
        $this->success('OK', $data);
    }
}
