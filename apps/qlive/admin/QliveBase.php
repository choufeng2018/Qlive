<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/25
 * Time: 15:50
 * Dedicated to my wife and daughter
 */

namespace app\qlive\admin;


use app\admin\controller\Admin;
use think\Db;

/**
 * Class QliveBase
 * @package app\qlive\admin
 * 直播模块基础控制器
 */
class QliveBase extends Admin
{
    /**
     * @var
     * 所有的主播列表,任何状态都有
     */
    protected $allAnchorList;
    /**
     * @var
     * 申请中的主播列表
     */
    protected $status2AnchorList;
    /**
     * @var
     * 正常可直播的主播列表
     */
    protected $status4AnchorList;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->allAnchorList = Db::name('QliveAnchorList')
            ->column('id,name');

        $this->status2AnchorList = Db::name('QliveAnchorList')
            ->where('status', 'eq', 2)
            ->column('id,name');

        $this->status4AnchorList = Db::name('QliveAnchorList')
            ->where('status', 'eq', 4)
            ->column('id,name');

    }
}
