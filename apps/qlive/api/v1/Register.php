<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/1
 * Time: 17:12
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\common\logic\User as UserLogic;
use app\common\model\User as UserModel;
use app\rest\controller\RestBase;

/**
 * Class Register
 * @package app\qlive\api\v1
 * 用户注册控制器
 */
class Register extends RestBase
{
    /**
     *
     */
    public function index()
    {
        if (\request()->isPost()) {
            $data = \input('post.');
            //检测用户名或昵称是否被禁止注册
            $check_username = UserLogic::checkDenyUser($data['username']);
            $check_nickname = UserLogic::checkDenyUser($data['username']);
            if ($check_username || $check_nickname) {
                $this->error('用户名或昵称包含违规关键字，禁止注册');
            }
            $userModel = new UserModel();
            $result = $userModel->editData($data);
            if ($result) {
                $this->success('注册成功');
            } else {
                $this->error('注册失败!');
            }
        } else {
            $this->error('提交方式不正确');
        }
    }
}
