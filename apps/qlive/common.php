<?php
//模块自定义函数文件
if (!function_exists('create_stream_name')) {
    function create_stream_name($name)
    {
        $res = \password_hash($name, \PASSWORD_DEFAULT);
        $res = \preg_replace('/[^a-zA-Z0-9_-]+/', '', $res);
        $res = \str_replace('.', '', $res);
        return $res;
    }
}
