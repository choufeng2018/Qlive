<?php 
// 微信素材管理
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 https://www.eacoophp.com, All rights reserved.         
// +----------------------------------------------------------------------
// | [EacooPHP] 并不是自由软件,可免费使用,未经许可不能去掉EacooPHP相关版权。
// | 禁止在EacooPHP整体或任何部分基础上发展任何派生、修改或第三方版本用于重新分发
// +----------------------------------------------------------------------
// | Author:  心云间、凝听 <981248356@qq.com>
// +----------------------------------------------------------------------
namespace app\wechat\model;

use app\common\model\Base;

class Material extends Base {
	protected $name = 'wechat_material';

	// 定义时间戳字段名 
    protected $updateTime = '';

    /**
     * 类型文字
     * @param  [type] $value [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    public function getTypeTextAttr($value,$data)
    {	
    	//状态。0待审核，1审核通过,转账中，2提现成功，3已拒绝，4已取消
        $status = ['text'=>'文本','image'=>'图片','news'=>'文章','voice'=>'音频','video'=>'视频'];
        return isset($status[$data['type']]) ? $status[$data['type']]:'未知';
    }
}
