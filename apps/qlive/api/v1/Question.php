<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/4
 * Time: 11:35
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;

/**
 * Class Question
 * @package app\qlive\api\v1
 * 提问列表
 */
class Question extends RestBase
{
    /**
     *问题列表
     */
    public function questionList()
    {
        $id = \input('id');
        $page = \input('page');
        //问题列表
        $question_list = \logic('QuestionLogic')->getQuestionListByLiveId($id, $page);
        $this->success('OK', $question_list);
    }

    /**
     *发布问题
     */
    public function questionAdd()
    {
        if ($this->request->isPost()) {
            $header = $this->request->header();
            if (empty($header['token'])) {
                $this->error('身份验证失败,请重新登录');
            } else {
                $userInfo = \getUserInfoByToken($header['token']);
                $param = [
                    'live_id' => \input('live_id'),
                    'anchor' => \getAnchorNameByLiveId(\input('live_id')),
                    'username' => $userInfo['username'],
                    'question' => \input('question'),
                    'status' => 0
                ];
                $res = \logic('QuestionLogic')->addQuestion($param);
                if ($res) {
                    $this->success('提问成功');
                } else {
                    $this->error('提问失败');
                }
            }
        } else {
            $this->error('提交方式不正确');
        }
    }
}
