<?php
// 附件模型

namespace app\common\model;

use think\Db;
use think\File;

class Attachment extends Base
{

    // protected $auto  = ['update_time'];
    protected $insert = ['status' => 1];

    protected function setUidAttr($value)
    {
        return is_login();
    }

    protected function setAdminUidAttr($value)
    {
        return is_admin_login();
    }

    //获取缩略图地址
    protected function getThumbSrcAttr($value, $data)
    {
        if ($data['location'] == 'link' || $data['ext'] == 'gif') {
            $thumb_src = $data['path'];
        } else {
            $style = 'medium';
            if ($data['path_type'] == 'brand') {
                $style = '';
            }
            if (in_array($data['ext'], ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'wps', 'txt', 'zip', 'rar', 'gz', 'bz2', '7z', 'wav', 'mp3', 'mp4', 'wmv'])) {
                $thumb_src = getImgSrcByExt($data['ext'], $data['path'], true);
            } else {
                $thumb_src = get_thumb_image($data['path'], $style);
            }

        }

        return $thumb_src;
    }

    /**
     * @param $id
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 下载文件
     * 远程文件返回URL;
     * 本地文件直接下载
     */
    public function download($id)
    {
        $file_info = Db::name('Attachment')
            ->find($id);
        $file_name = $file_info['name'] . '.' . $file_info['ext'];
        //判断是不是网络上的文件,则返回文件路径
        if (\filter_var($file_info['path'], \FILTER_VALIDATE_URL)) {
            return $file_info['path'];
        } else {
            $file_path = \ROOT_PATH . 'public' . $file_info['path'];
            $file_size = \filesize($file_path);
        }
        $file = \fopen($file_path, 'r');

        Header("Content-Type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:" . $file_size);
        Header("Content-Disposition: attachment; filename=" . $file_name);
        \ob_clean();
        \flush();
        echo \fread($file, \filesize($file_path));
        \fclose($file);
    }
}
