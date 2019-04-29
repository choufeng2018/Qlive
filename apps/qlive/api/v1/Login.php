<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/1
 * Time: 17:19
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;
use app\common\logic\User as UserLogic;
use think\Db;

/**
 * Class Login
 * @package app\qlive\api\v1
 * 登录控制器
 */
class Login extends RestBase
{
    /**
     *登录并更新token
     */
    public function index()
    {
        if (\request()->isPost()) {
            $data = \request()->param();
            if (empty($data['mobile']) || empty($data['password'])) {
                $this->error('数据不完整');
            }
            $result = UserLogic::login($data['mobile'], $data['password'], false);
            if ($result['code'] == 1) {
                //登录成功,更新token
                $this->userId = Db::name('Users')
                    ->where('mobile', 'eq', $data['mobile'])
                    ->value('uid');
                $findUserToken = Db::name('UserToken')
                    ->where('user_id', $this->userId)
                    ->where('device_type', $this->deviceType)
                    ->find();
                $currentTime = time();
                $expireTime = $currentTime + \config('token_expire');
                $token = md5(uniqid()) . md5(uniqid());
                if (empty($findUserToken)) {
                    //如果token不存在则新增,不同设备不同token
                    $result = Db::name("UserToken")->insert([
                        'token' => $token,
                        'user_id' => $this->userId,
                        'expire_time' => $expireTime,
                        'create_time' => $currentTime,
                        'device_type' => $this->deviceType,
                    ]);
                } else {
                    //如果已存在token则更新
                    $result = Db::name("UserToken")
                        ->where('user_id', $this->userId)
                        ->where('device_type', $this->deviceType)
                        ->update([
                            'token' => $token,
                            'expire_time' => $expireTime,
                            'create_time' => $currentTime
                        ]);
                }
                if (!empty($result)) {
                    //更新Users表相关数据
                    $user_data = [
                        'last_login_ip' => $this->request->ip(),
                        'last_login_time' => \date('Y-m-d H:i:s'),
                        'login_num' => Db::raw('login_num+1')
                    ];
                    Db::name('Users')
                        ->where('uid', 'eq', $this->userId)
                        ->update($user_data);

                    //登录成功将token返回给客户端
                    $this->success('登录成功', $token);
                }
            } else {
                $this->error($result['msg']);
            }
        } else {
            $this->error('提交方式不正确');
        }
    }
}
