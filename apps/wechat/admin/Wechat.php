<?php
// 微信管理
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 https://www.eacoophp.com, All rights reserved.         
// +----------------------------------------------------------------------
// | [EacooPHP] 并不是自由软件,可免费使用,未经许可不能去掉EacooPHP相关版权。
// | 禁止在EacooPHP整体或任何部分基础上发展任何派生、修改或第三方版本用于重新分发
// +----------------------------------------------------------------------
// | Author:  心云间、凝听 <981248356@qq.com>
// +----------------------------------------------------------------------
namespace app\wechat\admin;
use app\admin\controller\Admin;
use app\wechat\model\Wechat as WechatModel;

class Wechat extends Admin {

    protected $wechatModel;
    protected $categoryModel;

    public function _initialize()
    {
        parent::_initialize();
        $this->wechatModel = new WechatModel();
        $this->weixinType = $this->wechatModel->weixinType();
    }
    
    //公众号管理
    public function index(){
        return Iframe()
                ->setMetaTitle('公众号管理') // 设置页面标题
                ->content($this->grid());
    }

    /**
     * 列表构建
     * @return [type] [description]
     * @date   2018-10-04
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function grid()
    {
        $map['status'] =['egt', '0']; // 禁用和正常状态
        list($data_list,$total) = $this->wechatModel
                                    ->search('name') //添加搜索查询
                                    ->getListByPage($map,true,'create_time desc');
        return builder('List')
                ->addTopBtn('addnew')  // 添加新增按钮
                ->addTopBtn('resume')  // 添加启用按钮
                ->addTopBtn('forbid')  // 添加禁用按钮
                ->addTopBtn('delete') //添加删除按钮
                ->keyListItem('name', '公众号名称')
                ->keyListItem('type', '类型','array',$this->weixinType)
                ->keyListItem('description', '描述')
                ->keyListItem('create_time','创建时间')
                ->keyListItem('status', '状态', 'status')
                ->keyListItem('right_button', '操作', 'btn')
                ->setListData($data_list)    // 数据列表
                ->setListPage($total) // 数据列表分页
                ->addRightButton('self',['title'=>'查看','class'=>'btn btn-info btn-xs','href'=>url('detail',['id'=>'__data_id__'])])->addRightButton('edit')->addRightButton('delete')
                ->fetch();
    }

    //编辑公众号
    public function edit($id=0){
        $title = $id>0 ? "编辑":"添加";
        //修改
        if(IS_POST){
            $param = $this->request->param();

            if($this->wechatModel->editData($param)){
                $this ->success($title.'成功',url('index'));
            } else{
                $this ->error($this->wechatModel->getError());
            }

        } else{

            return Iframe()
                    ->setMetaTitle($title.'公众号') // 设置页面标题
                    ->content($this->form($id));
        }
        
    }

    /**
     * 表单构建
     * @return [type] [description]
     * @date   2018-10-04
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function form($id = 0)
    {
        $info = ['status'=>1];
        if ($id>0) $info = WechatModel::get($id);

        return builder('Form')
                ->addFormItem('id', 'hidden', 'ID', 'ID')
                ->addFormItem('name', 'text', '公众号名称', '','','required','placeholder="填写公众号名称"')
                ->addFormItem('type', 'radio', '公众号类型', '',$this->weixinType,'required')         
                ->addFormItem('origin_id', 'text', '原始ID', '')
                ->addFormItem('weixin_number', 'text', '微信号', '')
                ->addFormItem('appid', 'text', 'APPID', '')
                ->addFormItem('appsecret', 'password', 'APPSECRET', '')
                ->addFormItem('mch_id', 'text', '商户号', '')
                ->addFormItem('mch_key', 'password', '商户密钥', '')
                ->addFormItem('headimg', 'image', '头像', '')
                ->addFormItem('qrcode', 'image', '二维码', '')
                ->addFormItem('description', 'textarea', '描述', '')
                ->addFormItem('status', 'radio', '状态', '',[0=>'禁用',1=>'正常',2=>'审核中'],'required')
                ->setFormData($info)
                ->addButton('submit')
                ->addButton('back')    // 设置表单按钮
                ->fetch();
    }
    
    /**
     * 显示公众号详情
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function detail($id=0){
        if ($id!=0) $weixin = WechatModel::get($id);

        $this->assign('meta_title',$weixin['name']."详情");
        $weixin['url'] = $this->request->domain().'/WxInterface/'.$weixin['id'].'.html';
        $this->assign('weixin',$weixin);
        return $this->fetch();
    }

    /**
     * 设置
     * @return [type] [description]
     * @date   2017-12-26
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function setting()
    {
        if(IS_POST){
            $data =$this->request->param();
            if ($data['wxid']>0) {
                get_wxid($data['wxid']);
                $this->success('设置成功');
            }
            $this->error('暂无改变');
        } else{
            $wxids = $this->wechatModel->where('status',1)->column('name','id');
            $info = ['wxid'=>get_wxid()];

            $content = builder('Form')
                    ->addFormItem('wxid', 'select', '启用公众号', '用于使用的',$wxids)
                    ->setFormData($info)
                    ->addButton('submit')
                    ->addButton('back')    // 设置表单按钮
                    ->fetch();
            return Iframe()
                    ->setMetaTitle('微信设置') // 设置页面标题
                    ->content($content);
        }
    }
}