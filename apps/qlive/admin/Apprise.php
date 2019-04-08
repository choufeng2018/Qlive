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
use app\qlive\model\QliveLiveHistory;

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
            ->keyListItem('category', '直播分类', 'array', $this->allCategory)
            ->keyListItem('live_type', '直播类型', 'array', $this->liveType)
            ->keyListItem('flag', '标记', 'array', $this->appriseFlag)
            ->keyListItem('status', '状态', 'status')
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
                $apprise_id = $this->appriseModel->id;
                //直播预告的数据还需插入到开播申请中(并设置状态为已通过)
                $log_data = [
                    'anchor' => \getAnchorNameById($param['lecturer']),
                    'room_id' => \getRoomIdByAnchorId($param['lecturer']),
                    'title' => $param['title'],
                    'logo' => $param['image'],
                    'category' => $param['category'],
                    'live_type' => $param['live_type'],
                    'open_time' => $param['start_time'],
                    'status' => 1,
                    'apprise_id' => $apprise_id,
                ];

                $historyModel = new QliveLiveHistory();
                //查找开播历时表中是否有对应记录,有则更新无则新增
                $log_info = $historyModel
                    ->where('apprise_id', 'eq', $apprise_id)
                    ->find();
                if (empty($log_info)) {
                    $historyModel->editData($log_data);
                } else {
                    $historyModel
                        ->isUpdate(true)
                        ->save($log_data, ['apprise_id' => $apprise_id]);
                }

                $this->success($title . '成功', \url('index'));
            } else {
                $this->error($this->appriseModel->getError());
            }
        } else {
            $info = [
                'status' => 1,
            ];
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
                ->addFormItem('category', 'multilayer_select', '直播分类', '', $this->categoryList)
                ->addFormItem('live_type', 'select', '直播类型', '', $this->liveType)
                ->addFormItem('status', 'radio', '状态', '', [0 => '禁用', 1 => '启用'])
                ->addFormItem('flag', 'select', '标记', '', $this->appriseFlag)
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
