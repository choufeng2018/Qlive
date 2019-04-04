<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/28
 * Time: 10:06
 * Dedicated to my wife and daughter
 */

namespace app\qlive\admin;


use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\qlive\model\QliveQuestionList;

/**
 * Class Question
 * @package app\qlive\admin
 * 提问回答控制器
 */
class Question extends QliveBase
{
    /**
     * @var
     * qa模型
     */
    protected $qaModel;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->qaModel = new QliveQuestionList();
    }

    /**
     * @return \app\common\layout\Content
     * 提问列表
     */
    public function index()
    {
        list($data_list, $total) = $this->qaModel->search()->getListByPage([], true, 'create_time desc');
        $content = (new BuilderList())
            ->addTopButton('resume', ['title' => '显示', 'model' => 'QliveQuestionList'])
            ->addTopButton('forbid', ['title' => '隐藏', 'model' => 'QliveQuestionList'])
            ->addTopButton('delete', ['model' => 'QliveQuestionList'])
            ->keyListItem('id', 'ID')
            ->keyListItem('live_id', '直播ID')
            ->keyListItem('anchor', '主播')
            ->keyListItem('username', '提问者')
            ->keyListItem('question', '提问内容')
            ->keyListItem('answer', '回答内容')
            ->keyListItem('status', '状态', 'status')
            ->keyListItem('right_button', '操作')
            ->addRightButton('delete', ['model' => 'QliveQuestionList'])
            ->setListData($data_list)
            ->setListPage($total)
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('提问列表')
            ->content($content);
    }
}
