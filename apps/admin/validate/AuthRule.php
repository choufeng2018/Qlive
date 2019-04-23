<?php

namespace app\admin\validate;

use think\Validate;

/**
 * Class AuthRule
 * @package app\admin\validate
 * 规则验证器
 */
class AuthRule extends Validate
{
    // 验证规则
    protected $rule = [
        'title' => 'require',
        'name'  => 'require',
        'depend_type'  => 'require',
        'depend_flag'  => 'require',
    ];

    protected $message = [
        'title.require'   => '标题不能为空',
        'name.require'    => '链接/规则不能为空',
        'depend_type.require'    => '请选择一个来源类型',
        'depend_flag.require'    => '请选择一个来源标识',
        // 'name.between' => '链接长度为1-80个字符',
        // 'name.unique'  => '链接已经存在',
    ];

    protected $scene=[
        'edit' => ['title','name','depend_type','depend_flag'],
    ];
}
