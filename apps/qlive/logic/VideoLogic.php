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
$('#anchor_id').change(function() {
  var anchorId = $('#anchor_id').val();
  // alert(anchorId);
  $.ajax({
  type:'GET',
  url:'http://live.qiniuniu.com/admin.php/qlive/video/get_live_history/anchor_id/'+anchorId,
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
}
