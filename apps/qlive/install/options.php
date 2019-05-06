<?php

return [
    'status' => [
        'title' => '是否开启qlive:',
        'type' => 'radio',
        'options' => [
            '1' => '开启',
            '0' => '关闭',
        ],
        'value' => '1',
    ],
    'AccessKey' => [
        'title' => 'AK:',
        'type' => 'text',
        'value' => '',
        'description' => '请通过<a href="https://www.qiniu.com/" target="_blank">七牛云直播</a>申请',
    ],
    'SecretKey' => [
        'title' => 'SK:',
        'type' => 'text',
        'value' => '',
        'description' => '请通过<a href="https://www.qiniu.com/" target="_blank">七牛云直播</a>申请',
    ],
    'HubName' => [
        'title' => '直播空间名:',
        'type' => 'text',
        'value' => '',
        'description' => '请通过<a href="https://www.qiniu.com/" target="_blank">七牛云直播</a>添加',
    ],
    'LiveDomain' => [
        'title' => 'RTMP推流地址:',
        'type' => 'text',
        'value' => '',
        'description' => '请在直播空间的域名管理中获取'
    ],
    //暂时用不到,反正留着没毛病
    'BucketName' => [
        'title' => '储存空间名称:',
        'type' => 'text',
        'value' => '',
        'description' => '输入用于储存视频的bucket名称,请通过<a href="https://www.qiniu.com/" target="_blank">七牛云</a>获取',
    ]
];
