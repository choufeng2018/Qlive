<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/28
 * Time: 10:31
 * Dedicated to my wife and daughter
 */

namespace app\qlive\admin;


use app\common\builder\BuilderForm;
use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\qlive\model\QliveUserCertification;
use think\Db;

/**
 * Class Certification
 * @package app\qlive\admin
 * 实名认证控制器
 */
class Certification extends QliveBase
{
    /**
     * @var
     */
    protected $certModel;

    /**
     *
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->certModel = new QliveUserCertification();
    }

    /**
     * @return \app\common\layout\Content
     * 列表页
     */
    public function index()
    {
        list($data_list, $total) = $this->certModel->search([
            'keyword_condition' => 'uid|real_name|id_number',
        ])->getListByPage([], true, 'create_time desc');
        $content = (new BuilderList())
            ->keyListItem('id', 'ID')
            ->keyListItem('uid', '用户ID')
            ->keyListItem('real_name', '真实姓名')
            ->keyListItem('id_number', '身份证号')
            ->keyListItem('status', '审核状态', 'array', [0 => '待处理', 1 => '已通过', 2 => '未通过'])
            ->keyListItem('right_button', '操作')
            ->addRightButton('edit')
            ->setListData($data_list)
            ->setListPage($total)
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('实名列表')
            ->search([
                ['name' => 'status', 'type' => 'select', 'title' => '按状态', 'options' => [0 => '待处理', 1 => '已通过', 2 => '未通过']],
                ['name' => 'keyword', 'type' => 'text', 'extra_attr' => 'placeholder="请输入查询关键字"'],
            ])
            ->content($content);
    }

    /**
     * @param $id
     * @return \app\common\layout\Content
     * @throws \think\exception\DbException
     */
    public function edit($id)
    {
        if (IS_POST) {
            $param = \input();
            if ($this->certModel->editData($param)) {
                $this->success('操作成功', \url('index'));
            } else {
                $this->error($this->certModel->getError());
            }
        }
        $info = Db::name('QliveUserCertification')->find(['id' => $id]);
        $content = (new BuilderForm())
            ->addFormItem('id', 'hidden', 'ID', '', '', 'readonly')
            ->addFormItem('uid', 'text', '用户ID', '', '', 'readonly')
            ->addFormItem('real_name', 'text', '真实姓名', '', '', 'readonly')
            ->addFormItem('id_number', 'text', '身份证号', '', '', 'readonly')
            ->addFormItem('idcard_face', 'picture', '人像侧')
            ->addFormItem('idcard_emblem', 'picture', '国徽侧')
            ->addFormItem('status', 'radio', '审核结果', '', [1 => '已通过', 2 => '未通过'])
            ->setFormData($info)
            ->addButton('submit')
            ->addButton('back')
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('审核实名认证')
            ->content($content);
    }
}
