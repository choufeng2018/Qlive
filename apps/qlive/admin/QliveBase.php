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
use eacoo\Tree;
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
     * @var
     * 树状分类
     */
    protected $categoryList;
    /**
     * @var
     * 所有直播分类
     */
    protected $allCategory;
    /**
     * @var直播类型
     */
    protected $liveType;
    /**
     * @var
     * 直播标记
     */
    protected $appriseFlag;

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

        $categoryList = \model('QliveCategoryList')->getList(['status' => 1], true, 'id asc,order asc');
        $categoryList = \collection($categoryList)->toArray();
        $tree_obj = new Tree();
        $categoryList = $tree_obj->toFormatTree($categoryList, 'name');
        if ($categoryList) {
            $this->categoryList = \array_merge([0 => ['id' => 0, 'title_show' => '顶级分类']], $categoryList);
        }

        $this->allCategory = Db::name('QliveCategoryList')->column('id,name');
        $this->allCategory = \array_merge([0 => '顶级分类'], $this->allCategory);
        $this->appriseFlag = \config('apprise_flag');
        $this->liveType = \config('live_type');
    }
}
