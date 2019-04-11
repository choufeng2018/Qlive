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
        $this->checkAnchor();
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 检查token是否存在或者过期
     * 并初始化一些变量
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
            //当前用户基本信息(users表中)
            $this->user = $user;
            //当前用户id
            $this->userId = $user['uid'];
            //当前用户类型
            $this->userType = $user['usergroup'];
            //当前用户token
            $this->token = $token;
        } else {
            $this->error(['code' => 10001, 'msg' => '请重新登录']);
        }
    }

    /**
     *检查是否是主播
     * 用于复写
     */
    public function checkAnchor()
    {

    }
}
