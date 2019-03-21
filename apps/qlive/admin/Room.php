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
            ->addTopButton('delete', ['model' => 'QliveRoomList'])
            ->keyListItem('id', '房间ID')
            ->keyListItem('anchor_id', '房间主播', 'array', $this->anchorAllList)
            ->keyListItem('status', '房间状态', 'status')
            ->setListData($data_list)
            ->setListPage($total)
            ->keyListItem('right_button', '操作', 'btn')
//            ->addRightButton('self', $detail)
            ->addRightButton('edit')
            ->addRightButton('delete', ['model' => 'QliveRoomList'])
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('房间列表')
            ->content($content);

    }

    /**
     * @param int $id
     * @return \app\common\layout\Content
     * @throws \think\exception\DbException
     * 编辑/新增房间
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
            //如果绑定了主播,修改主播列表中主播的状态以及添加主播列表中的房间id
            if ($data['anchor_id']) {
                Db::name('QliveAnchorList')
                    ->where('id', 'eq', $data['anchor_id'])
                    ->setField('status', 1);
            }
            if ($this->roomModel->editData($data)) {
                $this->success($title . '成功', \url('index'));
            } else {
                $this->error($this->roomModel->getError());
            }
        } else {
            $info = [
                'status' => 0
            ];
            if ($id > 0) {
                $info = QliveRoomList::get($id);
                if (empty($info)) {
                    $this->error($this->roomModel->getError());
                }
            }

            $return = (new BuilderForm())
                ->addFormItem('id', 'hidden', 'ID')
                ->addFormItem('stream', 'hidden', '推流码')
                ->addFormItem('anchor_id', 'select', '绑定主播', '请选择该房间主播', $this->anchorAllList)
                ->addFormItem('status', 'radio', '房间状态', '请选择房间状态', [1 => '启用', 0 => '禁用'])
                ->addFormItem('marks', 'textarea', '备注')
                ->setFormData($info)
                ->addButton('submit')
                ->addButton('back')
                ->fetch();
            return (new Iframe())
                ->setMetaTitle($title . '房间')
                ->content($return);
        }
    }

    public function test()
    {

    }
}
