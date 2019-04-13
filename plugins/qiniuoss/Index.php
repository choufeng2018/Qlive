<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 http://www.eacoo123.com, All rights reserved.
// +----------------------------------------------------------------------
// | [EacooPHP] 并不是自由软件,可免费使用,未经许可不能去掉EacooPHP相关版权。
// | 禁止在EacooPHP整体或任何部分基础上发展任何派生、修改或第三方版本用于重新分发
// +----------------------------------------------------------------------
// | Author:  心云间、凝听 <981248356@qq.com>
// +----------------------------------------------------------------------
namespace plugins\qiniuoss;

use app\common\controller\Plugin;

/**
 * 七牛云储存插件
 */
class Index extends Plugin
{

    /**
     * @var array 插件钩子
     */
    public $hooks = [
        'UploadFile',
    ];

    /**
     * 插件安装方法
     */
    public function install()
    {
        return true;
    }

    /**
     * 插件卸载方法
     */
    public function uninstall()
    {
        return true;
    }


    /**
     * @param array $upload_info
     * @return bool
     * 实现上传文件方法
     */
    public function UploadFile($upload_info = [])
    {
        if ($upload_info['driver'] == 'qiniuoss') {
            $config = $this->getConfig();
            if ($config['enable'] == 1) {

                $this->ossUpload($upload_info['path']);
            }

        }
        return false;
    }

    /**
     * 获取cdn域名
     * @return [type] [description]
     * @date   2018-6-20 23:47:47
     * @author yyyvy <76836785@qq.com>
     */
    public function getDomain()
    {
        try {
            $config = $this->getConfig();
            if (!empty($config['domain'])) {
                return $config['domain'] . '/' . $config['root_path'];
            } else {
                throw new \Exception("Error Processing Request", 1);

            }
        } catch (\Exception $e) {
            return false;
        }

    }

    /**
     * 实例化七牛云储存
     * @return object 实例化得到的对象
     * @return 此步作为共用对象，可提供给多个模块统一调用
     */
    public function ossClient($config = [])
    {
        if (empty($config)) $config = $this->getConfig();
        //实例化OSS
        $oss = new \Qiniu\Auth($config['access_key_id'], $config['access_key_secret']);
        $upToken = $oss->uploadToken($config['bucket']);
        return $upToken;
    }

    /**
     * 上传指定的本地文件内容
     * @param string $object [description]
     * @return [type] [description]
     * @date   2017-11-15
     * @author 心云间、凝听 <981248356@qq.com>
     */
    public function ossUpload($object = '')
    {
        $path = ltrim($object, '/');
        $config = $this->getConfig();
        $object = $config['root_path'] . $object;
        //try 要执行的代码,如果代码执行过程中某一条语句发生异常,则程序直接跳转到CATCH块中,由$e收集错误信息和显示
        try {
            $filePath = PUBLIC_PATH . $path;
            if (file_exists($filePath)) {
                $ossClient = $this->ossClient();
                $uploadMgr = new \Qiniu\Storage\UploadManager();
                //putFile上传方法
                $uploadMgr->putFile($ossClient, $object, $filePath);
            }

        } catch (OssException $e) {
            //如果出错这里返回报错信息
            return $e->getMessage();
        }
        //否则，完成上传操作
        return true;
    }
    /*******************************Qiniu OSS end ********************************/
}
