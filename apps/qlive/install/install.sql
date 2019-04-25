/*
 Navicat Premium Data Transfer

 Source Server         : 企牛牛阿里测试服
 Source Server Type    : MySQL
 Source Server Version : 50643
 Source Host           : 139.196.30.162:3306
 Source Schema         : live_qiniuniu_co

 Target Server Type    : MySQL
 Target Server Version : 50643
 File Encoding         : 65001

 Date: 25/04/2019 08:53:28
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for eacoo_qlive_anchor_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_anchor_list`;
CREATE TABLE `eacoo_qlive_anchor_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NULL DEFAULT NULL COMMENT '关联前台用户id',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '直播姓名',
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '昵称',
  `sex` tinyint(4) NULL DEFAULT NULL COMMENT '1=男,2=女,0=保密',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '手机号',
  `idcard_face` int(11) NOT NULL COMMENT '身份证人像文件id',
  `idcard_emblem` int(11) NOT NULL COMMENT '身份证国徽文件id',
  `room_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '主播房间id',
  `status` tinyint(1) NULL DEFAULT 2 COMMENT '0=禁用,1=启用,2=申请中,3=禁播,4=正常可开播',
  `marks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '主播列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_anchor_list
-- ----------------------------
INSERT INTO `eacoo_qlive_anchor_list` VALUES (1, 5, 'kakaer', '卡尔', 1, 'kaer@163.com', '16388888888', 5, 4, '1', 4, '虎牙一哥哦', '2019-03-21 14:14:30', '2019-04-16 11:37:47');
INSERT INTO `eacoo_qlive_anchor_list` VALUES (2, 9, 'maweiwei', '马薇薇', 1, '', '', 0, 0, '4', 4, '', '2019-04-18 13:45:07', '2019-04-18 13:45:07');
INSERT INTO `eacoo_qlive_anchor_list` VALUES (3, 10, '白洁', '小白', 2, '617379916@qq.com', '18252772670', 0, 0, '5', 4, '3333', '2019-04-19 14:27:41', '2019-04-19 14:27:41');
INSERT INTO `eacoo_qlive_anchor_list` VALUES (4, 7, '17601573648', '17601573648', 1, 'i@iiong.com', '17601573648', 0, 0, '3', 4, '我要申请主播！', '2019-04-23 13:40:40', '2019-04-23 13:40:40');

-- ----------------------------
-- Table structure for eacoo_qlive_apprise_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_apprise_list`;
CREATE TABLE `eacoo_qlive_apprise_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '预告标题',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '直播海报',
  `lecturer` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '主播人',
  `category` int(11) NULL DEFAULT NULL COMMENT '直播分类',
  `live_type` int(11) NULL DEFAULT NULL COMMENT '直播类型',
  `start_time` datetime(0) NULL DEFAULT NULL COMMENT '开始时间',
  `short_content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '简介',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=禁用,1=启用',
  `flag` tinyint(1) NULL DEFAULT NULL COMMENT '标记',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '直播预告列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_apprise_list
-- ----------------------------
INSERT INTO `eacoo_qlive_apprise_list` VALUES (1, '直播预告', '7', '1', 5, 1, '2019-04-26 09:00:00', 'ap剑圣教学', 1, 3, '2019-03-21 16:52:43', '2019-04-17 09:09:10');
INSERT INTO `eacoo_qlive_apprise_list` VALUES (2, '用新型ProbeTube Assistant ™在Aurical中放置无忧探针管', '7', '1', 1, 2, '2019-04-30 16:30:41', '耳贝思（OTObase）可快速、简单、安全的将患者听觉数据与电子病历系统（EMR）连接。', 1, 1, '2019-04-02 16:14:53', '2019-04-17 09:09:16');
INSERT INTO `eacoo_qlive_apprise_list` VALUES (3, '直播测试一', '7', '1', 5, 2, '2019-04-18 13:41:58', '直播测试一直播测试一直播测试一直播测试一', 1, 2, '2019-04-18 13:42:23', '2019-04-18 13:42:23');
INSERT INTO `eacoo_qlive_apprise_list` VALUES (4, '直播测试二', '7', '2', 2, 4, '2019-04-18 13:56:41', '直播测试二直播测试二直播测试二', 1, 3, '2019-04-18 13:56:58', '2019-04-18 13:56:58');
INSERT INTO `eacoo_qlive_apprise_list` VALUES (5, '这是第三个测试', '7', '2', 3, 2, '2019-04-18 14:09:57', '这是第三个测试这是第三个测试这是第三个测试', 1, 2, '2019-04-18 14:10:16', '2019-04-18 14:26:51');
INSERT INTO `eacoo_qlive_apprise_list` VALUES (6, '小 白要直播', '8', '3', 6, 1, '2019-04-20 15:00:52', '小 白要直播小 白要直播', 1, 1, '2019-04-19 15:17:03', '2019-04-19 15:17:03');

-- ----------------------------
-- Table structure for eacoo_qlive_bill
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_bill`;
CREATE TABLE `eacoo_qlive_bill`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `live_id` int(11) NOT NULL COMMENT '直播id',
  `price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '下单时的价格',
  `status` tinyint(1) NULL DEFAULT NULL COMMENT '备用',
  `marks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备用',
  `create_time` datetime(0) NOT NULL,
  `update_time` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_bill
-- ----------------------------
INSERT INTO `eacoo_qlive_bill` VALUES (1, 5, 1, 10.00, NULL, NULL, '2019-04-17 15:46:17', '2019-04-17 15:46:19');

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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分类列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_category_list
-- ----------------------------
INSERT INTO `eacoo_qlive_category_list` VALUES (1, 0, '听力筛选', 50, 1, '2019-03-19 15:46:38', '2019-03-19 16:17:36');
INSERT INTO `eacoo_qlive_category_list` VALUES (2, 0, '听力诊断', 50, 1, '2019-03-19 16:05:20', '2019-03-19 16:05:20');
INSERT INTO `eacoo_qlive_category_list` VALUES (3, 0, '助听器验配', 50, 1, '2019-03-19 16:05:32', '2019-03-19 16:05:32');
INSERT INTO `eacoo_qlive_category_list` VALUES (4, 0, '平衡诊断', 50, 1, '2019-03-19 16:05:45', '2019-03-19 16:05:45');
INSERT INTO `eacoo_qlive_category_list` VALUES (5, 0, '数据平台', 50, 1, '2019-03-19 16:05:56', '2019-03-19 16:05:56');
INSERT INTO `eacoo_qlive_category_list` VALUES (6, 0, '其他', 50, 1, '2019-03-19 16:06:56', '2019-04-19 15:23:46');

-- ----------------------------
-- Table structure for eacoo_qlive_comment_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_comment_list`;
CREATE TABLE `eacoo_qlive_comment_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `live_id` int(11) NOT NULL COMMENT '直播记录ID',
  `anchor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '主播',
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评论内容',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=显示,0=不显示',
  `create_time` datetime(0) NOT NULL,
  `update_time` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '评论列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_comment_list
-- ----------------------------
INSERT INTO `eacoo_qlive_comment_list` VALUES (3, 7, '卡尔', '18252772670', '非常好的课程', 1, '2019-04-19 14:02:14', '2019-04-19 14:02:14');
INSERT INTO `eacoo_qlive_comment_list` VALUES (4, 7, '卡尔', '18252772670', '非常好的课程666', 1, '2019-04-19 14:14:48', '2019-04-19 14:14:48');
INSERT INTO `eacoo_qlive_comment_list` VALUES (5, 9, '卡尔', '18252772670', '好', 1, '2019-04-19 14:23:14', '2019-04-19 14:23:14');
INSERT INTO `eacoo_qlive_comment_list` VALUES (6, 7, '卡尔', '18252772670', '好', 1, '2019-04-19 14:23:32', '2019-04-19 14:23:32');
INSERT INTO `eacoo_qlive_comment_list` VALUES (7, 7, '卡尔', '18252772670', '好\n', 1, '2019-04-19 14:23:48', '2019-04-19 14:23:48');
INSERT INTO `eacoo_qlive_comment_list` VALUES (8, 8, '卡尔', '18252772670', '666', 1, '2019-04-19 14:23:59', '2019-04-19 14:23:59');
INSERT INTO `eacoo_qlive_comment_list` VALUES (9, 9, '卡尔', '18252772670', '666', 1, '2019-04-19 14:24:11', '2019-04-19 14:24:11');
INSERT INTO `eacoo_qlive_comment_list` VALUES (10, 7, '卡尔', '18252772670', '2333', 1, '2019-04-19 15:01:29', '2019-04-19 15:01:29');
INSERT INTO `eacoo_qlive_comment_list` VALUES (11, 1, '卡尔', '17601573648', '添加评论', 1, '2019-04-19 15:11:21', '2019-04-19 15:11:21');
INSERT INTO `eacoo_qlive_comment_list` VALUES (12, 1, '卡尔', '17601573648', '', 1, '2019-04-22 17:08:13', '2019-04-22 17:08:13');
INSERT INTO `eacoo_qlive_comment_list` VALUES (13, 1, '卡尔', '17601573648', '', 1, '2019-04-22 17:08:18', '2019-04-22 17:08:18');
INSERT INTO `eacoo_qlive_comment_list` VALUES (14, 1, '卡尔', '17601573648', '', 1, '2019-04-22 17:10:15', '2019-04-22 17:10:15');
INSERT INTO `eacoo_qlive_comment_list` VALUES (15, 7, '卡尔', '18252772670', '短短的反反复复', 1, '2019-04-23 11:51:52', '2019-04-23 11:51:52');
INSERT INTO `eacoo_qlive_comment_list` VALUES (16, 7, '卡尔', '18252772670', '66666', 0, '2019-04-23 11:52:10', '2019-04-23 11:52:10');

-- ----------------------------
-- Table structure for eacoo_qlive_live_history
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_live_history`;
CREATE TABLE `eacoo_qlive_live_history`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `anchor_id` int(11) NULL DEFAULT NULL COMMENT '主播id,之前都是用的nickname,防止改名之后的混乱',
  `anchor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主播名称',
  `room_id` int(11) NOT NULL COMMENT '房间ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '房间标题',
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '房间封面',
  `category` int(11) NULL DEFAULT NULL COMMENT '直播分类',
  `live_type` int(11) NULL DEFAULT NULL COMMENT '直播类型',
  `schedule` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '课程安排',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '房间介绍',
  `price` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '价格',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '房间密码',
  `commentable` tinyint(1) NULL DEFAULT 1 COMMENT '1=可评论,0=不可评论',
  `can_ask` tinyint(1) NULL DEFAULT 1 COMMENT '1=可提问,0=不可评论',
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件下载',
  `open_time` datetime(0) NULL DEFAULT NULL COMMENT '开播时间',
  `flag` tinyint(1) NULL DEFAULT NULL COMMENT '标记',
  `status` tinyint(1) NULL DEFAULT 2 COMMENT '0=拒绝,1=通过,2=未处理,',
  `hits` int(11) NOT NULL DEFAULT 0 COMMENT '点击数',
  `sales` int(11) NOT NULL DEFAULT 0 COMMENT '销量',
  `create_time` datetime(0) NOT NULL,
  `update_time` datetime(0) NOT NULL,
  `apprise_id` int(11) NULL DEFAULT NULL COMMENT '直播预告关联的id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '开播申请表,开播历史记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_live_history
-- ----------------------------
INSERT INTO `eacoo_qlive_live_history` VALUES (1, NULL, '卡尔', 1, '开播测试', '7', 1, 3, NULL, '测试一下', 100.00, '888888', 1, 1, NULL, '2019-03-27 16:02:04', NULL, 1, 113, 10, '0000-00-00 00:00:00', '2019-03-28 11:11:06', NULL);
INSERT INTO `eacoo_qlive_live_history` VALUES (7, NULL, '卡尔', 1, '用新型ProbeTube Assistant ™在Aurical中放置无忧探针管', '7', 1, 2, NULL, '', 80.00, NULL, 1, 1, NULL, '2019-04-30 16:30:41', 2, 1, 53, 20, '2019-04-09 11:08:50', '2019-04-17 09:09:16', 2);
INSERT INTO `eacoo_qlive_live_history` VALUES (8, NULL, '卡尔', 1, '直播预告', '7', 5, 1, NULL, '', 10.00, NULL, 1, 1, NULL, '2019-04-24 08:56:26', 4, 1, 31, 30, '2019-04-03 15:47:15', '2019-04-24 08:56:34', 1);
INSERT INTO `eacoo_qlive_live_history` VALUES (9, NULL, '卡尔', 1, '开播申请接口测试', '7', 1, 1, NULL, '开播申请接口测试的描述', 0.00, '', 1, 1, '', '2019-04-20 10:30:00', 3, 1, 0, 0, '2019-04-16 14:30:55', '2019-04-17 15:54:44', NULL);
INSERT INTO `eacoo_qlive_live_history` VALUES (10, NULL, '卡尔', 1, '直播测试一', '7', 5, 2, NULL, NULL, 0.00, NULL, 1, 1, NULL, '2019-04-18 13:41:58', NULL, 1, 9, 0, '2019-04-18 13:42:23', '2019-04-18 13:42:23', 3);
INSERT INTO `eacoo_qlive_live_history` VALUES (11, NULL, '马薇薇', 2, '直播测试二', '7', 2, 4, NULL, NULL, 0.00, NULL, 1, 1, NULL, '2019-04-18 13:56:41', NULL, 1, 2, 0, '2019-04-18 13:56:58', '2019-04-18 13:56:58', 4);
INSERT INTO `eacoo_qlive_live_history` VALUES (12, NULL, '马薇薇', 2, '这是第三个测试', '7', 3, 2, NULL, NULL, 0.00, NULL, 1, 1, NULL, '2019-04-18 14:09:57', NULL, 1, 9, 0, '2019-04-18 14:10:16', '2019-04-18 14:26:51', 5);
INSERT INTO `eacoo_qlive_live_history` VALUES (13, NULL, '小白', 5, '小 白要直播', '8', 6, 1, NULL, NULL, 0.00, NULL, 1, 1, NULL, '2019-04-20 15:00:52', NULL, 1, 9, 0, '2019-04-19 15:17:03', '2019-04-19 15:17:03', 6);
INSERT INTO `eacoo_qlive_live_history` VALUES (14, 4, '17601573648', 3, '测试12', '11', 2, 2, '测试测试测试测试测试测试测试测试测试测试测试测试测试', '测试测试测试测试测试测试测试测试测试测试测试测试', 1212.00, '121212', 1, 1, '', '2019-04-24 16:00:00', 1, 2, 1, 0, '2019-04-24 09:49:01', '2019-04-24 16:59:57', NULL);
INSERT INTO `eacoo_qlive_live_history` VALUES (15, NULL, '17601573648', 3, '测试1', '12', 6, 3, '测试1', '测试1测试1测试1测试1测试1', 12.00, '12121', 1, 1, '', '2019-04-26 16:00:00', 0, 0, 0, 0, '2019-04-24 09:51:27', '2019-04-24 10:25:22', NULL);
INSERT INTO `eacoo_qlive_live_history` VALUES (16, NULL, '17601573648', 3, '测试直播2', '13', 2, 3, '测试直播2测试直播2测试直播2测试直播2测试直播2测试直播2测试直播2', '测试直播2', 2222.00, '2222', 1, 1, '', '2019-04-26 16:00:00', NULL, 2, 0, 0, '2019-04-24 10:27:14', '2019-04-24 10:27:14', NULL);

-- ----------------------------
-- Table structure for eacoo_qlive_post_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_post_list`;
CREATE TABLE `eacoo_qlive_post_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `thumbnail` int(10) NULL DEFAULT NULL COMMENT '缩略图',
  `category` tinyint(1) NOT NULL COMMENT '分类id',
  `short_content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '简介',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `publisher` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '发布者',
  `hits` int(10) NOT NULL DEFAULT 100 COMMENT '点击量',
  `is_top` tinyint(1) NOT NULL COMMENT '1=是,0=否',
  `status` tinyint(1) NOT NULL COMMENT '1=开启,0=关闭',
  `order` int(10) NOT NULL COMMENT '排序',
  `create_time` datetime(0) NOT NULL,
  `update_time` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '直播模块的文章列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_post_list
-- ----------------------------
INSERT INTO `eacoo_qlive_post_list` VALUES (1, '文章测试', 24, 1, '测试', '<p></p><p></p><p>你说什么,<span style=\"font-family: FangSong; background-color: rgb(0, 102, 0);\"><strong><em>你再说一遍</em></strong></span><br></p><p>\r\n	<span style=\"font-family:FangSong;\"><strong><em><span>,</span><span style=\"font-family:FangSong;font-size:24px;line-height:1.5;\"><strong><em>你再<span style=\"color:#E56600;\">说一遍</span><span style=\"color:#E56600;\"></span></em></strong></span><span style=\"font-size:24px;line-height:1.5;\"></span><br>\r\n</em></strong></span> \r\n</p><p>\r\n	<span style=\"font-family:FangSong;\"><strong><em><span style=\"font-size:24px;line-height:1.5;\"><img src=\"http://www.live.gov/static/libs/nkeditor/plugins/emoticons/images/11.gif\" border=\"0\" alt=\"\"><br>\r\n</span></em></strong></span> \r\n</p><p>\r\n	<span style=\"font-family:FangSong;\"><strong><em><span style=\"font-size:24px;line-height:1.5;\"> </span></em></strong></span> \r\n</p><hr><p><br></p>', 'admin', 0, 0, 1, 99, '2019-03-26 09:58:28', '2019-03-28 17:36:58');
INSERT INTO `eacoo_qlive_post_list` VALUES (2, '文章简介', 7, 2, '文章简介文章简介文章简介', '<p>文章简介文章简介文章简介文章简介文章简介</p>', 'admin', 100, 1, 1, 1, '2019-04-18 14:07:13', '2019-04-18 14:07:13');
INSERT INTO `eacoo_qlive_post_list` VALUES (3, '直播设计', 9, 3, '直播设计直播设计', '<p>直播设计直播设计直播设计直播设计直播设计直播设计</p>', 'admin', 100, 1, 1, 5, '2019-04-19 15:18:13', '2019-04-19 15:18:13');

-- ----------------------------
-- Table structure for eacoo_qlive_question_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_question_list`;
CREATE TABLE `eacoo_qlive_question_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `live_id` int(11) NOT NULL COMMENT '对应直播',
  `anchor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主播名称',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `question` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '提问内容',
  `answer` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '回答内容',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '默认不显示,0=不显示,1=显示',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '提直播的问列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_question_list
-- ----------------------------
INSERT INTO `eacoo_qlive_question_list` VALUES (1, 8, 'wenxuan', 'admin', '我想到一个问题', '你说', 1, '2019-04-04 14:51:58', '2019-04-04 14:51:58');
INSERT INTO `eacoo_qlive_question_list` VALUES (2, 8, 'wenxuan', 'admin', '还有一个问题', '这是回答', 1, '2019-04-04 15:37:06', '2019-04-04 15:37:06');
INSERT INTO `eacoo_qlive_question_list` VALUES (3, 1, '卡尔', '卡尔', '你猜我想不想提问?', '你猜我想不想回答?', 1, '2019-04-11 14:42:15', '2019-04-11 14:42:15');
INSERT INTO `eacoo_qlive_question_list` VALUES (4, 1, '卡尔', '卡尔', '我想打篮球', '我是回答', 1, '2019-04-11 14:58:10', '2019-04-11 14:58:10');
INSERT INTO `eacoo_qlive_question_list` VALUES (5, 1, '卡尔', '17601573648', '121212', '我是回答', 1, '2019-04-19 14:53:06', '2019-04-19 14:53:06');
INSERT INTO `eacoo_qlive_question_list` VALUES (6, 1, '卡尔', '17601573648', '添加问题', '我是回答', 1, '2019-04-19 14:59:41', '2019-04-19 14:59:41');
INSERT INTO `eacoo_qlive_question_list` VALUES (7, 1, '卡尔', '17601573648', '添加问题', '我是回答', 1, '2019-04-19 15:00:10', '2019-04-19 15:00:10');
INSERT INTO `eacoo_qlive_question_list` VALUES (8, 7, '卡尔', '18252772670', '23333', NULL, 0, '2019-04-19 15:01:43', '2019-04-19 15:01:43');
INSERT INTO `eacoo_qlive_question_list` VALUES (9, 7, '卡尔', '18252772670', '还可以重播吗', NULL, 0, '2019-04-19 15:02:19', '2019-04-19 15:02:19');
INSERT INTO `eacoo_qlive_question_list` VALUES (10, 7, '卡尔', '18252772670', '111', NULL, 0, '2019-04-19 15:04:24', '2019-04-19 15:04:24');
INSERT INTO `eacoo_qlive_question_list` VALUES (11, 1, '卡尔', '17601573648', '添加活动', NULL, 0, '2019-04-19 15:06:25', '2019-04-19 15:06:25');
INSERT INTO `eacoo_qlive_question_list` VALUES (12, 1, '卡尔', '17601573648', '测试评论', NULL, 0, '2019-04-19 15:06:33', '2019-04-19 15:06:33');
INSERT INTO `eacoo_qlive_question_list` VALUES (13, 8, '卡尔', '18252772670', '还能免费观看吗', NULL, 0, '2019-04-19 15:07:03', '2019-04-19 15:07:03');
INSERT INTO `eacoo_qlive_question_list` VALUES (14, 1, '卡尔', '17601573648', '添加评论', NULL, 0, '2019-04-19 15:07:37', '2019-04-19 15:07:37');
INSERT INTO `eacoo_qlive_question_list` VALUES (15, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:18', '2019-04-19 15:09:18');
INSERT INTO `eacoo_qlive_question_list` VALUES (16, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:21', '2019-04-19 15:09:21');
INSERT INTO `eacoo_qlive_question_list` VALUES (17, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:23', '2019-04-19 15:09:23');
INSERT INTO `eacoo_qlive_question_list` VALUES (18, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:23', '2019-04-19 15:09:23');
INSERT INTO `eacoo_qlive_question_list` VALUES (19, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:24', '2019-04-19 15:09:24');
INSERT INTO `eacoo_qlive_question_list` VALUES (20, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:26', '2019-04-19 15:09:26');
INSERT INTO `eacoo_qlive_question_list` VALUES (21, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:27', '2019-04-19 15:09:27');
INSERT INTO `eacoo_qlive_question_list` VALUES (22, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:34', '2019-04-19 15:09:34');
INSERT INTO `eacoo_qlive_question_list` VALUES (23, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:34', '2019-04-19 15:09:34');
INSERT INTO `eacoo_qlive_question_list` VALUES (24, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:34', '2019-04-19 15:09:34');
INSERT INTO `eacoo_qlive_question_list` VALUES (25, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:35', '2019-04-19 15:09:35');
INSERT INTO `eacoo_qlive_question_list` VALUES (26, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:35', '2019-04-19 15:09:35');
INSERT INTO `eacoo_qlive_question_list` VALUES (27, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:35', '2019-04-19 15:09:35');
INSERT INTO `eacoo_qlive_question_list` VALUES (28, 7, '卡尔', '18252772670', '00', NULL, 0, '2019-04-19 15:09:35', '2019-04-19 15:09:35');
INSERT INTO `eacoo_qlive_question_list` VALUES (29, 1, '卡尔', '17601573648', '12121212', '23333333333', 0, '2019-04-22 14:48:51', '2019-04-22 14:48:51');
INSERT INTO `eacoo_qlive_question_list` VALUES (30, 1, '卡尔', '17601573648', '12121212', '23333333333', 0, '2019-04-22 14:48:52', '2019-04-22 14:48:52');
INSERT INTO `eacoo_qlive_question_list` VALUES (31, 1, '卡尔', '17601573648', '12121212', '23333333333', 0, '2019-04-22 14:48:53', '2019-04-22 14:48:53');
INSERT INTO `eacoo_qlive_question_list` VALUES (32, 1, '卡尔', '17601573648', '12121212', '23333333333', 0, '2019-04-22 14:48:53', '2019-04-22 14:48:53');
INSERT INTO `eacoo_qlive_question_list` VALUES (33, 1, '卡尔', '17601573648', '121212121212121212', '23333333333', 0, '2019-04-22 14:48:56', '2019-04-22 14:48:56');
INSERT INTO `eacoo_qlive_question_list` VALUES (34, 1, '卡尔', '17601573648', '121212121212121212', '23333333333', 0, '2019-04-22 14:48:56', '2019-04-22 14:48:56');
INSERT INTO `eacoo_qlive_question_list` VALUES (35, 1, '卡尔', '17601573648', '121212121212121212', '23333333333', 0, '2019-04-22 14:48:56', '2019-04-22 14:48:56');
INSERT INTO `eacoo_qlive_question_list` VALUES (36, 1, '卡尔', '17601573648', '121212121212121212', '23333333333', 0, '2019-04-22 14:48:56', '2019-04-22 14:48:56');
INSERT INTO `eacoo_qlive_question_list` VALUES (37, 1, '卡尔', '17601573648', '121212121212121212', '23333333333', 0, '2019-04-22 14:48:57', '2019-04-22 14:48:57');
INSERT INTO `eacoo_qlive_question_list` VALUES (38, 1, '卡尔', '17601573648', '121212121212121212', '23333333333', 0, '2019-04-22 14:48:58', '2019-04-22 14:48:58');
INSERT INTO `eacoo_qlive_question_list` VALUES (39, 1, '卡尔', '17601573648', '121212121212121212', '23333333333', 0, '2019-04-22 14:48:58', '2019-04-22 14:48:58');
INSERT INTO `eacoo_qlive_question_list` VALUES (40, 1, '卡尔', '17601573648', '121212121212121212', '23333333333', 0, '2019-04-22 14:49:31', '2019-04-22 14:49:31');
INSERT INTO `eacoo_qlive_question_list` VALUES (41, 1, '卡尔', '17601573648', '测试', '23333333333', 0, '2019-04-22 14:50:21', '2019-04-22 14:50:21');
INSERT INTO `eacoo_qlive_question_list` VALUES (42, 1, '卡尔', '17601573648', '测试', NULL, 0, '2019-04-22 14:58:49', '2019-04-22 14:58:49');
INSERT INTO `eacoo_qlive_question_list` VALUES (43, 1, '卡尔', '17601573648', '测试问题！@', NULL, 0, '2019-04-22 15:26:41', '2019-04-22 15:26:41');
INSERT INTO `eacoo_qlive_question_list` VALUES (44, 1, '卡尔', '17601573648', '121212', NULL, 0, '2019-04-22 15:29:08', '2019-04-22 15:29:08');
INSERT INTO `eacoo_qlive_question_list` VALUES (45, 7, '卡尔', '17601573648', '测试', NULL, 0, '2019-04-23 10:07:13', '2019-04-23 10:07:13');
INSERT INTO `eacoo_qlive_question_list` VALUES (46, 7, '卡尔', '18252772670', '233', NULL, 0, '2019-04-23 11:53:57', '2019-04-23 11:53:57');
INSERT INTO `eacoo_qlive_question_list` VALUES (47, 7, '卡尔', '18252772670', '2333', NULL, 0, '2019-04-23 12:02:31', '2019-04-23 12:02:31');
INSERT INTO `eacoo_qlive_question_list` VALUES (48, 7, '卡尔', '18252772670', '666', NULL, 0, '2019-04-23 12:03:34', '2019-04-23 12:03:34');
INSERT INTO `eacoo_qlive_question_list` VALUES (49, 7, '卡尔', '18252772670', '666666', NULL, 0, '2019-04-23 12:04:44', '2019-04-23 12:04:44');
INSERT INTO `eacoo_qlive_question_list` VALUES (50, 7, '卡尔', '18252772670', '3333', NULL, 0, '2019-04-23 13:31:31', '2019-04-23 13:31:31');

-- ----------------------------
-- Table structure for eacoo_qlive_rate
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_rate`;
CREATE TABLE `eacoo_qlive_rate`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `live_id` int(11) NOT NULL COMMENT '直播历史id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `rate` decimal(4, 1) NOT NULL COMMENT '评分',
  `create_time` datetime(0) NOT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '直播评分表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_rate
-- ----------------------------
INSERT INTO `eacoo_qlive_rate` VALUES (1, 1, 5, 5.0, '2019-04-11 15:13:37', '2019-04-11 15:13:37');
INSERT INTO `eacoo_qlive_rate` VALUES (2, 1, 5, 3.0, '2019-04-11 15:16:18', '2019-04-11 15:16:18');
INSERT INTO `eacoo_qlive_rate` VALUES (3, 7, 5, 4.0, '2019-04-16 13:58:30', '2019-04-16 13:58:30');
INSERT INTO `eacoo_qlive_rate` VALUES (4, 1, 7, 4.0, '2019-04-17 15:32:54', '2019-04-17 15:32:54');
INSERT INTO `eacoo_qlive_rate` VALUES (5, 7, 8, 0.0, '2019-04-19 13:57:15', '2019-04-19 13:57:15');
INSERT INTO `eacoo_qlive_rate` VALUES (6, 9, 8, 5.0, '2019-04-19 14:23:14', '2019-04-19 14:23:14');
INSERT INTO `eacoo_qlive_rate` VALUES (7, 8, 8, 5.0, '2019-04-19 14:23:59', '2019-04-19 14:23:59');

-- ----------------------------
-- Table structure for eacoo_qlive_reply_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_reply_list`;
CREATE TABLE `eacoo_qlive_reply_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL COMMENT '评论id',
  `reply_id` int(11) NOT NULL COMMENT '回复目标id',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '回复内容',
  `from_uid` int(11) NOT NULL COMMENT '发布者id',
  `to_uid` int(11) NOT NULL COMMENT '目标用户id',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '回复评论表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_reply_list
-- ----------------------------
INSERT INTO `eacoo_qlive_reply_list` VALUES (1, 1, 0, '我是第一条回复', 5, 7, '2019-04-19 17:17:26', '2019-04-19 17:17:26');
INSERT INTO `eacoo_qlive_reply_list` VALUES (2, 1, 1, '回复第二条回复', 7, 5, '2019-04-22 10:22:09', '2019-04-22 10:22:11');
INSERT INTO `eacoo_qlive_reply_list` VALUES (3, 1, 2, '回复第三条回复', 5, 7, '2019-04-22 10:47:31', '2019-04-22 10:47:35');
INSERT INTO `eacoo_qlive_reply_list` VALUES (4, 1, 0, '我是第二条回复', 5, 7, '2019-04-22 11:11:19', '2019-04-22 11:11:21');
INSERT INTO `eacoo_qlive_reply_list` VALUES (5, 14, 0, '测试！！！！', 7, 7, '2019-04-24 14:03:50', '2019-04-24 14:03:50');
INSERT INTO `eacoo_qlive_reply_list` VALUES (6, 13, 0, '测试回复！！！！', 7, 7, '2019-04-24 14:06:04', '2019-04-24 14:06:04');
INSERT INTO `eacoo_qlive_reply_list` VALUES (7, 11, 0, 'hello！', 7, 7, '2019-04-24 14:07:03', '2019-04-24 14:07:03');

-- ----------------------------
-- Table structure for eacoo_qlive_room_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_room_list`;
CREATE TABLE `eacoo_qlive_room_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'room_id',
  `stream` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '推流地址',
  `anchor_id` int(11) NULL DEFAULT NULL COMMENT '主播id',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=启用,0=禁用,只有通过开播申请后才会开启',
  `order` int(50) NOT NULL DEFAULT 50 COMMENT '排序',
  `marks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `beautify_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '个性化url',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '直播房间列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_room_list
-- ----------------------------
INSERT INTO `eacoo_qlive_room_list` VALUES (1, '49c9e28db070161ce2cbb97bf18524608f369ecc', 1, 1, 50, '虎牙一哥哦!', 'kaer', '2019-03-20 16:31:34', '2019-03-30 11:38:00');
INSERT INTO `eacoo_qlive_room_list` VALUES (2, 'ae0ed89266349bc98c8fbbb1a2df3f8a9433cea6', 2, 1, 50, '虎牙霸天虎', 'bage', '2019-03-21 09:51:23', '2019-03-30 10:59:20');
INSERT INTO `eacoo_qlive_room_list` VALUES (3, '7e2be548f2c21e7db0fd0631eb892faa0e9317cd', 4, 1, 50, '', NULL, '2019-03-21 14:46:38', '2019-04-24 09:25:48');
INSERT INTO `eacoo_qlive_room_list` VALUES (4, '06d77d66ba5892ca048e8643a8b95a02379f8bdb', 2, 1, 50, '这是一个测试这是一个测试这是一个测试', NULL, '2019-04-18 13:46:03', '2019-04-18 13:46:03');
INSERT INTO `eacoo_qlive_room_list` VALUES (5, '074fa6045c30c76bccd7999a71e19cbb67494251', 3, 1, 50, 'xiao', NULL, '2019-04-19 14:28:41', '2019-04-19 14:28:41');

-- ----------------------------
-- Table structure for eacoo_qlive_user_certification
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_user_certification`;
CREATE TABLE `eacoo_qlive_user_certification`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `real_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '真实姓名',
  `id_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '身份证',
  `idcard_face` int(11) NOT NULL COMMENT '身份证人像文件id',
  `idcard_emblem` int(11) NOT NULL COMMENT '身份证国徽文件id',
  `creat_time` datetime(0) NOT NULL,
  `update_time` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户实名信息' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_user_certification
-- ----------------------------
INSERT INTO `eacoo_qlive_user_certification` VALUES (1, 5, '肖鹏', '3208821989110054470', 4, 5, '0000-00-00 00:00:00', '2019-04-16 11:04:43');
INSERT INTO `eacoo_qlive_user_certification` VALUES (2, 7, '王瑾', '320821199504052739', 10, 10, '0000-00-00 00:00:00', '2019-04-23 12:02:33');
INSERT INTO `eacoo_qlive_user_certification` VALUES (3, 7, '王瑾', '320821199504052739', 10, 10, '0000-00-00 00:00:00', '2019-04-23 12:03:59');
INSERT INTO `eacoo_qlive_user_certification` VALUES (4, 7, '王瑾', '320821199504052739', 10, 11, '0000-00-00 00:00:00', '2019-04-23 12:06:03');
INSERT INTO `eacoo_qlive_user_certification` VALUES (5, 7, '王瑾', '320821199504052739', 10, 11, '0000-00-00 00:00:00', '2019-04-23 12:06:12');
INSERT INTO `eacoo_qlive_user_certification` VALUES (6, 7, '王瑾', '320821199504052739', 11, 11, '0000-00-00 00:00:00', '2019-04-23 12:07:04');

-- ----------------------------
-- Table structure for eacoo_qlive_video_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_video_list`;
CREATE TABLE `eacoo_qlive_video_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频标题',
  `anchor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属主播',
  `live_id` int(11) NOT NULL COMMENT '对应的直播记录id',
  `live_time` datetime(0) NULL DEFAULT NULL COMMENT '直播时间',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '视频地址',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '1=开启,0=隐藏',
  `order` int(11) NULL DEFAULT 50 COMMENT '排序',
  `marks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '直播对应的视频列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of eacoo_qlive_video_list
-- ----------------------------
INSERT INTO `eacoo_qlive_video_list` VALUES (1, '一个测试', '卡尔', 8, '2019-03-27 16:02:04', '/uploads/attachment/2019-03-26/5c99d0d1d955d.pdf', 1, 50, '啦啦啦', '2019-03-26 15:08:12', '2019-04-22 16:26:38');
INSERT INTO `eacoo_qlive_video_list` VALUES (2, '这是第二个测试', '马薇薇', 1, '0000-00-00 00:00:00', '', 1, 1, '这是第二个测试这是第二个测试这是第二个测试', '2019-04-18 14:08:34', '2019-04-18 14:08:34');
INSERT INTO `eacoo_qlive_video_list` VALUES (3, '测试第四次', '小白', 2, '0000-00-00 00:00:00', '', 1, 50, '没有备注', '2019-04-19 14:32:41', '2019-04-19 14:32:41');
INSERT INTO `eacoo_qlive_video_list` VALUES (4, '测试第5次', '小白', 3, '0000-00-00 00:00:00', '/uploads/attachment/2019-04-19/5cb97680332fe.pdf', 1, 50, '测试第5次测试第5次测试第5次', '2019-04-19 15:19:39', '2019-04-19 15:19:39');

SET FOREIGN_KEY_CHECKS = 1;
