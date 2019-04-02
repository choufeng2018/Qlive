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
        $token = $this->request->header('token');
        if (empty($token)) {
            $this->error(['code' => 0, 'msg' => 'token缺失']);
        }

        //检测token是否正确



        //todo
        $this->token = $token;

        $user = Db::name('UserToken')
            ->alias('a')
            ->field('b.*')
            ->where(['token' => $token, 'device_type' => $this->deviceType])
            ->join('__USERS__ b', 'a.user_id=b.uid')
            ->find();

        if (!empty($user)) {
            $this->user = $user;
            $this->userId = $user['id'];
            $this->userType = $user['usergroup'];
        } else {
            $this->error(['code' => 10001, 'msg' => '登录已失效!']);
        }
    }
}
