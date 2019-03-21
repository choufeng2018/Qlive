<?php

namespace app\qlive\admin;

use app\admin\controller\Admin;
use app\common\builder\BuilderForm;
use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\common\model\User;
use app\qlive\model\QliveAnchorList;
use think\Db;

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
            ->keyListItem('id', 'ID')
            ->keyListItem('nickname', '昵称')
            ->keyListItem('name', '真实姓名')
            ->keyListItem('room_id', '房间号')
            ->keyListItem('status', '直播状态', 'array', ['2' => '待分配房间', 3 => '被禁播', 4 => '正常'])
            ->keyListItem('uid', '前台用户ID')
            ->setListData($data_list)
            ->setListPage($total)
            ->keyListItem('right_button', '操作', 'btn')
            ->addRightButton('edit')
//            ->addRightButton('delete', ['model' => 'QliveAnchorList'])
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('主播列表')
            ->content($content);
    }


    /**
     * @param int $id
     * @return \app\common\layout\Content
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * 编辑/新增主播
     */
    public function edit($id = 0)
    {
        $title = $id > 0 ? '编辑' : '新增';
        if (IS_POST) {
            $data = \input();
            //新增主播时检查昵称是否唯一
            $nicknameCount = Db::name('QliveAnchorList')->where('nickname', 'eq', $data['nickname'])->count();
            if ($nicknameCount > 0 && $id == 0) {
                $this->error('昵称已被占用');
            }
            //如果选择禁播该主播,需要修改房间状态=0,禁用该主播的直播流
            //禁播主播的前提是该主播已绑定房间
            if ($id > 0 && $data['room_id'] && $data['status'] == 3) {
                //修改主播状态
                Db::name('QliveAnchorList')
                    ->where('id', 'eq', $id)
                    ->setField('status', '3');
                //禁用房间
                Db::name('QliveRoomList')
                    ->where('anchor_id', 'eq', $id)
                    ->setField('status', 0);
                //禁用房间的推流码
                $stream = \getStreamByAnchorId($id);
                \logic('QliveLogic')->disableStream($stream, \strtotime('2099-12-31'));
            } elseif ($id > 0 && $data['room_id'] && $data['status'] == 4) {
                //修改主播状态
                Db::name('QliveAnchorList')
                    ->where('id', 'eq', $id)
                    ->setField('status', 4);
                //启用房间
                Db::name('QliveRoomList')
                    ->where('anchor_id', 'eq', $id)
                    ->setField('status', 1);
                //启用房间的推流码
                $stream = \getStreamByAnchorId($id);
                \logic('QliveLogic')->enableStream($stream);
            }

            if (empty($data['uid'])) {
                //插入主播列表还需将数据插入普通用户列表
                $reg_data = [
                    'sex' => $data['sex'],
                    'email' => $data['email'],
                    'mobile' => $data['mobile'],
                    'actived' => 1,
                    'nickname' => $data['nickname'],
                    'username' => $data['name'],
                    'password' => \encrypt(88888888),
                ];
                $userModel = new User();
                $userModel->allowField(true)->isUpdate(false)->data($reg_data)->save();
                $uid = $userModel->uid;
                $data['uid'] = $uid;
            }


            if ($this->anchorModel->editData($data)) {
                $this->success($title . '成功', \url('index'));
            } else {
                $this->error($this->anchorModel->getError());
            }
        } else {
            $info = [
                'status' => 2,
                'sex' => 1
            ];
            if ($id > 0) {
                $info = QliveAnchorList::get($id);
                if (empty($info)) {
                    $this->error($this->listModel->getError());
                }
                $return = (new BuilderForm())
                    ->addFormItem('id', 'hidden', 'ID')
                    ->addFormItem('nickname', 'text', '昵称', '直播间显示的名称')
                    ->addFormItem('name', 'text', '主播姓名', '请填写真实姓名')
                    ->addFormItem('sex', 'radio', '性别', '', [1 => '男', 2 => '女', 0 => '保密'])
                    ->addFormItem('email', 'email', '邮箱', '请输入邮箱')
                    ->addFormItem('mobile', 'text', '手机号', '请输入手机号')
                    ->addFormItem('id_card', 'pictures', '身份证照片', '上传身份证正反面')
                    ->addFormItem('room_id', 'text', '房间号', '请在房间管理选择该主播进行绑定', '', 'readonly')
                    ->addFormItem('status', 'radio', '主播状态', '请选择主播状态', [3 => '禁播', 4 => '正常'])
                    ->addFormItem('marks', 'textarea', '备注')
                    ->setFormData($info)
                    ->addButton('submit')
                    ->addButton('back')
                    ->fetch();
            } else {
                $return = (new BuilderForm())
                    ->addFormItem('id', 'hidden', 'ID')
                    ->addFormItem('nickname', 'text', '昵称', '直播间显示的名称')
                    ->addFormItem('name', 'text', '主播姓名', '请填写真实姓名')
                    ->addFormItem('sex', 'radio', '性别', '', [1 => '男', 2 => '女', 0 => '保密'])
                    ->addFormItem('email', 'email', '邮箱', '请输入邮箱')
                    ->addFormItem('mobile', 'text', '手机号', '请输入手机号')
                    ->addFormItem('id_card', 'pictures', '身份证照片', '上传身份证正反面')
                    ->addFormItem('marks', 'textarea', '备注')
                    ->setFormData($info)
                    ->addButton('submit')
                    ->addButton('back')
                    ->fetch();
            }


            return (new Iframe())
                ->setMetaTitle($title . '主播')
                ->content($return);
        }
    }

    public function test()
    {

    }
}
