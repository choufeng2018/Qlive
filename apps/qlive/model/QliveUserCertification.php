<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/15
 * Time: 16:51
 * Dedicated to my wife and daughter
 */

namespace app\qlive\model;


use app\common\model\Base;

/**
 * Class QliveUserCertification
 * @package app\qlive\model
 */
class QliveUserCertification extends Base
{
    /**
     * @param $path
     * @return string
     * 返回身份证完整路径
     */
    public function getIdcardFaceAttr($path)
    {
        $real_path = \get_file_complete_path($path);
        return $real_path;
    }

    /**
     * @param $path
     * @return string
     * 返回身份证完整路径
     */
    public function getIdcardEmblemAttr($path)
    {
        $real_path = \get_file_complete_path($path);
        return $real_path;
    }
}
