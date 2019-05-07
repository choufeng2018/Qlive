<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/5/7
 * Time: 9:17
 * Dedicated to my wife and daughter
 */

namespace app\qlive\controller;


use app\common\model\Sms;
use app\common\model\User;
use app\qlive\model\QliveLiveHistory;
use think\Controller;
use think\Db;

/**
 * Class SmsApi
 * @package app\qlive\controller
 * 通知类短信的接口
 */
class SmsApi extends Controller
{
    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 定时发送直播预约通知短信
     */
    public function index()
    {
        //30分钟内即将开播的预约
        $time_point = \time() + 1800;
        $list = Db::name('QliveAppoint')
            ->where('status', 'eq', 0)
            ->whereTime('live_open_time', 'between', [\time(), $time_point])
            ->select();
        if (empty($list)) {
            $result = [
                'code' => 0,
                'msg' => '暂无任务',
                'time' => \time(),
            ];
            return \json($result);
        }
        foreach ($list as $v) {
            $user_info = User::get($v['uid']);
            $live_info = QliveLiveHistory::get($v['live_id']);
            //短信发送记录入库数据
            $sms_data = [
                'type' => 3,
                'mobile' => $user_info['mobile'],
                'code' => '直播预约记录',
                'ip' => \request()->ip(),
            ];

            //发送短信
            $templateCode = \config('alisms_config.live_appoint');
            $param = [
                'mobile' => $user_info['mobile'],
                'template' => $templateCode,
                'templateParam' => [
                    'name' => $live_info['title'],
                    'time' => $live_info['open_time'],
                ],
            ];
            $sms_res = \hook('sms', $param, true);
            if ($sms_res[0]) {
                $res = Sms::create($sms_data);
                if ($res) {
                    //短信发送成功后修改预约状态
                    Db::name('QliveAppoint')
                        ->where('id', 'eq', $v['id'])
                        ->setField('status', 1);
                    $result = [
                        'code' => 1,
                        'msg' => '预约成功',
                        'time' => \time(),
                    ];
                    return \json($result);
                } else {
                    $result = [
                        'code' => 0,
                        'msg' => '预约失败',
                        'time' => \time(),
                    ];
                    return \json($result);
                }
            } else {
                $result = [
                    'code' => 0,
                    'msg' => '短信发送失败',
                    'time' => \time(),
                ];
                return \json($result);
            }
        }
    }
}
