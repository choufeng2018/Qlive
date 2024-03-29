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
        list($data_list, $total) = $this->anchorModel->search([
                'keyword_condition' => 'uid|username|nickname',
            ]
        )->getListByPage([], true, 'create_time desc');
        $content = (new BuilderList())
            ->addTopButton('addnew')
            ->keyListItem('id', 'ID')
            ->keyListItem('username', '用户名')
            ->keyListItem('nickname', '主播昵称')
            ->keyListItem('room_id', '房间号')
            ->keyListItem('status', '状态', 'array', ['2' => '待分配房间', 3 => '被禁播', 4 => '正常'])
            ->keyListItem('uid', '前台用户ID')
            ->setListData($data_list)
            ->setListPage($total)
            ->keyListItem('right_button', '操作', 'btn')
            ->addRightButton('edit')
//            ->addRightButton('delete', ['model' => 'QliveAnchorList'])
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('主播列表')
            ->search([
                ['name' => 'status', 'type' => 'select', 'title' => '直播状态', 'options' => [3 => '禁播', 4 => '正常']],
                ['name' => 'keyword', 'type' => 'text', 'extra_attr' => 'placeholder="请输入关键字"'],
            ])
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
            $nicknameCount = Db::name('QliveAnchorList')
                ->where('nickname', 'eq', $data['nickname'])
                ->count();
            if ($nicknameCount > 0 && $id == 0) {
                $this->error('昵称已被占用');
            }
            //检测用户名是否合法，只可以使用字母,数字,破折号
            if (!preg_match('/^[a-z0-9 .\-]+$/i', $data['username'])) {
                $this->error('用户名只允许:字母,数字,破折号');
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
                \logic('QliveLogic')->disableStream($stream);
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
                    'username' => $data['username'],
                    'usergroup' => 2,
                    'password' => \encrypt(\config('default_password')),
                ];
                $userModel = new User();
                $userModel->allowField(true)
                    ->isUpdate(false)
                    ->data($reg_data)
                    ->save();
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
                    ->setPageTips('<code>默认密码：123456</code>')
                    ->addFormItem('id', 'hidden', 'ID')
                    ->addFormItem('uid', 'hidden', 'UID')
                    ->addFormItem('username', 'text', '用户名', '登录用的用户名', '', 'readonly')
                    ->addFormItem('nickname', 'text', '主播昵称', '直播室显示的名称', '', 'readonly')
                    ->addFormItem('sex', 'radio', '性别', '', [1 => '男', 2 => '女', 0 => '保密'])
                    ->addFormItem('email', 'email', '邮箱', '请输入邮箱')
                    ->addFormItem('mobile', 'text', '手机号', '请输入手机号')
                    ->addFormItem('idcard_face', 'image', '身份证照片', '上传身份证人像侧')
                    ->addFormItem('idcard_emblem', 'image', '身份证照片', '上传身份证国徽侧')
                    ->addFormItem('room_id', 'text', '房间号', '请在房间管理选择该主播进行绑定', '', 'readonly')
                    ->addFormItem('status', 'radio', '主播状态', '<code>不允许在分配房间之前修改此项目！！！</code>', [3 => '禁播', 4 => '正常'])
                    ->addFormItem('marks', 'textarea', '备注')
                    ->setFormData($info)
                    ->addButton('submit')
                    ->addButton('back')
                    ->fetch();
            } else {
                $return = (new BuilderForm())
                    ->setPageTips('<code>默认密码：123456</code>')
                    ->addFormItem('id', 'hidden', 'ID')
                    ->addFormItem('username', 'text', '用户名', '登录用的用户名,一旦确定不可修改')
                    ->addFormItem('nickname', 'text', '主播昵称', '直播室显示的名称,一旦确定不可修改')
                    ->addFormItem('sex', 'radio', '性别', '', [1 => '男', 2 => '女', 0 => '保密'])
                    ->addFormItem('email', 'email', '邮箱', '请输入邮箱')
                    ->addFormItem('mobile', 'text', '手机号', '请输入手机号')
                    ->addFormItem('idcard_face', 'picture', '身份证照片', '上传身份证人像侧')
                    ->addFormItem('idcard_emblem', 'picture', '身份证照片', '上传身份证国徽侧')
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
}
