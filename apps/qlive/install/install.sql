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

 Date: 21/03/2019 09:58:15
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
  `status`      tinyint(1)                                                    NULL DEFAULT NULL COMMENT '0=禁用,1=启用,2=申请中',
  `marks`       varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci       NULL DEFAULT NULL COMMENT '备注',
  `create_time` datetime(0)                                                   NULL DEFAULT NULL,
  `update_time` datetime(0)                                                   NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 4
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT = '主播列表'
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_qlive_anchor_list
-- ----------------------------
INSERT INTO `eacoo_qlive_anchor_list`
VALUES (2, '李文轩', '卡尔', '99,98,', '1', 1, '这是我大哥', '2019-03-20 15:52:52', '2019-03-20 15:57:17');
INSERT INTO `eacoo_qlive_anchor_list`
VALUES (3, '张无忌', '霸哥', '99,98,', '2', 1, '虎牙小霸王', '2019-03-21 09:48:22', '2019-03-21 09:48:22');

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
  COLLATE = utf8_general_ci COMMENT = '视频分类列表'
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
-- Table structure for eacoo_qlive_room_list
-- ----------------------------
DROP TABLE IF EXISTS `eacoo_qlive_room_list`;
CREATE TABLE `eacoo_qlive_room_list`
(
  `id`          int(11) UNSIGNED                                        NOT NULL AUTO_INCREMENT COMMENT 'room_id',
  `stream`      varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '推流地址',
  `anchor_id`   int(11)                                                 NULL     DEFAULT NULL COMMENT '主播id',
  `status`      tinyint(1)                                              NOT NULL DEFAULT 1 COMMENT '1=启用,0=禁用',
  `marks`       varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL     DEFAULT NULL COMMENT '备注',
  `create_time` datetime(0)                                             NULL     DEFAULT NULL,
  `update_time` datetime(0)                                             NULL     DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT = '直播房间列表'
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eacoo_qlive_room_list
-- ----------------------------
INSERT INTO `eacoo_qlive_room_list`
VALUES (1, '49c9e28db070161ce2cbb97bf18524608f369ecc', 2, 1, '虎牙一哥的房间哦', '2019-03-20 16:31:34', '2019-03-20 16:31:34');
INSERT INTO `eacoo_qlive_room_list`
VALUES (2, 'ae0ed89266349bc98c8fbbb1a2df3f8a9433cea6', 3, 1, '', '2019-03-21 09:51:23', '2019-03-21 09:51:23');

SET FOREIGN_KEY_CHECKS = 1;
