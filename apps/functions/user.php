<?php

use app\common\logic\User as UserLogic;

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author 心云间、凝听 <981248356@qq.com>
 */
function is_login()
{
    return UserLogic::isLogin();
}

/**
 * 根据用户ID获取用户信息
 * @param integer $id 用户ID
 * @return array  用户信息
 */
function get_user_info($uid)
{
    if ($uid > 0) {
        return UserLogic::info($uid);
    }
    return false;

}


/**
 * @param int $uid
 * @return bool|mixed
 * 获取用户昵称
 */
function get_nickname($uid = 0)
{
    if ($uid > 0) {
        return UserLogic::where('uid', $uid)->value('nickname');
    }
    return false;
}

if (!function_exists('get_user_avatar_by_uid')) {
    /**
     * @param $uid
     * @return mixed
     * 根据用户名获取头像
     */
    function get_user_avatar_by_uid($uid)
    {
        $avatar = db('Users')
            ->where('uid', 'eq', $uid)
            ->value('avatar');
        if (!empty($avatar)) {
            return $avatar;
        } else {
            return '/uploads/avatar/default-avatar.png';
        }
    }
}
