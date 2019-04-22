<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/30
 * Time: 16:03
 * Dedicated to my wife and daughter
 */

namespace app\qlive\controller;


use think\Db;
use think\queue\Job;

class Work
{
    public function fire(Job $job, $data)
    {
        $isJobDone = $this->send($data);
        if ($isJobDone) {
            $job->delete();
        } else {
            if ($job->attempts() > 3) {
                // 第1种处理方式：重新发布任务,该任务延迟10秒后再执行
                $job->release(10);
                // 第2种处理方式：原任务的基础上1分钟执行一次并增加尝试次数
                //$job->failed();
                // 第3种处理方式：删除任务
//                $job->delete();
            }
        }
    }

    private function send($data)
    {
        for ($i = 1; $i < 1000000; $i++) {
            Db::name('QueueTest')->insert(['name' => $data . $i]);
        }
        return true;
    }
}
