<?php
// 微信模块基类
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 https://www.eacoophp.com, All rights reserved.         
// +----------------------------------------------------------------------
// | [EacooPHP] 并不是自由软件,可免费使用,未经许可不能去掉EacooPHP相关版权。
// | 禁止在EacooPHP整体或任何部分基础上发展任何派生、修改或第三方版本用于重新分发
// +----------------------------------------------------------------------
// | Author:  心云间、凝听 <981248356@qq.com>
// +----------------------------------------------------------------------

namespace app\wechat\admin;
use app\admin\controller\Admin;

class Base extends Admin {

    protected $wxid;

    function _initialize()
    {
        parent::_initialize();
        $this->wxid = get_wxid();
        if (!$this->wxid) {
        	$this->error('请先启用一个公众号！',url('wechat/wechat/setting'));
        }
    }

}