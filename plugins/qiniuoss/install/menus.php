<?php

return [

    // 后台菜单及权限节点配置
    'admin_menus' =>[
        [
            'title'   =>'七牛云储存',
            'name'    =>'admin/plugins/config?name=qiniuoss',
            'icon'    => 'fa fa-file-text',
            'is_menu' => 1,
            'pid'     => 10,
        ]
        
    ],
];