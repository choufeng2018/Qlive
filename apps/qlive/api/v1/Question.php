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
}
