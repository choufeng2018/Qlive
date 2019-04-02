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
            $result = \validate($data, [
                ['username', 'require|min:1', '登录名不能为空|登录名格式不正确'],
                ['password', 'require|length:6,32', '请填写密码|密码格式不正确']
            ]);
            if (true !== $result) {
                $this->error($result);
            }
            $result = UserLogic::login($data['username'], $data['password'], false);
            if ($result['code'] == 1) {
                //登录成功,更新token
                $this->userId = Db::name('Users')
                    ->where('username', 'eq', $data['username'])
                    ->where('password', 'eq', $data['password'])
                    ->value('uid');
                $findUserToken = Db::name('UserToken')
                    ->where('user_id', $this->userId)
                    ->where('device_type', $data['clientfrom'])
                    ->find();
                $currentTime = time();
                $expireTime = $currentTime + \config('token_expire');
                $token = md5(uniqid()) . md5(uniqid());
                if (empty($findUserToken)) {
                    //如果token不存在则新增
                    $result = Db::name("user_token")->insert([
                        'token' => $token,
                        'user_id' => $this->userId,
                        'expire_time' => $expireTime,
                        'create_time' => $currentTime,
                        'device_type' => $data['clientfrom']
                    ]);
                } else {
                    //如果已存在token则更新
                    $result = Db::name("user_token")
                        ->where('user_id', $this->userId)
                        ->where('device_type', $data['device_type'])
                        ->update([
                            'token' => $token,
                            'expire_time' => $expireTime,
                            'create_time' => $currentTime
                        ]);
                }
                if (!empty($result)) {
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
