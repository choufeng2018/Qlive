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
    function getAnchorNameById($id)
    {
        $name = Db::name('QliveAnchorList')
            ->where('id', $id)
            ->value('name');
        return $name;
    }
}
