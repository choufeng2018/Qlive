/*
 Navicat Premium Data Transfer

 Source Server         : WSL服务器
 Source Server Type    : MySQL
 Source Server Version : 50725
 Source Host           : 127.0.0.1:3306
 Source Schema         : www_live_gov

 Target Server Type    : MySQL
 Target Server Version : 50725
 File Encoding         : 65001

 Date: 06/05/2019 14:57:26
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
  `idcard_face` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '身份证人像文件id',
  `idcard_emblem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '身份证国徽文件id',
  `room_id` int(11) NULL DEFAULT NULL COMMENT '主播房间id',
  `status` tinyint(1) NULL DEFAULT 2 COMMENT '0=禁用,1=启用,2=申请中,3=禁播,4=正常可开播',
  `marks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '主播列表' ROW_FORMAT = Compact;

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
  `flag` tinyint(1) NULL DEFAULT 1 COMMENT '标记,1=未分类，2=置顶，3=火爆，4=推荐',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '直播预告列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for eacoo_qlive_bill
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_bill`;
CREATE TABLE `eacoo_qlive_bill`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `live_id` int(11) NOT NULL COMMENT '直播id',
  `price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '下单时的价格',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '订单状态:1=正常,2=...',
  `marks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `out_trade_no` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统订单号',
  `transaction_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付方订单号',
  `payment_method` tinyint(1) NOT NULL COMMENT '支付方式:1=微信,2=支付宝',
  `pay_time` datetime(0) NULL DEFAULT NULL COMMENT '支付时间',
  `pay_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '支付状态:0=未支付,1=支付成功,2=支付失败',
  `create_time` datetime(0) NOT NULL,
  `update_time` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单列表' ROW_FORMAT = Compact;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分类列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for eacoo_qlive_comment_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_comment_list`;
CREATE TABLE `eacoo_qlive_comment_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `live_id` int(11) NOT NULL COMMENT '直播记录ID',
  `anchor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '主播昵称',
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户昵称',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `anchor_id` int(11) NOT NULL COMMENT '主播id',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评论内容',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=显示,0=不显示',
  `create_time` datetime(0) NOT NULL,
  `update_time` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '评论列表' ROW_FORMAT = Compact;

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
  `schedule` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '课程安排',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '房间介绍',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容描述',
  `price` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '价格',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '房间密码',
  `commentable` tinyint(1) NULL DEFAULT 1 COMMENT '1=可评论,0=不可评论',
  `can_ask` tinyint(1) NULL DEFAULT 1 COMMENT '1=可提问,0=不可评论',
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件下载',
  `open_time` datetime(0) NULL DEFAULT NULL COMMENT '开播时间',
  `flag` tinyint(1) NULL DEFAULT 1 COMMENT '标记',
  `status` tinyint(1) NULL DEFAULT 2 COMMENT '0=拒绝,1=通过,2=未处理,',
  `hits` int(11) NOT NULL DEFAULT 0 COMMENT '点击数',
  `sales` int(11) NOT NULL DEFAULT 0 COMMENT '销量',
  `create_time` datetime(0) NOT NULL,
  `update_time` datetime(0) NOT NULL,
  `apprise_id` int(11) NULL DEFAULT NULL COMMENT '直播预告关联的id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '开播申请表,开播历史记录表' ROW_FORMAT = Compact;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '直播模块的文章列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for eacoo_qlive_question_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_question_list`;
CREATE TABLE `eacoo_qlive_question_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `live_id` int(11) NOT NULL COMMENT '对应直播',
  `anchor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主播名称',
  `anchor_id` int(11) NOT NULL COMMENT '主播id',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `question` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '提问内容',
  `answer` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '回答内容',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '默认不显示,0=不显示,1=显示',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '提直播的问列表' ROW_FORMAT = Compact;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '直播评分表' ROW_FORMAT = Compact;

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
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=未审核，1=通过，2=不通过',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '回复评论表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for eacoo_qlive_room_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_room_list`;
CREATE TABLE `eacoo_qlive_room_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'room_id',
  `stream` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '推流地址',
  `anchor_id` int(11) NULL DEFAULT NULL COMMENT '主播id',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=启用,0=禁用',
  `order` int(50) NOT NULL DEFAULT 50 COMMENT '排序',
  `marks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `beautify_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '个性化url',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9000 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '直播房间列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for eacoo_qlive_user_certification
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_user_certification`;
CREATE TABLE `eacoo_qlive_user_certification`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `real_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '真实姓名',
  `id_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '身份证',
  `idcard_face` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '身份证人像文件id',
  `idcard_emblem` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '身份证国徽文件id',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=未处理，1=已通过，2=未通过',
  `create_time` datetime(0) NOT NULL,
  `update_time` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户实名信息' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for eacoo_qlive_video_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_video_list`;
CREATE TABLE `eacoo_qlive_video_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频标题',
  `anchor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属主播',
  `live_id` int(11) NOT NULL COMMENT '对应的直播记录id',
  `category` int(11) NULL DEFAULT NULL COMMENT '和直播保持一致',
  `type` int(11) NULL DEFAULT NULL COMMENT '和直播保持一致',
  `price` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '和直播保持一致',
  `live_time` datetime(0) NULL DEFAULT NULL COMMENT '直播时间',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '视频地址',
  `hits` int(11) NOT NULL DEFAULT 0 COMMENT '点击次数',
  `sales` int(11) NOT NULL DEFAULT 0 COMMENT '销量',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '1=开启,0=隐藏',
  `flag` tinyint(1) NULL DEFAULT NULL COMMENT '1=最热，2=推荐，3=置顶，4=。。。',
  `order` int(11) NULL DEFAULT 50 COMMENT '排序',
  `marks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '直播对应的视频列表' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
