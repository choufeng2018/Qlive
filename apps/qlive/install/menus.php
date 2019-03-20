<?php

/**
 * 菜单配置文件
 * 参考文档：https://www.kancloud.cn/youpzt/eacoo/413039
 */
return [
    'admin_menus' => [
        [
            'title' => '小Q直播',
            'name' => 'live/index',
            'icon' => 'fa fa-video-camera',
            'is_menu' => 1,
            'sub_menu' => [
                [
                    'title' => '应用配置',
                    'name' => 'admin/modules/config?name=qlive',
                    'icon' => 'fa fa-cog ',
                    'is_menu' => 1,
                    'no_pjax' => 1,
                ],
                [
                    'title' => '直播分类',
                    'name' => 'qlive/category/index',
                    'icon' => 'fa fa-cubes',
                    'is_menu' => 1,
                ],
                [
                    'title' => '房间管理',
                    'name' => 'qlive/room/index',
                    'icon' => 'fa fa-key',
                    'is_menu' => 1,
                ],
                [
                    'title' => '主播列表',
                    'name' => 'qlive/anchor/index',
                    'icon' => 'fa fa-podcast',
                    'is_menu' => 1,
                ],
                [
                    'title' => '申请列表',
                    'name' => 'qlive/anchor_apply/index',
                    'icon' => 'fa fa-file-text-o',
                    'is_menu' => 1,
                ],

                [
                    'title' => '文章管理',
                    'name' => 'qlive/posts/index',
                    'icon' => 'fa fa-file-picture-o',
                    'is_menu' => 1,
                ],
                [
                    'title' => '直播预告',
                    'name' => 'qlive/apprise/index',
                    'icon' => 'fa fa-volume-up',
                    'is_menu' => 1,
                ],
                [
                    'title' => '视频分类',
                    'name' => 'qlive/video_category/index',
                    'icon' => 'fa fa-yelp',
                    'is_menu' => 1,
                ],
                [
                    'title' => '视频列表',
                    'name' => 'qlive/video/index',
                    'icon' => 'fa fa-youtube-play',
                    'is_menu' => 1,
                ],
                ['title' => '评论列表',
                    'name' => 'qlive/comment/index',
                    'icon' => 'fa fa-commenting-o',
                    'is_menu' => 1,
                ],
                [
                    'title' => '提问列表',
                    'name' => 'qlive/question/index',
                    'icon' => 'fa fa-question-circle-o',
                    'is_menu' => 1,
                ],
            ],
        ],
    ],
];
