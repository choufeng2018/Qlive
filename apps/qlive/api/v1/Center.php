<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/1
 * Time: 16:23
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\common\model\User;
use app\qlive\model\QliveAnchorList;
use app\qlive\model\QliveBill;
use app\qlive\model\QliveLiveHistory;
use app\qlive\model\QliveRate;
use app\qlive\model\QliveReplyList;
use app\qlive\model\QliveUserCertification;
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
    use CommonTrait;

    /**
     *个人中心首页
     */
    public function index()
    {
        $user_info = $this->user;
        $this->success('获取成功', $user_info);
    }

    /**
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * 退出登录
     */
    public function logout()
    {
        Db::name('UserToken')
            ->where([
                'token' => $this->token,
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
            //判断是否实名认证
            $isCert = \isCertificate($this->userId);
            if (!$isCert) {
                $this->error('还未实名认证');
            }
            $param = [
                'live_id' => \input('live_id'),
                'anchor' => \getAnchorNameByLiveId(\input('live_id')),
                //注意这里是用的昵称字段不是用户名
                'username' => $userInfo['nickname'],
                'question' => \input('question'),
                'status' => 0
            ];
            $param['anchor_id'] = \getAnchorIdByName($param['anchor']);
            $param['uid'] = $userInfo['uid'];
            if (empty($param['question'])) {
                $this->error('内容不能为空');
            }
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
            //判断是否实名认证
            $isCert = \isCertificate($this->userId);
            if (!$isCert) {
                $this->error('还未实名认证');
            }
            $userInfo = $this->user;

            $param = [
                'live_id' => \input('live_id'),
                'anchor' => \getAnchorNameByLiveId(\input('live_id')),
                //注意这里是用的昵称字段不是用户名
                'username' => $userInfo['nickname'],
                'content' => \input('content'),
                'status' => 0
            ];
            $param['anchor_id'] = \getAnchorIdByName($param['anchor']);
            $param['uid'] = $userInfo['uid'];
            if (empty($param['content'])) {
                $this->error('内容不能为空');
            }
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
     *回复评论
     */
    public function commentReply()
    {
        if ($this->request->isPost()) {
            $to_uid = Db::name('Users')
                //这里nickname和username用混，应该是nickname
                ->where('nickname', 'eq', \input('username'))
                ->value('uid');
            $sql_data = [
                'comment_id' => \input('comment_id'),
                'reply_id' => \input('reply_id', 0),
                'content' => \input('content'),
                'from_uid' => $this->userId,
                'to_uid' => $to_uid
            ];
            $res = QliveReplyList::create($sql_data);
            if ($res) {
                $this->success('回复成功');
            } else {
                $this->error('回复失败');
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
            $return = logic('common/Upload')->uploadAvatar($this->userId);
            return \json($return);
        } else {
            $this->error('提交方式不正确');
        }
    }

    /**
     * @return \think\response\Json
     * 上传单个图片或文件
     */
    public function upload()
    {
        if ($this->request->isPost()) {
            $param['uid'] = $this->userId;
            $return = \logic('common/Upload')->upload($param);
            return \json($return);
        } else {
            $this->error('提交方式不正确');
        }
    }

    /**
     * @param Request $request
     * @throws \think\Exception
     * 更新用户基本信息
     */
    public function updateProfile(Request $request)
    {
        if ($request->isPost()) {
            $userInfo = $this->user;
            $param = \input();
            if (empty($param['mobile']) && empty($param['email'])) {
                $this->error('手机号或邮箱至少输入一项');
            }
            //检测各项是否更改或者可以更改
            if ($param['username'] != $userInfo['username']) {
                $this->checkUserName($param['username']);
            } else {
                $param['username'] = $userInfo['username'];
            }
            if ($param['nickname'] != $userInfo['nickname']) {
                $this->checkNickName($param['nickname']);
            } else {
                $param['nickname'] = $userInfo['nickname'];
            }
            if ($param['mobile'] != $userInfo['mobile']) {
                $this->checkMobile($param['mobile']);
            } else {
                $param['mobile'] = $userInfo['mobile'];
            }
            if ($param['email'] != $userInfo['email']) {
                $this->checkEmail($param['email']);
            } else {
                $param['email'] = $userInfo['email'];
            }

            //更新到users表中
            $userModel = new User();
            $res[0] = $userModel->allowField(true)->save($param, ['uid' => $this->userId]);

            //如果是主播还需要修改主播表中资料
            $is_anchor = \isAnchor($this->userId);
            if ($is_anchor) {
                $anchorModel = new QliveAnchorList();
                $res[1] = $anchorModel->allowField(true)->save($param, ['uid' => $this->userId]);
            }
            if ($res) {
                $this->success('OK');
            } else {
                $this->error('信息未更新');
            }
        } else {
            $this->error('提交方式不正确');
        }
    }

    /**
     *重置密码
     */
    public function updatePassword()
    {
        if ($this->request->isPost()) {
            $new_password = \input('new_password');
            $re_password = \input('re_password');
            $this->checkPassword($new_password, $re_password);
            $password = \encrypt($new_password);
            $res = Db::name('Users')
                ->where('uid', 'eq', $this->userId)
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


    /**
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * 实名认证/获取实名认证信息
     */
    public function certification()
    {
        if ($this->request->isPost()) {
            $certification_info = QliveUserCertification::get(['uid' => $this->userId]);
            if (!empty($certification_info)) {
                $this->success('已认证', $certification_info);
            } else {
                $param = \input();
                if (empty($param['real_name']) || empty($param['id_number']) || empty($param['idcard_face']) || empty($param['idcard_emblem'])) {
                    $this->error('信息不完整');
                }
                //检测身份证号是否合法
                $is_idcard = \check_id_card($param['id_number']);
                if (!$is_idcard) {
                    $this->error('身份证号不合法');
                }
                //身份证号码是否已经存在
                $id_number_count = Db::name('QliveUserCertification')
                    ->where('id_number', 'eq', $param['id_number'])
                    ->count();
                if ($id_number_count > 0) {
                    $this->error('身份证号码已存在');
                }

                $param['uid'] = $this->userId;
                $creModel = new QliveUserCertification();
                $res = $creModel->allowField(true)->save($param);
                if ($res) {
                    $this->success('认证成功');
                } else {
                    $this->error('认证失败');
                }
            }
        } else {
            $this->error('提交方式不正确');
        }
    }

    /**
     * @throws \think\exception\DbException
     * 申请成为主播
     */
    public function toBeAnchor()
    {
        if ($this->request->isPost()) {
            //判断是否已经是主播
            $is_anchor = QliveAnchorList::get(['uid' => $this->userId]);
            if (!empty($is_anchor)) {
                $this->error('已是主播,请勿重复申请');
            }
            //实名信息
            $certification_info = QliveUserCertification::get(['uid' => $this->userId]);
            if (empty($certification_info)) {
                $this->error('请先实名认证');
            }
            //检查个人信息是否完整(因为要用到工作单位)
            $user_info = User::get($this->userId);
            if (empty($user_info['workplace'])) {
                $this->error('请先完善个人信息');
            }
            $sql_data = [
                'username' => $user_info['username'],
                'nickname' => $user_info['nickname'],
                'sex' => $user_info['sex'],
                'email' => $user_info['email'],
                'mobile' => $user_info['mobile'],
                'idcard_face' => $certification_info['idcard_face'],
                'idcard_emblem' => $certification_info['idcard_emblem'],
                'uid' => $this->userId,
                'status' => 2,
                'marks' => \input('marks', 0, 'htmlspecialchars')
            ];
            $res = QliveAnchorList::create($sql_data);
            if ($res) {
                $this->success('申请成功,请等待平台审核');
            } else {
                $this->error('申请失败');
            }
        } else {
            $this->error('提交方式不正确');
        }
    }


    /**
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * 下单，购买视频，直播
     */
    public function order()
    {
        $live_id = \input('live_id');
        $live_info = QliveLiveHistory::get($live_id);
        if (empty($live_info)) {
            $this->error('该直播不存在');
        }
        //检测是否已存在
        $order_count = Db::name('QliveBill')
            ->where('uid', 'eq', $this->userId)
            ->where('live_id', 'eq', $live_id)
            ->count();
        if ($order_count > 0) {
            $this->error('请勿重复下单');
        }
        $sql_data = [
            'uid' => $this->userId,
            'live_id' => $live_id,
            'price' => $live_info['price'],
            'marks' => \input('marks', ''),
            'out_trade_no' => \get_order_sn(),
        ];
        if ($live_info['price'] + 0 == 0) {
            $sql_data['pay_status'] = 1;
        }
        $res = QliveBill::create($sql_data);
        if ($res) {
            $this->success('下单成功');
        } else {
            $this->error('下单失败');
        }
    }

    /**
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 订单列表
     */
    public function billList()
    {
        $page = \input('page', 1);

        $list = Db::name('QliveLiveHistory')
            ->alias('a')
            ->join('QliveBill b', 'a.id=b.live_id')
            ->where('b.uid', 'eq', $this->userId)
            ->page($page, 10)
            ->field('b.id,a.id as live_id,a.title,a.logo,b.price,b.create_time')
            ->select();
        $count = Db::name('QliveLiveHistory')
            ->alias('a')
            ->join('QliveBill b', 'a.id=b.live_id')
            ->where('b.uid', 'eq', $this->userId)
            ->count();
        $res['list'] = $list;
        $res['count'] = $count;
        if ($res) {
            $this->success('OK', $res);
        } else {
            $this->error('暂无数据');
        }
    }

    /**
     *检测是否付费
     */
    public function checkBill()
    {
        $live_id = \input('live_id');
        $live_info = QliveLiveHistory::get($live_id);
        if (empty($live_info)) {
            $this->error('数据不存在');
        } else {
            //该用户，已下单的直播，已经付费成功的
            $bill_find = QliveBill::get(['live_id' => $live_id, 'uid' => $this->userId, 'pay_status' => 1]);
            if ($live_info['price'] > 0 && empty($bill_find)) {
                $this->error('未购买');
            } else {
                $this->success('已购买');
            }
        }
    }


    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 返回用户实名认证状态
     */
    public function checkCertification()
    {
        $certification_info = Db::name('QliveUserCertification')
            ->where('uid', 'eq', $this->userId)
            ->find();
        if (empty($certification_info)) {
            $this->error('尚未提交认证资料', ['code' => '-1', 'msg' => '尚未提交认证资料']);
        } elseif ($certification_info['status'] == 0) {
            $this->error('后台审核中', ['code' => '0', 'msg' => '后台审核中']);
        } elseif ($certification_info['status'] == 1) {
            $this->success('已通过认证', ['code' => '1', 'msg' => '已通过认证']);
        } elseif ($certification_info['status'] == 2) {
            $this->error('未通过认证', ['code' => '2', 'msg' => '未通过认证']);
        } else {
            $this->error('未知状态');
        }
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取主播的状态
     */
    public function getAnchorStatus()
    {
        $anchor_info = Db::name('QliveAnchorList')
            ->where('uid', 'eq', $this->userId)
            ->find();
        if (empty($anchor_info)) {
            $this->error('还不是主播', ['code' => '-1', 'msg' => '还不是主播']);
        } elseif ($anchor_info['status'] == 2) {
            $this->success('后台审核中', ['code' => '2', 'msg' => '后台审核中']);
        } elseif ($anchor_info['status'] == 3) {
            $this->error('你已被禁播', ['code' => '3', 'msg' => '你已被禁播']);
        } elseif ($anchor_info['status'] == 4) {
            $this->success('正常可开播', ['code' => '4', 'msg' => '正常可开播']);
        } else {
            $this->error('未知状态');
        }
    }
}
