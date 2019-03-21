<?php 
// +----------------------------------------------------------------------
// | Copyright (c) 2017-2018 https://www.eacoophp.com, All rights reserved.         
// +----------------------------------------------------------------------
// | [EacooPHP] 并不是自由软件,可免费使用,未经许可不能去掉EacooPHP相关版权。
// | 禁止在EacooPHP整体或任何部分基础上发展任何派生、修改或第三方版本用于重新分发
// +----------------------------------------------------------------------
// | Author:  心云间、凝听 <981248356@qq.com>
// +----------------------------------------------------------------------
namespace app\wechat\logic;

/**
 * 素材逻辑处理
 * @author 心云间、凝听 <981248356@qq.com>
 */
class Material extends WechatLogic {
	
    //表单额外代码
    public function adminSelectExtraHtml(){
        return <<<EOF
<script type="text/javascript">
 $(function(){
    $('.item_type').hide();
    var type = $('#type').find("option:selected").attr("data-type");console.log(type);
    switch_form_item(type);
    $('#type').on('change',function(){
        var type = $('#type').find("option:selected").attr("data-type");
        switch_form_item(type);
    });
})
//事件方法
function switch_form_item(type){
    type=parseInt(type);
    if(type == 1){
        $('.item_content,.item_title').show();
        $('.item_attachment_id,.item_description,.item_attachment_id,.item_url,.item_news_content').hide();
    }else if(type ==2){
        $('.item_attachment_id').show();
        $('.item_content,.item_description,.item_title,.item_url,.item_news_content').hide();
    }else if(type == 3){
        $('.item_title,.item_description,.item_attachment_id,.item_url,.item_news_content').show();
        $('.item_content,.item_attachment_id').hide();
    } else{
        $('.item_content,.item_description,.item_attachment_id,.item_title,.item_url,.item_attachment_id,.item_news_content').hide();
    }
}
</script>
EOF;
    }
}
