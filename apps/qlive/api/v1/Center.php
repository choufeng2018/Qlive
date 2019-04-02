<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/1
 * Time: 16:23
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestUserBase;
use think\Db;

/**
 * Class Center
 * @package app\qlive\api\v1
 * 个人中心的操作
 */
class Center extends RestUserBase
{
    /**
     *个人中心首页
     */
    public function index()
    {
        if (!$this->request->isPost()) {
            $this->error('提交方式不正确');
        } else {
            $info = Db::name('Users')
                ->where('uid', 'eq', $this->userId)
                ->find();
            $this->success('获取成功', $info);
        }
    }

    /**
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * 退出登录
     */
    public function logout()
    {
        $header = $this->request->header();
        Db::name('UserToken')
            ->where([
                'token' => $header['token'],
                'device_type' => $this->deviceType,
            ])
            ->update(['token' => '']);
        $this->success('退出成功');
    }
}
