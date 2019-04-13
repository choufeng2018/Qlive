<?php
return [
    'enable'=>[
        'title'=>'是否开启:',
        'type'=>'radio',
        'options'=>[
            1=>'开启',
            0=>'关闭',
        ],
        'value'=>1,
    ],
    'bucket'=>[
        'title' =>'Bucket名称:',
        'type'  =>'text',
        'value' =>'eacoomall-qiniu',
    ],
    'access_key_id'=>[
        'title' =>'accessKey:',
        'type'  =>'text',
        'value' =>'', 
    ],
    'access_key_secret'=>[
        'title' =>'secretKey :',
        'type'  =>'text',
        'value' =>'', 
    ],
    'root_path'=>[
        'title' =>'图片存储根目录:',
        'description'=>'系统上传的所有图片均将被存放在此目录下，为空则存放在OSS根目录下，默认为“images”',
        'type'  =>'text',
        'value' =>'images', 
    ],
    'domain'=>[
        'title' =>'自定义绑定域名:',
        'type'  =>'text',
        'value' =>'http://img.eacoomall.com', 
    ],
    'endpoint'=>[
        'title' =>'外网地址endpoint:',
        'type'  =>'text',
        'value' =>'http://pamlntz0m.bkt.clouddn.com',
    ],
    'style'=>[
        'title' => '图片规则',
        'type'  => 'repeater',
        'options'=>[
            'options'=>
                [
                    'name'  =>['title'=>'规则名','type'=>'text','default'=>'','placeholder'=>''],
                ]
            ],
        'value' => [
                ['name'=>'wap-thumb'],
                ['name'=>'small'],
                ['name'=>'medium'],
                ['name'=>'large'],
            ]
    ]
    
];
                    