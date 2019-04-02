<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/1
 * Time: 15:05
 * Dedicated to my wife and daughter
 */

namespace app\rest\controller;


use think\Db;

/**
 * Class RestUserBase
 * @package app\rest\controller
 * 用户相关操作的基础控制器
 */
class RestUserBase extends RestBase
{
    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 用户初始化操作
     */
    public function initUser()
    {
        $this->checkToken();
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 检查token是否存在或者过期
     */
    public function checkToken()
    {
        $token = $this->request->header('token');
        if (empty($token)) {
            $this->error(['code' => 0, 'msg' => 'token缺失']);
        }

        $user = Db::name('UserToken')
            ->alias('a')
            ->field('b.*')
            ->where(['token' => $token, 'device_type' => $this->deviceType])
            ->whereTime('expire_time', '>', \time())
            ->join('__USERS__ b', 'a.user_id=b.uid')
            ->find();
        if (!empty($user)) {
            $this->user = $user;
            $this->userId = $user['uid'];
            $this->userType = $user['usergroup'];
            $this->token = $token;
        } else {
            $this->error(['code' => 10001, 'msg' => '请重新登录']);
        }
    }
}
