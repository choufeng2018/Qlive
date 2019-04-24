<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/8
 * Time: 15:57
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\qlive\model\QliveAnchorList;
use app\qlive\model\QliveCommentList;
use app\qlive\model\QliveLiveHistory;
use app\qlive\model\QliveRoomList;
use app\user\logic\User;
use think\Db;

/**
 * Class AnchorCenter
 * @package app\qlive\api\v1
 * 主播独有的操作控制器
 */
class AnchorCenter extends Center
{
    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 检查是否是主播
     */
    public function checkAnchor()
    {
        //检查这个用户是不是主播
        if ($this->userType != 2) {
            $this->error('你还不是主播,无法进行该操作');
        }
        if (!$this->request->isPost()) {
            $this->error('提交方式不正确');
        }
    }

    /**
     * @throws \think\exception\DbException
     * 主播的个人信息
     */
    public function index()
    {
        $uid = $this->userId;
        $anchor_id = \getAnchorIdByUid($uid);
        $user_info = User::get($uid);
        $anchor_info = QliveAnchorList::get($anchor_id);
        $room_info = QliveRoomList::get(['anchor_id' => $anchor_id]);
        $return = [
            'user_info' => $user_info,
            'anchor_info' => $anchor_info,
            'room_info' => $room_info,
        ];
        $this->success('OK', $return);
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 添加问题的回答
     */
    public function answerAdd()
    {
        $anchor_info = $this->user;
        $id = \input('question_id');
        $quesdtion_info = Db::name('QliveQuestionList')
            ->where('id', 'eq', $id)
            ->find();
        //检查该条问题的直播记录中的主播是不是正要处理这条问题的主播
        if ($anchor_info['username'] == $quesdtion_info['anchor']) {
            $data = [
                'id' => $id,
                'answer' => \input('content'),
            ];
            $res = \logic('QuestionLogic')->editQuestion($data);
            if ($res) {
                $this->success('回答问题成功');
            } else {
                $this->error('回答问题失败');
            }
        } else {
            $this->error('身份验证失败');
        }
    }

    /**
     * @throws \think\exception\DbException
     * 添加直播申请
     */
    public function addLive()
    {
        $anchor_info = QliveAnchorList::get(['uid' => $this->userId]);
        $sql_data = [
            'anchor' => $anchor_info['nickname'],
            'anchor_id' => \getAnchorIdByName($anchor_info['nickname']),
            'room_id' => $anchor_info['room_id'],
            'title' => \input('title'),
            'logo' => \input('logo'),
            'category' => \input('category'),
            'live_type' => \input('live_type'),
            'schedule' => \input('schedule', ''),
            'description' => \input('description', ''),
            'price' => \input('price', 0),
            'password' => \input('password', ''),
            'commentable' => \input('commentable', 1),
            'can_ask' => \input('can_ask', 1),
            'file' => \input('file', ''),
            'open_time' => \input('open_time'),
        ];
        if (empty($sql_data['title']) || empty($sql_data['open_time'])) {
            $this->error('标题或开播时间不能为空');
        }
        $res = QliveLiveHistory::create($sql_data);
        if ($res) {
            $this->success('提交成功');
        } else {
            $this->error('提交失败,请重试');
        }
    }


    /**
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取自己的直播记录
     */
    public function liveList()
    {
        $listModel = new QliveLiveHistory();
        $anchor_name = $this->user['nickname'];
        $page = \input('page', 1);
        $list = $listModel
            ->where('anchor', 'eq', $anchor_name)
            ->page($page, 10)
            ->select();
        foreach ($list as $k => $value) {
            $list[$k]['logo'] = \get_file_complete_path($value['logo']);
        }
        $count = $listModel->where('anchor', 'eq', $anchor_name)->count();
        $res['count'] = $count;
        $res['list'] = $list;
        if (empty($res)) {
            $this->error('暂无数据');
        } else {
            $this->success('OK', $res);
        }
    }

    /**
     *每个直播记录的评论
     */
    public function liveComment()
    {
        $id = \input('live_id');
        $page = \input('page', 1);
        //评论列表
        $comment_list = \logic('CommentLogic')->getCommentsByLiveId($id, '0,1', $page);
        if ($comment_list) {
            $this->success('Ok', $comment_list);
        } else {
            $this->error('暂无数据');
        }
    }

    /**
     *处理评论,1=对观众可见,2=删除评论
     */
    public function setCommentStatus()
    {
        $status = \input('status', 1);
        $comment_id = \input('id');
        $comment_info = QliveCommentList::get($comment_id);
        if (empty($comment_info)) {
            $this->error('评论不存在');
        }
        if ($status == 1) {
            //设置观众可见
            $res = Db::name('QliveCommentList')
                ->where('id', 'eq', $comment_id)
                ->setField('status', $status);
        } elseif ($status == 2) {
            $res = QliveCommentList::destroy($comment_id);
        } else {
            $res = '';
            $this->error('非法操作');
        }
        if ($res) {
            $this->success('处理成功');
        } else {
            $this->error('处理失败');
        }
    }
}
