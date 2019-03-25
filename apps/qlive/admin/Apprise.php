<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/21
 * Time: 16:13
 * Dedicated to my wife and daughter
 */

namespace app\qlive\admin;


use app\common\builder\BuilderForm;
use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\qlive\model\QliveAppriseList;

/**
 * Class Apprise
 * @package app\qlive\admin
 * 直播预告控制器
 */
class Apprise extends QliveBase
{
    /**
     * @var
     * 直播预告模型
     */
    protected $appriseModel;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->appriseModel = new QliveAppriseList();
    }

    /**
     * @return \app\common\layout\Content
     * 预告列表
     */
    public function index()
    {
        $_search = $this->buildModelSearchSetting();
        list($data_list, $total) = $this->appriseModel->search($_search)->getListByPage([], true, 'id,create_time desc');
        $content = (new BuilderList())
            ->addTopButton('addnew')
            ->addTopButton('delete', ['model' => 'QliveAppriseList'])
            ->keyListItem('id', 'ID')
            ->keyListItem('title', '标题')
            ->keyListItem('image', '封面', 'picture')
            ->keyListItem('lecturer', '讲者', 'array', $this->allAnchorList)
            ->keyListItem('short_content', '预告简介')
            ->keyListItem('start_time', '开始时间')
            ->keyListItem('right_button', '操作')
            ->setListData($data_list)
            ->setListPage($total)
            ->addRightButton('edit')
            ->addRightButton('delete', ['model' => 'QliveAppriseList'])
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('主播列表')
            ->search([
                    ['name' => 'start_time_range', 'type' => 'daterange', 'extra_attr' => 'placeholder="直播时间"'],
                    ['name' => 'keyword', 'type' => 'text', 'extra_attr' => 'placeholder="请输入查询关键字"'],
                ]
            )
            ->content($content);
    }

    /**
     * @return array
     * 组装搜索条件
     */
    public function buildModelSearchSetting()
    {
        //时间范围
        $timegap = input('start_time_range');
        $extend_conditions = [];
        if ($timegap) {
            $gap = explode('—', $timegap);
            $reg_begin = $gap[0];
            $reg_end = $gap[1];

            $extend_conditions = [
                'start_time' => ['between', [$reg_begin . ' 00:00:00', $reg_end . ' 23:59:59']]
            ];
        }
        //自定义查询条件
        $search_setting = [
            'keyword_condition' => 'title|lecturer',
            //忽略数据库不存在的字段
            'ignore_keys' => ['start_time_range'],
            //扩展的查询条件
            'extend_conditions' => $extend_conditions
        ];

        return $search_setting;
    }

    /**
     * @param int $id
     * @return \app\common\layout\Content
     * @throws \think\exception\DbException
     * 新增/编辑预告
     */
    public function edit($id = 0)
    {
        $title = $id > 0 ? '编辑' : '新增';
        if (IS_POST) {
            $param = \input();
            if ($this->appriseModel->editData($param)) {
                $this->success($title . '成功', \url('index'));
            } else {
                $this->error($this->appriseModel->getError());
            }
        } else {
            $info = [];
            if ($id > 0) {
                $info = QliveAppriseList::get($id);
            }
            $content = (new BuilderForm())
                ->addFormItem('id', 'hidden', 'ID')
                ->addFormItem('title', 'text', '标题')
                ->addFormItem('image', 'picture', '封面')
                ->addFormItem('lecturer', 'select', '主讲人', '', $this->status4AnchorList)
                ->addFormItem('start_time', 'datetime', '直播时间')
                ->addFormItem('short_content', 'textarea', '直播简介')
                ->setFormData($info)
                ->addButton('submit')
                ->addButton('back')
                ->fetch();
            return (new Iframe())
                ->setMetaTitle($title . '直播预告')
                ->content($content);
        }
    }
}
