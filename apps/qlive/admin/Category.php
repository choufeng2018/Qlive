<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/19
 * Time: 15:00
 * Dedicated to my wife and daughter
 */

namespace app\qlive\admin;


use app\common\builder\BuilderForm;
use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\qlive\model\QliveCategoryList;

/**
 * Class Category
 * @package app\qlive\admin
 * 直播分类
 */
class Category extends QliveBase
{
    /**
     * @var
     * 分类列表
     */
    protected $cateModel;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->cateModel = new QliveCategoryList();
    }

    /**
     * @return \app\common\layout\Content
     * 列表
     */
    public function index()
    {
        list($data_list, $total) = $this->cateModel->search()->getListByPage([], true, 'id,create_time desc');
        $content = (new BuilderList())
            ->addTopButton('addnew')
            ->addTopBtn('resume', ['model' => 'QliveCategoryList'])
            ->addTopButton('forbid', ['model' => 'QliveCategoryList'])
            ->addTopButton('delete', ['model' => 'QliveCategoryList'])
            ->keyListItem('id', 'ID')
            ->keyListItem('name', '分类名称')
            ->keyListItem('pid', '上级分类', 'array', $this->allCategory)
            ->keyListItem('order', '排序')
            ->keyListItem('status', '状态', 'status')
            ->setListData($data_list)
            ->setListPage($total)
            ->keyListItem('right_button', '操作', 'btn')
            ->addRightButton('edit')
            ->addRightButton('delete', ['model' => 'QliveCategoryList'])
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('分类列表')
            ->content($content);
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
            $data = \input();
            if ($this->cateModel->editData($data)) {
                $this->success($title . '成功', \url('index'));
            } else {
                $this->error($this->cateModel->getError());
            }
        } else {
            $info = [
                'pid' => 0,
                'order' => 50,
                'status' => 1,
            ];
            if ($id > 0) {
                $info = QliveCategoryList::get($id);
                if (empty($info)) {
                    $this->error($this->cateModel->getError());
                }
            }
            $content = (new BuilderForm())
                ->addFormItem('id', 'hidden', 'ID')
                ->addFormItem('pid', 'multilayer_select', '上级菜单', '上级菜单', $this->categoryList)
                ->addFormItem('name', 'text', '分类名称')
                ->addFormItem('order', 'number', '排序')
                ->addFormItem('status', 'radio', '状态', '', [1 => '启用', 0 => '禁用'])
                ->setFormData($info)
                ->addButton('submit')
                ->addButton('back')
                ->fetch();
            return (new Iframe())
                ->setMetaTitle($title . '分类')
                ->content($content);
        }
    }
}
