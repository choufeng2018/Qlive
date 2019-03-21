/*
 Navicat Premium Data Transfer

 Source Server         : WSL服务器
 Source Server Type    : MySQL
 Source Server Version : 50725
 Source Host           : 127.0.0.1:3306
 Source Schema         : live

 Target Server Type    : MySQL
 Target Server Version : 50725
 File Encoding         : 65001

 Date: 19/03/2019 17:14:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for eacoo_action
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_action`;
CREATE TABLE `eacoo_action`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '行为唯一标识（组合控制器名+操作名）',
  `depend_type` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '来源类型。0系统,1module，2plugin，3theme',
  `depend_flag` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '所属模块名',
  `title` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` varchar(140) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '行为规则',
  `log` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '日志规则',
  `action_type` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '执行类型。1自定义操作，2记录操作',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '修改时间',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态。0禁用，1启用',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统行为表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_action
-- ----------------------------
INSERT INTO `eacoo_action` VALUES (1, 'login_index', 1, 'admin', '登录后台', '用户登录后台', '', '[user|get_nickname]在[time|time_format]登录了后台', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (2, 'update_config', 1, 'admin', '更新配置', '新增或修改或删除配置', '', '', 2, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (3, 'update_channel', 1, 'admin', '更新导航', '新增或修改或删除导航', '', '', 2, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (4, 'update_category', 1, 'admin', '更新分类', '新增或修改或删除分类', '', '', 2, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (5, 'database_export', 1, 'admin', '数据库备份', '后台进行数据库备份操作', '', '', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (6, 'database_optimize', 1, 'admin', '数据表优化', '数据库管理-》数据表优化', '', '', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (7, 'database_repair', 1, 'admin', '数据表修复', '数据库管理-》数据表修复', '', '', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (8, 'database_delbackup', 1, 'admin', '备份文件删除', '数据库管理-》备份文件删除', '', '', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (9, 'database_import', 1, 'admin', '数据库完成', '数据库管理-》数据还原', '', '', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (10, 'delete_actionlog', 1, 'admin', '删除行为日志', '后台删除用户行为日志', '', '', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (11, 'user_register', 1, 'admin', '注册', '', '', '', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (12, 'action_add', 1, 'admin', '添加行为', '', '', '', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (13, 'action_edit', 1, 'admin', '编辑用户行为', '', '', '', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (14, 'action_dellog', 1, 'admin', '清空日志', '清空所有行为日志', '', '', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (15, 'setstatus', 1, 'admin', '改变数据状态', '通过列表改变了数据的status状态值', '', '', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_action` VALUES (16, 'modules_delapp', 1, 'admin', '删除模块', '删除整个模块的时候记录', '', '', 2, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);

-- ----------------------------
-- Table structure for eacoo_action_log
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_action_log`;
CREATE TABLE `eacoo_action_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(10) UNSIGNED NOT NULL COMMENT '行为ID',
  `is_admin` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否后台操作。0否，1是',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '执行用户id（管理员用户）',
  `nickname` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `request_method` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '请求类型',
  `url` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作页面',
  `data` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '相关数据,json格式',
  `ip` varchar(18) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'IP',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '日志备注',
  `user_agent` varchar(360) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'User-Agent',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '操作时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_uid`(`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统行为日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_action_log
-- ----------------------------
INSERT INTO `eacoo_action_log` VALUES (42, 1, 1, 1, 'admin', 'POST', '/admin.php/admin/login/index.html', '{\"param\":[]}', '127.0.0.1', '登录后台', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-18 16:50:47');
INSERT INTO `eacoo_action_log` VALUES (43, 1, 1, 1, 'admin', 'POST', '/admin.php/admin/login/index.html', '{\"param\":[]}', '127.0.0.1', '登录后台', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-19 10:26:10');
INSERT INTO `eacoo_action_log` VALUES (44, 1, 1, 1, 'admin', 'POST', '/admin.php/admin/login/index.html', '{\"param\":[]}', '127.0.0.1', '登录后台', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '2019-02-20 13:36:30');
INSERT INTO `eacoo_action_log` VALUES (45, 1, 1, 1, 'admin', 'POST', '/admin.php?s=/admin/login/index.html', '{\"param\":[]}', '127.0.0.1', '登录后台', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-18 11:04:50');
INSERT INTO `eacoo_action_log` VALUES (46, 1, 1, 1, 'admin', 'POST', '/admin.php?s=/admin/login/index.html', '{\"param\":[]}', '127.0.0.1', '登录后台', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-18 11:51:26');
INSERT INTO `eacoo_action_log` VALUES (47, 1, 1, 1, 'admin', 'POST', '/admin.php?s=/admin/login/index.html', '{\"param\":[]}', '127.0.0.1', '登录后台', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-18 11:54:27');
INSERT INTO `eacoo_action_log` VALUES (48, 1, 1, 1, 'admin', 'POST', '/admin.php?s=/admin/login/index.html', '{\"param\":[]}', '127.0.0.1', '登录后台', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '2019-03-18 11:54:51');
INSERT INTO `eacoo_action_log` VALUES (49, 1, 1, 1, 'admin', 'POST', '/admin.php?s=/admin/login/index.html', '{\"param\":[]}', '127.0.0.1', '登录后台', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.75 Safari/537.36', '2019-03-19 09:18:37');

-- ----------------------------
-- Table structure for eacoo_admin
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_admin`;
CREATE TABLE `eacoo_admin`  (
  `uid` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '管理员UID',
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '登录密码',
  `nickname` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `avatar` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '用户头像，相对于uploads/avatar目录',
  `sex` smallint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '性别；0：保密，1：男；2：女',
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '个人介绍',
  `login_num` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录次数',
  `last_login_ip` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_login_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '最后登录时间',
  `activation_auth_sign` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '激活码',
  `bind_uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '绑定前台用户ID（可选）',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '注册时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '更新时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 2 COMMENT '用户状态 0：禁用； 1：正常 ；2：待验证',
  PRIMARY KEY (`uid`) USING BTREE,
  UNIQUE INDEX `uniq_username`(`username`) USING BTREE,
  INDEX `idx_email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '管理员用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_admin
-- ----------------------------
INSERT INTO `eacoo_admin` VALUES (1, 'admin', '031c9ffc4b280d3e78c750163d07d275', '创始人', 'admin@admin.com', '', 'http://cdn.eacoo.xin/attachment/static/assets/img/default-avatar.png', 0, '', 0, '127.0.0.1', '2019-03-19 09:18:37', '9fa0588644a0f9a1cbd1d3acdbb73b0074e8e6ff', 1, '2019-02-18 16:50:26', '2019-02-18 16:50:26', 1);

-- ----------------------------
-- Table structure for eacoo_attachment
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_attachment`;
CREATE TABLE `eacoo_attachment`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `is_admin` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否后台用户上传',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件名',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件路径',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件链接（暂时无用）',
  `location` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件存储位置(或驱动)',
  `path_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'picture' COMMENT '路径类型，存储在uploads的哪个目录中',
  `ext` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件类型',
  `mime_type` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '文件大小',
  `alt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '替代文本图像alt',
  `md5` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件sha1编码',
  `download` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '下载次数',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '上传时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '修改时间',
  `sort` mediumint(8) UNSIGNED NOT NULL DEFAULT 99 COMMENT '排序，值越小越靠前',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_paty_type`(`path_type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 98 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '附件表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_attachment
-- ----------------------------
INSERT INTO `eacoo_attachment` VALUES (1, 1, 1, 'preg_match_imgs.jpeg', '/uploads/Editor/Picture/2016-06-12/575d4bd8d0351.jpeg', '', 'local', 'editor', 'jpeg', '', 19513, '', '4cf157e42b44c95d579ee39b0a1a48a4', 'dee76e7b39f1afaad14c1e03cfac5f6031c3c511', 0, '2018-09-30 12:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (2, 1, 1, 'gerxiangimg200x200.jpg', '/uploads/Editor/Picture/2016-06-12/575d4bfb09961.jpg', '', 'local', 'editor', 'jpg', '', 5291, 'gerxiangimg200x200', '4db879c357c4ab80c77fce8055a0785f', '480eb2e097397856b99b373214fb28c2f717dacf', 0, '2018-09-30 13:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (3, 1, 1, 'oraclmysqlzjfblhere.jpg', '/uploads/Editor/Picture/2016-06-12/575d4c691e976.jpg', '', 'local', 'editor', 'jpg', '', 23866, 'mysql', '5a3a5a781a6d9b5f0089f6058572f850', 'a17bfe395b29ba06ae5784486bcf288b3b0adfdb', 0, '2018-09-30 14:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (4, 1, 1, 'logo.png', '/logo.png', '', 'local', 'picture', 'jpg', '', 40000, 'eacoophp-logo', '', '', 0, '2018-09-30 15:12:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (10, 1, 1, '苹果短信-三全音 - 铃声', '/uploads/file/2016-07-27/579857b5aca95.mp3', '', 'local', 'file', 'mp3', '', 19916, NULL, 'bab00edb8d6a5cf4de5444a2e5c05009', '73cda0fb4f947dcb496153d8b896478af1247935', 0, '2018-09-30 15:15:26', '2018-09-30 22:32:26', 99, -1);
INSERT INTO `eacoo_attachment` VALUES (12, 1, 1, 'music', '/uploads/file/2016-07-28/57995fe9bf0da.mp3', '', 'local', 'file', 'mp3', '', 160545, NULL, '935cd1b8950f1fdcd23d47cf791831cf', '73c318221faa081544db321bb555148f04b61f00', 0, '2018-09-30 15:16:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (13, 1, 1, '7751775467283337', '/uploads/picture/2016-09-26/57e8dc9d29b01.jpg', '', 'local', 'picture', 'jpg', '', 70875, NULL, '3e3bfc950aa0b6ebb56654c15fe8e392', 'c75e70753eaf36aaee10efb3682fdbd8f766d32d', 0, '2018-09-30 15:17:26', '2018-09-30 22:32:26', 99, -1);
INSERT INTO `eacoo_attachment` VALUES (14, 1, 1, '4366486814073822', '/uploads/picture/2016-09-26/57e8ddebaafff.jpg', '', 'local', 'picture', 'jpg', '', 302678, NULL, 'baf2dc5ea7b80a6d73b20a2c762aec1e', 'd73fe63f5c179135b2c2e7f174d6df36e05ab3d8', 0, '2018-09-30 15:18:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (15, 1, 1, 'wx1image_14751583274385', '/uploads/picture/2016-09-29/wx1image_14751583274385.jpg', '', 'local', 'picture', 'jpg', '', 311261, NULL, '', '', 0, '2018-09-30 15:19:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (17, 1, 1, 'wx1image_14751583287356', '/uploads/picture/2016-09-29/wx1image_14751583287356.jpg', '', 'local', 'picture', 'jpg', '', 43346, NULL, '', '', 0, '2018-09-30 15:20:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (18, 1, 1, 'wx1image_14751583293547', '/uploads/picture/2016-09-29/wx1image_14751583293547.jpg', '', 'local', 'picture', 'jpg', '', 150688, NULL, '', '', 0, '2018-09-30 15:21:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (19, 1, 1, 'wx1image_14751583298683', '/uploads/picture/2016-09-29/wx1image_14751583298683.jpg', '', 'local', 'picture', 'jpg', '', 79626, NULL, '', '', 0, '2018-09-30 15:22:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (20, 1, 1, 'wx1image_14751583294128', '/uploads/picture/2016-09-29/wx1image_14751583294128.jpg', '', 'local', 'picture', 'jpg', '', 61008, NULL, '', '', 0, '2018-09-30 15:23:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (21, 1, 1, 'wx1image_14751583302886', '/uploads/picture/2016-09-29/wx1image_14751583302886.jpg', '', 'local', 'picture', 'jpg', '', 20849, NULL, '', '', 0, '2018-09-30 15:16:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (22, 1, 1, 'wx1image_1475158330831', '/uploads/picture/2016-09-29/wx1image_1475158330831.jpg', '', 'local', 'picture', 'jpg', '', 56265, NULL, '', '', 0, '2018-09-30 16:12:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (23, 1, 1, 'wx1image_1475158330180', '/uploads/picture/2016-09-29/wx1image_1475158330180.jpg', '', 'local', 'picture', 'jpg', '', 121610, NULL, '', '', 0, '2018-09-30 17:12:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (24, 1, 1, 'wx1image_14751583318180', '/uploads/picture/2016-09-29/wx1image_14751583318180.jpg', '', 'local', 'picture', 'jpg', '', 35555, 'url', '', '', 0, '2018-09-30 22:32:26', '2018-10-01 15:23:24', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (25, 1, 1, 'wx1image_1475158332231', '/uploads/picture/2016-09-29/wx1image_1475158332231.jpg', '', 'local', 'picture', 'jpg', '', 32095, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (26, 1, 1, 'wx1image_14751583325255', '/uploads/picture/2016-09-29/wx1image_14751583325255.jpg', '', 'local', 'picture', 'jpg', '', 70088, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (27, 1, 1, 'wx1image_14751583331037', '/uploads/picture/2016-09-29/wx1image_14751583331037.jpg', '', 'local', 'picture', 'jpg', '', 37085, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (28, 1, 1, 'wx1image_14751583343169', '/uploads/picture/2016-09-29/wx1image_14751583343169.jpg', '', 'local', 'picture', 'jpg', '', 65279, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (29, 1, 1, 'wx1image_14751583344810', '/uploads/picture/2016-09-29/wx1image_14751583344810.jpg', '', 'local', 'picture', 'jpg', '', 83936, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (30, 1, 1, 'wx1image_14751583356369', '/uploads/picture/2016-09-29/wx1image_14751583356369.jpg', '', 'local', 'picture', 'jpg', '', 20032, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (31, 1, 1, 'wx1image_14751583359328', '/uploads/picture/2016-09-29/wx1image_14751583359328.jpg', '', 'local', 'picture', 'jpg', '', 53984, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (32, 1, 1, 'wx1image_1475158335689', '/uploads/picture/2016-09-29/wx1image_1475158335689.jpg', '', 'local', 'picture', 'jpg', '', 50399, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (33, 1, 1, 'wx1image_14751583361694', '/uploads/picture/2016-09-29/wx1image_14751583361694.jpg', '', 'local', 'picture', 'jpg', '', 128125, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (34, 1, 1, 'wx1image_14751583371210', '/uploads/picture/2016-09-29/wx1image_14751583371210.jpg', '', 'local', 'picture', 'jpg', '', 35090, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (36, 1, 1, 'wx1image_14751583393940', '/uploads/picture/2016-09-29/wx1image_14751583393940.jpg', '', 'local', 'picture', 'jpg', '', 74827, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (38, 1, 1, 'wx1image_14751587991531', '/uploads/picture/2016-09-29/wx1image_14751587991531.jpg', '', 'local', 'picture', 'jpg', '', 154175, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (39, 1, 1, 'wx1image_14751587997094.png', '/uploads/picture/2016-09-29/wx1image_14751587997094.png', '', 'local', 'picture', 'jpg', '', 26583, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (40, 1, 1, 'wx1image_14751587995130', '/uploads/picture/2016-09-29/wx1image_14751587995130.jpg', '', 'local', 'picture', 'jpg', '', 23625, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (41, 1, 1, 'wx1image_14751587995676', '/uploads/picture/2016-09-29/wx1image_14751587995676.jpg', '', 'local', 'picture', 'jpg', '', 67232, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (43, 1, 1, 'wx1image_14751588004786', '/uploads/picture/2016-09-29/wx1image_14751588004786.jpg', '', 'local', 'picture', 'jpg', '', 26779, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (44, 1, 1, 'wx1image_14751588009825', '/uploads/picture/2016-09-29/wx1image_14751588009825.jpg', '', 'local', 'picture', 'jpg', '', 7546, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (45, 1, 1, 'wx1image_1475158800631', '/uploads/picture/2016-09-29/wx1image_1475158800631.jpg', '', 'local', 'picture', 'jpg', '', 10713, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (46, 1, 1, 'wx1image_14751588008193', '/uploads/picture/2016-09-29/wx1image_14751588008193.jpg', '', 'local', 'picture', 'jpg', '', 94825, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (47, 1, 1, 'wx1image_14751588004666', '/uploads/picture/2016-09-29/wx1image_14751588004666.jpg', '', 'local', 'picture', 'jpg', '', 39592, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (48, 1, 1, 'wx1image_14751588008768.png', '/uploads/picture/2016-09-29/wx1image_14751588008768.png', '', 'local', 'picture', 'jpg', '', 50732, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (50, 1, 1, 'wx1image_1475158801542.png', '/uploads/picture/2016-09-29/wx1image_1475158801542.png', '', 'local', 'picture', 'jpg', '', 19383, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (51, 1, 1, 'wx1image_14751588012312.png', '/uploads/picture/2016-09-29/wx1image_14751588012312.png', '', 'local', 'picture', 'jpg', '', 45798, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (52, 1, 1, 'wx1image_14751588058806', '/uploads/picture/2016-09-29/wx1image_14751588058806.jpg', '', 'local', 'picture', 'jpg', '', 24855, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (53, 1, 1, 'wx1image_14751588067284', '/uploads/picture/2016-09-29/wx1image_14751588067284.jpg', '', 'local', 'picture', 'jpg', '', 14851, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (54, 1, 1, 'wx1image_14751588091783.png', '/uploads/picture/2016-09-29/wx1image_14751588091783.png', '', 'local', 'picture', 'jpg', '', 68781, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (55, 1, 1, 'wx1image_14751588108673.png', '/uploads/picture/2016-09-29/wx1image_14751588108673.png', '', 'local', 'picture', 'jpg', '', 13649, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (56, 1, 1, 'wx1image_14751588114626.png', '/uploads/picture/2016-09-29/wx1image_14751588114626.png', '', 'local', 'picture', 'jpg', '', 10724, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (57, 1, 1, 'wx1image_14751588116216.png', '/uploads/picture/2016-09-29/wx1image_14751588116216.png', '', 'local', 'picture', 'jpg', '', 18955, NULL, '', '', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (58, 1, 1, 'wx1image_14751588117971', '/uploads/picture/2016-09-29/wx1image_14751588117971.jpg', '', 'local', 'picture', 'jpg', '', 34171, NULL, '', '', 0, '2018-09-30 22:31:10', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (59, 1, 1, 'wx1image_14751588113400', '/uploads/picture/2016-09-29/wx1image_14751588113400.jpg', '', 'local', 'picture', 'jpg', '', 16445, NULL, '', '', 0, '2018-09-30 22:31:11', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (60, 1, 1, 'wx1image_14751588113547', '/uploads/picture/2016-09-29/wx1image_14751588113547.jpg', '', 'local', 'picture', 'jpg', '', 7062, NULL, '', '', 0, '2018-09-30 22:31:12', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (61, 1, 1, 'wx1image_14751588111003', '/uploads/picture/2016-09-29/wx1image_14751588111003.jpg', '', 'local', 'picture', 'jpg', '', 7982, NULL, '', '', 0, '2018-09-30 22:31:13', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (62, 1, 1, 'wx1image_14751588185564.png', '/uploads/picture/2016-09-29/wx1image_14751588185564.png', '', 'local', 'picture', 'jpg', '', 163203, NULL, '', '', 0, '2018-09-30 22:31:14', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (63, 1, 1, 'wx1image_14751588213497.png', '/uploads/picture/2016-09-29/wx1image_14751588213497.png', '', 'local', 'picture', 'jpg', '', 14153, NULL, '', '', 0, '2018-09-30 22:31:15', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (64, 1, 1, 'wx1image_14751588212612.png', '/uploads/picture/2016-09-29/wx1image_14751588212612.png', '', 'local', 'picture', 'jpg', '', 15962, NULL, '', '', 0, '2018-09-30 22:31:16', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (65, 1, 1, 'wx1image_14751588215121.png', '/uploads/picture/2016-09-29/wx1image_14751588215121.png', '', 'local', 'picture', 'jpg', '', 22820, NULL, '', '', 0, '2018-09-30 22:31:17', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (67, 1, 1, 'wx1image_14751588223870', '/uploads/picture/2016-09-29/wx1image_14751588223870.jpg', '', 'local', 'picture', 'jpg', '', 31690, NULL, '', '', 0, '2018-09-30 22:31:18', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (68, 1, 1, 'wx1image_14751588235543.png', '/uploads/picture/2016-09-29/wx1image_14751588235543.png', '', 'local', 'picture', 'jpg', '', 32383, NULL, '', '', 0, '2018-09-30 22:31:19', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (69, 1, 1, 'wx1image_14751588233114.png', '/uploads/picture/2016-09-29/wx1image_14751588233114.png', '', 'local', 'picture', 'jpg', '', 16871, NULL, '', '', 0, '2018-09-30 22:31:20', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (70, 1, 1, 'wx1image_14751588247501.png', '/uploads/picture/2016-09-29/wx1image_14751588247501.png', '', 'local', 'picture', 'jpg', '', 48306, '', '', '', 0, '2018-09-30 22:31:21', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (73, 1, 1, 'wx1image_1475158835506', '/uploads/picture/2016-09-29/wx1image_1475158835506.jpg', '', 'local', 'picture', 'jpg', '', 12805, NULL, '', '', 0, '2018-09-30 22:31:22', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (74, 1, 1, 'wx1image_14751588359605.png', '/uploads/picture/2016-09-29/wx1image_14751588359605.png', '', 'local', 'picture', 'jpg', '', 42306, NULL, '', '', 0, '2018-09-30 22:31:23', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (75, 1, 1, 'wx1image_14751588351768.png', '/uploads/picture/2016-09-29/wx1image_14751588351768.png', '', 'local', 'picture', 'jpg', '', 13828, NULL, '', '', 0, '2018-09-30 22:31:24', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (76, 1, 1, 'wx1image_14751588383783.png', '/uploads/picture/2016-09-29/wx1image_14751588383783.png', '', 'local', 'picture', 'jpg', '', 39390, NULL, '', '', 0, '2018-09-30 22:31:25', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (78, 1, 1, 'wx1image_14751588393130.png', '/uploads/picture/2016-09-29/wx1image_14751588393130.png', '', 'local', 'picture', 'jpg', '', 10686, NULL, '', '', 0, '2018-09-30 22:31:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (79, 1, 1, 'wx1image_1475158843730.png', '/uploads/picture/2016-09-29/wx1image_1475158843730.png', '', 'local', 'picture', 'jpg', '', 77934, NULL, '', '', 0, '2018-09-30 22:32:09', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (80, 1, 1, 'wx1image_14751588431771.png', '/uploads/picture/2016-09-29/wx1image_14751588431771.png', '', 'local', 'picture', 'jpg', '', 38682, NULL, '', '', 0, '2018-09-30 22:32:10', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (81, 1, 1, 'wx1image_14751588432055.png', '/uploads/picture/2016-09-29/wx1image_14751588432055.png', '', 'local', 'picture', 'jpg', '', 54928, NULL, '', '', 0, '2018-09-30 22:32:11', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (82, 1, 1, 'wx1image_14751588441630.png', '/uploads/picture/2016-09-29/wx1image_14751588441630.png', '', 'local', 'picture', 'jpg', '', 22413, NULL, '', '', 0, '2018-09-30 22:32:12', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (83, 1, 1, 'wx1image_14751588456818.png', '/uploads/picture/2016-09-29/wx1image_14751588456818.png', '', 'local', 'picture', 'jpg', '', 12567, NULL, '', '', 0, '2018-09-30 22:32:13', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (84, 1, 1, 'wx1image_14751588548752.png', '/uploads/picture/2016-09-29/wx1image_14751588548752.png', '', 'local', 'picture', 'jpg', '', 86619, NULL, '', '', 0, '2018-09-30 22:32:14', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (85, 1, 1, 'wx1image_14751588549711', '/uploads/picture/2016-09-29/wx1image_14751588549711.jpg', '', 'local', 'picture', 'jpg', '', 11863, NULL, '', '', 0, '2018-09-30 22:32:15', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (87, 1, 1, 'wx1image_14751588668519', '/uploads/picture/2016-09-29/wx1image_14751588668519.jpg', '', 'local', 'picture', 'jpg', '', 27712, NULL, '', '', 0, '2018-09-30 22:32:16', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (88, 1, 1, 'wx1image_14751588684053', '/uploads/picture/2016-09-29/wx1image_14751588684053.jpg', '', 'local', 'picture', 'jpg', '', 101186, NULL, '', '', 0, '2018-09-30 22:32:17', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (89, 1, 1, 'wx1image_14751588703441', '/uploads/picture/2016-09-29/wx1image_14751588703441.jpg', '', 'local', 'picture', 'jpg', '', 155125, NULL, '', '', 0, '2018-09-30 22:32:18', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (90, 1, 1, 'wx1image_14751588708117', '/uploads/picture/2016-09-29/wx1image_14751588708117.jpg', '', 'local', 'picture', 'jpg', '', 24226, NULL, '', '', 0, '2018-09-30 22:32:19', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (92, 1, 1, '57e0a9c03a61b', '/uploads/picture/2016-10-03/57f2076c4e997.jpg', '', 'local', 'picture', 'jpg', '', 110032, '', 'e3694c361707487802476e81709c863f', 'd5381f24235ee72d9fd8dfe2bb2e3d128217c8ce', 0, '2018-09-30 22:32:21', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (93, 1, 1, '9812496129086622', '/uploads/picture/2016-10-06/57f6136b5bd4e.jpg', '', 'local', 'picture', 'jpg', '', 164177, '9812496129086622', '983944832c987b160ae409f71acc7933', 'bce6147f4070989fc0349798acf6383938e5563a', 0, '2018-09-30 22:32:22', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (94, 1, 1, 'eacoophp-watermark-banner-1', 'http://cdn.eacoophp.com/static/demo-eacoophp/eacoophp-watermark-banner-1.jpg', 'http://cdn.eacoophp.com/static/demo-eacoophp/eacoophp-watermark-banner-1.jpg', 'link', 'picture', 'jpg', 'image', 171045, 'eacoophp-watermark-banner-1', '', '', 0, '2018-09-30 22:32:23', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (95, 1, 1, 'eacoophp-banner-3', 'http://cdn.eacoophp.com/static/demo-eacoophp/eacoophp-banner-3.jpg', 'http://cdn.eacoophp.com/static/demo-eacoophp/eacoophp-banner-3.jpg', 'link', 'picture', 'jpg', 'image', 356040, 'eacoophp-banner-3', '', '', 0, '2018-09-30 22:32:24', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (96, 1, 1, 'eacoophp-watermark-banner-2', 'http://cdn.eacoophp.com/static/demo-eacoophp/eacoophp-watermark-banner-2.jpg', 'http://cdn.eacoophp.com/static/demo-eacoophp/eacoophp-watermark-banner-2.jpg', 'link', 'picture', 'jpg', 'image', 356040, 'eacoophp-watermark-banner-2', '', '', 0, '2018-09-30 22:32:25', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_attachment` VALUES (97, 1, 1, '150217753092666', '/uploads/picture/2018-04-12/5acec2ffee8a4.jpg', '/uploads/picture/2018-04-12/5acec2ffee8a4.jpg', 'local', 'picture', 'jpg', 'image', 67406, '150217753092666', '82a25ea71fd7db1a2180894086790ea9', '87a03fe9161c0d3b4b757e999160355f9ce0ee75', 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);

-- ----------------------------
-- Table structure for eacoo_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_auth_group`;
CREATE TABLE `eacoo_auth_group`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '描述信息',
  `rules` varchar(160) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态。1启用，0禁用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户组表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_auth_group
-- ----------------------------
INSERT INTO `eacoo_auth_group` VALUES (1, '超级管理员', '拥有网站的最高权限', '1,2,6,18,9,12,19,25,17,26,3,7,21,43,44,4,37,38,39,40,41,42,5,22,23,30,24,10,11,13,14,20,32,15,8,16,45,27,28,29', 1);
INSERT INTO `eacoo_auth_group` VALUES (2, '管理员', '授权管理员', '1,6,18,12,19,26,3,7,21,44,4,37,38,39,40,41,42,5,22,23,30,24,10,11,13,14,20,15,8,16,27,28,29', 1);
INSERT INTO `eacoo_auth_group` VALUES (3, '普通用户', '这是普通用户的权限', '1,3,8,10,11,94,95,96,97,98,99,41,42,43,44,38,39,40', 1);
INSERT INTO `eacoo_auth_group` VALUES (4, '客服', '客服处理订单发货', '1,27,28,29,7,4,52,53,54,55', 1);

-- ----------------------------
-- Table structure for eacoo_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_auth_group_access`;
CREATE TABLE `eacoo_auth_group_access`  (
  `uid` int(11) UNSIGNED NOT NULL COMMENT '管理员用户ID',
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否审核  2：未审核，1:启用，0：禁用，-1：删除',
  INDEX `uid`(`uid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户组明细表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_auth_group_access
-- ----------------------------
INSERT INTO `eacoo_auth_group_access` VALUES (1, 1, 1);

-- ----------------------------
-- Table structure for eacoo_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_auth_rule`;
CREATE TABLE `eacoo_auth_rule`  (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '导航链接',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '导航名字',
  `depend_type` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '来源类型。1module，2plugin，3theme',
  `depend_flag` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '来源标记。如：模块或插件标识',
  `type` tinyint(1) NULL DEFAULT 1 COMMENT '是否支持规则表达式',
  `pid` smallint(6) UNSIGNED NULL DEFAULT 0 COMMENT '上级id',
  `icon` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图标',
  `condition` char(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `is_menu` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否菜单',
  `position` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'admin' COMMENT '菜单显示位置。如果是插件就写模块名',
  `developer` tinyint(1) NOT NULL DEFAULT 0 COMMENT '开发者',
  `sort` smallint(6) UNSIGNED NULL DEFAULT 99 COMMENT '排序，值越小越靠前',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '更新时间',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否有效(0:无效,1:有效)',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uniq_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '规则表（后台菜单）' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_auth_rule
-- ----------------------------
INSERT INTO `eacoo_auth_rule` VALUES (1, 'admin/dashboard/index', '仪表盘', 1, 'admin', 1, 0, 'fa fa-tachometer', NULL, 1, 'admin', 0, 3, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (2, 'admin/manage', '系统管理', 1, 'admin', 1, 0, 'fa fa-cog', NULL, 1, 'admin', 0, 7, '2018-12-03 00:47:34', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (3, 'user/user/', '会员管理', 1, 'user', 1, 0, 'fa fa-users', NULL, 1, 'user', 0, 28, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0);
INSERT INTO `eacoo_auth_rule` VALUES (4, 'admin/attachment/index', '附件空间', 1, 'admin', 1, 0, 'fa fa-picture-o', NULL, 1, 'admin', 0, 28, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (5, 'admin/extend/index', '应用中心', 1, 'admin', 1, 0, 'fa fa-cloud', NULL, 1, 'admin', 0, 30, '2019-03-18 11:30:42', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (6, 'admin/navigation/index', '前台导航菜单', 1, 'admin', 1, 0, 'fa fa-leaf', NULL, 1, 'admin', 0, 25, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (7, 'user/user/index', '用户列表', 1, 'user', 1, 0, 'fa fa-user', NULL, 1, 'user', 0, 4, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (8, 'admin/AuthGroup/index', '角色组', 1, 'admin', 1, 0, '', NULL, 1, 'admin', 0, 10, '2018-12-03 00:49:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (9, 'admin/menu/index', '后台菜单管理', 1, 'admin', 1, 2, 'fa fa-inbox', NULL, 1, 'admin', 1, 31, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (10, 'tools', '工具', 1, 'admin', 1, 0, 'fa fa-gavel', NULL, 1, 'admin', 1, 29, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (11, 'admin/database', '安全', 1, 'admin', 1, 10, 'fa fa-database', NULL, 0, 'admin', 0, 32, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (12, 'admin/attachment/setting', '设置', 1, 'admin', 1, 0, '', NULL, 0, 'admin', 0, 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (13, 'admin/link/index', '友情链接', 1, 'admin', 1, 10, '', NULL, 1, 'admin', 0, 26, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (14, 'admin/link/edit', '链接编辑', 1, 'admin', 1, 13, '', NULL, 0, 'admin', 0, 4, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (15, 'user/auth', '权限管理', 1, 'user', 1, 0, 'fa fa-sun-o', NULL, 1, 'user', 0, 25, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0);
INSERT INTO `eacoo_auth_rule` VALUES (16, 'admin/auth/index', '规则管理', 1, 'admin', 1, 2, 'fa fa-500px', NULL, 1, 'admin', 0, 19, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (17, 'admin/config/edit', '配置编辑或添加', 1, 'admin', 1, 25, '', NULL, 0, 'admin', 0, 27, '2018-12-02 22:56:27', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (18, 'admin/navigation/edit', '导航编辑或添加', 1, 'admin', 1, 6, '', NULL, 0, 'admin', 0, 5, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (19, 'admin/config/website', '网站设置', 1, 'admin', 1, 0, '', NULL, 1, 'admin', 0, 6, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (20, 'admin/database/index', '数据库管理', 1, 'admin', 1, 10, 'fa fa-database', NULL, 1, 'admin', 0, 33, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (21, 'user/user/resetPassword', '修改密码', 1, 'user', 1, 0, '', '', 1, 'user', 0, 40, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (22, 'admin/theme/index', '主题', 1, 'admin', 1, 5, 'fa fa-cloud', NULL, 1, 'admin', 0, 22, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (23, 'admin/plugins/index', '插件', 1, 'admin', 1, 5, 'fa fa-cloud', NULL, 1, 'admin', 0, 20, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (24, 'admin/modules/index', '模块', 1, 'admin', 1, 5, 'fa fa-cloud', NULL, 1, 'admin', 0, 2, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (25, 'admin/config/index', '配置管理', 1, 'admin', 1, 2, '', NULL, 1, 'admin', 1, 34, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (26, 'admin/config/group', '系统设置', 1, 'admin', 1, 2, '', NULL, 1, 'admin', 0, 8, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (27, 'admin/action', '行为管理', 1, 'admin', 1, 0, 'fa fa-list-alt', NULL, 1, 'admin', 0, 23, '2018-12-03 00:10:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (28, 'admin/action/index', '用户行为', 1, 'admin', 1, 27, '', NULL, 1, 'admin', 0, 11, '2018-12-03 00:08:20', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (29, 'admin/action/log', '行为日志', 1, 'admin', 1, 27, 'fa fa-address-book-o', NULL, 1, 'admin', 0, 21, '2018-12-03 00:08:30', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (30, 'admin/plugins/hooks', '钩子管理', 1, 'admin', 1, 23, '', NULL, 0, 'admin', 1, 12, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (32, 'admin/mailer/template', '邮件模板', 1, 'admin', 1, 10, NULL, NULL, 1, 'admin', 0, 24, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (37, 'admin/attachment/attachmentCategory', '附件分类', 1, 'admin', 1, 4, NULL, NULL, 0, 'admin', 0, 13, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (38, 'admin/attachment/upload', '文件上传', 1, 'admin', 1, 4, NULL, NULL, 0, 'admin', 0, 14, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (39, 'admin/attachment/uploadPicture', '上传图片', 1, 'admin', 1, 4, NULL, NULL, 0, 'admin', 0, 15, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (40, 'admin/attachment/upload_onlinefile', '添加外链附件', 1, 'admin', 1, 4, NULL, NULL, 0, 'admin', 0, 16, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (41, 'admin/attachment/attachmentInfo', '附件详情', 1, 'admin', 1, 4, NULL, NULL, 0, 'admin', 0, 17, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (42, 'admin/attachment/uploadAvatar', '上传头像', 1, 'admin', 1, 4, NULL, NULL, 0, 'admin', 0, 18, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (43, 'user/tags/index', '标签管理', 1, 'user', 1, 0, '', NULL, 1, 'user', 0, 22, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0);
INSERT INTO `eacoo_auth_rule` VALUES (44, 'user/tongji/analyze', '会员统计', 1, 'user', 1, 0, '', NULL, 1, 'user', 0, 27, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (45, 'admin/AdminUser/index', '管理员', 1, 'admin', 1, 0, 'fa fa-users', '', 1, 'admin', 0, 9, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_auth_rule` VALUES (54, 'live/index', '小Q直播', 1, 'qlive', 1, 0, 'fa fa-video-camera', '', 1, 'qlive', 0, 99, '2019-02-19 14:10:43', '2019-02-19 14:10:43', 1);
INSERT INTO `eacoo_auth_rule` VALUES (55, 'admin/modules/config?name=qlive', '应用配置', 1, 'qlive', 1, 54, 'fa fa-cog ', '', 1, 'qlive', 0, 99, '2019-02-19 14:10:43', '2019-02-19 14:10:43', 1);
INSERT INTO `eacoo_auth_rule` VALUES (56, 'qlive/anchor/index', '主播列表', 1, 'qlive', 1, 54, 'fa fa-podcast', '', 1, 'qlive', 0, 99, '2019-02-19 14:10:43', '2019-02-19 14:10:43', 1);
INSERT INTO `eacoo_auth_rule` VALUES (57, 'qlive/room/index', '房间管理', 1, 'qlive', 1, 54, 'fa fa-key', '', 1, 'qlive', 0, 99, '2019-02-19 14:10:43', '2019-02-19 14:10:43', 1);
INSERT INTO `eacoo_auth_rule` VALUES (58, 'qlive/comment/index', '评论列表', 1, 'qlive', 1, 54, 'fa fa-commenting-o', '', 1, 'qlive', 0, 99, '2019-02-19 14:10:43', '2019-02-19 14:10:43', 1);

-- ----------------------------
-- Table structure for eacoo_config
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_config`;
CREATE TABLE `eacoo_config`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置名称',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置说明',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置值',
  `options` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置额外值',
  `group` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '配置分组',
  `sub_group` tinyint(3) NULL DEFAULT 0 COMMENT '子分组，子分组需要自己定义',
  `type` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置类型',
  `remark` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置说明',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '更新时间',
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT 99 COMMENT '排序，值越小越靠前',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_config
-- ----------------------------
INSERT INTO `eacoo_config` VALUES (1, 'toggle_web_site', '站点开关', '1', '0:关闭\r\n1:开启', 1, 0, 'select', '站点关闭后将提示网站已关闭，不能正常访问', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1, 1);
INSERT INTO `eacoo_config` VALUES (2, 'web_site_title', '网站标题', 'EacooPHP快速开发框架', '', 6, 0, 'text', '网站标题前台显示标题', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 2, 1);
INSERT INTO `eacoo_config` VALUES (4, 'web_site_logo', '网站LOGO', '4', '', 6, 0, 'picture', '网站LOGO', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 4, 1);
INSERT INTO `eacoo_config` VALUES (5, 'web_site_description', 'SEO描述', '开源框架 EacooPHP ThinkPHP', '', 6, 1, 'textarea', '网站搜索引擎描述', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 6, 1);
INSERT INTO `eacoo_config` VALUES (6, 'web_site_keyword', 'SEO关键字', 'EacooPHP是基于ThinkPHP5开发的一套轻量级WEB产品开发框架，追求高效，简单，灵活。', '', 6, 1, 'textarea', '网站搜索引擎关键字', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 4, 1);
INSERT INTO `eacoo_config` VALUES (7, 'web_site_copyright', '版权信息', 'Copyright © ******有限公司 All rights reserved.', '', 1, 0, 'text', '设置在网站底部显示的版权信息', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 7, 1);
INSERT INTO `eacoo_config` VALUES (8, 'web_site_icp', '网站备案号', '豫ICP备14003306号', '', 6, 0, 'text', '设置在网站底部显示的备案号，如“苏ICP备1502009-2号\"', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 8, 1);
INSERT INTO `eacoo_config` VALUES (9, 'web_site_statistics', '站点统计', '', '', 1, 0, 'textarea', '支持百度、Google、cnzz等所有Javascript的统计代码', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 9, 1);
INSERT INTO `eacoo_config` VALUES (10, 'index_url', '首页地址', 'http://www.live.gov', '', 2, 0, 'text', '可以通过配置此项自定义系统首页的地址，比如：http://www.xxx.com', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (13, 'admin_tags', '后台多标签', '1', '0:关闭\r\n1:开启', 2, 0, 'radio', '', '2018-09-30 22:32:26', '2018-12-02 23:00:29', 99, 1);
INSERT INTO `eacoo_config` VALUES (14, 'admin_page_size', '后台分页数量', '12', '', 2, 0, 'number', '后台列表分页时每页的记录数', '2018-09-30 22:32:26', '2018-12-02 23:01:12', 99, 1);
INSERT INTO `eacoo_config` VALUES (15, 'admin_theme', '后台主题', 'default', 'default:默认主题\r\nblue:蓝色理想\r\ngreen:绿色生活', 2, 0, 'select', '后台界面主题', '2018-09-30 22:32:26', '2018-12-02 23:00:44', 98, 1);
INSERT INTO `eacoo_config` VALUES (16, 'develop_mode', '开发模式', '1', '1:开启\r\n0:关闭', 3, 0, 'select', '开发模式下会显示菜单管理、配置管理、数据字典等开发者工具', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1, 1);
INSERT INTO `eacoo_config` VALUES (17, 'app_trace', '是否显示页面Trace', '1', '1:开启\r\n0:关闭', 3, 0, 'select', '是否显示页面Trace信息', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 2, 1);
INSERT INTO `eacoo_config` VALUES (18, 'auth_key', '系统加密KEY', 'vzxI=vf[=xV)?a^XihbLKx?pYPw$;Mi^R*<mV;yJh$wy(~~E?<.JA&ANdIZ#QhPq', '', 3, 0, 'textarea', '轻易不要修改此项，否则容易造成用户无法登录；如要修改，务必备份原key', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 3, 1);
INSERT INTO `eacoo_config` VALUES (19, 'only_auth_rule', '权限仅验证规则表', '1', '1:开启\n0:关闭', 4, 0, 'radio', '开启此项，则后台验证授权只验证规则表存在的规则', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (20, 'static_domain', '静态文件独立域名', '', '', 3, 0, 'text', '静态文件独立域名一般用于在用户无感知的情况下平和的将网站图片自动存储到腾讯万象优图、又拍云等第三方服务。', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 3, 1);
INSERT INTO `eacoo_config` VALUES (21, 'config_group_list', '配置分组', '1:基本\r\n2:系统\r\n3:开发\r\n4:安全\r\n5:数据库\r\n6:网站设置\r\n7:用户\r\n8:邮箱\r\n9:高级', '', 3, 0, 'array', '配置分组的键值对不要轻易改变', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 5, 1);
INSERT INTO `eacoo_config` VALUES (25, 'form_item_type', '表单项目类型', 'hidden:隐藏\r\nreadonly:仅读文本\r\nnumber:数字\r\ntext:单行文本\r\ntextarea:多行文本\r\narray:数组\r\npassword:密码\r\nradio:单选框\r\ncheckbox:复选框\r\nselect:下拉框\r\nicon:字体图标\r\ndate:日期\r\ndatetime:时间\r\npicture:单张图片\r\npictures:多张图片\r\nfile:单个文件\r\nfiles:多个文件\r\nwangeditor:wangEditor编辑器\r\nueditor:百度富文本编辑器\r\neditormd:Markdown编辑器\r\ntags:标签\nselect2:高级下拉框\r\njson:JSON\r\nboard:拖', '', 3, 0, 'array', '专为配置管理设定\r\n', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (26, 'term_taxonomy', '分类法', 'post_category:分类目录\r\npost_tag:标签\r\nmedia_cat:多媒体分类', '', 3, 0, 'array', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (27, 'data_backup_path', '数据库备份根路径', '../data/backup', '', 5, 0, 'text', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (28, 'data_backup_part_size', '数据库备份卷大小', '20971520', '', 5, 0, 'number', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (29, 'data_backup_compress_level', '数据库备份文件压缩级别', '4', '1:普通\r\n4:一般\r\n9:最高', 5, 0, 'radio', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (30, 'data_backup_compress', '数据库备份文件压缩', '1', '0:不压缩\r\n1:启用压缩', 5, 0, 'radio', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (31, 'hooks_type', '钩子的类型', '1:视图\r\n2:控制器', '', 3, 0, 'array', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (33, 'action_type', '行为类型', '1:系统\r\n2:用户', '1:系统\r\n2:用户', 7, 0, 'array', '配置说明', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (34, 'website_group', '网站信息子分组', '0:基本信息\r\n1:SEO设置\r\n3:其它', '', 6, 0, 'array', '作为网站信息配置的子分组配置，每个大分组可设置子分组作为tab切换', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 20, 1);
INSERT INTO `eacoo_config` VALUES (36, 'mail_reg_active_template', '注册激活邮件模板', '{\"active\":\"0\",\"subject\":\"\\u6ce8\\u518c\\u6fc0\\u6d3b\\u901a\\u77e5\"}', '', 8, 0, 'json', 'JSON格式保存除了模板内容的属性', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (37, 'mail_captcha_template', '验证码邮件模板', '{\"active\":\"0\",\"subject\":\"\\u90ae\\u7bb1\\u9a8c\\u8bc1\\u7801\\u901a\\u77e5\"}', '', 8, 0, 'json', 'JSON格式保存除了模板内容的属性', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (38, 'mail_reg_active_template_content', '注册激活邮件模板内容', '<p><span style=\"font-family: 微软雅黑; font-size: 14px;\"></span><span style=\"font-family: 微软雅黑; font-size: 14px;\">您在{$title}的激活链接为</span><a href=\"{$url}\" target=\"_blank\" style=\"font-family: 微软雅黑; font-size: 14px; white-space: normal;\">激活</a><span style=\"font-family: 微软雅黑; font-size: 14px;\">，或者请复制链接：{$url}到浏览器打开。</span></p>', '', 8, 0, 'textarea', '注册激活模板邮件内容部分，模板内容单独存放', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (39, 'mail_captcha_template_content', '验证码邮件模板内容', '<p><span style=\"font-family: 微软雅黑; font-size: 14px;\">您的验证码为{$verify}验证码，账号为{$account}。</span></p>', '', 8, 0, 'textarea', '验证码邮件模板内容部分', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (40, 'attachment_options', '附件配置选项', '{\"driver\":\"local\",\"file_max_size\":\"2097152\",\"file_exts\":\"doc,docx,xls,xlsx,ppt,pptx,pdf,wps,txt,zip,rar,gz,bz2,7z\",\"file_save_name\":\"uniqid\",\"image_max_size\":\"2097152\",\"image_exts\":\"gif,jpg,jpeg,bmp,png\",\"image_save_name\":\"uniqid\",\"page_number\":\"24\",\"widget_show_type\":\"0\",\"cut\":\"1\",\"small_size\":{\"width\":\"150\",\"height\":\"150\"},\"medium_size\":{\"width\":\"320\",\"height\":\"280\"},\"large_size\":{\"width\":\"560\",\"height\":\"430\"},\"watermark_scene\":\"2\",\"watermark_type\":\"1\",\"water_position\":\"9\",\"water_img\":\"\\/logo.png\",\"water_opacity\":\"80\"}', '', 9, 0, 'json', '以JSON格式保存', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (42, 'user_deny_username', '保留用户名和昵称', '管理员,测试,admin,垃圾', '', 7, 0, 'textarea', '禁止注册用户名和昵称，包含这些即无法注册,用&quot; , &quot;号隔开，用户只能是英文，下划线_，数字等', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (43, 'captcha_open', '验证码配置', 'reg,login,reset', 'reg:注册显示\r\nlogin:登陆显示\r\nreset:密码重置', 4, 0, 'checkbox', '验证码开启配置', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (44, 'captcha_type', '验证码类型', '4', '1:中文\r\n2:英文\r\n3:数字\r\n4:英文+数字', 4, 0, 'select', '验证码类型', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (45, 'web_site_subtitle', '网站副标题', '基于ThinkPHP5的开发框架', '', 6, 0, 'textarea', '用简洁的文字描述本站点（网站口号、宣传标语、一句话介绍）', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 2, 1);
INSERT INTO `eacoo_config` VALUES (46, 'cache', '缓存配置', '{\"type\":\"File\",\"path\":\"\\/Library\\/WebServer\\/Documents\\/EacooPHP\\/runtime\\/cache\\/\",\"prefix\":\"\",\"expire\":\"0\"}', '', 9, 0, 'json', '以JSON格式保存', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (47, 'session', 'Session配置', '{\"type\":\"\",\"prefix\":\"eacoophp_\",\"auto_start\":\"1\"}', '', 9, 0, 'json', '以JSON格式保存', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_config` VALUES (48, 'cookie', 'Cookie配置', '{\"path\":\"\\/\",\"prefix\":\"eacoophp_\",\"expire\":\"0\",\"domain\":\"\",\"secure\":\"0\",\"httponly\":\"\",\"setcookie\":\"1\"}', '', 9, 0, 'json', '以JSON格式保存', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_config` VALUES (49, 'reg_default_roleid', '注册默认角色', '4', '', 7, 0, 'select', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (50, 'open_register', '开放注册', '0', '1:是\r\n0:否', 7, 0, 'radio', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (56, 'meanwhile_user_online', '允许同时登录', '1', '1:是\r\n0:否', 7, 0, 'radio', '是否允许同一帐号在不同地方同时登录', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0, 1);
INSERT INTO `eacoo_config` VALUES (57, 'admin_collect_menus', '后台收藏菜单', '[]', '', 2, 0, 'json', '在后台顶部菜单栏展示，可以方便快速菜单入口', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_config` VALUES (58, 'minify_status', '开启minify', '1', '1:开启\r\n0:关闭', 2, 0, 'radio', '开启minify会压缩合并js、css文件，可以减少资源请求次数，如果不支持minify，可关闭', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_config` VALUES (59, 'admin_allow_login_many', '同账号多人登录后台', '0', '0:不允许\r\n1:允许', 4, 0, 'radio', '允许多个人使用同一个账号登录后台。默认：不允许', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_config` VALUES (60, 'admin_allow_ip', '仅限登录后台IP', '', '', 4, 0, 'textarea', '填写IP地址，多个IP用英文逗号隔开。默认为空，允许所有IP', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_config` VALUES (61, 'redis', 'Redis配置', '{\"host\":\"127.0.0.1\",\"port\":\"6979\"}', '', 9, 0, 'json', '以JSON格式保存', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_config` VALUES (62, 'memcache', 'Memcache配置', '{\"host\":\"127.0.0.1\",\"port\":\"11211\"}', '', 9, 0, 'json', '以JSON格式保存', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_config` VALUES (63, 'admin_menus_mode', '后台菜单模式', '2', '1:全局模式\r\n2:模块模式', 2, 0, 'radio', '全局模式：所有菜单都显示在后台左侧。\r\n模式模式：菜单根据模式的方式显示在顶部加载。', '2018-12-02 22:59:47', '2018-12-03 00:57:51', 20, 0);

-- ----------------------------
-- Table structure for eacoo_hooks
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_hooks`;
CREATE TABLE `eacoo_hooks`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '钩子ID',
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `type` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '类型。1视图，2控制器',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态。1启用，0禁用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '钩子表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_hooks
-- ----------------------------
INSERT INTO `eacoo_hooks` VALUES (1, 'AdminIndex', '后台首页小工具', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (2, 'FormBuilderExtend', 'FormBuilder类型扩展Builder', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (3, 'UploadFile', '上传文件钩子', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (4, 'PageHeader', '页面header钩子，一般用于加载插件CSS文件和代码', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (5, 'PageFooter', '页面footer钩子，一般用于加载插件CSS文件和代码', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (6, 'LoginUser', '用户登录钩子', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (7, 'SendMessage', '发送消息钩子，用于消息发送途径的扩展', 2, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (8, 'sms', '短信插件钩子', 2, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (9, 'RegisterUser', '用户注册钩子', 2, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (10, 'ImageGallery', '图片轮播钩子', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (11, 'JChinaCity', '每个系统都需要的一个中国省市区三级联动插件。', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (13, 'editor', '内容编辑器钩子', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (14, 'adminEditor', '后台内容编辑页编辑器', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (15, 'ThirdLogin', '集成第三方授权登录，包括微博、QQ、微信、码云', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (16, 'comment', '实现本地评论功能，支持评论点赞', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (17, 'uploadPicture', '实现阿里云OSS对象存储，管理附件', 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_hooks` VALUES (18, 'MicroTopicsUserPost', '微话题，专注实时热点、个人兴趣、网友讨论等，包含用户等级机制，权限机制。', 1, '2019-01-06 19:08:38', '2019-01-06 19:08:38', 1);

-- ----------------------------
-- Table structure for eacoo_hooks_extra
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_hooks_extra`;
CREATE TABLE `eacoo_hooks_extra`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hook_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '钩子ID',
  `depend_type` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '应用类型。1module，2plugin，3theme',
  `depend_flag` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '应用标记。如：模块或插件标识',
  `sort` smallint(6) UNSIGNED NOT NULL DEFAULT 99 COMMENT '排序，值越小越靠前',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态。0禁用，1正常',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_hookid_depend`(`hook_id`, `depend_flag`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '钩子应用依赖表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for eacoo_links
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_links`;
CREATE TABLE `eacoo_links`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `image` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '图标',
  `url` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接',
  `target` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '_blank' COMMENT '打开方式',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '类型',
  `rating` int(11) UNSIGNED NOT NULL COMMENT '评级',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '修改时间',
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT 99 COMMENT '排序，值越小越靠前',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态，1启用，0禁用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '友情链接表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_links
-- ----------------------------
INSERT INTO `eacoo_links` VALUES (1, 'EacooPHP官网', 96, 'https://www.eacoophp.com', '_blank', 2, 8, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 2, 1);
INSERT INTO `eacoo_links` VALUES (2, '社区', 89, 'https://forum.eacoophp.com', '_blank', 1, 9, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1, 1);

-- ----------------------------
-- Table structure for eacoo_modules
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_modules`;
CREATE TABLE `eacoo_modules`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(31) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(63) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(127) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `author` varchar(31) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '开发者',
  `icon` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标',
  `version` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '版本',
  `config` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置',
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否允许卸载',
  `url` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '站点',
  `admin_manage_into` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '后台管理入口',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '更新时间',
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT 99 COMMENT '排序，值越小越靠前',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态。0禁用，1启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '模块功能表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_modules
-- ----------------------------
INSERT INTO `eacoo_modules` VALUES (1, 'admin', '系统', '后台系统模块', '心云间、凝听', 'fa fa-home', '1.0.0', '', 1, '', '', '2018-12-02 22:32:26', '2018-12-02 22:32:26', 99, 1);
INSERT INTO `eacoo_modules` VALUES (2, 'home', 'Home模块', '一款基础前台Home模块', '心云间、凝听', 'fa fa-home', '1.0.0', '', 1, '', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_modules` VALUES (3, 'user', '用户中心', '用户模块，系统核心模块，不可卸载', '心云间、凝听', 'fa fa-users', '1.0.2', '', 1, 'https://www.eacoophp.com', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_modules` VALUES (6, 'qlive', '小Q直播', '基于七牛云直播开发的直播', 'xpwsgg', '', '1.0.0', '{\"status\":\"1\",\"AccessKey\":\"wkkOpP-qcNGq3Wj9Cs7bTdEAh_r0IOMyEyxpPb4V\",\"SecretKey\":\"qq9cWnsl5Pfd5xAAuISzwbQbdPwBb2keVjDYJ2zY\",\"HubName\":\"qiniuniulive2019\",\"LiveDomain\":\"pili-publish.live.qiniuniu.com\"}', 0, '', '', '2019-02-19 14:10:43', '2019-02-19 17:23:44', 99, 1);

-- ----------------------------
-- Table structure for eacoo_nav
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_nav`;
CREATE TABLE `eacoo_nav`  (
  `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `value` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'url地址',
  `pid` smallint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级',
  `position` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '位置。头部：header，我的：my',
  `target` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '_self' COMMENT '打开方式。',
  `depend_type` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '来源类型。0普通外链http，1模块扩展，2插件扩展，3主题扩展',
  `depend_flag` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '来源标记。如：模块或插件标识',
  `icon` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标',
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT 99 COMMENT '排序，值越小越靠前',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '更新时间',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态。0禁用，1启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '前台导航' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_nav
-- ----------------------------
INSERT INTO `eacoo_nav` VALUES (1, '主页', '/', 0, 'header', '_self', 1, 'home', 'fa fa-home', 10, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_nav` VALUES (2, '会员', 'user/index/index', 0, 'header', '_self', 1, 'user', '', 99, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_nav` VALUES (3, '下载', 'https://gitee.com/ZhaoJunfeng/EacooPHP/attach_files', 0, 'header', '_blank', 0, '', '', 99, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_nav` VALUES (4, '社区', 'https://forum.eacoophp.com', 0, 'header', '_blank', 0, '', '', 99, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_nav` VALUES (5, '文档', 'https://www.kancloud.cn/youpzt/eacoo', 0, 'header', '_blank', 0, '', '', 99, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);

-- ----------------------------
-- Table structure for eacoo_plugins
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_plugins`;
CREATE TABLE `eacoo_plugins`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '插件名或标识',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '插件描述',
  `config` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '配置',
  `author` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '作者',
  `version` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '版本号',
  `admin_manage_into` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '后台管理入口',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '插件类型',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '安装时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '修改时间',
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT 99 COMMENT '排序，值越小越靠前',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '插件表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for eacoo_qlive_anchor_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_anchor_list`;
CREATE TABLE `eacoo_qlive_anchor_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '直播姓名',
  `room_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '主播房间id',
  `status` tinyint(1) NULL DEFAULT NULL COMMENT '0=禁用,1=启用',
  `marks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '主播列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_qlive_anchor_list
-- ----------------------------
INSERT INTO `eacoo_qlive_anchor_list` VALUES (1, '卡尔', '', 1, '虎牙第一丑', '2019-03-18 14:07:42', '2019-03-18 14:07:42');

-- ----------------------------
-- Table structure for eacoo_qlive_category_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_category_list`;
CREATE TABLE `eacoo_qlive_category_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int(11) NULL DEFAULT 0 COMMENT '父级id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类名称',
  `order` int(11) NULL DEFAULT 50 COMMENT '排序',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '视频分类列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_qlive_category_list
-- ----------------------------
INSERT INTO `eacoo_qlive_category_list` VALUES (1, 0, '听力筛选', 50, 1, '2019-03-19 15:46:38', '2019-03-19 16:17:36');
INSERT INTO `eacoo_qlive_category_list` VALUES (2, 0, '听力诊断', 50, 1, '2019-03-19 16:05:20', '2019-03-19 16:05:20');
INSERT INTO `eacoo_qlive_category_list` VALUES (3, 0, '助听器验配', 50, 1, '2019-03-19 16:05:32', '2019-03-19 16:05:32');
INSERT INTO `eacoo_qlive_category_list` VALUES (4, 0, '平衡诊断', 50, 1, '2019-03-19 16:05:45', '2019-03-19 16:05:45');
INSERT INTO `eacoo_qlive_category_list` VALUES (5, 0, '数据平台', 50, 1, '2019-03-19 16:05:56', '2019-03-19 16:05:56');
INSERT INTO `eacoo_qlive_category_list` VALUES (6, 0, '其他', 50, 1, '2019-03-19 16:06:56', '2019-03-19 16:06:56');

-- ----------------------------
-- Table structure for eacoo_qlive_room_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_room_list`;
CREATE TABLE `eacoo_qlive_room_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'room_id',
  `stream` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '推流地址',
  `anchor_id` int(11) NULL DEFAULT NULL COMMENT '主播id',
  `room_status` tinyint(1) NULL DEFAULT NULL COMMENT '1=直播中,0=停播中',
  `marks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '直播房间列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for eacoo_rewrite
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_rewrite`;
CREATE TABLE `eacoo_rewrite`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id自增',
  `rule` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'url',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '更新时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态：0禁用，1启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '伪静态表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for eacoo_term_relationships
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_term_relationships`;
CREATE TABLE `eacoo_term_relationships`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'posts表里文章id',
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分类id',
  `table` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '数据表',
  `uid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '分类与用户关系',
  `create_time` datetime(0) NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT 99 COMMENT '排序，值越小越靠前',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态，1发布，0不发布',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_term_id`(`term_id`) USING BTREE,
  INDEX `idx_object_id`(`object_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '对象分类对应表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_term_relationships
-- ----------------------------
INSERT INTO `eacoo_term_relationships` VALUES (1, 95, 9, 'attachment', 1, '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_term_relationships` VALUES (2, 94, 13, 'attachment', 1, '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_term_relationships` VALUES (3, 116, 12, 'attachment', 1, '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_term_relationships` VALUES (4, 92, 12, 'attachment', 1, '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_term_relationships` VALUES (5, 70, 12, 'attachment', 1, '2018-09-30 22:32:26', 9, 1);
INSERT INTO `eacoo_term_relationships` VALUES (6, 93, 11, 'attachment', 1, '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_term_relationships` VALUES (7, 96, 12, 'attachment', 1, '2018-09-30 22:32:26', 99, 1);

-- ----------------------------
-- Table structure for eacoo_terms
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_terms`;
CREATE TABLE `eacoo_terms`  (
  `term_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分类名称',
  `slug` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类别名',
  `taxonomy` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类类型',
  `pid` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '上级ID',
  `seo_title` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'seo 关键词',
  `seo_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'seo描述',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '更新时间',
  `sort` mediumint(8) UNSIGNED NULL DEFAULT 99 COMMENT '排序，值越小越靠前',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态，1发布，0不发布',
  PRIMARY KEY (`term_id`) USING BTREE,
  INDEX `idx_taxonomy`(`taxonomy`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分类' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_terms
-- ----------------------------
INSERT INTO `eacoo_terms` VALUES (1, '未分类', 'nocat', 'post_category', 0, '未分类', '', '自定义分类描述', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_terms` VALUES (4, '大数据', 'tag_dashuju', 'post_tag', 0, '大数据', '', '这是标签描述', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, -1);
INSERT INTO `eacoo_terms` VALUES (5, '技术类', 'technology', 'post_category', 0, '技术类', '关键词', '自定义分类描述', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, -1);
INSERT INTO `eacoo_terms` VALUES (7, '运营', 'yunying', 'post_tag', 0, '运营', '关键字', '自定义标签描述', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_terms` VALUES (9, '人物', 'renwu', 'media_cat', 0, '人物', '', '聚集多为人物显示的分类', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_terms` VALUES (10, '美食', 'meishi', 'media_cat', 0, '美食', '', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_terms` VALUES (11, '图标素材', 'icons', 'media_cat', 0, '图标素材', '', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_terms` VALUES (12, '风景', 'fengjin', 'media_cat', 0, '风景', '风景', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);
INSERT INTO `eacoo_terms` VALUES (13, '其它', 'others', 'media_cat', 0, '其它', '', '', '2018-09-30 22:32:26', '2018-09-30 22:32:26', 99, 1);

-- ----------------------------
-- Table structure for eacoo_themes
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_themes`;
CREATE TABLE `eacoo_themes`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(127) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `author` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '开发者',
  `version` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '版本',
  `config` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '主题配置',
  `current` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '当前主题类型，1PC端，2手机端。默认0',
  `website` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '站点',
  `sort` tinyint(4) UNSIGNED NOT NULL DEFAULT 99 COMMENT '排序，值越小越靠前',
  `create_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '更新时间',
  `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '前台主题表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_themes
-- ----------------------------
INSERT INTO `eacoo_themes` VALUES (1, 'default', '默认主题', '内置于系统中，是其它主题的基础主题', '心云间、凝听', '1.0.2', '', 1, 'https://www.eacoophp.com', 99, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_themes` VALUES (2, 'default-mobile', '默认主题-手机端', '内置于系统中，是系统的默认主题。手机端', '心云间、凝听', '1.0.1', '', 2, '', 99, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);

-- ----------------------------
-- Table structure for eacoo_user_level
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_user_level`;
CREATE TABLE `eacoo_user_level`  (
  `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '等级名称',
  `description` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态。0禁用，1启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户等级表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for eacoo_users
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_users`;
CREATE TABLE `eacoo_users`  (
  `uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '前台用户ID',
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `number` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '会员编号',
  `password` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '登录密码',
  `nickname` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `avatar` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '用户头像，相对于uploads/avatar目录',
  `sex` smallint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '性别；0：保密，1：男；2：女',
  `birthday` date NOT NULL COMMENT '生日',
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '个人描述',
  `register_ip` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '注册IP',
  `login_num` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录次数',
  `last_login_ip` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_login_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '最后登录时间',
  `activation_auth_sign` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '激活码',
  `url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '用户个人网站',
  `score` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户积分',
  `money` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '金额',
  `freeze_money` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '冻结金额，和金币相同换算',
  `pay_pwd` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '支付密码',
  `reg_from` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '注册来源。1PC端，2WAP端，3微信端，4APP端，5后台添加',
  `reg_method` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '注册方式。wechat,sina,等',
  `level` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '等级，关联表user_level主键',
  `p_uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '推荐人会员ID',
  `is_lock` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否锁定。0否，1是',
  `actived` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否激活，0否，1是',
  `reg_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '注册时间',
  `update_time` datetime(0) NOT NULL DEFAULT '0001-01-01 00:00:00' COMMENT '更新时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '用户状态 0：禁用； 1：正常 ；',
  PRIMARY KEY (`uid`) USING BTREE,
  UNIQUE INDEX `uniq_number`(`number`) USING BTREE,
  INDEX `idx_username`(`username`) USING BTREE,
  INDEX `idx_email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户会员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_users
-- ----------------------------
INSERT INTO `eacoo_users` VALUES (1, 'admin', '5257975351', '031c9ffc4b280d3e78c750163d07d275', '站长', '981248356@qq.com', '15801182251', 'http://cdn.eacoo.xin/attachment/static/assets/img/default-avatar.png', 1, '0000-00-00', '网站创始人和超级管理员。1', '', 0, '127.0.0.1', '2018-10-30 23:37:51', 'e2847283eb09508cfe0db793e5a90ad53b1b570b', 'https://www.eacoophp.com', 100, 100.00, 0.00, 'eba6095468eb32492d20d5db6a85aa5d', 0, '', 0, 0, 0, 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_users` VALUES (3, 'U1471610993', '9948511005', '031c9ffc4b280d3e78c750163d07d275', '陈婧', '', '', '/static/assets/img/avatar-woman.png', 2, '0000-00-00', '', '', 0, '', '2018-09-30 22:32:26', 'a525c9259ff2e51af1b6e629dd47766f99f26c69', '', 0, 2.00, 0.00, '', 0, '', 0, 0, 0, 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_users` VALUES (4, 'U1472438063', '9752985498', '031c9ffc4b280d3e78c750163d07d275', '妍冰', '', '', '/static/assets/img/avatar-woman.png', 2, '0000-00-00', '承接大型商业演出和传统文化学习班', '', 0, '', '2018-09-30 22:32:26', 'ed587cf103c3f100be20f7b8fdc7b5a8e2fda264', '', 0, 0.00, 0.00, '', 0, '', 0, 0, 0, 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0);
INSERT INTO `eacoo_users` VALUES (5, 'U1472522409', '9849571025', '031c9ffc4b280d3e78c750163d07d275', '久柳', '', '', '/static/assets/img/avatar-man.png', 1, '0000-00-00', '', '', 0, '', '2018-09-30 22:32:26', '5e542dc0c77b3749f2270cb3ec1d91acc895edc8', '', 0, 0.00, 0.00, '', 0, '', 0, 0, 0, 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_users` VALUES (6, 'U1472739566', '5051101100', '031c9ffc4b280d3e78c750163d07d275', 'Ray', '', '', '/uploads/avatar/6/5a8ada8f72ac0.jpg', 1, '0000-00-00', '', '', 0, '', '2018-09-30 22:32:26', '6321b4d8ecb1ce1049eab2be70c44335856c840d', '', 0, 0.00, 0.00, '', 0, '', 0, 0, 0, 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_users` VALUES (8, 'U1472877421', '5497481009', '031c9ffc4b280d3e78c750163d07d275', '印文博律师', '', '', '/static/assets/img/avatar-man.png', 1, '0000-00-00', '', '', 0, '', '2018-09-30 22:32:26', 'e99521af40a282e84718f759ab6b1b4a989d8eb1', '', 0, 0.00, 0.00, '', 0, '', 0, 0, 0, 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 0);
INSERT INTO `eacoo_users` VALUES (9, 'U1472966655', '1004810149', '031c9ffc4b280d3e78c750163d07d275', '嘉伟', '', '', '/static/assets/img/avatar-man.png', 1, '0000-00-00', '', '', 0, '', '2018-09-30 22:32:26', 'f1075223be5f53b9c2c1abea8288258545365d96', '', 0, 0.00, 0.00, '', 0, '', 0, 0, 0, 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_users` VALUES (10, 'U1473304718', '9852101101', '031c9ffc4b280d3e78c750163d07d275', '鬼谷学猛虎流', '', '15801182191', '/static/assets/img/avatar-man.png', 1, '0000-00-00', '', '', 0, '', '2018-09-30 22:32:26', '039fc7a3f9366adf55ee9e707c371a2459c17bd7', '', 0, 0.00, 0.00, '', 0, '', 0, 0, 0, 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_users` VALUES (11, 'U1473391063', '1004810150', '031c9ffc4b280d3e78c750163d07d275', '@Gyb.', '', '', '/uploads/avatar/11/59e32aa3a75a2.jpg', 1, '0000-00-00', '', '', 0, '', '2018-09-30 22:32:26', '70d80a9f7599c81270a986abaea73e63101b3ecb', '', 0, 0.00, 0.00, '', 0, '', 0, 0, 0, 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_users` VALUES (12, 'U1473396778', '5310148501', '031c9ffc4b280d3e78c750163d07d275', '董超楠', '', '', '/static/assets/img/avatar-woman.png', 2, '0000-00-00', '', '', 0, '', '2018-09-30 22:32:26', '8bbf5242300e5e8e4917b287a31efcb0c9feedfd', '', 0, 0.00, 0.00, '', 0, '', 0, 0, 0, 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_users` VALUES (14, 'U1473396839', '4853979757', '031c9ffc4b280d3e78c750163d07d275', '求真实者', '', '', '/static/assets/img/default-avatar.png', 0, '0000-00-00', '', '', 0, '', '2018-09-30 22:32:26', '8f7579a85981e1c1f726704b0865320dfadbef2e', '', 0, 0.00, 0.00, '', 0, '', 0, 0, 0, 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_users` VALUES (15, 'U1473397391', '9810148101', '031c9ffc4b280d3e78c750163d07d275', 'peter', '', '', '/uploads/avatar/15/5a9d1473d4c91.png', 2, '0000-00-00', '', '', 0, '', '2018-09-30 22:32:26', 'c66d3a0e16a81a13173756a2832ba424b34a095c', '', 0, 0.00, 0.00, '', 0, '', 0, 0, 0, 1, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_users` VALUES (16, 'U1473397426', '1015057995', '031c9ffc4b280d3e78c750163d07d275', '随风而去的心情', '', '15801182190', '/static/assets/img/avatar-man.png', 1, '0000-00-00', '大师傅', '', 0, '', '2018-09-30 22:32:26', '14855b00775de46b451c8255e6a73a5c044fc188', '', 0, 0.00, 0.00, '', 0, '', 0, 0, 0, 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);
INSERT INTO `eacoo_users` VALUES (17, 'U1474181145', '5551564851', '031c9ffc4b280d3e78c750163d07d275', '班鱼先生', '', '', '/static/assets/img/avatar-man.png', 1, '0000-00-00', '', '', 0, '', '2018-09-30 22:32:26', '86d19a7b1f15db4fd25e0b64bfc17870a70f67e2', '', 0, 0.00, 0.00, '', 0, '', 0, 0, 0, 0, '2018-09-30 22:32:26', '2018-09-30 22:32:26', 1);

SET FOREIGN_KEY_CHECKS = 1;
