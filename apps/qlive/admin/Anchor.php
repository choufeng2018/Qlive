<?php

namespace app\qlive\admin;

use app\admin\controller\Admin;
use app\common\builder\BuilderForm;
use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\qlive\model\QliveAnchorList;

/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2019/2/19
 * Time: 11:18
 */
class Anchor extends Admin
{
    /**
     * @var
     * 主播模型
     */
    protected $anchorModel;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->anchorModel = new QliveAnchorList();
    }

    /**
     * @return \app\common\layout\Content
     * 主播列表
     */
    public function index()
    {
        list($data_list, $total) = $this->anchorModel->search()->getListByPage([], true, 'create_time desc');
        $content = (new BuilderList())
            ->addTopButton('addnew')
            ->addTopBtn('resume')
            ->addTopButton('forbid')
            ->addTopButton('delete')
            ->keyListItem('id', 'ID')
            ->keyListItem('name', '主播姓名')
            ->keyListItem('room_id', '房间号')
            ->keyListItem('status', '状态','status')
            ->setListData($data_list)
            ->setListPage($total)
            ->keyListItem('right_button', '操作', 'btn')
            ->addRightButton('edit')
            ->addRightButton('delete', ['model' => 'QliveAnchorList'])
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('主播列表')
            ->content($content);
    }

    /**
     * @param int $id
     * @return \app\common\layout\Content
     * @throws \think\exception\DbException
     * 编辑/新增主播
     */
    public function edit($id=0)
    {
        $title = $id > 0 ? '编辑' : '新增';
        if (IS_POST) {
            $data = \input();
            if ($this->anchorModel->editData($data)) {
                $this->success($title . '成功', \url('index'));
            } else {
                $this->error($this->anchorModel->getError());
            }
        } else {
            $info = ['status'=>1];
            if ($id > 0) {
                $info = QliveAnchorList::get($id);
                if (empty($info)) {
                    $this->error($this->listModel->getError());
                }
            }

            $return =(new BuilderForm())
                ->addFormItem('id', 'hidden', 'ID')
                ->addFormItem('name', 'text', '主播姓名')
                ->addFormItem('room_id', 'text', '房间号')
                ->addFormItem('status', 'radio', '主播状态','请选择主播状态',[1=>'启用',0=>'禁用'])
                ->addFormItem('marks', 'textarea', '备注')
                ->setFormData($info)
                ->addButton('submit')
                ->addButton('back')
                ->fetch();
            return (new Iframe())
                ->setMetaTitle($title . '主播')
                ->content($return);
        }
    }
}
