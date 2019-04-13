<?php

namespace app\common\logic;

use think\Model;
use eacoo\EacooAccredit;

/**
 * Class Base
 * @package app\common\logic
 */
class Base extends Model
{
    /**
     * @var
     * 完整url
     */
    protected $url;
    /**
     * @var
     * Request示例
     */
    protected $request;
    /**
     * @var
     * 被访问的模块
     */
    protected $module;
    /**
     * @var
     * 被访问的控制器
     */
    protected $controller;
    /**
     * @var
     * 被访问的操作
     */
    protected $action;
    /**
     * @var
     * 当前用户
     */
    protected $currentUser;
    /**
     * @var
     * 当前用户id
     */
    protected $uid;
    /**
     * @var
     * 用户ip
     */
    protected $ip;
    /**
     * @var
     * 三段式url
     */
    protected $urlRule;

    /**
     *初始化
     */
    protected function initialize()
    {
        parent::initialize();
        $this->request = request();
        //获取本地授权token
        defined('ACCREDIT_TOKEN') or define('ACCREDIT_TOKEN', EacooAccredit::getAccreditToken());
        //获取request信息
        $this->requestInfo();
        //halt(config());
    }

    /**
     * request信息
     * @return [type] [description]
     */
    protected function requestInfo()
    {

        defined('MODULE_NAME') or define('MODULE_NAME', $this->request->module());
        defined('CONTROLLER_NAME') or define('CONTROLLER_NAME', $this->request->controller());
        defined('ACTION_NAME') or define('ACTION_NAME', $this->request->action());
        defined('IS_POST') or define('IS_POST', $this->request->isPost());
        defined('IS_AJAX') or define('IS_AJAX', $this->request->isAjax());
        defined('IS_PJAX') or define('IS_PJAX', $this->request->isPjax());
        defined('IS_GET') or define('IS_GET', $this->request->isGet());

        $this->urlRule = strtolower($this->request->module() . '/' . $this->request->controller() . '/' . $this->request->action());
        $this->ip = $this->request->ip();
        $this->url = $this->request->url(true);
    }
}
