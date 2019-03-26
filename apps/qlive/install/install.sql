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

 Date: 26/03/2019 11:30:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for eacoo_qlive_anchor_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_anchor_list`;
CREATE TABLE `eacoo_qlive_anchor_list`
(
  `id`          int(11) UNSIGNED                                              NOT NULL AUTO_INCREMENT,
  `name`        varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci       NOT NULL COMMENT '直播姓名',
  `nickname`    varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '昵称',
  `id_card`     varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '身份证照片',
  `room_id`     varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci       NULL DEFAULT NULL COMMENT '主播房间id',
  `uid`         int(11)                                                       NULL DEFAULT NULL COMMENT '关联前台用户id',
  `status`      tinyint(1)                                                    NULL DEFAULT 2 COMMENT '0=禁用,1=启用,2=申请中,3=禁播,4=正常可开播',
  `marks`       varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci       NULL DEFAULT NULL COMMENT '备注',
  `create_time` datetime(0)                                                   NULL DEFAULT NULL,
  `update_time` datetime(0)                                                   NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT = '主播列表'
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_qlive_anchor_list
-- ----------------------------
INSERT INTO `eacoo_qlive_anchor_list`
VALUES (1, '李文轩', '卡尔', '99,98,', '1', 19, 4, '虎牙一哥哦', '2019-03-21 14:14:30', '2019-03-21 14:14:30');
INSERT INTO `eacoo_qlive_anchor_list`
VALUES (2, '雄霸天下', '霸哥', '99,98,', '2', 20, 4, '虎牙霸天虎', '2019-03-21 14:23:25', '2019-03-21 14:23:25');

-- ----------------------------
-- Table structure for eacoo_qlive_apprise_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_apprise_list`;
CREATE TABLE `eacoo_qlive_apprise_list`
(
  `id`            int(11) UNSIGNED                                        NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title`         varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '预告标题',
  `image`         varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '直播海报',
  `lecturer`      varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '主播人',
  `start_time`    datetime(0)                                             NULL DEFAULT NULL COMMENT '开始时间',
  `short_content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '简介',
  `create_time`   datetime(0)                                             NULL DEFAULT NULL,
  `update_time`   datetime(0)                                             NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  CHARACTER SET = utf8
  COLLATE = utf8_general_ci COMMENT = '直播预告列表'
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_qlive_apprise_list
-- ----------------------------
INSERT INTO `eacoo_qlive_apprise_list`
VALUES (1, '直播预告', '99', '1', '2019-03-31 09:30:00', '花式耍猴', '2019-03-21 16:52:43', '2019-03-25 15:52:09');

-- ----------------------------
-- Table structure for eacoo_qlive_category_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_category_list`;
CREATE TABLE `eacoo_qlive_category_list`
(
  `id`          int(11) UNSIGNED                                        NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid`         int(11)                                                 NULL DEFAULT 0 COMMENT '父级id',
  `name`        varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类名称',
  `order`       int(11)                                                 NULL DEFAULT 50 COMMENT '排序',
  `status`      tinyint(1)                                              NULL DEFAULT 1 COMMENT '状态',
  `create_time` datetime(0)                                             NULL DEFAULT NULL,
  `update_time` datetime(0)                                             NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 7
  CHARACTER SET = utf8
  COLLATE = utf8_general_ci COMMENT = '分类列表'
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_qlive_category_list
-- ----------------------------
INSERT INTO `eacoo_qlive_category_list`
VALUES (1, 0, '听力筛选', 50, 1, '2019-03-19 15:46:38', '2019-03-19 16:17:36');
INSERT INTO `eacoo_qlive_category_list`
VALUES (2, 0, '听力诊断', 50, 1, '2019-03-19 16:05:20', '2019-03-19 16:05:20');
INSERT INTO `eacoo_qlive_category_list`
VALUES (3, 0, '助听器验配', 50, 1, '2019-03-19 16:05:32', '2019-03-19 16:05:32');
INSERT INTO `eacoo_qlive_category_list`
VALUES (4, 0, '平衡诊断', 50, 1, '2019-03-19 16:05:45', '2019-03-19 16:05:45');
INSERT INTO `eacoo_qlive_category_list`
VALUES (5, 0, '数据平台', 50, 1, '2019-03-19 16:05:56', '2019-03-19 16:05:56');
INSERT INTO `eacoo_qlive_category_list`
VALUES (6, 0, '其他', 50, 1, '2019-03-19 16:06:56', '2019-03-19 16:06:56');

-- ----------------------------
-- Table structure for eacoo_qlive_post_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_post_list`;
CREATE TABLE `eacoo_qlive_post_list`
(
  `id`            int(11) UNSIGNED                                              NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title`         varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci       NOT NULL COMMENT '标题',
  `thumbnail`     int(10)                                                       NULL     DEFAULT NULL COMMENT '缩略图',
  `category`      tinyint(1)                                                    NOT NULL COMMENT '分类id',
  `short_content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci       NULL     DEFAULT NULL COMMENT '简介',
  `content`       longtext CHARACTER SET utf8 COLLATE utf8_general_ci           NOT NULL COMMENT '内容',
  `publisher`     varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '发布者',
  `hits`          int(10)                                                       NOT NULL DEFAULT 100 COMMENT '点击量',
  `is_top`        tinyint(1)                                                    NOT NULL COMMENT '1=是,0=否',
  `status`        tinyint(1)                                                    NOT NULL COMMENT '1=开启,0=关闭',
  `order`         int(10)                                                       NOT NULL COMMENT '排序',
  `create_time`   datetime(0)                                                   NOT NULL,
  `update_time`   datetime(0)                                                   NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT = '直播模块的文章列表'
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_qlive_post_list
-- ----------------------------
INSERT INTO `eacoo_qlive_post_list`
VALUES (1, '文章测试', 24, 1, '测试', '<p></p><p>测试一下</p>', 'admin', 0, 0, 1, 99, '2019-03-26 09:58:28',
        '2019-03-26 10:01:45');

-- ----------------------------
-- Table structure for eacoo_qlive_room_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_room_list`;
CREATE TABLE `eacoo_qlive_room_list`
(
  `id`          int(11) UNSIGNED                                        NOT NULL AUTO_INCREMENT COMMENT 'room_id',
  `stream`      varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '推流地址',
  `anchor_id`   int(11)                                                 NULL     DEFAULT NULL COMMENT '主播id',
  `status`      tinyint(1)                                              NOT NULL DEFAULT 1 COMMENT '1=启用,0=禁用',
  `order`       int(50)                                                 NOT NULL DEFAULT 50 COMMENT '排序',
  `marks`       varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL     DEFAULT NULL COMMENT '备注',
  `create_time` datetime(0)                                             NULL     DEFAULT NULL,
  `update_time` datetime(0)                                             NULL     DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 4
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT = '直播房间列表'
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_qlive_room_list
-- ----------------------------
INSERT INTO `eacoo_qlive_room_list`
VALUES (1, '49c9e28db070161ce2cbb97bf18524608f369ecc', 1, 1, 50, '虎牙一哥哦!', '2019-03-20 16:31:34',
        '2019-03-21 15:12:43');
INSERT INTO `eacoo_qlive_room_list`
VALUES (2, 'ae0ed89266349bc98c8fbbb1a2df3f8a9433cea6', 2, 1, 50, '虎牙霸天虎', '2019-03-21 09:51:23', '2019-03-21 15:13:04');
INSERT INTO `eacoo_qlive_room_list`
VALUES (3, '7e2be548f2c21e7db0fd0631eb892faa0e9317cd', 0, 1, 50, '啊', '2019-03-21 14:46:38', '2019-03-21 14:46:38');

SET FOREIGN_KEY_CHECKS = 1;
