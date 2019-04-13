<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/13
 * Time: 9:02
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;

/**
 * Class Sms
 * @package app\qlive\api\v1
 * 短信控制器
 */
class Sms extends RestBase
{
    use CommonTrait;

    /**
     * @throws \think\Exception
     * 获取短信验证码
     */
    public function getSms()
    {
        if ($this->request->isPost()) {
            //手机号
            $mobile = \input('mobile');
            $this->checkMobile($mobile);
            //验证码类别
            $smsType = \input('type', 1);

            //对应的短信模板编号
            $templateCode = '';
            switch ($smsType) {
                case 1:
                    $templateCode = \config('alisms_config.register');
                    break;
                case 2:
                    $templateCode = \config('alisms_config.reset_password');
                    break;
            }

            $checkFrequency = \logic('Sms')->checkFrequency($mobile, $smsType);
            if (!$checkFrequency) {
                $this->error('频率过快或已达当日限制');
            }
            $code = \rand_string(4, 1);
            $param = [
                'mobile' => $mobile,
                'template' => $templateCode,
                'templateParam' => [
                    'code' => $code,
                    'product' => '耳听美',
                ],
            ];
            $res = \hook('sms', $param, true);
            if ($res) {
                //写入sms数据表中
                $sql_data = [
                    'type' => $smsType,
                    'mobile' => $mobile,
                    'code' => $code,
                    'ip' => $this->request->ip(),
                ];
                \app\common\model\Sms::create($sql_data);
                $this->success('发送成功,验证码有效时间为' . \config('alisms_config.expire') . '秒');
            } else {
                $this->error('发送失败');
            }
        } else {
            $this->error('提交方式不正确');
        }
    }

    /**
     *检测验证码
     */
    public function checkSms()
    {
        if ($this->request->isPost()) {
            $param = \input();
            $res = \logic('Sms')->checkCode($param['mobile'], $param['code'], $param['type']);
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
