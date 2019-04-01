<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/1
 * Time: 15:47
 * Dedicated to my wife and daughter
 */

namespace app\qlive\api\v1;


use app\rest\controller\RestBase;

class Index extends RestBase
{
    public function index()
    {
        $this->success("Hello API");
    }
}
