<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2019/2/20
 * Time: 13:58
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
     * ["AccessKey"] => string(40) ""
     * ["SecretKey"] => string(40) ""
     * ["HubName"] => string(16) ""
     * ["LiveDomain"] => string(30) ""
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
     * 根据 prefix 遍历 Hub 的流列表.(没有prefix则为空)
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
     * @param array $streamKeys
     * @return mixed|string
     * 批量查询当前直播空间所有直播中的流信息.
     */
    public function batchLiveStreamsStatus($streamKeys = [])
    {
        try {
            $res = $this->hub->batchLiveStatus($streamKeys);
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
        $status = false;
        try {
            $info = $stream = $this->hub->stream($streamKey)->liveStatus();
            if (\is_array($info)) {
                $status = true;
            }
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $status;
    }


    /**
     * @param $streamKey    流名称
     * @param int $disableTime 禁用时间(Unix 时间戳,默认2099/01/01 在这之前流均不可用.)
     * @return string
     * 在一定时间内禁用某个流
     */
    public function disableStream($streamKey, $disableTime = 4070880000)
    {
        try {
            $this->hub->stream($streamKey)->disable($disableTime);
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
    }

    /**
     * @param $streamKey
     * @return string
     * 启用流
     */
    public function enableStream($streamKey)
    {
        try {
            $this->hub->stream($streamKey)->enable();
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
    }


    /**
     * @param $streamKey    直播流名称
     * @param int $start_time 开始时间
     * @param int $end_time 结束时间
     * @return string
     * 保存直播数据
     */
    public function saveStream($streamKey, $start_time = 0, $end_time = 0)
    {
        try {
            $fname = $this->hub->stream($streamKey)->save($start_time, $end_time);
        } catch (\Exception $exception) {
            return "Error:" . $exception->getMessage();
        }
        return $fname;
    }

    /**
     * @param $streamKey
     * @param array $options
     * * PARAM
     * @fname: 保存的文件名, 不指定会随机生成.
     * @start: Unix 时间戳, 起始时间, 0 值表示不指定, 则不限制起始时间.
     * @end: Unix 时间戳, 结束时间, 0 值表示当前时间.
     * @format: 保存的文件格式, 默认为m3u8.
     * @pipeline: dora 的私有队列, 不指定则用默认队列.
     * @notify: 保存成功后的回调地址.
     * @expireDays: 对应ts文件的过期时间.
     *   -1 表示不修改ts文件的expire属性.
     *   0  表示修改ts文件生命周期为永久保存.
     *   >0 表示修改ts文件的的生命周期为ExpireDays.
     * RETURN
     * @fname: 保存到bucket里的文件名.
     * @persistentID: 异步模式时，持久化异步处理任务ID，通常用不到该字段.
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
