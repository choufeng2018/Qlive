<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/26
 * Time: 9:02
 * Dedicated to my wife and daughter
 */

namespace app\qlive\admin;


use app\admin\controller\Admin;
use app\common\builder\BuilderForm;
use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\qlive\model\QlivePostList;

/**
 * Class Posts
 * @package app\qlive\admin
 * 文章控制器
 */
class Posts extends Admin
{
    /**
     * @var
     * 文章模型
     */
    protected $postModel;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->postModel = new QlivePostList();
    }

    /**
     * @return \app\common\layout\Content
     * 文章列表
     */
    public function index()
    {
        list($data_list, $total) = $this->postModel->search()->getListByPage([], true, 'id');
        $content = (new BuilderList())
            ->addTopButton('addnew')
            ->addTopButton('resume', ['model' => 'QlivePostList'])
            ->addTopButton('forbid', ['model' => 'QlivePostList'])
            ->addTopButton('delete', ['model' => 'QlivePostList'])
            ->keyListItem('id', 'ID')
            ->keyListItem('thumbnail', '缩略图', 'picture')
            ->keyListItem('title', '标题')
            ->keyListItem('category', '分类', 'array', \config('post_category'))
            ->keyListItem('hits', '浏览量')
            ->keyListItem('publisher', '作者')
            ->keyListItem('is_top', '置顶', 'status')
            ->keyListItem('status', '状态', 'status')
            ->keyListItem('order', '排序')
            ->keyListItem('create_time', '发布时间')
            ->keyListItem('right_button', '操作')
            ->addRightButton('edit')
            ->addRightButton('delete', ['model' => 'QlivePostList'])
            ->setListData($data_list)
            ->setListPage($total)
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('文章列表')
            ->content($content);
    }

    /**
     * @param int $id
     * @return \app\common\layout\Content
     * @throws \think\exception\DbException
     * 编辑/新增文章
     */
    public function edit($id = 0)
    {
        $title = $id > 0 ? '编辑' : '新增';
        if (IS_POST) {
            $param = \input();
            $param['publisher'] = \session('admin_login_auth.username');
            if ($this->postModel->editData($param)) {
                $this->success($title . '成功', \url('index'));
            } else {
                $this->error($title . '失败', \url('index'));
            }
        } else {
            $info = [
                'status' => 1,
                'order' => 99,
                'is_top' => 0
            ];
            if ($id > 0) {
                $info = QlivePostList::get($id);
            }
            $content = (new BuilderForm())
                ->addFormItem('id', 'hidden', 'ID')
                ->addFormItem('title', 'text', '标题')
                ->addFormItem('category', 'select', '分类', '', \config('post_category'))
                ->addFormItem('thumbnail', 'picture', '缩略图')
                ->addFormItem('short_content', 'textarea', '文章简介')
                ->addFormItem('content', 'wangeditor', '正文')
                ->addFormItem('is_top', 'radio', '置顶', '', [1 => '是', 0 => '否'])
                ->addFormItem('status', 'radio', '状态', '', [1 => '显示', 0 => '隐藏'])
                ->addFormItem('order', 'number', '排序')
                ->setFormData($info)
                ->addButton('submit')
                ->addButton('back')
                ->fetch();
            return (new Iframe())
                ->setMetaTitle($title . '文章')
                ->content($content);
        }
    }
}
