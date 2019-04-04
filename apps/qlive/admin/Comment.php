<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/19
 * Time: 10:51
 * Dedicated to my wife and daughter
 */

namespace app\qlive\admin;


use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\qlive\model\QliveCommentList;

/**
 * Class Comment
 * @package app\qlive\admin
 * 评论控制器
 */
class Comment extends QliveBase
{
    /**
     * @var
     * 评论模型
     */
    protected $commentModel;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->commentModel = new QliveCommentList();
    }

    /**
     * @return \app\common\layout\Content
     * 评论列表
     */
    public function index()
    {
        list($data_list, $total) = $this->commentModel->search()->getListByPage([], true, 'create_time desc');
        $content = (new BuilderList())
            ->addTopButton('resume', ['model' => 'QliveCommentList', 'title' => '显示'])
            ->addTopButton('forbid', ['model' => 'QliveCommentList', 'title' => '隐藏'])
            ->addTopButton('delete', ['model' => 'QliveCommentList'])
            ->keyListItem('id', 'ID')
            ->keyListItem('live_id', '直播ID')
            ->keyListItem('anchor', '主播')
            ->keyListItem('username', '发布者')
            ->keyListItem('content', '内容')
            ->keyListItem('status', '状态', 'status')
            ->keyListItem('right_button', '操作')
            ->setListData($data_list)
            ->setListPage($total)
            ->addRightButton('delete', ['model' => 'QliveCommentList'])
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('评论列表')
            ->content($content);
    }
}
