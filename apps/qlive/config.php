<?php
//模块配置文件，只在模块中有效
return [
    //后台添加主播时的默认密码
    'default_password' => 123456,
    //直播类型
    'live_type' => [
        1 => '干货分享',
        2 => '圆桌会议',
        3 => '小型沙龙',
        4 => '技术峰会',
        5 => '其他'
    ],
    //文章类型
    'post_category' => [
        1 => '未分类',
        2 => '讲师介绍',
        3 => '课程介绍'
    ],
    //直播预告/开播申请的标记
    'apprise_flag' => [
        1 => '未分类',
        2 => '置顶',
        3 => '火爆',
        4 => '推荐',
    ],

    //token过期时间
    'token_expire' => 24 * 3600 * 180,
    //用于生成sign签名的key
    'sign_key' => 'GYUGJHBNKJoijgjewgkljweojgjw',
    //阿里云通信的模板配置
    'alisms_config' => [
        //过期秒数
        'expire' => '180',
        //注册用模板
        'register' => 'SMS_73000100',
        //重置密码
        'reset_password' => 'SMS_73000098'
    ],
];
