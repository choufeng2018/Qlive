<?php 
// 微信用户
// +----------------------------------------------------------------------
// | Copyright (c) 2017-2018 https://www.eacoophp.com, All rights reserved.         
// +----------------------------------------------------------------------
// | [EacooPHP] 并不是自由软件,可免费使用,未经许可不能去掉EacooPHP相关版权。
// | 禁止在EacooPHP整体或任何部分基础上发展任何派生、修改或第三方版本用于重新分发
// +----------------------------------------------------------------------
// | Author:  心云间、凝听 <981248356@qq.com>
// +----------------------------------------------------------------------
namespace app\wechat\logic;
use app\wechat\model\WechatUser as WechatUserModel;

class WechatUser extends WechatLogic {
    // 定义时间戳字段名 
    protected $createTime = '';
    protected $updateTime = '';
    
    /**
     * 新增微信登录用户信息
     */
    public static function createUser($wxid,$wechat_user){

        if ($wechat_user['uid']>0) {
            $data = [
                'uid'            => $wechat_user['uid'],
                'wxid'           =>$wxid,
                'openid'         =>$wechat_user['openid'],
                'nickname'       => $wechat_user['nickname'],
                'sex'            => $wechat_user['sex'],
                'city'           => $wechat_user['city'],
                'country'        => $wechat_user['country'],
                'province'       => $wechat_user['province'],
                'headimgurl'     => $wechat_user['headimgurl'],
                'subscribe'      => isset($wechat_user['subscribe']) ? $wechat_user['subscribe']:'', 
                'subscribe_time' => isset($wechat_user['subscribe_time']) ? $wechat_user['subscribe_time']:'',
                'unionid'        =>isset($wechat_user['unionid']) ? $wechat_user['unionid']:'',
                'last_update'    => isset($wechat_user['last_update']) ? $wechat_user['last_update']:'', 
            ];
                /*$res = self::create($data); */
            $wechatuserModel = new WechatUserModel;
            $wechatuserModel->allowField(true)->isUpdate(false)->data($data)->save();
            return $wechatuserModel->id;
        }
        return false;
    }
}
