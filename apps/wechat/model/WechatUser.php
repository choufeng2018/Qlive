<?php
// 微信用户
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 https://www.eacoophp.com, All rights reserved.         
// +----------------------------------------------------------------------
// | [EacooPHP] 并不是自由软件,可免费使用,未经许可不能去掉EacooPHP相关版权。
// | 禁止在EacooPHP整体或任何部分基础上发展任何派生、修改或第三方版本用于重新分发
// +----------------------------------------------------------------------
// | Author:  心云间、凝听 <981248356@qq.com>
// +----------------------------------------------------------------------
namespace app\wechat\model;

use app\common\model\Base;

class WechatUser extends Base {

    // 定义时间戳字段名 
    protected $createTime = '';
    protected $updateTime = '';
    /**
     * 新增微信登录用户信息
     */
    public static function add($wxid,$weixin_user){

        if ($weixin_user['uid']>0) {
            $data = [
                'uid'            => $weixin_user['uid'],
                'wxid'   		 => $wxid,
                'openid'   => $weixin_user['openid'],
                'nickname'       => $weixin_user['nickname'],
                'sex'            => $weixin_user['sex'],
                'city'           => $weixin_user['city'],
                'country'        => $weixin_user['country'],
                'province'       => $weixin_user['province'],
                'headimgurl'     => $weixin_user['headimgurl'],
                'subscribe'      => isset($weixin_user['subscribe']) ? $weixin_user['subscribe']:'', 
                'subscribe_time' => isset($weixin_user['subscribe_time']) ? $weixin_user['subscribe_time']:'',
                'unionid'        => isset($weixin_user['unionid']) ? $weixin_user['unionid']:'', 
                'last_update'    => isset($weixin_user['last_update']) ? $weixin_user['last_update']:'', 
            ];
            $info = self::create($data);
            return $info->id;
        }
        return false;
    }
    

}
