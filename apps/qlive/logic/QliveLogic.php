<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2019/2/20
 * Time: 14:58
 */

namespace app\Qlive\logic;

use app\common\logic\Base as BaseLogic;
use Qiniu\Pili\Client;
use Qiniu\Pili\Mac;
use think\Db;

/**
 * Class QliveLogic
 * @package app\Qlive\logic
 * 直播逻辑层
 */
class QliveLogic extends BaseLogic
{
    /**
     * @var mixed
     * 直播模块配置数据
     * array(5) {
     * ["status"] => string(1) "1"
     * ["AccessKey"] => string(40) "wkkOpP-qcNGq3Wj9Cs7bTdEAh_r0IOMyEyxpPb4V"
     * ["SecretKey"] => string(40) "qq9cWnsl5Pfd5xAAuISzwbQbdPwBb2keVjDYJ2zY"
     * ["HubName"] => string(16) "qiniuniulive2019"
     * ["LiveDomain"] => string(30) "pili-publish.live.qiniuniu.com"
     * }
     */
    protected $liveConfig;
    /**
     * @var \Qiniu\Pili\Hub
     * 直播空间名
     * 反正都要去七牛里去设置的,所以直接在控制台里手动创建空间
     */
    protected $hub;

    /**
     * QliveLogic constructor.
     * @param array $data
     * 构造方法
     */
    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->liveConfig = \json_decode(Db::name('Modules')
            ->where('name', 'eq', 'qlive')
            ->value('config'), true);
        $mac = new Mac($this->liveConfig['AccessKey'], $this->liveConfig['SecretKey']);
        $client = new Client($mac);
        $this->hub = $client->hub($this->liveConfig['HubName']);
    }

    /**
     * @return mixed
     * 获取模块配置
     */
    public function getLiveConfig()
    {
        $config = $this->liveConfig;
        return $config;
    }

    /**
     * @param $streamKey 流名称;
     * 流名称在直播空间中唯一，可包含 字母、数字、中划线、下划线；1 ~ 200 个字符长。
     * @return \Exception|\Qiniu\Pili\Stream
     * 创建stream
     */
    public function createStream($streamKey)
    {
        try {
            $res = $this->hub->create($streamKey);
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $res;
    }

    /**
     * @param $streamKey 流名称
     * @return array|string
     * 获取流信息
     */
    public function getStreamInfo($streamKey)
    {
        try {
            $res = $this->hub->stream($streamKey)->info();
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $res;
    }

    /**
     * @return array|\Exception|mixed|string
     * 列出当前直播空间的所有流
     */
    public function listAllStreams()
    {
        try {
            $res = $this->hub->listStreams('', '', '');

        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $res;
    }

    /**
     * @return array|\Exception|mixed|string
     * 列出当前空间正在直播的流
     */
    public function listLiveStream()
    {
        try {
            $res = $this->hub->listLiveStreams('', '', '');
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $res;

    }

    /**
     * @param $streamKey
     * @return string
     * 获取流的直播状态
     */
    public function getLiveStatus($streamKey)
    {
        try {
            $status = $stream = $this->hub->stream($streamKey)->liveStatus();

        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $status;
    }

    /**
     * @param $streamKey    流名称
     * @param $disableTime  禁用时间(Unix 时间戳, 在这之前流均不可用.)
     * @return string
     * 在一定时间内禁用某个流
     */
    public function disableStream($streamKey, $disableTime)
    {
        try {
            $stream = $this->hub->stream($streamKey)->disable(\time() + $disableTime);
            $status = $stream->liveStatus();

        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $status;
    }

    /**
     * @param $streamKey
     * @return string
     * 启用流
     */
    public function enableStream($streamKey)
    {
        try {
            $stream = $this->hub->stream($streamKey)->enable();
            $status = $stream->liveStatus();
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $status;
    }

    /**
     * @param $streamKey
     * @return string
     * 保存直播数据
     */
    public function saveStream($streamKey)
    {
        try {
            $fname = $this->hub->stream($streamKey)->save(0, 0);
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $fname;
    }

    /**
     * @param $streamKey
     * @param array $options =[
     *                      'format'=>'mp4',
     *                       'fname'=>'保存文件名',
     *                          ........
     *                          ]
     * @return string
     * 花式保存直播数据
     */
    public function saveFormatStream($streamKey, $options = [])
    {
        try {
            $res = $this->hub->stream($streamKey)->saveas($options);
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $res;
    }

    /**
     * @param $streamKey
     * @return string
     * 查询推流历史记录
     */
    public function getStreamHistoryRecord($streamKey)
    {
        try {
            $res = $this->hub->stream($streamKey)->historyActivity();
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $res;
    }

    /**
     * @param $streamKey
     * @param array $options
     * @return string
     * 保存直播截图(默认jpg格式)
     */
    public function saveSnapshot($streamKey, $options = ['format' => 'jpg'])
    {
        try {
            $res = $this->hub->stream($streamKey)->snapshot($options);
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $res;
    }

    /**
     * @param $streamKey
     * @param array $profiles
     * @return string
     * 更改流的实时转码规格
     */
    public function updateConverts($streamKey, $profiles = ['480p', '720p'])
    {
        try {
            $res = $this->hub->stream($streamKey)->updateConverts($profiles);
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $res;
    }

    /**
     * @param $streamKey
     * @param $expireAfterSeconds   表示 URL 在多久之后失效(如果不过期,在七牛控制台关闭直播鉴权)
     * @return string
     * 获取RTMP推流地址
     */
    public function getRtmpPublishUrl($streamKey, $expireAfterSeconds)
    {
        try {
            $url = \Qiniu\Pili\RTMPPublishURL($this->liveConfig['LiveDomain'], $this->liveConfig['HubName'], $streamKey, $expireAfterSeconds, $this->liveConfig['AccessKey'], $this->liveConfig['SecretKey']);
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $url;
    }

    /**
     * @param $streamKey
     * @return string
     * RTMP 直播放址
     */
    public function getRtmpPlayUrl($streamKey)
    {
        try {
            $url = \Qiniu\Pili\RTMPPlayURL($this->liveConfig['LiveDomain'], $this->liveConfig['HubName'], $streamKey);
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $url;
    }

    /**
     * @param $streamKey
     * @return string
     * 获取HLS播放地址
     */
    public function getHlsPlayUrl($streamKey)
    {
        try {
            $url = \Qiniu\Pili\HLSPlayURL($this->liveConfig['LiveDomain'], $this->liveConfig['HubName'], $streamKey);
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $url;
    }

    /**
     * @param $streamKey
     * @return string
     * 获取HDL播放地址
     */
    public function getHdlPlayUrl($streamKey)
    {
        try {
            $url = \Qiniu\Pili\HDLPlayURL($this->liveConfig['LiveDomain'], $this->liveConfig['HubName'], $streamKey);
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $url;
    }
}
