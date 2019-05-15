<?php
//模块自定义函数文件
use app\qlive\model\QliveLiveHistory;
use Douyasi\IdentityCard\ID;
use think\Db;

if (!function_exists('create_stream_name')) {
    /**
     * @return string
     * 生成唯一的直播密钥
     * 增加房间时生成,绑定一个房间
     * 分配给主播用于推流
     */
    function create_stream_name()
    {
        $res = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . time() . rand();
        return sha1($res);
    }
}

if (!function_exists('getAnchorNameById')) {
    /**
     * @param $id
     * @return mixed
     * 根据主播ID获取主播姓名
     */
    function getAnchorNameById($id)
    {
        $name = Db::name('QliveAnchorList')
            ->where('id', $id)
            ->value('nickname');
        if (!empty($name)) {
            return $name;
        } else {
            return '未知主播';
        }
    }
}
if (!function_exists('getAnchorIdByName')) {
    /**
     * @param $name
     * @return mixed
     * 根据主播名称获取主播ID
     */
    function getAnchorIdByName($name)
    {
        $name = trim($name);
        $id = Db::name('QliveAnchorList')
            ->where('nickname', 'eq', $name)
            ->value('id');
        return $id;
    }
}

if (!function_exists('getAnchorIdByUid')) {
    /**
     * @param $uid
     * @return bool|mixed
     * 根据Users表id获取anchor表id
     */
    function getAnchorIdByUid($uid)
    {
        $anchor_id = Db::name('QliveAnchorList')
            ->where('uid', 'eq', $uid)
            ->value('id');
        if (empty($anchor_id)) {
            return false;
        } else {
            return $anchor_id;
        }
    }
}
if (!function_exists('getStreamByAnchorId')) {
    /**
     * @param $anchor_id
     * @return mixed
     * 根据主播ID获取对应的推流码
     */
    function getStreamByAnchorId($anchor_id)
    {
        $stream = Db::name('QliveRoomList qrl')
            ->join('QliveAnchorList qal', 'qrl.anchor_id=qal.id')
            ->where('qal.id', 'eq', $anchor_id)
            ->value('qrl.stream');
        return $stream;
    }
}
if (!function_exists('getStreamNameByRoomId')) {
    /**
     * @param $room_id
     * @return mixed
     * 根据直播间ID获取推流码
     */
    function getStreamNameByRoomId($room_id)
    {
        $stream = Db::name('QliveRoomList')
            ->where('id', 'eq', $room_id)
            ->value('stream');
        return $stream;
    }
}
if (!function_exists('getAdminNameById')) {
    /**
     * @param $id
     * @return mixed
     * 根据管理员id获取管理员名称
     */
    function getAdminNameById($id)
    {
        $name = Db::name('Admin')
            ->where('uid', 'eq', $id)
            ->value('username');
        return $name;
    }
}
if (!function_exists('getLiveTitleById')) {
    /**
     * @param $id
     * @return mixed
     * 根据直播记录的id获取直播名称
     */
    function getLiveTitleById($id)
    {
        $title = Db::name('QliveLiveHistory')
            ->where('id', 'eq', $id)
            ->value('title');
        return $title;
    }
}
if (!function_exists('getUserNameById')) {
    /**
     * @param $uid
     * @return mixed
     * 根据uid获取username
     */
    function getUserNameById($uid)
    {
        $username = Db::name('Users')
            ->where('uid', 'eq', $uid)
            ->value('username');
        return $username;
    }
}
if (!function_exists('getUidByToken')) {
    /**
     * @param $token
     * @return mixed
     * 根据token获取用户ID
     */
    function getUidByToken($token)
    {
        $uid = Db::name('UserToken')
            ->where('token', 'eq', $token)
            ->value('user_id');
        return $uid;
    }
}
if (!function_exists('getImagePathById')) {
    /**
     * @param $id
     * @return mixed
     * 根据图片ID获取图片路径
     */
    function getImagePathById($id)
    {
        $prefix = \request()->domain();
        $path = Db::name('Attachment')
            ->where('id', 'eq', $id)
            ->value('path');
        return $prefix . $path;
    }
}
if (!function_exists('getCategoryNameById')) {
    /**
     * @param $id
     * @return mixed
     * 根据直播分类id获取名称
     */
    function getCategoryNameById($id)
    {
        $name = Db::name('QliveCategoryList')
            ->where('id', 'eq', $id)
            ->value('name');
        return $name;
    }
}
if (!function_exists('getRoomIdByAnchorId')) {
    /**
     * @param $id
     * @return mixed
     * 根据主播ID获取所在直播间ID
     */
    function getRoomIdByAnchorId($id)
    {
        $room_id = Db::name('QliveRoomList')
            ->where('anchor_id', 'eq', $id)
            ->value('id');
        return $room_id;
    }
}
if (!function_exists('getLiveTypeNameById')) {
    /**
     * @param $id
     * @return mixed
     * 根据直播类型id获取名称
     */
    function getLiveTypeNameById($id)
    {
        $type_list = config('live_type');
        $name = $type_list[$id];
        return $name;
    }
}
if (!function_exists('getPlayUrlByRoomId')) {

    /**
     * @param $room_id
     * @return array
     * 根据直播间id获取播放地址
     */
    function getPlayUrlByRoomId($room_id)
    {
        $stream = getStreamNameByRoomId($room_id);
        $playUrls = [
            logic('QliveLogic')->getRtmpPlayUrl($stream),
            logic('QliveLogic')->getHlsPlayUrl($stream),
            logic('QliveLogic')->getHdlPlayUrl($stream),
        ];
        return $playUrls;
    }
}
if (!function_exists('getAnchorNameByLiveId')) {
    /**
     * @param $live_id
     * @return mixed
     * 根据直播记录ID获取当时主播名称
     */
    function getAnchorNameByLiveId($live_id)
    {
        $name = Db::name('QliveLiveHistory')
            ->where('id', 'eq', $live_id)
            ->value('anchor');
        return $name;
    }
}
if (!function_exists('getUserInfoByToken')) {
    /**
     * @param $token
     * @return array|bool|false|PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据token获取用户信息
     */
    function getUserInfoByToken($token)
    {
        $info = Db::name('Users a')
            ->join('UserToken b', 'a.uid=b.user_id')
            ->where('b.token', 'eq', $token)
            ->field('a.*')
            ->find();
        if (empty($info)) {
            return false;
        }
        return $info;
    }
}
if (!function_exists('isLivingRoom')) {

    /**
     * @param $room_id
     * @return bool
     * 判断直播间是否在直播
     */
    function isLivingRoom($room_id)
    {
        $res = \logic('QliveLogic')->getLiveStatus(getStreamNameByRoomId($room_id));
        if (\is_array($res)) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('getHistoryLiveInfo')) {
    /**
     * @param $live_id
     * @return array|false|PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据直播id获取直播详情
     */
    function getHistoryLiveInfo($live_id)
    {
        $info = Db::name('QliveLiveHistory')
            ->where('id', 'eq', $live_id)
            ->find();
        return $info;
    }
}
if (!function_exists('getVideoByLiveId')) {
    /**
     * @param $live_id
     * @return array|false|PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据直播id获取对应视频信息
     */
    function getVideoByLiveId($live_id)
    {
        $video_info = Db::name('QliveVideoList')
            ->where('live_id', 'eq', $live_id)
            ->find();
        if (empty($video_info)) {
            return null;
        } else {
            $video_info['url'] = get_file_complete_path($video_info['url']);
            return $video_info;
        }
    }
}
if (!function_exists('getUidByAnchorId')) {
    /**
     * @param $anchor_id
     * @return mixed
     * 根据主播id获取对应用户id
     */
    function getUidByAnchorId($anchor_id)
    {
        $uid = Db::name('QliveAnchorList')
            ->where('id', 'eq', $anchor_id)
            ->value('uid');
        return $uid;
    }
}
if (!function_exists('getAnchorIdByUid')) {
    /**
     * @param $uid
     * @return mixed
     * 根据用户id获取主播id
     */
    function getAnchorIdByUid($uid)
    {
        $anchor_id = Db::name('QliveAnchorList')
            ->where('uid', 'eq', $uid)
            ->value('id');
        return $anchor_id;
    }
}
if (!function_exists('isAnchor')) {
    /**
     * @param $uid
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 判断该用户是不是主播
     */
    function isAnchor($uid)
    {
        $anchor_info = Db::name('QliveAnchorList')
            ->where('uid', 'eq', $uid)
            ->find();
        if (empty($anchor_info)) {
            return false;
        } else {
            return true;
        }
    }
}
if (!function_exists('isCertificate')) {
    /**
     * @param $uid
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 判断用户是否实名认证
     */
    function isCertificate($uid)
    {
        $certification_info = Db::name('QliveUserCertification')
            ->where('uid', 'eq', $uid)
            ->find();
        if (empty($certification_info) || $certification_info['status'] != 1) {
            return false;
        } else {
            return true;
        }
    }
}
if (!function_exists('check_id_card')) {
    /**
     * @param $number
     * @return bool
     * 检测是不是合法身份证号
     */
    function check_id_card($number)
    {
        $ID = new ID();
        $passed = $ID->validateIDCard($number);
        if ($passed) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('get_order_sn')) {
    /**
     * @return string
     * 生成订单号
     */
    function get_order_sn()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2019] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }
}
if (!function_exists('get_live_history_by_apprise_id')) {
    /**
     * @param $apprise_id
     * @return QliveLiveHistory|bool|null
     * @throws \think\exception\DbException
     * 根据直播预告id获取对应开播申请数据
     */
    function get_live_history_by_apprise_id($apprise_id)
    {
        $history_info = QliveLiveHistory::get(['apprise_id' => $apprise_id]);
        if ($history_info) {
            return $history_info;
        } else {
            return false;
        }
    }
}
if (!function_exists('get_live_category_name')) {
    /**
     * @param $id
     * @return mixed
     * 根据直播分类id获取名称
     */
    function get_live_category_name_by_id($id)
    {
        $name = Db::name('QliveCategoryList')
            ->where('id', 'eq', $id)
            ->value('name');
        if (!empty($name)) {
            return $name;
        } else {
            return '未知分类';
        }
    }
}
if (!function_exists('get_live_type_name_by_id')) {
    /**
     * @param $id
     * @return mixed
     * 根据直播分类id获取名称
     */
    function get_live_type_name_by_id($id)
    {
        $typeArr = config('live_type');
        $name = $typeArr[$id];
        return $name;
    }
}
