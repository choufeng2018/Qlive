<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/25
 * Time: 9:23
 * Dedicated to my wife and daughter
 */

namespace app\user\admin;


use app\admin\controller\Admin;
use app\common\builder\BuilderForm;
use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\user\model\UsersGroup;

/**
 * Class Group
 * @package app\user\admin
 * 用户角色组控制器
 */
class Group extends Admin
{
    /**
     * @var
     * 角色组模型
     */
    protected $userModel;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->userModel = new UsersGroup();
    }

    /**
     * @return \app\common\layout\Content
     * 角色组列表
     */
    public function index()
    {
        list($data_list, $total) = $this->userModel->search()->getListByPage();
        $content = (new BuilderList())
            ->addTopButton('addnew')
            ->addTopButton('delete', ['model' => 'UsersGroup'])
            ->addTopButton('resume', ['model' => 'UsersGroup'])
            ->addTopButton('forbid', ['model' => 'UsersGroup'])
            ->keyListItem('id', 'ID')
            ->keyListItem('title', '用户组名')
            ->keyListItem('description', '描述')
            ->keyListItem('status', '状态', 'status')
            ->keyListItem('right_button', '操作', 'btn')
            ->addRightButton('edit', '编辑')
            ->addRightButton('delete', '删除')
            ->setListData($data_list)
            ->setListPage($total)
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('用户组列表')
            ->content($content);
    }

    /**
     * @param int $id
     * @return \app\common\layout\Content
     * @throws \think\exception\DbException
     * 编辑/新增角色组
     */
    public function edit($id = 0)
    {
        $title = $id > 0 ? '编辑' : '新增';
        if (IS_POST) {
            $param = \input();
            if ($this->userModel->editData($param)) {
                $this->success($title . '成功', \url('index'));
            } else {
                $this->error($this->userModel->getError());
            }
        } else {
            $info = [
                'status' => 1
            ];
            if ($id > 0) {
                $info = UsersGroup::get($id);
            }
            $content = (new BuilderForm())
                ->addFormItem('id', 'hidden', 'ID')
                ->addFormItem('title', 'text', '用户组名称')
                ->addFormItem('description', 'textarea', '描述')
                ->addFormItem('status', 'radio', '状态', '', [1 => '启用', 0 => '禁用'])
                ->setFormData($info)
                ->addButton('submit')
                ->addButton('back')
                ->fetch();
            return (new Iframe())
                ->setMetaTitle($title . '用户分组')
                ->content($content);
        }
    }
}
