<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/4
 * Time: 11:09
 * Dedicated to my wife and daughter
 */

namespace app\Qlive\logic;


use app\common\logic\Base as BaseLogic;
use app\qlive\model\QliveCommentList;
use think\Db;

/**
 * Class CommentLogic
 * @package app\Qlive\logic
 * 评论逻辑层
 */
class CommentLogic extends BaseLogic
{

    /**
     * @param $live_id 直播id
     * @param int $status
     * @param int $page
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 评论列表
     */
    public function getCommentsByLiveId($live_id, $status = '1', $page = 1)
    {
        $map = [
            'status' => ['in', $status],
            'live_id' => $live_id,
        ];
        $comment_list = Db::name('QliveCommentList')
            ->where($map)
            ->field('id,username,content,create_time')
            ->page($page, 10)
            ->select();
        if (!empty($comment_list)) {
            foreach ($comment_list as $k => $value) {
                $comment_list[$k]['reply_list'] = $this->getReplyList($value['id']);
            }
        }
        return $comment_list;
    }

    /**
     * @param $comment_id
     * @param int $reply_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取评论下的回复
     */
    function getReplyList($comment_id, $reply_id = 0)
    {
        $list = Db::name('QliveReplyList')
            ->where('comment_id', 'eq', $comment_id)
            ->where('reply_id', 'eq', $reply_id)
            ->select();
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]['sub_reply'] = $this->getSubReplyList($v['id']);
            }
        }

        return $list;
    }

    /**
     * @param $reply_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取回复下的子回复
     */
    function getSubReplyList($reply_id)
    {
        $list = Db::name('QliveReplyList')
            ->where('reply_id', 'eq', $reply_id)
            ->select();
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]['sub_reply'] = $this->getSubReplyList($v['id']);
            }
        }
        return $list;
    }

    /**
     * @param array $param
     * @return bool
     * 添加评论
     */
    public function addComment(array $param)
    {
        $commentModel = new QliveCommentList();
        $res = $commentModel->editData($param);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
}
