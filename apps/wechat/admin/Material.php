<?php
// 素材管理
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 https://www.eacoophp.com, All rights reserved.         
// +----------------------------------------------------------------------
// | [EacooPHP] 并不是自由软件,可免费使用,未经许可不能去掉EacooPHP相关版权。
// | 禁止在EacooPHP整体或任何部分基础上发展任何派生、修改或第三方版本用于重新分发
// +----------------------------------------------------------------------
// | Author:  心云间、凝听 <981248356@qq.com>
// +----------------------------------------------------------------------
namespace app\wechat\admin;

use app\wechat\model\Material as MaterialModel;
use app\common\model\Attachment as AttachmentModel;
use EasyWeChat\Factory;

class Material extends Base {

    protected $WechatObj;
    protected $access_token;
    protected $materialModel;

    function _initialize()
    {
        parent::_initialize();

        $this->materialModel = new MaterialModel();
        $this->tab_list = [
                'text'  =>['title'=>'文本素材','href'=>url('text')],
                'image' =>['title'=>'图片素材','href'=>url('image')],
                //'voice' =>['title'=>'音频素材','href'=>url('voice')],
                //'video' =>['title'=>'视频素材','href'=>url('video')],
                'news'  =>['title'=>'图文素材','href'=>url('news')]
            ];
            
        $wechat_option = get_wechat_info($this->wxid);
        $options = [
           /**
             * Debug 模式，bool 值：true/false
             *
             * 当值为 false 时，所有的日志都不会记录
             */
            'debug'  => false,
            /**
             * 账号基本信息，请从微信公众平台/开放平台获取
             */
            'app_id'  => $wechat_option['appid'],         // AppID
            'secret'  => $wechat_option['appsecret'],     // AppSecret
            'token'   => $wechat_option['valid_token'],   // Token
            'aes_key' => $wechat_option['encodingaeskey'],  // EncodingAESKey，安全模式下请一定要填写！！！
            /**
             * 日志配置
             *
             * level: 日志级别, 可选为：
             *         debug/info/notice/warning/error/critical/alert/emergency
             * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
             * file：日志文件位置(绝对路径!!!)，要求可写权限
             */
            'log' => [
                'level'      => 'debug',
                'permission' => 0777,
                'file'       => 'runtime/log/wechat/easywechat.logs',
            ],
        ];//dump($options);
        $this->app = Factory::officialAccount($options);
    }

    //文本素材管理
    public function text(){

        $map = [
            'wxid'=>$this->wxid,
            'type'=>'text',
            'status'=>['egt',0]
        ];
        list($data_list,$total) = $this->materialModel
                                    ->search('title') //添加搜索查询
                                    ->getListByPage($map,true,'create_time desc');
        foreach ($data_list as $key => $data) {
            $data_list[$key]['content'] = cut_str($data['content'],160,0,0);
        }
        $content = builder('list')
                ->setMetaTitle('文本素材') // 设置页面标题
                ->setTabNav($this->tab_list,'text')  // 设置Tab按钮列表
                ->addTopBtn('addnew',['title'=>'添加文本素材','href'=>url('edit',['type'=>'text'])])  // 添加新增按钮
                ->addTopBtn('delete') //添加删除按钮
                ->setSearch('请输入ID/名称',url('text'))
                ->keyListItem('id', 'ID')
                ->keyListItem('title', '标题')
                ->keyListItem('content', '素材内容',null,null,'width="430"')
                ->keyListItem('create_time','创建时间')
                ->keyListItem('status', '状态', 'status')
                ->keyListItem('right_button', '操作', 'btn')
                ->setListData($data_list)    // 数据列表
                ->setListPage($total) // 数据列表分页
                ->addRightButton('edit')
                ->addRightButton('delete')
                ->fetch();

        return Iframe()
                ->setMetaTitle('文本素材') // 设置页面标题
                ->content($content);
    }

