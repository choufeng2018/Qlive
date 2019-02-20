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

 Date: 19/02/2019 14:10:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
INSERT INTO `eacoo_qlive_anchor_list` VALUES (1, '大司马', '1', 1, '', NULL, '2019-02-19 11:59:26');

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

SET FOREIGN_KEY_CHECKS = 1;
