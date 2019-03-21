<?php
// 微信基类
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 https://www.eacoophp.com, All rights reserved.         
// +----------------------------------------------------------------------
// | [EacooPHP] 并不是自由软件,可免费使用,未经许可不能去掉EacooPHP相关版权。
// | 禁止在EacooPHP整体或任何部分基础上发展任何派生、修改或第三方版本用于重新分发
// +----------------------------------------------------------------------
// | Author:  心云间、凝听 <981248356@qq.com>
// +----------------------------------------------------------------------
namespace app\wechat\controller;
use app\common\controller\Base;

use app\common\model\User as UserModel;
use app\common\logic\User as UserLogic;
use app\wechat\model\WechatUser as WechatUserModel;
use EasyWeChat\Factory;
use think\Db;

class Home extends Base {

    function _initialize()
    {
        parent::_initialize();
        $this->wxid    = get_wxid($this->request->param('wxid'));
        /*$this->wxid = 1;*/
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
             * OAuth 配置
             *
             * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
             * callback：OAuth授权完成后的回调页地址
             */
            'oauth' => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => request()->domain().'/wechat/home/wechatOauthCallback',
            ],
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
        ];//dump($options);die;
        $this->app = Factory::officialAccount($options);
    }
    
    /**
     * 微信授权跳转
     * @return [type] [description]
     * @date   2017-12-07
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function wechatOauth($scope='snsapi_userinfo')
    {   
        session('wechat_user',null);
        $response = $this->app->oauth->scopes([$scope])->redirect()->send();
        //return $response;
    }

    /**
     * 微信授权回调
     * @return [type] [description]
     * @date   2017-12-07
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function wechatOauthCallback()
    {
        try {
            $wechat_user = $this->app->oauth->user();
            session('wechat_user',$wechat_user);//存储wechat_user
            $result = $this->wechatOauthRegister();//同步注册
            if ($result['code']==1) {
                $targetUrl = session('?wechat_oauth_target_url') ? session('wechat_oauth_target_url') : '/';
                header('location:'. $targetUrl);exit;
            } else{
                throw new \Exception($result['msg'], $result['code']);
                
            }
        } catch (\Exception $e) {
            setAppLog($e,'error');
            $this->error($e->getMessage());
        }
        
    }

    /**
     * 微信授权注册
     * @return [type] [description]
     * @date   2017-12-09
     * @author 心云间、凝听 <981248356@qq.com>
     */
    private function wechatOauthRegister()
    {
        try {
            if (!session('?wechat_user')) {
                throw new \Exception("微信授权信息为空", 0);
                
            }
            $wechat_user = session('wechat_user');
            if (!empty($wechat_user)) {
                get_wechat_token();
                get_wxid($this->wxid);
                get_openid($wechat_user['id']);
            }
            $userModel = new UserModel;
            $map = [];
            $map['wxid']=$this->wxid;
            if (isset($wechat_user['unionid'])) {
                $map['unionid'] = $wechat_user['unionid'];
            } else{
                $map['openid'] = $wechat_user['id'];
            }
            $wechatUserModel = new WechatUserModel;
            $wechat_db_user  = $wechatUserModel->where($map)->field(true)->find(); //获取当前用户的信息
            if (!empty($wechat_db_user)) {//已授权过的用户
                $userdata = get_user_info($wechat_db_user['uid']);
                UserLogic::autoLogin($userdata);
                $user_wechat_relationship = [
                    'uid'    => $wechat_db_user['uid'],
                    'wxid'   => $this->wxid,
                    'openid' => $wechat_user['id'],
                ];
                session('user_wechat_relationship',$user_wechat_relationship);
                return [
                            'code' => 1,
                            'msg'  => '已注册用户',
                            'data' => []
                        ];

            } elseif($wechat_user){
                session('wx_token', $wechat_user['token']);
                $wechat_original_user = $wechat_user['original'];
                $data = [
                    'sex'        =>$wechat_original_user['sex'],
                    'nickname'   =>$wechat_original_user['nickname'],
                    'username'   =>'wx'.$this->wxid.time().mt_rand(100,999),
                    'password'   =>$wechat_original_user['openid'],
                    'avatar'     =>$wechat_original_user['headimgurl'],
                    'reg_from'   =>3,
                    'reg_method' =>'wechat',
                ];
                // 启动事务
                Db::startTrans();
                $userModel->allowField(true)->data($data)->save();
                $uid = $userModel->uid;
                if ($uid>0) {
                    $wechat_original_user = json_decode(json_encode($wechat_original_user),true);
                    $wechat_original_user['uid']=$uid;
                    //setAppLog(json_encode($wechat_original_user),'wechat','info');
                    $result = logic('wechat/WechatUser')->createUser($this->wxid, $wechat_original_user);
                    if ($result) {
                        // 提交事务
                        Db::commit();
                        $user_wechat_relationship = [
                            'uid'    =>$uid,
                            'wxid'   =>$this->wxid,
                            'openid' =>$wechat_user['id'],
                        ];
                        session('user_wechat_relationship',$user_wechat_relationship);
                        return [
                            'code' => 1,
                            'msg'  => '注册成功',
                            'data' => []
                        ];
                    }
                    
                }
                
            }
            throw new \Exception("注册失败", 0);
            
        } catch (\Exception $e) {
            setAppLog($e,'error');
            // 回滚事务
            Db::rollback();
            return [
                'code'=>$e->getCode(),
                'msg'=>$e->getMessage(),
                'data'=>[]
            ];
        }
        
    }

    /**
     * 获取access_token
     * @param  integer $refresh 0不刷新,1刷新
     * @return [type] [description]
     * @date   2017-12-07
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function getAccessToken($refresh = 0){
        $accessToken = $this->app->access_token; // EasyWeChat\Core\AccessToken 实例
        if (!$refresh) {
            $token = $accessToken->getToken(); 
        } else {
            $token = $accessToken->getToken(true); // 强制重新从微信服务器获取 token.
        }
        return $token;
    }
}