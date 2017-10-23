/*
Navicat MySQL Data Transfer

Source Server         : LocalHost
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : rkpm

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2017-10-24 00:22:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `parking`
-- ----------------------------
DROP TABLE IF EXISTS `parking`;
CREATE TABLE `parking` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `company` varchar(50) DEFAULT NULL,
  `reg` varchar(56) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `timein` varchar(20) DEFAULT NULL,
  `tid` text COMMENT '1',
  `col` varchar(4) DEFAULT '1',
  `paid` text,
  `timeout` varchar(20) DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of parking
-- ----------------------------
INSERT INTO `parking` VALUES ('1', null, '', null, null, null, null, null, null, null);
INSERT INTO `parking` VALUES ('2', null, '', null, null, null, null, null, null, null);
INSERT INTO `parking` VALUES ('3', null, '', null, null, null, null, null, null, null);
INSERT INTO `parking` VALUES ('4', null, '', null, null, null, null, null, null, null);
INSERT INTO `parking` VALUES ('5', null, '', null, null, null, null, null, null, null);
INSERT INTO `parking` VALUES ('6', null, '', null, null, null, null, null, null, null);
INSERT INTO `parking` VALUES ('7', 'MARKTRANS', 'DHFH3333', '6', '20/02:53', '', '1', '', '', '');
INSERT INTO `parking` VALUES ('8', '', '', '3', '20/03:00', '', '1', '', '', '');

-- ----------------------------
-- Table structure for `trucks`
-- ----------------------------
DROP TABLE IF EXISTS `trucks`;
CREATE TABLE `trucks` (
  `id` int(12) NOT NULL,
  `company` varchar(26) DEFAULT NULL,
  `reg` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of trucks
-- ----------------------------
