<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/28
 * Time: 10:15
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;
use think\Db;

/**
 * Class Password
 * @package app\qlive\api\v1
 */
class Password extends RestBase
{
    use CommonTrait;

    /**
     * @throws \think\Exception
     * 忘记密码的重置密码
     */
    public function reset()
    {
        if ($this->request->isPost()) {
            $mobile = \input('mobile');
            $this->checkMobile($mobile);
            $new_password = \input('new_password');
            $re_password = \input('re_password');
            $this->checkPassword($new_password, $re_password);
            $password = \encrypt($new_password);
            $res = Db::name('Users')
                ->where('mobile', 'eq', $mobile)
                ->setField('password', $password);
            if ($res) {
                $this->success('密码重置成功');
            } else {
                $this->error('密码重置失败');
            }
        } else {
            $this->error('提交方式不正确');
        }
    }
}
