<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/4
 * Time: 11:15
 * Dedicated to my wife and daughter
 */

namespace app\Qlive\logic;


use app\common\logic\Base as BaseLogic;
use app\qlive\model\QliveQuestionList;
use think\Db;

/**
 * Class QuestionLogic
 * @package app\Qlive\logic
 * 问题列表逻辑层
 */
class QuestionLogic extends BaseLogic
{

    /**
     * @param $live_id
     * @param int $page
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 问题列表
     */
    public function getQuestionListByLiveId($live_id, $page = 1)
    {
        $map = [
            'answer' => ['neq', ''],
            'live_id' => $live_id
        ];
        $question_list = Db::name('QliveQuestionList')
            ->where($map)
            ->page($page, 10)
            ->field('status,update_time', true)
            ->select();
        return $question_list;
    }

    /**
     * @param array $param
     * @return bool
     * 添加问题
     */
    public function addQuestion(array $param)
    {
        $questionModel = new QliveQuestionList();
        $res = $questionModel->editData($param);
        if ($res) {
            return true;
        } else {
        }
        return false;
    }

    /**
     * @param array $data
     * @return bool
     * 回答问题
     */
    public function editQuestion(array $data)
    {
        $field = [
            'answer' => $data['answer'],
            'status' => 1,
        ];
        $res = Db::name('QliveQuestionList')
            ->where('id', 'eq', $data['id'])
            ->setField($field);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
}
