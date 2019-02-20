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
use Qiniu\Pili\Client;
use Qiniu\Pili\Mac;
use think\Db;
use think\Exception;

/**
 * Class Room
 * @package app\qlive\admin
 * 房间控制器
 */
class Room extends Admin
{
    /**
     * @var
     * 主播列表
     */
    protected $anchorList;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->anchorList = Db::name('QliveAnchorList')->where('status', 'eq', 1)->column('id,name');
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
            'class' => 'btn btn-success btn-sm',
            'href' => url('detail')
        ];
        list($data_list, $total) = (new QliveRoomList())->search()->getListByPage([], true, 'create_time desc');
        $content = (new BuilderList())
            ->addTopButton('addnew')
            ->addTopBtn('resume')
            ->addTopButton('forbid')
            ->addTopButton('delete')
            ->keyListItem('id', 'ID')
            ->keyListItem('stream', '推流码')
            ->keyListItem('anchor_id', '房间主播', 'array', $this->anchorList)
            ->keyListItem('room_status', '房间状态')
            ->setListData($data_list)
            ->setListPage($total)
            ->keyListItem('right_button', '操作', 'btn')
            ->addRightButton('self', $detail)
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
            if ((new QliveRoomList())->editData($data)) {
                $this->success($title . '成功', \url('index'));
            } else {
                $this->error((new QliveRoomList())->getError());
            }
        } else {
            $info = ['room_status' => 0];
            if ($id > 0) {
                $info = QliveRoomList::get($id);
                if (empty($info)) {
                    $this->error((new QliveRoomList())->getError());
                }
            }

            $return = (new BuilderForm())
                ->addFormItem('id', 'hidden', 'ID')
                ->addFormItem('stream', 'text', '推流码', '自动生成请勿手写', '', 'readonly')
                ->addFormItem('anchor_id', 'select', '绑定主播', '请选择该房间主播', $this->anchorList)
                ->addFormItem('room_status', 'radio', '房间状态', '请选择房间状态', [1 => '直播中', 0 => '停播中'])
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
