<?php
// 菜单
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 https://www.eacoophp.com, All rights reserved.         
// +----------------------------------------------------------------------
// | [EacooPHP] 并不是自由软件,可免费使用,未经许可不能去掉EacooPHP相关版权。
// | 禁止在EacooPHP整体或任何部分基础上发展任何派生、修改或第三方版本用于重新分发
// +----------------------------------------------------------------------
// | Author:  心云间、凝听 <981248356@qq.com>
// +----------------------------------------------------------------------
namespace app\wechat\admin;

use app\wechat\model\Menus as MenusModel;
use EasyWeChat\Factory;

class Menu extends Base {

    protected $app;
    protected $menusModel;
    function _initialize()
    {
        parent::_initialize();
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
        $this->menusModel = new MenusModel();
    }

    /**
     * 菜单管理
     * @return [type] [description]
     * @date   2017-12-11
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function index()
    {
        $data_list = db('wechat_menus')->order('pid,sort asc')->select();
        $data_list = list_to_tree($data_list);
        if (empty($data_list)) {
            $this->sycGetMenu();
        }

        $this->assign('meta_title','自定义菜单');
        $this->assign('data_list',$data_list);
        return $this->fetch();
    }

    /**
     * 添加菜单
     * @date   2017-12-11
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function add() {
        if (IS_POST) {
            $data = input('post.');
            //验证数据
            //$this->validateData($data,'Menu');
            $data['wxid']=$this->wxid;
            if ($this->menusModel->editData($data)) {
                $this->success('添加成功', url('index'));
            } else {
                $this->error($this->menusModel->getError());
            }

        } else {
            $info = [];
            $menu_cats = $this->menusModel->where([
                'status'=>1,
                'wxid'=>$this->wxid,
                'pid'=>0])->field('id,name')->select();
            $this->assign('menu_cats',$menu_cats);
            $this->assign('meta_title','添加菜单');
            $this->assign('info',$info);
            return $this->fetch('edit');
        }
    }

    /**
     * 编辑菜单
     * @param  integer $id [description]
     * @return [type] [description]
     * @date   2017-12-11
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function edit($id=0) {
        $title = $id>0 ? "编辑":"新增";
        if (IS_POST) {
            $data = input('post.');
            //验证数据
            //$this->validateData($data,'Menu');
            $data['wxid'] = $this->wxid;
            if ($this->menusModel->editData($data)) {
                $this->success($title.'成功', url('index'));
            } else {
                $this->error($this->menusModel->getError());
            }

        } else {
            $info = [];
            if ($id>0) {
                $info = $this->menusModel->get($id);
            }
            $menu_cats = $this->menusModel->where([
                'status'=>1,
                'wxid'=>$this->wxid,
                'pid'=>0])->field('id,name')->select(); 
            $this->assign('menu_cats',$menu_cats);
            $this->assign('meta_title','编辑菜单');
            $this->assign('info',$info);
            return $this->fetch();
        }
    }

    /**
     * 排序处理
     * @return [type] [description]
     * @date   2017-12-14
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function sort()
    {
        if (IS_POST) {
            $wechat_menus_db = db('wechat_menus');
            $params = $this->request->param();
            $sorts = $params['sorts'];
            $sortids = $params['sortids'];
            if (!empty($sortids)) {
                foreach ($sortids as $key => $id) {
                    $sort_id = $id;
                    $sort_v = $sorts[$key];
                    $wechat_menus_db->where('id',$sort_id)->setField('sort',$sort_v);
                }
                $this->success('排序成功');
            } else{
                $this->error('排序失败');
            }

        }
    
    }

    /**
     * 同步获取菜单
     * @return [type] [description]
     * @date   2017-12-11
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function sycGetMenu()
    {
        $menu = $this->app->menu;
        $menus = $menu->current();
        if (!empty($menus['selfmenu_info']['button'])) {
            //删除本地菜单
            $this->menusModel->where('wxid',$this->wxid)->delete();
            $menus_button = $menus['selfmenu_info']['button'];
            foreach ($menus_button as $key => $row) {
                $menu = [
                    'wxid' =>$this->wxid,
                    'name' =>$row['name'],
                    'type' =>isset($row['type']) ? $row['type'] : '',
                    'key'  =>isset($row['key']) ? $row['key'] : '',
                    'url'  =>isset($row['url']) ? $row['url'] : '',
                ];
                $result = $this->menusModel->allowField(true)->isUpdate(false)->data($menu)->save();
                if (!empty($row['sub_button']['list'])) {
                    $pid = $this->menusModel->id;
                    $sub_button = $row['sub_button']['list'];
                    foreach ($sub_button as $key => $vo) {
                        $submenu = [
                            'wxid'=>$this->wxid,
                            'name'=>$vo['name'],
                            'type'=>$vo['type'],
                            'pid'=>$pid,
                            'key'=>isset($vo['key']) ? $vo['key'] : '',
                            'url'=>isset($vo['url']) ? $vo['url'] : '',
                        ];
                        $this->menusModel->allowField(true)->isUpdate(false)->data($submenu)->save();
                    }
                }
            }
            
            $this->success('获取菜单成功!',url('index'));
        } else{
            $errmsg = !empty($menus['errmsg']) ? $menus['errmsg']:'';
            $this->error($errmsg);
        }
        
    }

    /**
     * 同步到微信
     * @return [type] [description]
     * @date   2017-12-13
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function publishToWechat()
    {
        $buttons = [];
        $buttons = db('wechat_menus')->field('id,pid,type,name,key,url')->order('pid,sort asc')->select();
        $buttons = list_to_tree($buttons);
        if (!empty($buttons)) {
            foreach ($buttons as $key => &$val) {
                if ($val['type']=='view') {
                    unset($val['key']);
                } elseif ($val['type']=='click') {
                    unset($val['url']);
                }

                unset($val['id']);
                unset($val['pid']);
                if (!empty($val['_child'])) {
                    foreach ($val['_child'] as $k => &$button) {
                        if ($button['type']=='view') {
                            unset($button['key']);
                        } elseif ($button['type']=='click') {
                            unset($button['url']);
                        }
                        unset($button['id']);
                        unset($button['pid']);
                    }
                    $val['sub_button']=$val['_child'];
                    unset($val['_child']);
                    unset($val['type']);
                    unset($val['key']);
                    unset($val['url']);
                }
            }
        }

        $result = $this->app->menu->create($buttons);
        if ($result['errcode']==0) {
            $this->success('同步成功');
        } else{
            $this->error($result->msg);
        }
        
    }
}