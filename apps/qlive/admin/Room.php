<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2019/2/19
 * Time: 13:44
 */

namespace app\qlive\admin;


use app\admin\controller\Admin;
use app\common\builder\BuilderForm;
use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\qlive\model\QliveRoomList;
use think\Db;

/**
 * Class Room
 * @package app\qlive\admin
 * 房间控制器
 */
class Room extends Admin
{
    protected $roomModel;
    /**
     * @var
     * 未被禁播的主播列表
     */
    protected $anchorAllList;
    /**
     * @var
     * 主播(状态=2 申请中)列表
     */
    protected $anchorApplyList;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->roomModel = new QliveRoomList();
        $this->anchorApplyList = Db::name('QliveAnchorList')->where('status', 'eq', 2)->column('id,name');
        $this->anchorAllList = Db::name('QliveAnchorList')->where('status', 'neq', 0)->column('id,name');
    }

    /**
     * @return \app\common\layout\Content
     * 房间列表
     */
    public function index()
    {
        $detail = [
            'icon' => 'fa fa-eye',
            'title' => '查看',
            'class' => 'btn btn-success btn-xs',
            'href' => url('detail')
        ];
        list($data_list, $total) = $this->roomModel->search()->getListByPage([], true, 'create_time desc');
        $content = (new BuilderList())
            ->addTopButton('addnew')
            ->addTopBtn('resume', ['model' => 'QliveRoomList'])
            ->addTopButton('forbid', ['model' => 'QliveRoomList'])
//            ->addTopButton('delete', ['model' => 'QliveRoomList'])
            ->keyListItem('id', '房间ID')
            ->keyListItem('anchor_id', '房间主播')
            ->keyListItem('status', '房间状态', 'status')
            ->setListData($data_list)
            ->setListPage($total)
            ->keyListItem('right_button', '操作', 'btn')
//            ->addRightButton('self', $detail)
            ->addRightButton('edit')
//            ->addRightButton('delete', ['model' => 'QliveRoomList'])
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('房间列表')
            ->search([
                ['name' => 'status', 'type' => 'select', 'title' => '房间状态', 'options' => [0 => '禁用', 1 => '启用']],

            ])
            ->content($content);

    }

    /**
     * @param int $id
     * @return \app\common\layout\Content
     * @throws \think\exception\DbException
     * 编辑/新增房间
     *
     * 新增和没有主播的房间可以选择主播;
     * 已有主播的房间不允许修改主播
     */
    public function edit($id = 0)
    {
        $title = $id > 0 ? '编辑' : '新增';
        $data = \input();
        if (IS_POST) {
            //如果是新增,生成一个推流码,并且在七牛新建一个流
            if ($id == 0) {
                $data['stream'] = \create_stream_name();
                $createStreamRes = \logic('QliveLogic')->createStream($data['stream']);

            }

            if ($this->roomModel->editData($data)) {
                //新增房间的id号
                $room_id = $this->roomModel->id;
                //如果绑定了主播,修改主播列表中主播的状态以及添加主播列表中的房间id
                if ($data['anchor_id']) {
                    Db::name('QliveAnchorList')
                        ->where('id', 'eq', $data['anchor_id'])
                        ->setField(['status' => 4, 'room_id' => $room_id]);
                }

                $this->success($title . '成功', \url('index'));
            } else {
                $this->error($this->roomModel->getError());
            }
        } else {
            if ($id > 0) {
                $info = QliveRoomList::get($id);
                if (empty($info)) {
                    $this->error($this->roomModel->getError());
                }
                if (!empty($info['anchor_id'])) {
                    //一旦绑定主播就不可以更改,因为推流码无法收回只能禁用
                    $return = (new BuilderForm())
                        ->addFormItem('id', 'hidden', 'ID')
                        ->addFormItem('stream', 'hidden', '推流码')
                        ->addFormItem('anchor_id', 'text', '绑定主播', '该项不允许修改', '', 'readonly')
                        ->addFormItem('status', 'radio', '房间状态', '请选择房间状态', [1 => '启用', 0 => '禁用'])
                        ->addFormItem('marks', 'textarea', '备注')
                        ->setFormData($info)
                        ->addButton('submit')
                        ->addButton('back')
                        ->fetch();
                } else {

                    $return = (new BuilderForm())
                        ->addFormItem('id', 'hidden', 'ID')
                        ->addFormItem('stream', 'hidden', '推流码')
                        ->addFormItem('anchor_id', 'select', '绑定主播', '请选择该房间主播,一旦绑定不可修改!', $this->anchorApplyList, 'required')
                        ->addFormItem('status', 'radio', '房间状态', '请选择房间状态', [1 => '启用', 0 => '禁用'])
                        ->addFormItem('marks', 'textarea', '备注')
                        ->setFormData($info)
                        ->addButton('submit')
                        ->addButton('back')
                        ->fetch();
                }
                return (new Iframe())
                    ->setMetaTitle($title . '房间')
                    ->content($return);
            } else {
                $info = [
                    'status' => 0
                ];
                $return = (new BuilderForm())
                    ->addFormItem('id', 'hidden', 'ID')
                    ->addFormItem('stream', 'hidden', '推流码')
                    ->addFormItem('anchor_id', 'select', '绑定主播', '请选择该房间主播,一旦绑定不可修改!', $this->anchorApplyList, 'required')
                    ->addFormItem('status', 'radio', '房间状态', '请选择房间状态', [1 => '启用', 0 => '禁用'])
                    ->addFormItem('marks', 'textarea', '备注')
                    ->setFormData($info)
                    ->addButton('submit')
                    ->addButton('back')
                    ->fetch();
            }
            return (new Iframe())
                ->setMetaTitle($title . '房间')
                ->content($return);
        }
    }

    public function test()
    {

    }
}
