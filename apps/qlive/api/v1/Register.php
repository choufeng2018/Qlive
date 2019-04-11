<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/1
 * Time: 17:12
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\common\model\User as UserModel;
use app\rest\controller\RestBase;

/**
 * Class Register
 * @package app\qlive\api\v1
 * 用户注册控制器
 * 一些条件判断单独拿出来,可用于前端验证
 */
class Register extends RestBase
{
    use CommonTrait;

    /**
     * @throws \think\Exception
     * 用户注册
     */
    public function index()
    {
        if (\request()->isPost()) {
            $data = \input();
            //检查数据是否完整
            if (empty($data['username']) || empty($data['nickname']) || empty($data['email']) || empty($data['password']) || empty($data['password_confirm'])) {
                $this->error('提交数据不完整');
            }
            $this->checkUserName($data['username']);
            $this->checkNickName($data['nickname']);
            $this->checkEmail($data['email']);
            $this->checkPassword($data['password'], $data['password_confirm']);

            //其他信息
            $data['register_ip'] = $data['last_login_ip'] = $this->request->ip();
            $data['last_login_time'] = \time();
            $data['reg_from'] = 1;
            $data['actived'] = 1;
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
