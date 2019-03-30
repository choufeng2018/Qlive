<?php

/**
 * 菜单配置文件
 * 参考文档：https://www.kancloud.cn/youpzt/eacoo/413039
 */
return [
    'admin_menus' => [
        [
            'title' => '应用配置',
            'name' => 'admin/modules/config?name=qlive',
            'icon' => 'fa fa-cog ',
            'is_menu' => 1,
            'no_pjax' => 1,
        ],
        [
            'title' => '分类管理',
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
            'title' => '开播申请',
            'name' => 'qlive/Apply/index',
            'icon' => 'fa fa-book',
            'is_menu' => 1,
        ],
        [
            'title' => '历史记录',
            'name' => 'qlive/History/index',
            'icon' => 'fa fa-history',
            'is_menu' => 1,
        ],
        [
            'title' => '直播预告',
            'name' => 'qlive/apprise/index',
            'icon' => 'fa fa-volume-up',
            'is_menu' => 1,
        ],
        [
            'title' => '文章管理',
            'name' => 'qlive/posts/index',
            'icon' => 'fa fa-file-picture-o',
            'is_menu' => 1,
        ],

        [
            'title' => '视频列表',
            'name' => 'qlive/video/index',
            'icon' => 'fa fa-film',
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
];
