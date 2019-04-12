<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/1
 * Time: 17:12
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\common\model\Sms;
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
            if (empty($data['mobile']) || empty($data['password']) || empty($data['password_confirm'])) {
                $this->error('提交数据不完整');
            }
            $this->checkUserName($data['mobile']);
            $this->checkMobile($data['mobile']);
            $this->checkPassword($data['password'], $data['password_confirm']);

            //组装入库数据
            $data['username'] = $data['nickname'] = \trim($data['mobile']);
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
     * @throws \think\Exception
     * 获取注册手机验证码
     */
    public function getRegSms()
    {
        $mobile = \input('mobile');

        if (empty($mobile)) {
            $this->error('手机号不能为空');
        }
        $this->checkMobile($mobile);

        $checkOne = \logic('Sms')->checkFrequency($mobile);
        if (!$checkOne) {
            $this->error('频率过快或已达当日限制');
        }

        $code = \rand_string(4, 1);
        $param = [
            'mobile' => $mobile,
            'template' => \config('alisms_config.register'),
            'templateParam' => [
                'code' => $code,
                'product' => '耳听美',
            ],
        ];
        $res = \hook('sms', $param, true);
        if ($res) {
            //写入sms数据表中
            $sql_data = [
                'type' => 1,
                'mobile' => $mobile,
                'code' => $code,
                'ip' => $this->request->ip(),
            ];
            Sms::create($sql_data);
            $this->success('发送成功,验证码有效时间为' . \config('alisms_config.expire') . '秒');
        } else {
            $this->error('发送失败');
        }
    }

    /**
     *检测注册验证码
     */
    public function checkRegSms()
    {
        if ($this->request->isPost()) {
            $param = \input();
            $res = \logic('Sms')->checkCode($param['mobile'], $param['code'], 1);
            if ($res) {
                $this->success('验证通过');
            } else {
                $this->error('验证失败');
            }
        } else {
            $this->error('提交方式不正确');
        }
    }
}
