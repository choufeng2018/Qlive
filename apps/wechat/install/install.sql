
CREATE TABLE IF NOT EXISTS `eacoo_wechat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(50) NOT NULL COMMENT '公众号名称',
  `type` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '公众号类型（1：普通订阅号；2：认证订阅号；3：普通服务号；4：认证服务号',
  `origin_id` varchar(50) NOT NULL DEFAULT '' COMMENT '公众号原始ID',
  `weixin_number` varchar(50) NOT NULL DEFAULT '' COMMENT '微信号',
  `valid_token` varchar(40) NOT NULL DEFAULT '' COMMENT '接口验证Token',
  `token` varchar(50) NOT NULL DEFAULT '' COMMENT '公众号标识',
  `mch_id` varchar(50) NOT NULL DEFAULT '' COMMENT '商户号',
  `mch_key` varchar(60) NOT NULL DEFAULT '',
  `encodingaeskey` varchar(50) NOT NULL DEFAULT '' COMMENT '消息加解密秘钥',
  `appid` varchar(50) NOT NULL DEFAULT '' COMMENT 'AppId',
  `appsecret` varchar(50) NOT NULL DEFAULT '' COMMENT 'AppSecret',
  `headimg` varchar(120) NOT NULL DEFAULT '' COMMENT '头像',
  `qrcode` varchar(120) NOT NULL DEFAULT '' COMMENT '二维码',
  `description` text NOT NULL COMMENT '描述',
  `create_time` datetime NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `update_time` datetime NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0：禁用，1：正常，2：审核中）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公众号表';

CREATE TABLE IF NOT EXISTS `eacoo_wechat_material` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `wxid` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '公众号标识',
  `wx_media_id` varchar(100) NOT NULL DEFAULT '0' COMMENT '微信端素材的media_id',
  `type` varchar(50) NOT NULL DEFAULT '' COMMENT '素材类型',
  `description` text NOT NULL COMMENT '素材描述',
  `content` text NOT NULL COMMENT '文本素材内容',
  `attachment_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '图片素材路径',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '素材标题',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '素材链接',
  `news_content` longtext NOT NULL COMMENT '图文素材描述',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '多图文组的ID',
  `fields` text NULL COMMENT '扩展字段',
  `create_time` datetime NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '素材创建时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态。1正常，0禁用',
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='公众号素材表';

CREATE TABLE IF NOT EXISTS `eacoo_wechat_menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `wxid` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '公众号标识',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `type` char(10) NOT NULL DEFAULT '' COMMENT '菜单类型,click,view, miniprogram',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `key` varchar(30) DEFAULT '',
  `url` varchar(255) DEFAULT '' COMMENT '若为小程序菜单，作为备用url',
  `appid` varchar(20) DEFAULT '' COMMENT '对应小程序的appid',
  `pagepath` varchar(180) DEFAULT '' COMMENT ' 小程序路径',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `eacoo_wechat_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `wxid` tinyint(3) unsigned NOT NULL COMMENT '公众号标识',
  `type` varchar(50) DEFAULT NULL COMMENT '回复场景',
  `reply_type` varchar(50) DEFAULT NULL COMMENT '回复类型',
  `material_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复素材ID',
  `keyword` varchar(50) DEFAULT NULL COMMENT '绑定的关键词',
  `plugin` varchar(50) DEFAULT NULL COMMENT '处理消息的插件',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `idx_keyword` (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='公众号自动回复';


CREATE TABLE IF NOT EXISTS `eacoo_wechat_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户标识',
  `wxid` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '公众号标识',
  `openid` varchar(32) NOT NULL DEFAULT '' COMMENT 'OPENID',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `sex` tinyint(1) NOT NULL,
  `city` varchar(255) NOT NULL DEFAULT '' COMMENT '城市',
  `country` varchar(255) NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(255) NOT NULL DEFAULT '' COMMENT '省份',
  `headimgurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `subscribe` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否订阅',
  `subscribe_time` int(11) unsigned DEFAULT '0' COMMENT '订阅时间',
  `unionid` varchar(32) DEFAULT '',
  `last_update` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='微信用户表';

CREATE TABLE IF NOT EXISTS `eacoo_wechat_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `wxid` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '公众号标识ID',
  `ToUserName` varchar(100) NOT NULL DEFAULT '' COMMENT 'Token',
  `FromUserName` varchar(100) NOT NULL DEFAULT '' COMMENT 'OpenID',
  `CreateTime` int(10) NOT NULL COMMENT '创建时间',
  `MsgType` varchar(30) NOT NULL DEFAULT '' COMMENT '消息类型',
  `MsgId` varchar(100) NOT NULL DEFAULT '' COMMENT '消息ID',
  `Content` text NOT NULL COMMENT '文本消息内容',
  `PicUrl` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `MediaId` varchar(100) NOT NULL DEFAULT '' COMMENT '多媒体文件ID',
  `Format` varchar(30) NOT NULL DEFAULT '' COMMENT '语音格式',
  `ThumbMediaId` varchar(30) NOT NULL DEFAULT '' COMMENT '缩略图的媒体id',
  `Title` varchar(100) NOT NULL DEFAULT '' COMMENT '消息标题',
  `Description` varchar(255) NOT NULL DEFAULT '' COMMENT '消息描述',
  `Url` varchar(255) NOT NULL DEFAULT '' COMMENT 'Url',
  `collect` tinyint(1) NOT NULL DEFAULT '0' COMMENT '收藏状态',
  `deal` tinyint(1) NOT NULL DEFAULT '0' COMMENT '处理状态',
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '消息分类',
  `is_material` tinyint(1) NOT NULL DEFAULT '0' COMMENT '设置为文本素材',
  PRIMARY KEY (`id`),
  KEY `idx_wxid_openid` (`wxid`,`ToUserName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信消息记录';

INSERT INTO `eacoo_wechat` (`id`, `name`, `type`, `origin_id`, `weixin_number`, `valid_token`, `token`, `mch_id`, `mch_key`, `encodingaeskey`, `appid`, `appsecret`, `headimg`, `qrcode`, `description`, `create_time`, `update_time`, `status`) VALUES ('2', '公众平台测试账号', '4', 'gh_866ee7026f43  ', 'gh_866ee7026f43  ', 'Mf8Pv8Oc', 'fbbe31c758cd06451f1aaf5b55122251', '', '', 'vlEORHu2zpaEV67oiN0FNalKdRwTrIXKcEp4d7eYbx0', 'wx5627ca95a3d62b24', '5785ffa71d964ad8744a51e9e19d7d76', '/uploads/picture/2018-10-06/5bb86eb1929cf.png', '', '测试开发功能使用，可删除', '2018-10-06 16:13:53', '2018-10-06 16:13:53', '1');