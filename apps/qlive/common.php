<?php
//模块自定义函数文件
use think\Db;

if (!function_exists('create_stream_name')) {
    /**
     * @return string
     * 生成唯一的直播密钥
     * 增加房间时生成,绑定一个房间
     * 分配给主播用于推流
     */
    function create_stream_name()
    {
        $res = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . time() . rand();
        return sha1($res);
    }
}

if (!function_exists('getAnchorNameById')) {
    /**
     * @param $id
     * @return mixed
     * 根据主播ID获取主播姓名
     */
    function getAnchorNameById($id)
    {
        $name = Db::name('QliveAnchorList')
            ->where('id', $id)
            ->value('name');
        if (!empty($name)) {
            return $name;
        } else {
            return '未知主播';
        }
    }
}
if (!function_exists('getAnchorIdByName')) {
    /**
     * @param $name
     * @return mixed
     * 根据主播名称获取主播ID
     */
    function getAnchorIdByName($name)
    {
        $name = trim($name);
        $id = Db::name('QliveAnchorList')
            ->where('name', 'eq', $name)
            ->value('id');
        return $id;
    }
}

if (!function_exists('getStreamByAnchorId')) {
    /**
     * @param $anchor_id
     * @return mixed
     * 根据主播ID获取对应的推流码
     */
    function getStreamByAnchorId($anchor_id)
    {
        $stream = Db::name('QliveRoomList qrl')
            ->join('QliveAnchorList qal', 'qrl.anchor_id=qal.id')
            ->where('qal.id', 'eq', $anchor_id)
            ->value('qrl.stream');
        return $stream;
    }
}
if (!function_exists('getAdminNameById')) {
    /**
     * @param $id
     * @return mixed
     * 根据管理员id获取管理员名称
     */
    function getAdminNameById($id)
    {
        $name = Db::name('Admin')
            ->where('uid', 'eq', $id)
            ->value('username');
        return $name;
    }
}
if (!function_exists('getLiveTitleById')) {
    /**
     * @param $id
     * @return mixed
     * 根据直播记录的id获取直播名称
     */
    function getLiveTitleById($id)
    {
        $title = Db::name('QliveLiveHistory')
            ->where('id', 'eq', $id)
            ->value('title');
        return $title;
    }
}
if (!function_exists('getUserNameById')) {
    /**
     * @param $uid
     * @return mixed
     * 根据uid获取username
     */
    function getUserNameById($uid)
    {
        $username = Db::name('Users')
            ->where('uid', 'eq', $uid)
            ->value('username');
        return $username;
    }
}
