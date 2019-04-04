<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/4
 * Time: 11:33
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;

/**
 * Class Comment
 * @package app\qlive\api\v1
 * 评论控制器
 */
class Comment extends RestBase
{
    /**
     *评论列表
     */
    public function commentList()
    {
        $id = \input('id');
        $page = \input('page');
        //评论列表
        $comment_list = \logic('CommentLogic')->getCommentsByLiveId($id, $page);
        $this->success('Ok', $comment_list);
    }
}
