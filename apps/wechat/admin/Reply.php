<?php
// 自定义回复
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 https://www.eacoophp.com, All rights reserved.         
// +----------------------------------------------------------------------
// | [EacooPHP] 并不是自由软件,可免费使用,未经许可不能去掉EacooPHP相关版权。
// | 禁止在EacooPHP整体或任何部分基础上发展任何派生、修改或第三方版本用于重新分发
// +----------------------------------------------------------------------
// | Author:  心云间、凝听 <981248356@qq.com>
// +----------------------------------------------------------------------
namespace app\wechat\admin;

use app\wechat\model\Reply as ReplyModel;
use app\wechat\model\Material as MaterialModel;

class Reply extends Base {
    
    protected $replyModel;
    protected $materialModel;

    function _initialize()
    {
        parent::_initialize();
        $this->replyModel     = new ReplyModel();
        $this->materialModel = new MaterialModel();
        
    }
    
    /**
     * 关键字回复
     * @param  integer $reply_type [description]
     * @return [type] [description]
     * @date   2017-12-14
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function keyword(){
        
        return Iframe()
                ->setMetaTitle('关键词回复') // 设置页面标题
                ->content($this->keywordGrid());
    }

    /**
     * 关键字列表构建
     * @return [type] [description]
     * @date   2018-10-05
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function keywordGrid($reply_type = 0)
    {
        $map['status'] = ['egt', '0']; // 禁用和正常状态
        if($reply_type) $map['reply_type']=$reply_type;
        $map['type'] ='keyword';
        $map['wxid'] = $this->wxid;
        list($data_list,$total) = $this->replyModel
                                    //->search('title') //添加搜索查询
                                    ->getListByPage($map,true,'id desc');
        foreach ($data_list as $key => $data) {
            $metarial_data = $this->materialModel->where('id',$data['material_id'])->find();
            $data_list[$key]['reply_type']=$metarial_data['type'];
            switch ($metarial_data['type']) {
                case 'text':
                    $data_list[$key]['reply_content']= cut_str($metarial_data['content'],160,0,0);
                    break;
                case 'image':
                    $data_list[$key]['reply_content']='<img class="cover" width="120" src="'.get_image($metarial_data['attachment_id'],'medium').'">';
                    break;
                case 'news':
                    $data_list[$key]['reply_content']='<div class="oh" style="background:#fff;border:1px dotted #ddd;padding:6px;border-radius:5px;width:100%;"><a href="'.$metarial_data['url'].'" target="_blank" class="color-6 f12"><h6 class="fb">'.$metarial_data['title'].'</h6><div class="col-md-3 pd0"><img class="cover" width="100" src="'.get_image($metarial_data['attachment_id'],'medium').'"></div><div class="col-md-8">'.cut_str($metarial_data['news_content'],80,0,0).'</div></a></div>';
                    break;
                default:
                    $data_list[$key]['reply_content']='';
                    break;
            }
            
        }
        $optType=[
                ['id'=>0,'value'=>'全部类型'],
                ['id'=>'text','value'=>'文本'],
                ['id'=>'image','value'=>'图片'],
                ['id'=>'news','value'=>'图文'],
            ];
        $tab_list = logic('Reply')->getBuilderTab();
         return  builder('list')
                ->setTabNav($tab_list,'keyword')  // 设置Tab按钮列表
                ->addTopBtn('addnew',['title'=>'添加'])  // 添加新增按钮
                ->addTopBtn('resume')  // 添加启用按钮
                ->addTopBtn('forbid')  // 添加禁用按钮
                ->addTopBtn('delete') //添加删除按钮
                //->addSelect('类型','reply_type',$optType)//添加分类筛选
                ->keyListItem('keyword', '关键词')
                ->keyListItem('reply_type','回复类型', 'array',array('text'=>'<label class="label label-info">文本</label>','image'=>'<label class="label label-primary">图片</label>','news'=>'<label class="label label-success">图文</label>'))
                ->keyListItem('reply_content', '回复内容',null,null,'width="430"')
                ->keyListItem('right_button', '操作', 'btn')
                ->setListData($data_list)    // 数据列表
                ->setListPage($total) // 数据列表分页
                ->addRightButton('edit')->addRightButton('delete')
                ->fetch();
    }

    /**
     * 编辑回复
     * @param  integer $id [description]
     * @return [type] [description]
     * @date   2018-02-23
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function edit($id=0){
        $title = $id ? "编辑" : "添加";
        //修改
        if(IS_POST){
            $params = $this->request->param();
            
            $reply_id =input('param.id',false);
            if ($reply_id) {
                $data['id']=$reply_id;
            }
            $data['material_id'] = !empty($params['material_id']) ? $params['material_id'] : 0;//素材ID
            $data['wxid']        = $this->wxid;
            $data['type']        = 'keyword';
            $data['reply_type']  = isset($params['reply_type']) ? $params['reply_type']:'';
            $data['keyword']     = input('post.keyword');

            $result = $this->replyModel->editData($data);
            if($result){
                $this->success($title.'成功',url('keyword'));
            }else{
                if (!$result && $res_id) {//只更新素材内容
                    $this->success('回复素材更新成功');
                }
                $this->error($title.'失败');
            }

        } else{
            if ($id>0){
                $info = ReplyModel::get($id);
                $info['from']='add';
            } else{
                $info['reply_type']='text';
                $info['from']='add';
                $info['status']=1;
            }
            $extra_html = logic('Reply')->formExtraHtml();
            $content =  builder('form')
                        ->addFormItem('id', 'hidden', 'ID', 'ID')
                        ->addFormItem('keyword', 'text', '关键词', '','','required','placeholder="填写关键词"')
                        ->addFormItem('material_id', 'self','素材ID','',logic('Reply')->materialInputHtml('material_id',$info))   
                        ->addFormItem('status', 'radio', '状态', '',array(0=>'禁用',1=>'正常',2=>'审核中'),'required')
                        //->setExtraItems(array('type'=>3,'status'=>1))
                        ->setFormData($info)
                        ->setExtraHtml($extra_html)
                        ->setAjaxSubmit(false)
                        ->addButton('submit')->addButton('back')    // 设置表单按钮
                        ->fetch();

            return Iframe()
                    ->setMetaTitle($title.'自动回复')
                    ->content($content);
        }
        
    }

    //编辑回复
    public function edit_big($id=0){
        $title = $id>0 ? "编辑":"添加";
        //修改
        if(IS_POST){
            $material_id=input('post.material_id',false);
            $reply_type=input('reply_type',false);

            if($material_id) $material_data['id']=$material_id;
            $material_data['wxid']=$this->wxid;
            $material_data['type']=$reply_type;
            if($reply_type=='text') {
                $material_data['title']='关键字回复';
                $material_data['content']=input('post.reply_textarea','','htmlspecialchars_decode');
            }elseif ($reply_type=='image') {
                $material_data['image']=input('post.reply_img');
            }elseif ($reply_type=='news') {
                $material_data['news_title']   =input('post.news_title');
                $material_data['news_img']     =input('post.news_img');
                $material_data['news_url']     =input('post.news_url');
                $material_data['news_content'] =input('post.news_content');
            }
            $res_id = $this->materialModel->editData($material_data);
            
            $reply_id=input('post.id',false);
            if ($reply_id) {
                $data['id']=$reply_id;
            }
            $data['material_id'] =$material_id ? $material_id:$res_id;//素材ID
            $data['wxid']        =$this->wxid;
            $data['type']        ='keyword';
            $data['reply_type']  =$reply_type;
            $data['keyword']     =input('post.keyword');
            
            if($data){
                $result = $this->replyModel->editData($data);
                if($result){
                    $this->success($title.'成功',url('keyword'));
                }else{
                    if (!$result&&$res_id) {//只更新素材内容
                        $this->success('回复素材更新成功');
                    }
                    $this->error($title.'失败');
                }
            }else{
                $this->error($this->replyModel->getError());
            }
            return;
        } else{
            if ($id>0){
                $info = $this->replyModel->find($id);
                $metarial_data=$this->materialModel->find($info['material_id']);
                if ($metarial_data) {
                    $info['reply_textarea'] =$metarial_data['content'];
                    $info['reply_img']      =$metarial_data['image'];
                    
                    $info['news_title']     =$metarial_data['news_title'];
                    $info['news_img']       =$metarial_data['news_img'];
                    $info['news_url']       =$metarial_data['news_url'];
                    $info['news_content']   =$metarial_data['news_content'];
                }
            }else{
                    $info['reply_type']='text';
                }

            $extra_html=$this->selectExtraHtml();

            // 使用FormBuilder快速建立表单页面。
            $content = builder('form')
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                    ->addFormItem('material_id', 'hidden')
                    ->addFormItem('keyword', 'text', '关键词', '','','required','placeholder="填写关键词"')     
                    ->addFormItem('reply_type', 'select', '类型','',$this->replyTypeList)
                    ->addFormItem('reply_textarea', 'textarea', '文本内容', '')
                    ->addFormItem('reply_img', 'picture', '回复图片', '')
                    ->addFormItem('news_title', 'text', '图文标题', '')
                    ->addFormItem('news_img', 'picture', '图文封面', '')
                    ->addFormItem('news_url', 'text', '图文链接', '')
                    ->addFormItem('news_content', 'wangeditor', '图文内容', '',array('config'=>'all','height'=>'360px'))
                    ->addFormItem('status', 'radio', '状态', '',array(0=>'禁用',1=>'正常',2=>'审核中'),'required')
                    //->setExtraItems(array('type'=>3,'status'=>1))
                    ->setFormData($info)
                    ->setExtraHtml($extra_html)
                    ->addButton('submit')->addButton('back')    // 设置表单按钮
                    ->fetch();

            return Iframe()
                    ->setMetaTitle($title.'自动回复')
                    ->content($content);
        }
        
    }
    
    //特殊回复
    public function special(){
        if (IS_POST) {
            // 批量添加数据
            $dataList[] = array('type'=>'image','material_id'=>input('post.image'));
            $dataList[] = array('type'=>'voice','material_id'=>input('post.voice'));
            $dataList[] = array('type'=>'shortvideo','material_id'=>input('post.shortvideo'));
            $dataList[] = array('type'=>'location','material_id'=>input('post.location'));
            $dataList[] = array('type'=>'link','material_id'=>input('post.link'));
            $dataList[] = array('type'=>'default','material_id'=>input('post.default'));
            //$data=$this->replyModel->addAll($dataList);
            foreach ($dataList as $key => $data) {
                $res = $this->replyModel->where(['type'=>$data['type']])->find();
                if ($res) {
                    $result = $this->replyModel->where(['id'=>$res['id']])->setField('material_id',$data['material_id']);
                } else{
                    $data['wxid'] = $this->wxid;
                    $result       = $this->replyModel->isUpdate(false)->allowField(true)->data($data)->save();
                }
            }
            $this->success('更新成功',url('special'));

        } else{
            $map         = [];
            $map['type'] = ['in','image,voice,shortvideo,location,link,default'];
            $map['wxid'] = $this->wxid;
            $results     = $this->replyModel->where($map)->select();
            $info        = [];
            foreach ($results as $key => $row) {
                $info[$row['type']]=$row['material_id'];
            }

            $extra_html = logic('Reply')->formExtraHtml();
            $tab_list = logic('Reply')->getBuilderTab();
            $content =  builder('form')
                        ->addFormItem('id', 'hidden', 'ID', 'ID')
                        ->setTabNav($tab_list,'special')  // 设置Tab按钮列表
                        ->setPageTips('特殊回复内容需要绑定一个素材ID，<a href="'.url('wechat/Material/text').'" target="_blank">查找素材</a>')
                        ->addFormItem('image', 'self', '图片消息', '留空或0表示不处理',logic('Reply')->materialInputHtml('image',$info),'','placeholder="素材ID"')
                        ->addFormItem('voice', 'self', '语音消息', '留空或0表示不处理',logic('Reply')->materialInputHtml('voice',$info),'','placeholder="素材ID"')
                        ->addFormItem('shortvideo', 'self', '短视频消息', '留空或0表示不处理',logic('Reply')->materialInputHtml('shortvideo',$info),'','placeholder="素材ID"')
                        ->addFormItem('location', 'self', '位置消息', '留空或0表示不处理',logic('Reply')->materialInputHtml('location',$info),'','placeholder="素材ID"')
                        ->addFormItem('link', 'self', '链接消息', '留空或0表示不处理',logic('Reply')->materialInputHtml('link',$info),'','placeholder="素材ID"')
                        ->addFormItem('default', 'self', '默认回复', '当用户发送的消息没有触发任何回复规则时回复的消息',logic('Reply')->materialInputHtml('default',$info),'','placeholder="素材ID"')
                        ->setFormData($info)
                        ->setExtraHtml($extra_html)
                        //->setAjaxSubmit(false)
                        ->addButton('submit')->addButton('back')    // 设置表单按钮
                        ->fetch();

            return Iframe()
                    ->setMetaTitle('特殊回复') // 设置页面标题
                    ->content($content);
        }
    }

    //事件回复
    public function event(){
        if (IS_POST) {
            $post_data = $this->request->param();
            $dataList = [
                ['type'=>'subscribe','material_id'=>$post_data['subscribe']],
                ['type'=>'unsubscribe','material_id'=>$post_data['unsubscribe']],
                ['type'=>'scan','material_id'=>$post_data['scan']],
                ['type'=>'report_location','material_id'=>$post_data['report_location']],
                ['type'=>'click','material_id'=>$post_data['click']]
            ];

            //$data=$this->replyModel->addAll($dataList);
            foreach ($dataList as $key => $data) {
                $res = $this->replyModel->where(['type'=>$data['type']])->find();
                if ($res) {
                    $result = $this->replyModel->where(['id'=>$res['id']])->setField('material_id',$data['material_id']);
                } else{
                    $data['wxid']=$this->wxid;
                    $result = $this->replyModel->allowField(true)->isUpdate(false)->data($data)->save();
                }
            }
            $this->success('操作成功',url('event'));
        } else{
            $map = [];
            $map['type']=array('in','subscribe,unsubscribe,scan,report_location,click');
            $map['wxid']=$this->wxid;
            $results = $this->replyModel->where($map)->select();
            $info=[];
            foreach ($results as $key => $row) {
                $info[$row['type']]=$row['material_id'];
            }
            $extra_html = logic('Reply')->formExtraHtml();

            $tab_list = logic('Reply')->getBuilderTab();
            $content = builder('form')
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                    ->setTabNav($tab_list,'event')  // 设置Tab按钮列表
                    ->setPageTips('事件回复内容需要绑定一个素材ID，留空或0表示不处理，<a href="'.url('wechat/Material/text').'" target="_blank">查找素材</a>')
                    ->addFormItem('subscribe', 'self', '关注', '关注欢迎语',logic('Reply')->materialInputHtml('subscribe',$info),'','placeholder="素材ID"')
                    ->addFormItem('unsubscribe', 'self', '取消关注', '用户取消关注进行事件回复',logic('Reply')->materialInputHtml('unsubscribe',$info),'','placeholder="素材ID"')
                    ->addFormItem('scan', 'self', '扫描二维码', '绑定关键词进行处理',logic('Reply')->materialInputHtml('scan',$info),'','placeholder="素材ID"')
                    ->addFormItem('report_location', 'self', '上报地理位置', '',logic('Reply')->materialInputHtml('report_location',$info),'','placeholder="素材ID"')
                    ->addFormItem('click', 'self', '点击菜单拉取消息', '',logic('Reply')->materialInputHtml('click',$info),'','placeholder="素材ID"')
                    ->setFormData($info)
                    ->setExtraHtml($extra_html)
                    ->addButton('submit')->addButton('back')    // 设置表单按钮
                    ->fetch();

            return Iframe()
                    ->setMetaTitle('事件回复') // 设置页面标题
                    ->content($content);
        }
    }

    
}