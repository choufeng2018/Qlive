<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/12
 * Time: 10:43
 * Dedicated to my wife and daughter
 */

namespace app\common\logic;


use think\Db;

/**
 * Class Sms
 * @package app\common\logic
 * 1=注册;2=重置密码
 */
class Sms extends Base
{
    /**
     * @param $mobile
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据手机号获取最近一条验证码的数据
     */
    public function getLastCodeInfoByMobile($mobile)
    {
        $code_info = Db::name('Sms')
            ->where('mobile', 'eq', $mobile)
            ->order('create_time desc')
            ->find();
        return $code_info;
    }

    /**
     * @param $mobile
     * @return bool
     * @throws \think\Exception
     * 检查发送频率和总条数
     */
    public function checkFrequency($mobile, $type)
    {
        //一天最多十五条相同类型的验证码
        $map = [
            'mobile' => $mobile,
            'type' => $type,
        ];
        $count = Db::name('Sms')
            ->where($map)
            ->whereTime('create_time', 'today')
            ->count();
        //每次间隔不超过60s
        $code_info = $this->getLastCodeInfoByMobile($mobile);
        if (\time() - \strtotime($code_info['create_time']) < 60) {
            return false;
        } elseif ($count > 15) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * @param $mobile   手机号
     * @param $code 验证码
     * @param $type 类型
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 检查验证码是否正确或过期
     */
    public function checkCode($mobile, $code, $type)
    {
        $code_info = $this->getLastCodeInfoByMobile($mobile);
        //检查验证码和过期时间
        if ($code != $code_info['code']) {
            return false;
        } elseif (\time() - \strtotime($code_info['create_time']) > \config('alisms_config.expire')) {
            return false;
        } elseif ($type != $code_info['type']) {
            return false;
        } else {
            return true;
        }
    }
}
