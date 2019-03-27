<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/27
 * Time: 14:17
 * Dedicated to my wife and daughter
 */

namespace app\qlive\controller;


use app\common\model\User;
use app\home\controller\Home;
use app\user\logic\UserLogic;

/**
 * Class Login
 * @package app\qlive\controller
 * 登录登出控制器
 */
class Login extends Home
{
    /**
     * @var
     * 用户模型
     */
    protected $userModel;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->userModel = new User();
        if (\is_login()) {
            $this->redirect('/');
        }
    }

    /**
     * @return mixed|string
     * @throws \Exception
     * 登录
     */
    public function login()
    {
        if (IS_POST) {
            $param = \input();
            $validateRule = [
                ['username', 'require|min:1', '登录名不能为空|登录名格式不正确'],
                ['password', 'require|length:6,32', '请填写密码|密码格式不正确']
            ];
            $validateRes = $this->validate($param, $validateRule);
            if ($validateRes !== true) {
                $this->error($validateRes);
            }
            if (isset($param['rememberme'])) {
                $rememberme = $param['rememberme'] == 1 ? true : false;
            } else {
                $rememberme = false;
            }
            $resule = UserLogic::login($param['username'], $param['password'], $rememberme);
            if ($resule['code'] == 1) {
                $uid = !empty($resule['data']['uid']) ? $resule['data']['uid'] : 0;

                \hook('LoginUser', ['uid' => $uid]);
                $this->success('登录成功', \url('center'));
            } elseif ($resule['code'] == 0) {
                $this->error($resule['msg']);
            } else {
                $this->logout();
            }
        } else {
            return $this->fetch();
        }
    }

    /**
     *退出
     */
    public function logout()
    {
        \session(null);
        \cookie(null, \config('cookie.prefix'));
        $this->redirect('/');
    }
}
