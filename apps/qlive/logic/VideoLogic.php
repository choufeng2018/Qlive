<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/22
 * Time: 15:03
 * Dedicated to my wife and daughter
 */

namespace app\Qlive\logic;


use app\common\logic\Base;
use think\Db;

/**
 * Class VideoLogic
 * @package app\Qlive\logic
 * 视频逻辑层
 */
class VideoLogic extends Base
{
    /**
     * @return string
     * 根据主播获取他的直播历史
     */
    public function getLiveListByAnchor()
    {
        return <<<EOF
        <script type="text/javascript">
        $(function() {
          var anchorId = $('#anchor_id').val();
          var liveId=$('#live_id').val();
          $.ajax({
  type:'GET',
  url:'http://live.natusmedical.cn/admin.php/qlive/video/get_live_history/anchor_id/'+anchorId,
  dataType:'json',
  success:function(data) {
      //填充表单
var build_dropdown = function( data, element, defaultText ){
	element.empty().append( '<option value="">' + defaultText + '</option>' );
	if( data ){
		$.each( data, function( key, value ){
			element.append( '<option value="' + key + '">' + value + '</option>' );
		} );
	}
	}
    build_dropdown(data,$('#live_id'),'请选择...');
$('#live_id').val(liveId);
  },
  });
        });
        
       
        </script>
<script type="text/javascript">
$('#anchor_id').change(function() {
  var anchorId = $('#anchor_id').val();
  $.ajax({
  type:'GET',
  url:'http://live.natusmedical.cn/admin.php/qlive/video/get_live_history/anchor_id/'+anchorId,
  dataType:'json',
  success:function(data) {
      //填充表单
var build_dropdown = function( data, element, defaultText ){
	element.empty().append( '<option value="">' + defaultText + '</option>' );
	if( data ){
		$.each( data, function( key, value ){
			element.append( '<option value="' + key + '">' + value + '</option>' );
		} );
	}
	}
    build_dropdown(data,$('#live_id'),'请选择...');
  },
  })
})
</script>
EOF;


    }

    /**
     * @param int $flag
     * @param int $limit
     * @param string $order
     * @return false|\PDOStatement|string|\think\Collection|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据条件获取视频列表
     */
    public function getVideoByCondition($flag = 1, $limit = 6, $order = 'hist desc')
    {
        $map = [
            'status' => 1,
            'flag' => $flag,
        ];
        $list = Db::name('QliveVideoList')
            ->where($map)
            ->limit($limit)
            ->order($order)
            ->select();
        if (!empty($list)) {
            return $list;
        } else {
            return null;
        }
    }
}