    /**
     * 图片素材管理
     * @return [type] [description]
     * @date   2017-12-18
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function image(){

        $map = [
            'type'=>'image',
            'wxid'=>$this->wxid,
            'status'=>['egt',0]
        ];
        list($data_list,$total) = $this->materialModel
                                    ->search('title') //添加搜索查询
                                    ->getListByPage($map,true,'create_time desc');
        $content= builder('list')
                ->setMetaTitle('图片素材') // 设置页面标题
                ->setTabNav($this->tab_list,'image')  // 设置Tab按钮列表
                ->addTopBtn('addnew',['title'=>'添加图片素材','href'=>url('edit',['type'=>'image'])])  // 添加新增按钮
                //->addTopBtn('self',['title'=>'一键上传素材到微信素材库','href'=>url('material_to_wechat',['type'=>'image']),'class'=>'btn btn-info btn-sm'])  // 添加素材库按钮
                ->addTopBtn('self',['title'=>'一键下载微信素材库到本地','href'=>url('synFromWechat',['type'=>'image']),'class'=>'btn btn-info btn-sm','data-pjax'=>'false'])  // 添加素材库按钮
                ->addTopBtn('delete') //添加删除按钮
                ->setSearch('请输入ID/名称',url('text'))
                ->keyListItem('id', 'ID')
                ->keyListItem('attachment_id', '素材图片','picture')
                ->keyListItem('create_time','创建时间')
                ->keyListItem('status', '状态', 'status')
                ->keyListItem('right_button', '操作', 'btn')
                ->setListData($data_list)    // 数据列表
                ->setListPage($total) // 数据列表分页
                ->addRightButton('edit')
                ->addRightButton('delete')
                ->fetch();
            return Iframe()
                ->setMetaTitle('图片素材') // 设置页面标题
                ->content($content);
    }

    //语音素材管理
    public function voice(){
        $map = [
            'type'=>'voice',
            'wxid'=>$this->wxid,
            'status'=>['egt',0]
        ];
        list($data_list,$total) = $this->materialModel
                                    ->search('title') //添加搜索查询
                                    ->getListByPage($map,true,'create_time desc');
        $content= builder('list')
                ->setMetaTitle('语音素材') // 设置页面标题
                ->setTabNav($this->tab_list,'voice')  // 设置Tab按钮列表
                ->addTopBtn('addnew',array('title'=>'添加语音素材','href'=>url('edit',array('type'=>'voice'))))  // 添加新增按钮
                //->addTopBtn('self',array('title'=>'一键上传素材到微信素材库','href'=>url('material_to_wechat',array('type'=>'voice')),'class'=>'btn btn-info btn-sm'))  // 添加素材库按钮
                //->addTopBtn('self',array('title'=>'一键下载微信素材库到本地','href'=>url('material_from_wechat',array('type'=>'voice')),'class'=>'btn btn-info btn-sm'))  // 添加素材库按钮
                ->addTopBtn('delete') //添加删除按钮
                ->setSearch('请输入ID/名称',url('text'))
                ->keyListItem('id', 'ID')
                ->keyListItem('attachment_id', '素材文件')
                ->keyListItem('create_time','创建时间', 'time')
                ->keyListItem('status', '状态', 'status')
                ->keyListItem('right_button', '操作', 'btn')
                ->setListData($data_list)    // 数据列表
                ->setListPage($total) // 数据列表分页
                ->addRightButton('edit')->addRightButton('delete')
                ->fetch();
            return Iframe()
                ->setMetaTitle('语音素材') // 设置页面标题
                ->content($content);
    }

    /**
     * 视频素材管理
     * @return [type] [description]
     * @date   2018-02-23
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function video(){
        $map = [
            'type'   =>'video',
            'wxid'   =>$this->wxid,
            'status' =>['egt',0]
        ];
        list($data_list,$total) = $this->materialModel
                                    ->search('title') //添加搜索查询
                                    ->getListByPage($map,true,'create_time desc');
        $content = builder('list')
                ->setMetaTitle('视频素材') // 设置页面标题
                ->setTabNav($this->tab_list,'video')  // 设置Tab按钮列表
                ->addTopBtn('addnew',array('title'=>'添加视频素材','href'=>url('edit',array('type'=>'video'))))  // 添加新增按钮
                //->addTopBtn('self',array('title'=>'一键上传素材到微信素材库','href'=>url('material_to_wechat',array('type'=>'video')),'class'=>'btn btn-info btn-sm'))  // 添加素材库按钮
                //->addTopBtn('self',array('title'=>'一键下载微信素材库到本地','href'=>url('material_from_wechat',array('type'=>'video')),'class'=>'btn btn-info btn-sm'))  // 添加素材库按钮
                ->addTopBtn('delete') //添加删除按钮
                ->setSearch('请输入ID/名称',url('text'))
                ->keyListItem('id', 'ID')
                ->keyListItem('attachment_id', '素材图片','picture')
                ->keyListItem('create_time','创建时间', 'time')
                ->keyListItem('status', '状态', 'status')
                ->keyListItem('right_button', '操作', 'btn')
                ->setListData($data_list)    // 数据列表
                ->setListPage($data_list->render()) // 数据列表分页
                ->addRightButton('edit')->addRightButton('delete')
                ->fetch();
            return Iframe()
                ->setMetaTitle('视频素材') // 设置页面标题
                ->content($content);
    }

    /**
     * 图文素材管理
     * @return [type] [description]
     * @date   2017-12-18
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function news(){
        $map = [
            'type'=>'news',
            'wxid'=>$this->wxid,
            'status'=>['egt',0]
        ];
        list($data_list,$total) = $this->materialModel
                                    ->search('title') //添加搜索查询
                                    ->getListByPage($map,true,'create_time desc');
        foreach ($data_list as $key => $data) {
            $data_list[$key]['title']='<a href="'.$data['url'].'" target="_blank">'.$data['title'].'</a>';
        }

        $content=  builder('list')
                ->setMetaTitle('图文素材') // 设置页面标题
                ->setTabNav($this->tab_list,'news')  // 设置Tab按钮列表
                ->addTopBtn('addnew',array('title'=>'添加图文素材','href'=>url('news_edit',array('type'=>'news'))))  // 添加新增按钮
                //->addTopBtn('self',array('title'=>'一键上传素材到微信素材库','href'=>url('material_to_wechat',array('type'=>'news')),'class'=>'btn btn-info btn-sm'))  // 添加素材库按钮
                ->addTopBtn('self',array('title'=>'一键下载微信素材库到本地','href'=>url('synFromWechat',array('type'=>'news')),'class'=>'btn btn-info btn-sm','data-pjax'=>'false'))  // 添加素材库按钮
                ->addTopBtn('resume')  // 添加启用按钮
                ->addTopBtn('forbid')  // 添加禁用按钮
                ->addTopBtn('delete') //添加删除按钮
                ->setSearch('请输入ID/名称',url('text'))
                ->keyListItem('id', 'ID')
                ->keyListItem('title', '图文标题')
                ->keyListItem('attachment_id', '图文封面','picture',null,'width="130"')
                ->keyListItem('description', '图文内容',null,null,'width="320"')
                ->keyListItem('create_time','创建时间')
                ->keyListItem('status', '状态', 'status')
                ->keyListItem('right_button', '操作', 'btn')
                ->setListData($data_list)    // 数据列表
                ->setListPage($total) // 数据列表分页
                ->addRightButton('edit',['href'=>url('news_edit',['id'=>'__data_id__'])])->addRightButton('delete')
                ->fetch();
            return Iframe()
                ->setMetaTitle('图文素材') // 设置页面标题
                ->content($content);
    }

    /**
     * 编辑素材
     * @param  integer $id [description]
     * @return [type] [description]
     * @date   2018-02-23
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function edit($id = 0){
        $title = $id ? "编辑" : "添加";
        //修改
        if(IS_POST){
            $data = $this->request->param();

            if(isset($data['content']))     $data['content']       = htmlspecialchars_decode(($data['content']));
            if(isset($data['news_content'])) $data['news_content'] = htmlspecialchars_decode($data['news_content']);
            $data['wxid'] = $this->wxid;

            if($this->materialModel->editData($data)){
                $this->success($title.'成功',url($data['type']));
            } else{
                $this->error($this->materialModel->getError());
            }

        } else{
            if ($id>0) {
                $info = MaterialModel::get($id);
            } else{
                $info['type'] = $this->request->param('type');
            }
            $extra_html = logic('wechat/Material')->adminSelectExtraHtml();
            $reply_type =[
                    'text'  =>['title'=>'文本素材','data-type'=>'1'],
                    'image' =>['title'=>'图片素材','data-type'=>'2'],
                    'news'  =>['title'=>'图文素材','data-type'=>'3']
                    ];
            $content = builder('form')
                    ->setMetaTitle($title.'素材')
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                    ->setTabNav($this->tab_list,$info['type'])  // 设置Tab按钮列表
                    ->addFormItem('title', 'text', '标题', '')
                    ->addFormItem('type', 'select', '素材类型','',$reply_type)   
                    ->addFormItem('content', 'textarea', '文本素材内容', '')
                    ->addFormItem('attachment_id', 'picture', '图片', '')
                    ->addFormItem('url', 'text', '链接', '')
                    ->addFormItem('description', 'textarea', '摘要', '')
                    ->addFormItem('news_content', 'wangeditor', '内容', '',array('config'=>'all','height'=>'360px'))
                    ->setFormData($info)
                    ->setExtraHtml($extra_html)
                    //->setAjaxSubmit(false)
                    ->addButton('submit')->addButton('back')    // 设置表单按钮
                    ->fetch();
                return Iframe()
                ->setMetaTitle($title.'素材') // 设置页面标题
                ->content($content);
        }
        
    }

    
    
    //编辑图文素材
    public function news_edit($id=0){
        $title = $id ? "编辑":"添加";
        //修改
        if(IS_POST){
            $data                  = $this->request->param();
            $data['id']            = $id ? $id : input('param.id',false,'intval');

            $data['news_content']  = htmlspecialchars_decode(input('param.news_content'));
            $data['description']   = input('param.description',cut_str($data['news_content'],54,0,0));
            $data['type']          = 'news';
            $data['wxid']          = $this->wxid;

            $result = $this->materialModel->editData($data);
            if($result){
                if (!$data['group_id']) {
                    $this->materialModel->where('id',$result)->setField('group_id',$result);
                    
                }
                if(!$data['id']){
                    $callback_id = $this->materialModel->id;
                } else{
                    $callback_id = $data['id'];
                }
                $this->success($title.'成功',url('news_edit',['id'=>$callback_id]));
            }else{
                $this->error($this->materialModel->getError());
            }
        } else{
            $this->assign('meta_title',$title.'图文');
            $this->assign('page_config',['back'=>url('news')]);
            $sub_news =[];
            $news['news_content']=$news['attachment_id']='';
            
            if ($id>0) {
                $news = $this->materialModel->where('id',$id)->field(true)->find();
                if ($news['group_id']>0) {
                    //获取子图文
                    $sub_news = $this->materialModel->getList(['group_id'=>$news['group_id'],'type'=>'news'],'id,title,type,description,attachment_id,url,group_id','create_time asc');
                } else{
                    $sub_news[]= $news;
                }
            }
            $this->assign('news',$news);
            $this->assign('sub_news',$sub_news);
            $this->assign('id',$id);
            $this->assign('tab_list',$this->tab_list);
            return $this->fetch();
        } 
    }

    //同步本地素材到微信素材库
    public function material_to_wechat($type=null){
        // 上传本地素材
        $map = [
            'wx_media_id' => 0,
            'wxid'        => $this->wxid,
            'type'        => $type
        ];
        $field = '*';
        $list =$this->materialModel->limit( 10 )->where ($map)->field ( $field . ',count(id) as count' )->group ( 'group_id' )->order ( 'group_id desc' )->select();
        if (empty ( $list )) {
            $this->success ( '上传素材完成', url($type) );
            exit ();
        }
        //图片上传
        if ($type=='image'||$type=='voice') {
            foreach ( $list as $vo ) {
                if ($type=='image') {
                    $mediaId = $this->_image_media_id ($vo ['attachment_id'],'image');
                }else{
                    $mediaId=$this->_get_file_media_id($vo ['attachment_id'],'voice');
                }
                
                if ($mediaId) {
                    $save ['wx_media_id'] = $mediaId;
                    $this->materialModel->where ( array (
                            'id' => $vo ['id'] 
                    ) )->save ( $save );
                }
            }
        } elseif ($type=='news') {
            //dump($list);exit;
            foreach ( $list as $vo ) {
                $ids [] = $vo ['id'];
                $gids [] = $vo ['group_id'];
            }
            $map2 ['id'] = array (
                    'not in',
                    $ids 
            );
            $map2 ['group_id'] = array (
                    'in',
                    $gids 
            );
            $child = $this->materialModel->where ( $map2 )->field ( $field )->select ();
            empty ( $child ) || $list = array_merge ( $list, $child );

            foreach ( $list as $vo ) {
                $data ['title']                 = $vo ['title'];
                $data ['thumb_media_id']        = $this->_image_media_id ( $vo ['attachment_id'],'thumb');
                //$data ['author']              = $vo ['author'];
                $data ['digest']                = $vo ['description'];
                $data ['show_cover_pic']        = 1;
                $data ['content']               = str_replace ( '"', '\'', $vo ['news_content'] );
                $data ['content_source_url']    = url('news_detail', array ('id' => $vo ['id']));
                
                $articles [$vo ['group_id']] [] = $data;
            }
            $url = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token='.$this->access_token;
    //      dump($url);
            foreach ( $articles as $group_id => $art ) {
                $param ['articles'] = $art;
                //dump(JSON($param));exit;
                $res = post_data ( $url, $param );
                if ($res ['errcode'] != 0) {
                    $this->error ( wechat_error_msg ( $res ) );
                } else {
                    $map3 ['group_id'] = $group_id;
                    $map3 ['type']=$type;
                    $this->materialModel->where($map3)->setField('wx_media_id',$res['media_id']);
                    $newsUrl = $this->_news_url($res ['media_id'] );
                    foreach ( $art as $a ) {
                        $map4['group_id']=$group_id;
                        $map4 ['type']=$type;
                        $map4 ['title'] = $a ['title'];
                        $this->materialModel->where ( $map4 )->setField ( 'url', $newsUrl [$a ['wx_url']] );
                    }
                }
            }
        }
        
        $url = url ($type);
        $this->success ( '上传本地素材到微信中，请勿关闭', $url );
    }
        // 获取图文素材url
    function _news_url($media_id) {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=' .$this->access_token;
        $param ['media_id'] = $media_id;
        $news = post_data ( $url, $param );
        if (isset ( $news ['errcode'] ) && $news ['errcode'] != 0) {
            $this->error ( wechat_error_msg ( $news ) );
        }
        foreach ( $news ['news_item'] as $vo ) {
            $newsUrl [$vo ['wx_url']] = $vo ['url'];
        }
        return $newsUrl;
    }
    
    //图片
    function _image_media_id($cover_id,$type='wap-thumb') {
        $attachment_info = get_attachment_info ($cover_id);
        $path = $attachment_info['path'];

        $option   = config('attachment_options');//获取附件配置值
        if ($option['driver']!='local' && $option['driver']!='' && ! file_exists ( PUBLIC_PATH . $path)) { // 先把图片下载到本地
            
            $pathinfo = pathinfo ( PUBLIC_PATH . $path);
            mkdirs ( $pathinfo ['dirname'] );
            
            $content = wp_file_get_contents ( path_to_url($path));
            $res = file_put_contents ( PUBLIC_PATH . $path, $content );
            if (! $res) {
                $this->error ( '远程图片下载失败' );
            }
        }
        
        if (! $path) {
            $this->error ( '获取文章封面失败，请确认是否增加封面' );
        }
        
        $param ['type'] = $type;
        $param ['media'] = '@' . realpath ( PUBLIC_PATH . $path );
        $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->access_token;

        $res = post_data ( $url, $param, true );
        
        if (isset ( $res ['errcode'] ) && $res ['errcode'] != 0) {
            $this->error ( wechat_error_msg ( $res, '图片上传' ) );
        }
        if ($type=='thumb') {
            $map ['attachment_id'] = $cover_id;
            $map ['type'] = 'image';
            $map ['wxid'] = $this->wxid;
            $this->materialModel->where ( $map )->setField ( 'wx_media_id', $res ['media_id'] );
        }
        
        return $res ['media_id'];
    }

    //上传视频、语音素材
    function _get_file_media_id($file_id,$type='voice',$title='',$introduction=''){
        $fileInfo= model('attachment')->get($file_id);
        if ($fileInfo){
            $path=$fileInfo['path'];
            if (! $path) {
                $this->error ('获取素材失败' );
                exit ();
            }
            $param ['type'] = $type;
            $param ['media'] = '@' . realpath ( ROOT_PATH . $path );
            if ($type=='video'){
                $param['description']['title']=$title;
                $param['description']['introduction']=$introduction;
            }
            $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->access_token;
            $res = post_data ( $url, $param);
            if (!$res){
                $this->error('同步失败');
            }
            if (isset ( $res ['errcode'] ) && $res ['errcode'] != 0) {
                $this->error ( wechat_error_msg ( $res, '素材上传' ) );
                exit ();
            }
        }
        return $res ['media_id'];
    }

    /**
     * 从微信素材库同步到本地
     * @param  string $type [description]
     * @return [type] [description]
     * @date   2017-12-24
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function synFromWechat($type='')
    {
        try {
            $result = $this->validate(['type'=>$type],
                    [
                        ['type','require|in:text,image,voice,video,news','参数不合法|参数不合法'],
                    ]);
            if(true !== $result){
                // 验证失败 输出错误信息
                throw new \Exception($result);
            }
            $offset = input('param.offset',0,'intval');
            $list = $this->app->material->list($type, $offset, 20);
            if (!empty($list['item'])) {
                $res = $this->saveMaterialInfo($type,$list);//保存素材信息到数据库
                $next_offset = $offset + $list['item_count'];
                $url = url('wechat/Material/synFromWechat',['type'=>$type,'offset'=>$next_offset]);
                $msg = '下载微信素材中，请勿关闭';
            } else{
                $url = url($type);
                $msg = '下载完成';
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success($msg, $url);
        
    }
    
    //保存微信库素材信息到本地
    private function saveMaterialInfo($type,$list){
        try {
            $result = $this->validate(['type'=>$type],
                [
                    ['type','require|in:text,image,voice,video,news','参数不合法|参数不合法'],
                ]);
            if(true !== $result){
                // 验证失败 输出错误信息
                throw new \Exception($result);
            }
            if (!$list) {
                throw new \Exception("素材信息不正确");
            }
            $map = [
                'wx_media_id'=>['in', getSubByKey($list['item'],'media_id')],
            ];
            
            //$map['token']=get_token();
            //$map['manager_id']=$this->mid;
            $has = $this->materialModel->where($map)->column('id','wx_media_id');
            foreach($list ['item'] as $item) {
                $media_id = $item ['media_id'];
                if (array_key_exists($media_id,$has)) continue;
                
                $ids = $data = $meta_data = [];
                if ($type=='news') {
                    foreach($item ['content'] ['news_item'] as $vo ) {
                        $meta_data ['author']         = $vo ['author'];
                        $meta_data ['thumb_media_id'] = $vo ['thumb_media_id'];
                        $data ['fields']              = json_encode($meta_data);
                        $data ['description']         = $vo ['digest'];
                        $data ['title']               = $vo ['title'];
                        $data ['news_content']             = $vo ['content'];
                        $data ['attachment_id']       = $this->_downloadMaterialFile('image',$meta_data['thumb_media_id']);
                        $data ['url']                 = $vo ['url'];       
                        $data ['fields']              = json_encode($meta_data);
                        $data ['type']                = $type;
                        $data ['wx_media_id']         = $media_id;
                        //$data ['create_time']         = time();
                        $data ['wxid']                = $this->wxid;
                                      
                    }
                } elseif ($type=='image') {
                    if ($item ['url']) {
                        $meta_data=$item;
                        $data ['attachment_id'] = $this->_downloadMaterialFile('image',$media_id, $item ['url']);
                        $data ['url'] = $item['url'];
                    }
                } elseif($type=='voice'){
                    $data ['title'] = $item['name'];
                    $data ['attachment_id'] = $this->_downloadMaterialFile('voice',$media_id, $item['url'] );
                } elseif($type=='video'){//视频下载暂未实现
                    $video                  = $this->_downloadMaterialFile('video',$media_id);
                    $data ['title']         = $video['title'];
                    $data ['url']           = $video['down_url'];
                    $data['description']    = $video['description'];
                    $data ['attachment_id'] = $this->_downloadMaterialFile ('video',0,$data ['url']);
                }
                if ($type!='news') {
                    $data ['fields']      = json_encode($meta_data);
                    $data ['type']        = $type;
                    $data ['wx_media_id'] = $media_id;
                    //$data ['create_time'] = time();
                    $data ['wxid']        = $this->wxid;
                }
                $this->materialModel->isUpdate(false)->data($data)->save();
                $ids [] = $this->materialModel->id;
                
                if (! empty ($ids) && is_array($ids) && $type=='news') {
                    $map2 = [
                        'id'=>['id',$ids]
                    ];
                    $this->materialModel->where($map2)->setField('group_id',$ids[0]);
                }
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
        
    }

    /**
     * 下载素材文件
     * @param  string $type text,image,voice,video,news
     * @param  [type] $media_id [description]
     * @param  string $file_url [description]
     * @return [type] [description]
     * @date   2017-12-25
     * @author 心云间、凝听 <981248356@qq.com>
     */
    private function _downloadMaterialFile($type='',$media_id,$file_url = '')
    {
        try {
            $result = $this->validate(
                [
                'type'=>$type,
                //'media_id'=>$media_id,
                'file_url'=>$file_url
                ],
                [
                    ['type','require|in:text,image,voice,video,news','参数不合法|参数不合法'],
                    //['media_id','require','参数不合法'],
                    ['file_url','url','参数不合法'],
                ]);
            if(true !== $result){
                // 验证失败 输出错误信息
                throw new \Exception($result);
            }
            switch ($type) {
                case 'image':
                    $save_dir='picture';
                    $ext='jpg';
                    break;
                case 'voice':
                    $save_dir='file';
                    $ext='mp3';
                    break;
                case 'video':
                    $save_dir='file';
                    $ext='mp4';
                    break;
                
                default:
                    # code...
                    break;
            }
            $save_path = 'uploads/wechat/'.$save_dir.'/' . time_format(time(),'Y-m-d');
            $savePath = PUBLIC_PATH.$save_path;
            mkdirs ($savePath);
            if (!empty($file_url)) {
                // 获取图片扩展名
                $fileExt = substr($file_url, strrpos($file_url,'=') + 1 );
                if ($type=='image') {
                    if (empty ( $fileExt ) || $fileExt == 'jpeg') {
                        $fileExt = $ext;
                    }
                } else{
                    if (empty($fileExt)){
                        $fileExt = $ext;
                    }
                }
                $file_name = 'wx'.$this->wxid.$type.'_'.time().mt_rand(100,9999).'.'.$fileExt;
                $path      = $url = '/'.$save_path.'/'.$file_name;
                $content   = wp_file_get_contents($file_url);
                $res       = file_put_contents($savePath.'/'.$file_name, $content);
                if (!$res) {
                    $this->error( '远程素材下载失败');
                    exit ();
                }
            } else{
                $fileExt = $ext;
                $stream = $this->app->material->get($media_id);
                $file_name = 'wx'.$this->wxid.$type.'_'.time().mt_rand(100,9999).'.'.$fileExt;
                // 自定义文件名，不需要带后缀
                $res = $stream->saveAs($savePath, $file_name);
                $path = '/'.$save_path.'/'.$file_name;
                $url = '/'.$save_path.'/'.$file_name;
            }
            if ($res) {
                $data = [
                    'uid'       => is_login(),
                    'name'      => str_replace('.'.$fileExt,'',$file_name),
                    'path'      => $path,
                    'url'       => $url,
                    'location'  => 'local',
                    'path_type' => 'wechat',
                    'size'      => '',
                    'ext'       => $ext,
                ];
                $attachmentModel = new AttachmentModel;
                $res = $attachmentModel->isUpdate(false)->data($data)->save();
                if ($res) {
                    $attachment_id = $attachmentModel->id;
                    return $attachment_id;
                    unset($media_id);
                }
            } else{
                throw new \Exception("error"); 
            }
            
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 弹窗列表组件
     * @return [type] [description]
     * @date   2017-12-23
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function iframeChooseList($type='all',$inputnode='')
    {
        // 搜索
        $keyword = $this->request->param('keyword');
        if ($keyword) {
            $this->materialModel->where('id|title','like','%'.$keyword.'%');
        }

        $map = [
            'wxid'=>$this->wxid,
            'status'=>1
        ];
        if ($type!='all') {
            $map['type']=$type;
        }
        $data_list = $this->materialModel->where($map)->field(true)->order('create_time desc')->paginate(15);
        $this->assign('data_list',$data_list);
        $this->assign('inputnode',$inputnode);

        $tab_list = [
                'all'  =>['title'=>'所有','href'=>url('iframeChooseList',['type'=>'all','inputnode'=>$inputnode])],
                'text'  =>['title'=>'文本','href'=>url('iframeChooseList',['type'=>'text','inputnode'=>$inputnode])],
                'image' =>['title'=>'图片','href'=>url('iframeChooseList',['type'=>'image','inputnode'=>$inputnode])],
                'voice' =>['title'=>'音频','href'=>url('iframeChooseList',['type'=>'voice','inputnode'=>$inputnode])],
                'video' =>['title'=>'视频','href'=>url('iframeChooseList',['type'=>'video','inputnode'=>$inputnode])],
                'news'  =>['title'=>'图文','href'=>url('iframeChooseList',['type'=>'news','inputnode'=>$inputnode])]
            ];
        $this->assign('tab_list',$tab_list);
        return $this->fetch('iframe_choose_list');
    }
}