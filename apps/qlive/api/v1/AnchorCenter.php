<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/8
 * Time: 15:57
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use think\Db;

/**
 * Class AnchorCenter
 * @package app\qlive\api\v1
 * 主播独有的操作控制器
 */
class AnchorCenter extends Center
{
    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 检查是否是主播
     */
    public function checkAnchor()
    {
        //检查这个用户是不是主播
        if ($this->userType != 2) {
            $this->error('非法操作');
        }
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 添加问题的回答
     */
    public function answerAdd()
    {
        if ($this->request->isPost()) {
            $anchor_info = $this->user;
            $id = \input('question_id');
            $quesdtion_info = Db::name('QliveQuestionList')
                ->where('id', 'eq', $id)
                ->find();
            //检查该条问题的直播记录中的主播是不是正要处理这条问题的主播
            if ($anchor_info['username'] == $quesdtion_info['anchor']) {
                $data = [
                    'id' => $id,
                    'answer' => \input('content'),
                ];
                $res = \logic('QuestionLogic')->editQuestion($data);
                if ($res) {
                    $this->success('回答问题成功');
                } else {
                    $this->error('回答问题失败');
                }
            } else {
                $this->error('身份验证失败');
            }
        }
    }
}
