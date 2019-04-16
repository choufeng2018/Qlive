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
    public function getCommentsByLiveId($live_id, $status = 1, $page = 1)
    {
        $map = [
            'status' => ['eq', $status],
            'live_id' => $live_id,
        ];
        $comment_list = Db::name('QliveCommentList')
            ->where($map)
            ->field('username,content,create_time')
            ->page($page, 10)
            ->select();
        return $comment_list;
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
