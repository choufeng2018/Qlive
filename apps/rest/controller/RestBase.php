<?php
/**
 * Created by PhpStorm.
 * Editor: xpwsg
 * Date: 2019/4/1
 * Time: 14:56
 * Dedicated to my wife and daughter
 */

namespace app\rest\controller;


use think\exception\HttpResponseException;
use think\Request;
use think\Response;

/**
 * Class RestBase
 * @package app\rest\controller
 * api基础控制器
 */
class RestBase
{
    /**
     * @var string
     */
    protected $token = '';

    /**
     * @var string
     */
    protected $sign = '';
    /**
     * @var string
     * 设备类型
     */
    protected $deviceType = '';

    /**
     * @var
     * api版本
     */
    protected $apiVersion;

    /**
     * @var int
     * 用户id
     */
    protected $userId = 0;


    /**
     * @var
     * 用户
     */
    protected $user;

    /**
     * @var
     * 用户类型
     */
    protected $userType;

    /**
     * @var array
     * 允许使用的设备类型
     */
    protected $allowedDeviceTypes = [
        'mobile',
        'android',
        'iphone',
        'ipad',
        'web',
        'pc',
        'mac',
        'wxapp'
    ];

    /**
     * @var \think\Request Request实例
     */
    protected $request;


    /**
     * RestBase constructor.
     */
    public function __construct()
    {
        $this->request = Request::instance();
        $this->init();
        $this->initUser();
    }


    /**
     *初始化
     */
    protected function init()
    {
        $this->checkDeviceType();
        $this->checkSign();
    }

    /**
     *用户基础控制器
     */
    protected function initUser()
    {

    }

    /**
     * @param string $msg
     * @param string $data
     * @param array $header
     * 操作成功的跳转
     */
    protected function success($msg = '', $data = '', array $header = [])
    {
        $this->result(1, $msg, $data, $header);
    }

    /**
     * @param string $msg
     * @param string $data
     * @param array $header
     * 操作失败的跳转
     */
    protected function error($msg = '', $data = '', array $header = [])
    {
        $this->result(0, $msg, $data, $header);
    }

    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $data
     * @param array $header
     */
    protected function result($code = 0, $msg = '', $data = '', array $header = [])
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'time' => $this->request->server('REQUEST_TIME'),
        ];
        $type = $this->getResponseType();
        $header['Access-Control-Allow-Origin'] = '*';
        $header['Access-Control-Allow-Headers'] = 'X-Requested-With,Content-Type,clientfrom,token,apiversion,sign';
        $header['Access-Control-Allow-Methods'] = 'GET,POST,PATCH,PUT,DELETE,OPTIONS';
        $response = Response::create($result, $type)->header($header);
        throw new HttpResponseException($response);
    }

    /**
     * 获取当前的response 输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType()
    {
        return 'json';
    }

    /**
     * @return bool
     * 检查sign签名
     * 规则很简单,毕竟不存在也没大问题
     */
    protected function checkSign()
    {
        $sign = $this->request->header('sign');
        $sign_key = \config('sign_key');
        $server_sign = \md5(\md5($sign_key) . \md5($sign_key));
        if ($sign !== $server_sign) {
            $this->error('sign验证失败');
        }
    }

    /**
     * @return bool
     * 检查登录设备
     */
    protected function checkDeviceType()
    {
        $deviceType = $this->request->header('clientfrom');
        if (empty($deviceType)) {
            $this->error('clientfrom为空');
        } elseif (!\in_array($deviceType, $this->allowedDeviceTypes)) {
            $this->error('不允许登录的设备');
        } else {
            $this->deviceType = $deviceType;
        }
    }
}
