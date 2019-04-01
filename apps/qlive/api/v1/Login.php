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

/**
 * Class Login
 * @package app\qlive\api\v1
 * 登录控制器
 */
class Login extends RestBase
{
    /**
     *
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
                $this->success('登录成功');
            } else {
                $this->error($result['msg']);
            }
        } else {
            $this->error('提交方式不正确');
        }
    }
}
