<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/5/16
 * Time: 16:48
 * Dedicated to my wife and daughter
 */

namespace app\qlive\admin;


use app\admin\controller\Admin;
use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\qlive\model\QliveReplyList;

/**
 * Class Reply
 * @package app\qlive\admin
 * 回复控制器
 */
class Reply extends Admin
{
    /**
     * @var
     */
    protected $replyModel;

    /**
     *
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->replyModel = new QliveReplyList();
    }

    /**
     * @return \app\common\layout\Content
     */
    public function index()
    {
        $id = \input('id');
        $data_list = $this->replyModel->where('comment_id', 'eq', $id)->order('create_time desc')->page(1, 12)->select();
        $total = $this->replyModel->where('comment_id', 'eq', $id)->count();
        $content = (new BuilderList())
            ->addTopBtn('resume', ['model' => 'QliveReplyList', 'title' => '显示'])
            ->addTopButton('forbid', ['model' => 'QliveReplyList', 'title' => '隐藏'])
            ->addTopButton('delete', ['model' => 'QliveReplyList'])
            ->keyListItem('id', 'ID')
            ->keyListItem('comment_id', '评论ID')
            ->keyListItem('reply_id', '回复目标ID')
            ->keyListItem('content', '回复内容')
            ->keyListItem('from_uid', '发布者')
            ->keyListItem('to_uid', '被回复者')
            ->keyListItem('status', '状态', 'status')
            ->keyListItem('right_button', '操作')
            ->setListData($data_list)
            ->setListPage($total)
            ->addRightButton('delete', ['model' => 'QliveReplyList'])
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('回复列表')
            ->content($content);
    }
}
