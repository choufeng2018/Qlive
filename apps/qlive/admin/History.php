<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/27
 * Time: 14:38
 * Dedicated to my wife and daughter
 */

namespace app\qlive\admin;


use app\common\builder\BuilderForm;
use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\qlive\model\QliveLiveHistory;

/**
 * Class History
 * @package app\qlive\admin
 * 开播记录
 */
class History extends QliveBase
{
    /**
     * @var
     * 开播模型
     */
    protected $historyModel;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->historyModel = new QliveLiveHistory();
    }

    /**
     * @return \app\common\layout\Content
     * 列表页面
     */
    public function index()
    {
        $search_setting = $this->buildModelSearchSetting();
        list($data_list, $total) = $this->historyModel->search($search_setting)->getListByPage([], true, 'create_time');
        $content = (new BuilderList())
            ->addTopButton('resume', ['title' => '通过', 'icon' => 'fa fa-check', 'model' => 'QliveLiveHistory'])
            ->addTopButton('forbid', ['title' => '拒绝', 'icon' => 'fa fa-exclamation', 'model' => 'QliveLiveHistory'])
            ->addTopButton('delete', ['model' => 'QliveListHistory'])
            ->keyListItem('id', 'ID')
            ->keyListItem('anchor', '主播')
            ->keyListItem('room_id', '房间号')
            ->keyListItem('title', '房间标题')
            ->keyListItem('logo', '房间封面', 'picture')
            ->keyListItem('category', '直播分类', 'array', $this->allCategory)
            ->keyListItem('description', '描述')
            ->keyListItem('price', '价格')
            ->keyListItem('password', '房间密码')
            ->keyListItem('commentable', '是否可评论', 'array', [1 => '可以', 0 => '不可以'])
            ->keyListItem('can_ask', '是否可提问', 'array', [1 => '可以', 0 => '不可以'])
//            ->keyListItem('file', '附件', 'url')
            ->keyListItem('open_time', '开播时间')
            ->keyListItem('status', '状态', 'array', [0 => '未通过', 1 => '已通过', 2 => '待处理'])
            ->setListData($data_list)
            ->setListPage($total)
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('开播记录')
            ->search([
                ['name' => 'open_time_range', 'type' => 'daterange', 'extra_attr' => 'placeholder="开播时间"'],
                ['name' => 'status', 'type' => 'select', 'title' => '按状态', 'options' => [0 => '待处理', 1 => '已通过', 2 => '已拒绝']],
                ['name' => 'keyword', 'type' => 'text', 'extra_attr' => 'placeholder="请输入查询关键字"'],
            ])
            ->content($content);
    }

    /**
     * @return array
     * 构建搜索条件
     */
    public function buildModelSearchSetting()
    {
        //时间范围
        $timegap = input('open_time_range');
        $extend_conditions = [];
        if ($timegap) {
            $gap = explode('—', $timegap);
            $_begin = $gap[0];
            $_end = $gap[1];

            $extend_conditions = [
                'open_time' => ['between', [$_begin . ' 00:00:00', $_end . ' 23:59:59']]
            ];
        }
        //自定义查询条件
        $search_setting = [
            'keyword_condition' => 'anchor|room_id|title',
            //忽略数据库不存在的字段
            'ignore_keys' => ['open_time_range'],
            //扩展的查询条件
            'extend_conditions' => $extend_conditions
        ];
        return $search_setting;
    }

    /**
     * @param int $id
     * @return \app\common\layout\Content
     * @throws \think\exception\DbException
     * 编辑/新增
     */
    public function edit($id = 0)
    {
        $title = $id > 0 ? '编辑' : '新增';
        if (IS_POST) {
            $param = \input();
            if ($this->historyModel->editData($param)) {
                $this->success($title . '成功', \url('index'));
            } else {
                $this->error($this->historyModel->getError());
            }
        } else {
            $info = [
                'price' => 0,
                'password' => '',
                'commentable' => 1,
                'can_ask' => 1
            ];
            if ($id > 0) {
                $info = QliveLiveHistory::get($id);
            }
            $content = (new BuilderForm())
                ->addFormItem('id', 'hidden', 'ID')
                ->addFormItem('anchor', 'text', '主播', '', '', 'readonly')
                ->addFormItem('room_id', 'text', '房间号', '', '', 'readonly')
                ->addFormItem('title', 'text', '标题')
                ->addFormItem('category', 'multilayer_select', '分类', '', $this->categoryList)
                ->addFormItem('logo', 'picture', '封面')
                ->addFormItem('description', 'textarea', '描述')
                ->addFormItem('price', 'number', '价格')
//                ->addFormItem('password', 'text', '房间密码')
                ->addFormItem('open_time', 'datetime', '开播时间')
                ->addFormItem('commentable', 'radio', '是否可评论', '', [0 => '否', 1 => '是'])
                ->addFormItem('can_ask', 'radio', '是否可评论', '', [0 => '否', 1 => '是'])
//                ->addFormItem('file', 'file', '附件')
                ->setFormData($info)
                ->addButton('submit')
                ->addButton('back')
                ->fetch();
            return (new Iframe())
                ->setMetaTitle($title . '房间设置')
                ->content($content);
        }
    }
}
