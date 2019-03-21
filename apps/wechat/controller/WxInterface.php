<?php
// 微信接口服务
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 https://www.eacoophp.com, All rights reserved.         
// +----------------------------------------------------------------------
// | [EacooPHP] 并不是自由软件,可免费使用,未经许可不能去掉EacooPHP相关版权。
// | 禁止在EacooPHP整体或任何部分基础上发展任何派生、修改或第三方版本用于重新分发
// +----------------------------------------------------------------------
// | Author:  心云间、凝听 <981248356@qq.com>
// +----------------------------------------------------------------------
namespace app\wechat\controller;
use think\Controller;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Image;
use EasyWeChat\Kernel\Messages\Video;
use EasyWeChat\Kernel\Messages\Voice;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Article;
use EasyWeChat\Kernel\Messages\Media;

use app\wechat\model\Reply as ReplyModel;
use app\wechat\model\Material as MaterialModel;
use app\wechat\model\WechatUser as WechatUserModel;
use app\common\model\User as UserModel;
use think\Db;

class WxInterface extends Controller {

    protected $wxid;
    
    protected function _initialize()
    {
        $this->wxid    = get_wxid($this->request->param('wxid'));
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

    /**
     * 默认方法
     * @return [type] [description]
     * @date   2018-04-05
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function index() {
        if ($this->request->has('echostr','get')) {
            $response = $this->app->server->serve(); 
            // 将响应输出
            $response->send(); // Laravel 里请使用：return $response;
            exit;
        }
        // 回复数据
        $this->reply();
        exit ();
    }

    /**
     * 微信回复数据
     * @return [type] [description]
     * @date   2018-04-05
     * @author 心云间、凝听 <981248356@qq.com>
     */
    private function reply()
    {
        $server = $this->app->server;
        $data = $server->getMessage();
        if(array_key_exists('Content', $data)){
            $key = $data['Content'];  
        }
        $keywordArr = [];
        
        /**
         * 微信事件转化成特定的关键词来处理
         * event可能的值：
         * subscribe : 关注公众号
         * unsubscribe : 取消关注公众号
         * scan : 扫描带参数二维码事件
         * LOCATION : 上报地理位置事件
         * click : 自定义菜单事件
         */
        if ($data ['MsgType'] == 'event') {
            if ( $data['Event'] == 'LOCATION' ) {
                $event = 'report_location';
            } else {
                $event = strtolower ( $data ['Event'] );
            }
            
            if ($event == 'click' && ! empty ( $data ['EventKey'] )) {
                $key = $data ['Content'] = $data ['EventKey'];
            } else {
                $key = $data ['Content'] = $event;
            }
        } else {

            /**
             * 非事件型消息处理逻辑
             * event可能的值：
             * text : 文本消息
             * image : 图片消息
             * voice : 语音消息
             * video : 视频消息
             * shortvideo : 短视频消息
             * location : 地理位置消息
             * link : 链接消息
             */
            $event = strtolower ( $data ['MsgType'] );
            // 数据保存到消息管理中
            if($data) db('wechat_message' )->insert($data);
        }
        $reply_map         = [];
        $reply_map['type'] = $event=='text' ? 'keyword' : $event;
        $reply_map['wxid'] = $this->wxid;
        //$this->wechatObj->text("debug:".$this->wxid)->reply();
        
        switch ($data['MsgType']) {
            case 'event':
            //处理事件类型
                switch($data['Event']){
                    case 'subscribe':
                        $this->welcome($data);
                        break;
                    case 'unsubscribe':
                        $this->unsubscribe($data);
                        break;
                    case 'click'://自定义菜单事件
                        $reply_map['type']    = 'keyword';//转换为文本回复
                        $reply_map['keyword'] = $key;
                        break;
                }
                break;
            case 'text':
                $reply_map['keyword']=$key;
                break;
            case 'image':
                break;
            case 'voice':
                break;
            case 'video':
                break;
            case 'link':
                break;
            case 'shortvideo':
                break;
            case 'report_location':
                break;
            case 'scan':
                break;
            case 'location':
                break;
            case 'link':
                break;
            // ... 其它消息
            default:
                $server->setMessageHandler(function ($data) {
                    return "您好！您想让我告诉您什么~~";
                });
                break;
        }
        //setAppLog(json_encode($reply_map),'wechat_reply','debug');
        $material_id = ReplyModel::where($reply_map)->value('material_id');
        if (!$material_id) {
            $material_id = ReplyModel::where(['type'=>'default'])->value('material_id');
        }
        $this->replyEvent($material_id);
        exit;
    }

    /**
     * 微信事件内容回复
     * @param  [type] $material_id [description]
     * @return [type] [description]
     * @date   2018-04-05
     * @author 心云间、凝听 <981248356@qq.com>
     */
    private function replyEvent($material_id){
       
       try {
            if ($material_id<0 && !$material_id) {
                throw new \Exception("素材ID不能为空");
            }
           $info = MaterialModel::get($material_id);
           if (empty($info)) {
               throw new \Exception($material_id."素材不存在");
               
           }
           $this->app->server->push(function ($message) use($info) {
                switch ($info['type']) {
                    case 'text':
                       return new Text($info['content']);
                       break;
                    case 'image':
                        $items = [
                            new NewsItem([
                                'title'       => '这是一张图片',
                                'description' => '点击查看大图',
                                'url'         => $info['url'],
                                'image'       => get_image($info['attachment_id'],'medium'),
                                // ...
                            ]),
                        ];
                        
                        return new News($items);
                       break;
                    case 'news': 
                        $items = [
                            new NewsItem([
                                'title'       => $info['title'],
                                'description' => $info['description'],
                                'image'       => get_image($info['attachment_id'],'medium'),
                                'url'         => $info['url']
                                // ...
                            ]),
                        ];
                       return new News($items);
                       break;
                    case 'voice':
                       return new Voice(['media_id' => $info['wx_media_id']]);
                       break;
                    case 'video':
                       return new Video([
                                    'title' => $info['title'],
                                    'media_id' => $mediaId,
                                    'description' => $info['description'],
                                    'thumb_media_id'=>'',
                                    // ...
                                ]);
                       break;
                   
                   default:
                       return new Text(['content' => $info['content']]);
                       break;
               }
           });
           $response = $this->app->server->serve(); 
            // 将响应输出
            return $response->send(); // Laravel 里请使用：return $response;
       } catch (\Exception $e) {
            setAppLog($e,'error');
           return false;
       }
       
       
    }

    /**
     * 初始化用户关注
     * @param  [type] $data [description]
     * @return [type] [description]
     * @date   2018-04-05
     * @author 心云间、凝听 <981248356@qq.com>
     */
    private function welcome($data){
        // 初始化用户信息
        $this->createWechatUser($data['FromUserName']);

        $reply_map  = $map = $articles = [];
        $reply_map = [
                'wxid' => $this->wxid,
                'type' => 'subscribe',
        ];
        $material_id  = ReplyModel::where($reply_map)->value('material_id');
        if ($is_group = 1) {//是否开启图文组(后期完善后台)
            $map = [
                'type'     => 'news',
                'status'   => 1,
                'group_id' => $material_id,//推送的图文组
            ];
            $data_list = MaterialModel::where($map)
                                    ->field('id,title,type,description,attachment_id,url,group_id')
                                    ->order('create_time asc')
                                    ->limit(8)
                                    ->select();
            if ($data_list) {
                $articles = [];
                foreach ($data_list as $key => $row) {
                    $articles[] = new News([
                                    'title'       => $row['title'],
                                    'description' => $row['description'],
                                    'url'         => $row['url'] ? htmlspecialchars_decode($row['url']) : $this->request->domain().'/'.url('wechat/index/news_detail',['id'=>$row['id']]),
                                    'image'       => get_image($row['attachment_id'],'medium'),
                                ]);
                }
            }
            return $articles;
        } else{
            $this->replyEvent($material_id);
        }

        exit;
    }

    /**
     * 注册成用户
     * @param  [type] $openid [description]
     * @return [type] [description]
     * @date   2018-04-05
     * @author 心云间、凝听 <981248356@qq.com>
     */
    private function createWechatUser($openid){
        try {
            // 启动事务
            Db::startTrans();
            //$map ['token'] = $data ['ToUserName'];
            $map ['wxid'] = $this->wxid;
            $map ['openid'] = $openid;
            $count = WechatUserModel::where($map)->count(); //获取当前用户的uid
            if (!$count) {
                $wechat_user = $this->app->user->get($openid);
                
                //注册用户            
                //构造注册数据
                $reg_data = [
                    'sex'      =>$wechat_user['sex'],
                    'nickname' =>$wechat_user['nickname'],
                    'username' =>'WX'.time(),
                    'password' =>$wechat_user['openid'],
                    'avatar'   =>$wechat_user['headimgurl'],
                ];

                $userModel = new UserModel;
                $userModel->allowField(true)->isUpdate(false)->data($reg_data)->save();
                $uid = $userModel->uid;
                if ($uid>0) {
                    $wechat_user['uid'] = $uid;
                    logic('wechat/WechatUser')->createUser($this->wxid, $wechat_user);//公众号1
                }

            } else{
                WechatUserModel::where($map)->update(['subscribe'=>1,'subscribe_time'=>time()]);
            }
            // 提交事务
            Db::commit();
            return true;
        } catch (\Exception $e) {
            setAppLog($e,'error');
            // 回滚事务
            Db::rollback();
            return false;
        }
        
    }
    /**
     * 用户取消关注
     * @param  [type] $openid [description]
     * @return [type] [description]
     * @date   2018-10-12
     * @author 洋仔 <441222899@qq.com>
     */
    private function unsubscribe($data){
            $map ['wxid'] = $this->wxid;
            $map ['openid'] = $data['FromUserName'];
            $count = WechatUserModel::where($map)->count(); //获取当前用户的uid
            if($count){
                WechatUserModel::where($map)->update(['subscribe'=>0,'subscribe_time'=>'']);
            }
    }
}