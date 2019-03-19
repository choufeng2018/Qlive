<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2019/2/19
 * Time: 14:13
 */

namespace app\qlive\admin;


use app\admin\controller\Admin;

class Channel extends Admin
{
    protected $logic;

    public function _initialize()
    {
        parent::_initialize();
        $this->logic = \logic('QliveLogic');
    }

    public function index()
    {
        $list = $this->logic->listAllStreams();
        \halt($list);
    }

    public function info()
    {
        $list = $this->logic->getLiveStatus('test1');
        \halt($list);
    }

    public function add($name)
    {
        $name = create_stream_name($name);
        $res = $this->logic->createStream($name);
        \halt($res);
    }
}
