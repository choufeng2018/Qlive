<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/5/7
 * Time: 9:35
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\qlive\model\QliveAppoint;
use app\qlive\model\QliveLiveHistory;
use app\rest\controller\RestUserBase;
use think\Db;

/**
 * Class Appoint
 * @package app\qlive\api\v1
 * 预约直播控制器
 */
class Appoint extends RestUserBase
{

    /**
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $user_info = $this->user;
        if (empty($user_info['mobile'])) {
            $this->error('尚未绑定手机号');
        }
        $live_id = \input('live_id');
        $live_info = QliveLiveHistory::get($live_id);
        if (empty($live_info)) {
            $this->error('直播信息不存在');
        }
        if (\strtotime($live_info['open_time']) < \time()) {
            $this->error('该直播不预约');
        }
        if (\strtotime($live_info['open_time']) - \time() < 600) {
            $this->error('即将开播，无需预约');
        }
        //检查是否已经预约过
        $count = Db::name('QliveAppoint')
            ->where('uid', 'eq', $this->userId)
            ->where('live_id', 'eq', $live_id)
            ->count();
        if ($count > 0) {
            $this->error('不得重复预约');
        }
        //预约入库数据
        $sql_data = [
            'uid' => $this->userId,
            'mobile' => $user_info['mobile'],
            'live_id' => $live_id,
            'live_open_time' => $live_info['open_time'],
        ];
        //短信发送记录入库数据
        $sms_data = [
            'type' => 3,
            'mobile' => $user_info['mobile'],
            'code' => '直播预约记录',
            'ip' => $this->request->ip(),
        ];
        //开启事务操作
        $modelA = new QliveAppoint();
        $modelA->startTrans();
        $modelS = new \app\common\model\Sms();
        $modelS->startTrans();
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
            $res1 = $modelS->save($sms_data);
            $res2 = $modelA->save($sql_data);
            if ($res1 === false || $res2 === false) {
                $modelA->rollback();
                $modelS->rollback();
                $this->error('预约失败');
            } else {
                $modelS->commit();
                $modelA->commit();
                $this->success('预约成功');
            }
        } else {
            $this->error('短信发送失败');
        }
    }
}
