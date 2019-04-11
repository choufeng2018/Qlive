<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/11
 * Time: 16:06
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\common\logic\User as UserLogic;
use think\Db;

/**
 * Trait CommonTrait
 * @package app\qlive\api\v1
 */
trait CommonTrait
{
    /**
     * @param $username
     * @throws \think\Exception
     * 检查用户名是否可用,是否唯一
     */
    public function checkUserName($username)
    {
        if (!empty($username)) {
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
            //只可以使用字母,数字,破折号
            if (!preg_match('/^[a-z0-9 .\-]+$/i', $username)) {
                $this->error('用户名只允许:字母,数字,破折号');
            }
        } else {
            $this->error('用户名不可为空');
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
        if (!\filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            $this->error('邮箱格式不正确');
        }
    }

    /**
     * @param $mobile
     * @throws \think\Exception
     * 检查手机号是否可用
     */
    public function checkMobile($mobile)
    {
        //检查是否唯一
        $emailCount = Db::name('Users')
            ->where('mobile', 'eq', $mobile)
            ->count();
        if ($emailCount > 0) {
            $this->error('该手机号已被占用');
        }
        //正则检测手机号
        if (!\preg_match("/^1[345789]\d{9}$/", $mobile)) {
            $this->error('手机号格式有误');
        }
    }

    /**
     * @param $password
     * @param $repassword
     * 检查密码是否一致
     */
    public function checkPassword($password, $repassword)
    {
        if (\strlen($password) < 6 || \strlen($password) > 20) {
            $this->error('密码长度必须在6~20之间');
        }
        if ($password !== $repassword) {
            $this->error('两次密码不一致');
        }
    }
}
