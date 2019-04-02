<?php
//模块配置文件，只在模块中有效
return [
    //直播类型
    'live_type' => [
        '干货分享',
        '圆桌会议',
        '小型沙龙',
        '技术峰会',
        '其他'
    ],
    //文章类型
    'post_category' => [
        '未分类',
        '讲师介绍',
        '课程介绍'
    ],
    //直播预告/开播申请的标记
    'apprise_flag' => [
        '未分类',
        '置顶',
        '火爆',
        '推荐',
    ],

    //token过期时间
    'token_expire' => 24 * 3600 * 180,
    //用于生成sign签名的key
    'sign_key' => 'GYUGJHBNKJoijgjewgkljweojgjw',
];
