<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/3/26
 * Time: 11:36
 * Dedicated to my wife and daughter
 */

namespace app\qlive\admin;


use app\common\builder\BuilderForm;
use app\common\builder\BuilderList;
use app\common\layout\Iframe;
use app\qlive\model\QliveVideoList;
use think\Db;

/**
 * Class Video
 * @package app\qlive\admin
 * 视频列表控制器
 */
class Video extends QliveBase
{
    /**
     * @var
     * 视频模型
     */
    protected $videoModel;

    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->videoModel = new QliveVideoList();

    }

    /**
     * @return \app\common\layout\Content
     * 视频列表
     */
    public function index()
    {
        $search_setting = $this->buildModelSearchSetting();
        list($data_list, $total) = $this->videoModel->search($search_setting)->getListByPage([], true, 'id');
        $content = (new BuilderList())
            ->addTopButton('addnew')
            ->addTopButton('resume', ['model' => 'QliveVidoeList', 'title' => '显示'])
            ->addTopButton('forbid', ['model' => 'QliveVidoeList', 'title' => '隐藏'])
            ->addTopButton('delete', ['model' => 'QliveVidoeList'])
            ->keyListItem('id', 'ID')
            ->keyListItem('title', '标题')
            ->keyListItem('anchor', '所属主播')
            ->keyListItem('live_id', '对应直播', 'callback', 'getLiveTitleById')
            ->keyListItem('live_time', '直播时间')
            ->keyListItem('url', '视频地址', 'url', '', 'target="_blank"')
            ->keyListItem('status', '状态', 'status')
            ->keyListItem('order', '排序')
            ->keyListItem('marks', '备注')
            ->keyListItem('right_button', '操作')
            ->setListData($data_list)
            ->setListPage($total)
            ->addRightButton('edit')
            ->addRightButton('delete')
            ->fetch();
        return (new Iframe())
            ->setMetaTitle('视频列表')
            ->search([
                ['name' => 'live_time_range', 'type' => 'daterange', 'extra_attr' => 'placeholder="直播时间"'],
                ['name' => 'status', 'type' => 'select', 'title' => '状态', 'options' => [1 => '正常', 0 => '隐藏']],
                ['name' => 'keyword', 'type' => 'text', 'extra_attr' => 'placeholder="请输入查询关键字"'],
            ])
            ->content($content);
    }

    /**
     * @return array
     * 自定义搜索
     */
    private function buildModelSearchSetting()
    {
        $timegap = \input('live_time_range');
        $extend_condition = [];
        if ($timegap) {
            $gap = explode('—', $timegap);
            $live_begin = $gap[0];
            $live_end = $gap[1];

            $extend_condition = [
                'live_time' => ['between', [$live_begin . '00:00:00', $live_end . '23:59:59']]
            ];
        }

        $search_setting = [
            'keyword_condition' => 'title|anchor',
            'ignore_keys' => ['live_time_range'],
            'extend_condition' => $extend_condition,
        ];
        return $search_setting;
    }


    /**
     * @param int $id
     * @return \app\common\layout\Content
     * @throws \think\exception\DbException
     * 新增/编辑视频
     */
    public function edit($id = 0)
    {
        $title = $id > 0 ? '编辑' : '新增';

        $live_all_list = Db::name('QliveLiveHistory')
            ->column('id,title');
        $live_all_list[0] = '请在上方选择主播';

        $moreJs = \logic('VideoLogic')->getLiveListByAnchor();
        if (IS_POST) {
            $param = \input();
            $param['anchor'] = getAnchorNameById($param['anchor_id']);
            $live_info = \getHistoryLiveInfo($param['live_id']);
            //将对应直播的相关数据同步给视频
            $param['live_time'] = $live_info['open_time'];
            $param['category'] = $live_info['category'];
            $param['type'] = $live_info['live_type'];
            $param['price'] = $live_info['price'];
            $param['hits'] = $live_info['hits'];
            $param['sales'] = $live_info['sales'];
            if ($this->videoModel->editData($param)) {
                $this->success($title . '成功', \url('index'));
            } else {
                $this->error($title . '失败', \url('index'));
            }
        }
        $info = [
            'status' => 1,
            'order' => 50,
        ];
        if ($id > 0) {
            $info = QliveVideoList::get($id);
            $info['anchor_id'] = getAnchorIdByName($info['anchor']);
        }
        $content = (new BuilderForm())
            ->addFormItem('id', 'hidden', 'ID')
            ->addFormItem('title', 'text', '视频标题', '请输入视频标题')
            ->addFormItem('anchor_id', 'select', '所属主播', '选择该视频的所有者', $this->allAnchorList)
            ->addFormItem('live_id', 'select', '对应直播', '只显示最近30天内的记录', $live_all_list)
            ->addFormItem('url', 'file', '上传视频')
            ->addFormItem('status', 'radio', '视频状态', '是否在前台显示', [1 => '正常', 0 => '隐藏'])
            ->addFormItem('order', 'text', '排序')
            ->addFormItem('marks', 'textarea', '备注')
            ->setExtraHtml($moreJs)
            ->setFormData($info)
            ->addButton('submit')
            ->addButton('back')
            ->fetch();
        return (new Iframe())
            ->setMetaTitle($title . '视频')
            ->content($content);
    }

    /**
     * @return \think\response\Json
     * 返回根据主播ID查找到的直播记录
     * 这里用于添加视频时的对应直播
     */
    public function get_live_history()
    {
        $anchor_id = \input('anchor_id');
        $anchor_name = \getAnchorNameById($anchor_id);
        $list = Db::name('QliveLiveHistory')
            ->where('anchor', 'eq', $anchor_name)
            ->whereTime('open_time', '-30 days')
            ->column('id,title');
        return \json($list);
    }
}
