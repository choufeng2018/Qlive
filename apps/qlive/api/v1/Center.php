<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/1
 * Time: 16:23
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\qlive\model\QliveRate;
use app\rest\controller\RestUserBase;
use think\Db;
use think\Request;

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
            $info = \get_user_info($this->userId);
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

    /**
     *发布问题
     */
    public function questionAdd()
    {
        if ($this->request->isPost()) {
            $userInfo = $this->user;
            $param = [
                'live_id' => \input('live_id'),
                'anchor' => \getAnchorNameByLiveId(\input('live_id')),
                'username' => $userInfo['nickname'],
                'question' => \input('question'),
                'status' => 0
            ];
            $res = \logic('QuestionLogic')->addQuestion($param);
            if ($res) {
                $this->success('提问成功');
            } else {
                $this->error('提问失败');
            }
        } else {
            $this->error('提交方式不正确');
        }
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 发表评论
     */
    public function commentAdd()
    {
        if ($this->request->isPost()) {

            $userInfo = $this->user;
            $param = [
                'live_id' => \input('live_id'),
                'anchor' => \getAnchorNameByLiveId(\input('live_id')),
                'username' => $userInfo['nickname'],
                'content' => \input('content'),
                'status' => 0
            ];
            $res = \logic('CommentLogic')->addComment($param);
            if ($res) {
                $this->success('评论成功');
            } else {
                $this->error('评论失败');
            }
        } else {
            $this->error('提交方式不正确');
        }
    }

    /**
     *评价(打分)直播
     */
    public function rate()
    {
        if ($this->request->isPost()) {
            $param = [
                'live_id' => \input('live_id'),
                'uid' => $this->userId,
                'rate' => \input('rate'),
            ];
            $rateModel = new QliveRate();
            $count = $rateModel->where(['live_id' => $param['live_id'], 'uid' => $param['uid']])->count();
            if ($count > 0) {
                $this->error('不可重复评分');
            }
            $res = $rateModel->save($param);
            if ($res) {
                $this->success('评价成功');
            } else {
                $this->error('评价失败');
            }
        } else {
            $this->error('提交方式不正确');
        }
    }

    /**
     *上传头像
     */
    public function uploadAvatar()
    {
        if ($this->request->isPost()) {
            $uid = \getUidByToken($this->token);
            $return = logic('common/Upload')->uploadAvatar($uid);
            $this->success('OK', $return);
        } else {
            $this->error('提交方式不正确');
        }
    }

    public function updateProfile(Request $request)
    {
        if ($request->isPost()) {
            $userInfo = $this->user;
            $param = \input();

        } else {
            $this->error('提交方式不正确');
        }
    }
}
