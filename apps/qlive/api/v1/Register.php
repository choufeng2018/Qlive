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
use think\Db;

/**
 * Class Register
 * @package app\qlive\api\v1
 * 用户注册控制器
 * 一些条件判断单独拿出来,可用于前端验证
 */
class Register extends RestBase
{

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

    /**
     * @param $username
     * @throws \think\Exception
     * 检查用户名是否可用,是否唯一
     */
    public function checkUserName($username)
    {
        //检测用户名是否被禁止注册
        $check_username = UserLogic::checkDenyUser($username);
        if ($check_username) {
            $this->error('该用户名不可用');
        }
        //检查是否唯一
        $userNameCount = Db::name('Users')
            ->where('username', 'eq', $username)
            ->count();
        if ($userNameCount > 0) {
            $this->error('该用户名已被占用');
        }
    }

    /**
     * @param $nickname
     * @throws \think\Exception
     * 检查昵称是否可用,是否唯一
     */
    public function checkNickName($nickname)
    {
        //检测昵称是否被禁止注册
        $check_nickname = UserLogic::checkDenyUser($nickname);
        if ($check_nickname) {
            $this->error('该昵称不可用');
        }
        //检查是否唯一
        $nickNameCount = Db::name('Users')
            ->where('nickname', 'eq', $nickname)
            ->count();
        if ($nickNameCount > 0) {
            $this->error('该昵称已被占用');
        }
    }

    /**
     * @param $email
     * @throws \think\Exception
     * 检查邮箱是否可用
     */
    public function checkEmail($email)
    {
        //检查是否唯一
        $emailCount = Db::name('Users')
            ->where('email', 'eq', $email)
            ->count();
        if ($emailCount > 0) {
            $this->error('该邮箱已被占用');
        }
    }

    /**
     * @param $password
     * @param $repassword
     * 检查密码是否一致
     */
    public function checkPassword($password, $repassword)
    {
        if ($password !== $repassword) {
            $this->error('两次密码不一致');
        }
    }
}
