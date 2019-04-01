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
    protected $allowedDeviceTypes = ['mobile', 'android', 'iphone', 'ipad', 'web', 'pc', 'mac', 'wxapp'];

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
        $deviceType = $this->request->header('clientfrom');
        if (empty($deviceType)) {
            return;
        }
        if (!\in_array($deviceType, $this->allowedDeviceTypes)) {
            return;
        }
        $this->deviceType = $deviceType;
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
        $code = 1;
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
        $type = $this->getResponseType();
        $header['Access-Control-Allow-Origin'] = '*';
        $header['Access-Control-Allow-Headers'] = 'X-Requested-With,Content-Type,clientfrom,token';
        $header['Access-Control-Allow-Methods'] = 'GET,POST,PATCH,PUT,DELETE,OPTIONS';
        $response = Response::create($result, $type)->header($header);
        throw new HttpResponseException($response);
    }

    /**
     * @param string $msg
     * @param string $data
     * @param array $header
     * 操作失败的跳转
     */
    protected function error($msg = '', $data = '', array $header = [])
    {
        $code = 0;
        if (is_array($msg)) {
            $code = $msg['code'];
            $msg = $msg['msg'];
        }
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
        $type = $this->getResponseType();
        $header['Access-Control-Allow-Origin'] = '*';
        $header['Access-Control-Allow-Headers'] = 'X-Requested-With,Content-Type,clientfrom,XX-Token';
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
}
