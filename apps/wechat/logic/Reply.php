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
 * 回复逻辑处理
 * @author 心云间、凝听 <981248356@qq.com>
 */
class Reply extends WechatLogic {
	
    /**
     * 获取Builder的tab
     * @return [type] [description]
     * @date   2018-02-23
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function getBuilderTab()
    {
        $tab_list = [
            'keyword' => ['title'=>'关键词回复','href'=>url('keyword')],
            'special' => ['title'=>'特殊回复','href'=>url('special')],
            'event'   => ['title'=>'事件回复','href'=>url('event')]
        ];
        return $tab_list;
    }

    /**
     * 表单额外HTML
     * @return [type] [description]
     * @date   2017-12-23
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function formExtraHtml()
    {
        return <<<EOF
        <script type="text/javascript">
            function set_material_val(inputnode,material_id){
                if (!material_id) return false;
                $('#m_'+inputnode).val(material_id);
                layer.closeAll('iframe');
            }
        </script>
EOF;
    }

    /**
     * 素材输入框
     * @param  string $value [description]
     * @return [type] [description]
     * @date   2017-12-21
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function materialInputHtml($name = '',$data=[])
    {
        try {
            if (!$name) {
                throw new \Exception("Name值不能为空");
            }
            $value = '';
            if (isset($data[$name])) {
                $value = $data[$name];
            }
            return '<div class="col-md-5" style="padding-left:0;"><div class="input-group"><input type="number" class="form-control" name="'.$name.'" id="m_'.$name.'" value="'.$value.'" readonly><span class="input-group-btn"><button type="button" class="btn btn-success btn-flat" onclick="javascript:layer.open({type: 2,title: \'选择素材\',shadeClose: true,shade: 0.8,area: [\'50%\',\'60%\'],content:\''.url('wechat/Material/iframeChooseList',['inputnode'=>$name]).'\'});"><i class="fa fa-edit"></i> 选择素材</button></span></div></div>';
        } catch (\Exception $e) {
            return '';
        }
        
    }
}
