/*
Navicat MySQL Data Transfer

Source Server         : 医诊通数据库
Source Server Version : 50714
Source Host           : 47.95.245.67:3306
Source Database       : xzcloud

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2019-12-17 12:18:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sunny_admin
-- ----------------------------
DROP TABLE IF EXISTS `sunny_admin`;
CREATE TABLE `sunny_admin` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `sessionID` varchar(32) DEFAULT NULL COMMENT 'sessionid',
  `username` varchar(60) DEFAULT '' COMMENT '登陆转好',
  `userpass` char(60) DEFAULT '0' COMMENT '登陆密码',
  `email` varchar(100) DEFAULT '' COMMENT '邮件地址',
  `mobile` varchar(30) DEFAULT '' COMMENT '手机号',
  `firstime` int(11) DEFAULT '0' COMMENT '首次登陆时间',
  `lastime` int(11) DEFAULT '0' COMMENT '最后一次登陆时间',
  `IP` char(15) DEFAULT '' COMMENT '登录IP',
  `status` tinyint(1) DEFAULT '0' COMMENT '锁定状态0 锁定  1正常',
  `mark` varchar(500) DEFAULT '' COMMENT '备注',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Records of sunny_admin
-- ----------------------------
INSERT INTO `sunny_admin` VALUES ('3e78ad7e-a83e-11e9-9dc5-30b49efad619', 'q3ja8o89smpndqmsrm322in063', 'adminxzc', '$2y$10$0dYRlJVM90wVZfwLWkUpX.FU8Tdm/fzdrCx0ORn/haeB/NzOIZMdS', '', '', '0', '1564986410', '127.0.0.1', '1', '', null, null);

-- ----------------------------
-- Table structure for sunny_ads
-- ----------------------------
DROP TABLE IF EXISTS `sunny_ads`;
CREATE TABLE `sunny_ads` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `adtitle` varchar(120) DEFAULT '' COMMENT '广告标题',
  `shortitle` varchar(200) DEFAULT '' COMMENT '副标题',
  `pics` varchar(120) DEFAULT '' COMMENT '广告封面图片',
  `adurl` varchar(150) DEFAULT '' COMMENT '广告url ',
  `adtypeID` char(36) DEFAULT '' COMMENT '广告位置',
  `mark` varchar(300) DEFAULT '' COMMENT '说明备注',
  `status` tinyint(1) DEFAULT '0' COMMENT '审核显示 0 不显示 1显示',
  `sort` smallint(10) DEFAULT '0' COMMENT '排序',
  `clicks` smallint(10) DEFAULT '0' COMMENT '点击量',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间 ',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告表 ';

-- ----------------------------
-- Records of sunny_ads
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_adtype
-- ----------------------------
DROP TABLE IF EXISTS `sunny_adtype`;
CREATE TABLE `sunny_adtype` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `tname` varchar(60) DEFAULT '' COMMENT '广告位名称',
  `sort` smallint(10) DEFAULT '0' COMMENT '排序',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告位置';

-- ----------------------------
-- Records of sunny_adtype
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_art_chapter
-- ----------------------------
DROP TABLE IF EXISTS `sunny_art_chapter`;
CREATE TABLE `sunny_art_chapter` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `cname` varchar(60) NOT NULL DEFAULT '' COMMENT '分类名称',
  `pid` char(36) NOT NULL COMMENT '父级分类',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '显示状态 0 不显示 1显示',
  `sort` smallint(10) DEFAULT '0' COMMENT '排序',
  `create_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作文档章节表';

-- ----------------------------
-- Records of sunny_art_chapter
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_art_detail
-- ----------------------------
DROP TABLE IF EXISTS `sunny_art_detail`;
CREATE TABLE `sunny_art_detail` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `articleID` char(36) DEFAULT NULL COMMENT '文章ID',
  `info` varchar(500) DEFAULT '' COMMENT '简介',
  `content` longtext COMMENT '内容',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作文档详情表';

-- ----------------------------
-- Records of sunny_art_detail
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_article
-- ----------------------------
DROP TABLE IF EXISTS `sunny_article`;
CREATE TABLE `sunny_article` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `cateID` char(36) NOT NULL COMMENT '分类id',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '文档标题',
  `shortitle` varchar(200) NOT NULL DEFAULT '' COMMENT '副标题',
  `doc_pic` varchar(100) NOT NULL DEFAULT '' COMMENT '封面图片',
  `is_comment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可评论 0不能评论 1评论',
  `clicks` smallint(10) NOT NULL DEFAULT '0' COMMENT '点击量',
  `comments` smallint(10) NOT NULL DEFAULT '0' COMMENT '评论数 ',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核显示 0 不显示  1显示',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间 ',
  `sort` smallint(10) DEFAULT '0' COMMENT '排序',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `is_back` tinyint(1) DEFAULT '0' COMMENT '1回收站',
  `tags` varchar(300) DEFAULT NULL COMMENT '标签',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作文档表';

-- ----------------------------
-- Records of sunny_article
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `sunny_auth_group`;
CREATE TABLE `sunny_auth_group` (
  `ID` char(36) NOT NULL COMMENT '主键 ',
  `gname` varchar(60) DEFAULT '' COMMENT '角色名称',
  `gcode` varchar(60) DEFAULT '' COMMENT '角色缩写',
  `ruleNum` longtext COMMENT '角色权限',
  `status` tinyint(1) DEFAULT '0' COMMENT '角色状态',
  `info` varchar(500) DEFAULT NULL COMMENT '备注',
  `create_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of sunny_auth_group
-- ----------------------------
INSERT INTO `sunny_auth_group` VALUES ('7fc04884-a922-11e9-9070-30b49efad619', '超级管理员', 'cj', '454eeb5a-b4cc-11e9-a98c-30b49efad619,407adffe-b5ac-11e9-8ddd-30b49efad619,757fdc8a-b5ad-11e9-9456-30b49efad619,e18a090a-b4cc-11e9-b47f-30b49efad619,56f993f0-b4cc-11e9-b2b0-30b49efad619,0401c838-b4cd-11e9-82f9-30b49efad619,01ff148e-b516-11e9-ae3a-30b49efad619,7a069228-b515-11e9-810b-30b49efad619,9e08527e-b515-11e9-ab4b-30b49efad619,b462d918-b515-11e9-ace1-30b49efad619,cf833706-b515-11e9-96c7-30b49efad619,e88bf7ba-b515-11e9-9270-30b49efad619,4a4c13fa-b4cf-11e9-a573-30b49efad619,204a316c-b516-11e9-a0da-30b49efad619,35e62030-b516-11e9-91c9-30b49efad619,4f49d378-b516-11e9-9703-30b49efad619,a64a37da-b516-11e9-9ac0-30b49efad619,533ae414-b4cf-11e9-b167-30b49efad619,5f72915e-b516-11e9-ac00-30b49efad619,72c8a644-b516-11e9-b91d-30b49efad619,6f25c0ea-b4cf-11e9-af4f-30b49efad619,09bdcb12-b515-11e9-87b3-30b49efad619,243c1a3e-b515-11e9-a2ca-30b49efad619,5aeb29ee-b515-11e9-8126-30b49efad619,ef8a1a84-b514-11e9-8228-30b49efad619,617ff9f4-b4cc-11e9-99d3-30b49efad619,82c8be72-b4cf-11e9-93af-30b49efad619,5576f468-b513-11e9-af6c-30b49efad619,7d706396-b513-11e9-b908-30b49efad619,9b7c058e-b513-11e9-8a06-30b49efad619,b5e17530-b513-11e9-aee5-30b49efad619,d05f9d4c-b513-11e9-939b-30b49efad619,e69cb068-b513-11e9-af49-30b49efad619,8e403ec4-b4cf-11e9-ae34-30b49efad619,0832229e-b514-11e9-a2c9-30b49efad619,27033a50-b514-11e9-9657-30b49efad619,419a6906-b514-11e9-9fdf-30b49efad619,bb2eeea4-b514-11e9-9ade-30b49efad619,991a925e-b4cf-11e9-a57b-30b49efad619,5e13f368-b514-11e9-a53d-30b49efad619,d2db0074-b514-11e9-9e98-30b49efad619,aaa185d2-b4cf-11e9-bac0-30b49efad619,6ba44156-b4cc-11e9-b3e5-30b49efad619,b65e9ba8-b4cf-11e9-b41e-30b49efad619,12b2a1e6-b512-11e9-9ddf-30b49efad619,32aab1be-b512-11e9-9a74-30b49efad619,5d5da5d8-b512-11e9-a9d4-30b49efad619,a2e9bb10-b511-11e9-9a4b-30b49efad619,c210bc32-b511-11e9-968f-30b49efad619,dcaa0ddc-b511-11e9-8643-30b49efad619,f59226b8-b511-11e9-ab95-30b49efad619,c4da668a-b4cf-11e9-afdb-30b49efad619,0206f012-b513-11e9-9e7b-30b49efad619,82c982ce-b512-11e9-bf4a-30b49efad619,97658a02-b512-11e9-ac2e-30b49efad619,af095e4a-b512-11e9-ad16-30b49efad619,d3a22fb8-b4cf-11e9-827a-30b49efad619,c3bb5ece-b512-11e9-b51c-30b49efad619,e6fd75d4-b512-11e9-b0ab-30b49efad619,7ed4572a-b4cc-11e9-8d8b-30b49efad619,e00aa334-b4cf-11e9-b2be-30b49efad619,16485f9a-b511-11e9-9b57-30b49efad619,325088de-b511-11e9-9836-30b49efad619,572ccde8-b511-11e9-922c-30b49efad619,730a15fc-b511-11e9-896a-30b49efad619,954684c4-b4cc-11e9-b507-30b49efad619,01ab3922-b4d0-11e9-a21d-30b49efad619,2149a31e-b510-11e9-bd5f-30b49efad619,3701ccd6-b510-11e9-8f45-30b49efad619,52ab6060-b50f-11e9-a4e4-30b49efad619,68a1cc88-b50f-11e9-8292-30b49efad619,7a06435a-b50f-11e9-9f6a-30b49efad619,8f768d94-b50f-11e9-aabd-30b49efad619,0cd5a9c2-b4d0-11e9-b2e5-30b49efad619,51a83e12-b510-11e9-99d2-30b49efad619,67213afa-b510-11e9-9ae6-30b49efad619,7fe37bca-b510-11e9-ad85-30b49efad619,93a2db60-b510-11e9-a37b-30b49efad619,ad0d1e76-b510-11e9-bcdf-30b49efad619,c998f894-b510-11e9-b908-30b49efad619,f594b762-b4cf-11e9-93dc-30b49efad619,0b96dcce-b508-11e9-8b80-30b49efad619,4b4fe612-b508-11e9-87ff-30b49efad619,5fba7c52-b508-11e9-8607-30b49efad619,7b4fbdce-b508-11e9-9334-30b49efad619,9321f5ca-b508-11e9-b7f6-30b49efad619,bc86da7a-b4cc-11e9-80e9-30b49efad619,1c83b792-b4d0-11e9-a91f-30b49efad619,8e0f7d90-b509-11e9-9a24-30b49efad619,9652fd7a-b50d-11e9-8b5d-30b49efad619,ac1168d6-b50d-11e9-957b-30b49efad619,bff62b48-b50d-11e9-89d9-30b49efad619,2701e018-b4d0-11e9-95c1-30b49efad619,08723920-b50e-11e9-8a61-30b49efad619,db0746c4-b50d-11e9-b979-30b49efad619,ee99c950-b50d-11e9-88fc-30b49efad619,3173fa86-b4d0-11e9-822c-30b49efad619,32158dfe-b50e-11e9-8813-30b49efad619,4b188248-b50e-11e9-b230-30b49efad619,5ce8188a-b50e-11e9-ae5b-30b49efad619,6f27fe70-b50e-11e9-9097-30b49efad619,45076772-b4d0-11e9-addd-30b49efad619,9704e48a-b50e-11e9-ab75-30b49efad619,525c1328-b4d0-11e9-b8fe-30b49efad619,b67f0ffc-b50e-11e9-9747-30b49efad619,5d8ee856-b4d0-11e9-b286-30b49efad619,17f9f350-b50f-11e9-bc6f-30b49efad619,d904d91c-b50e-11e9-88bd-30b49efad619,f8e234a0-b50e-11e9-93a8-30b49efad619,c6126784-b5bd-11e9-93c0-30b49efad619,29de9684-b5be-11e9-acfb-30b49efad619,48214ed4-b5be-11e9-8196-30b49efad619,', '1', '超级管理员，不得修改任何信息', '1563430063', null);

-- ----------------------------
-- Table structure for sunny_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `sunny_auth_group_access`;
CREATE TABLE `sunny_auth_group_access` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `userid` char(36) DEFAULT NULL COMMENT '用户ID',
  `group_id` char(36) DEFAULT NULL COMMENT '角色id',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色与 权限中间表';

-- ----------------------------
-- Records of sunny_auth_group_access
-- ----------------------------
INSERT INTO `sunny_auth_group_access` VALUES ('102386fa-b500-11e9-88d8-30b49efad619', '3e78ad7e-a83e-11e9-9dc5-30b49efad619', '7fc04884-a922-11e9-9070-30b49efad619');

-- ----------------------------
-- Table structure for sunny_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `sunny_auth_rule`;
CREATE TABLE `sunny_auth_rule` (
  `ID` char(36) NOT NULL,
  `num` int(10) DEFAULT '0' COMMENT '权限编号',
  `group` varchar(100) DEFAULT NULL COMMENT '分组',
  `link` varchar(80) DEFAULT '' COMMENT '权限路径',
  `title` varchar(80) DEFAULT '' COMMENT '权限名称',
  `pid` char(36) DEFAULT NULL COMMENT '父级id',
  `sort` smallint(10) DEFAULT '0' COMMENT '排序',
  `level` tinyint(3) DEFAULT '0' COMMENT '级别',
  `status` tinyint(1) DEFAULT '0' COMMENT '显示状态 0不显示1显示',
  `ischeck` tinyint(1) DEFAULT NULL COMMENT '是否需要验证 0需要验证 1不需要',
  `icon` varchar(60) DEFAULT NULL COMMENT '菜单图标',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `condition` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限表 ';

-- ----------------------------
-- Records of sunny_auth_rule
-- ----------------------------
INSERT INTO `sunny_auth_rule` VALUES ('01ab3922-b4d0-11e9-a21d-30b49efad619', '22', '权限管理', 'Role/index', '角色管理', '954684c4-b4cc-11e9-b507-30b49efad619', '2', '2', '1', '0', null, '1564714108', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('01ff148e-b516-11e9-ae3a-30b49efad619', '101', '门户文章', 'Menudoor/move', '移动分类', '0401c838-b4cd-11e9-82f9-30b49efad619', '6', '2', '0', '0', null, '1564744173', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('0206f012-b513-11e9-9e7b-30b49efad619', '79', '发布在线视频', 'Video/delDocTrue', '彻底删除视频', 'c4da668a-b4cf-11e9-afdb-30b49efad619', '4', '2', '0', '0', null, '1564742885', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('0401c838-b4cd-11e9-82f9-30b49efad619', '9', '门户文章', 'Menudoor/index', '栏目菜单', '56f993f0-b4cc-11e9-b2b0-30b49efad619', '1', '1', '1', '0', '', '1564712824', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('0832229e-b514-11e9-a2c9-30b49efad619', '86', '发布在线文档', 'Helpdoc/addDoc', '添加文档', '8e403ec4-b4cf-11e9-ae34-30b49efad619', '1', '1', '0', '0', null, '1564743325', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('08723920-b50e-11e9-8a61-30b49efad619', '41', '广告管理', 'Advert/delType', '删除广告位', '2701e018-b4d0-11e9-95c1-30b49efad619', '3', '2', '0', '0', null, '1564740748', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('09bdcb12-b515-11e9-87b3-30b49efad619', '93', '图片素材', 'Picture/updatePic', '修改图集', '6f25c0ea-b4cf-11e9-af4f-30b49efad619', '2', '2', '0', '0', null, '1564743757', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('0b96dcce-b508-11e9-8b80-30b49efad619', '30', '权限管理', 'Account/newAccount', '添加管理员', 'f594b762-b4cf-11e9-93dc-30b49efad619', '1', '1', '0', '0', null, '1564738177', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('0cd5a9c2-b4d0-11e9-b2e5-30b49efad619', '23', '权限管理', 'Rule/index', '权限规则', '954684c4-b4cc-11e9-b507-30b49efad619', '3', '2', '1', '0', '', '1564714127', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('12b2a1e6-b512-11e9-9ddf-30b49efad619', '71', '培训视频分类', 'Videocate/operate', '视频分类移动', 'b65e9ba8-b4cf-11e9-b41e-30b49efad619', '5', '2', '0', '1', null, '1564742483', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('16485f9a-b511-11e9-9b57-30b49efad619', '63', '专题管理', 'Special/addSpec', '添加专题', 'e00aa334-b4cf-11e9-b2be-30b49efad619', '1', '1', '0', '0', null, '1564742060', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('17f9f350-b50f-11e9-bc6f-30b49efad619', '50', '数据管理', 'Sysdatabase/repair', '修复数据表', '5d8ee856-b4d0-11e9-b286-30b49efad619', '3', '2', '0', '0', null, '1564741204', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('1c83b792-b4d0-11e9-a91f-30b49efad619', '24', '广告管理', 'Advert/index', '宣传广告', 'bc86da7a-b4cc-11e9-80e9-30b49efad619', '1', '1', '1', '0', null, '1564714153', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('204a316c-b516-11e9-a0da-30b49efad619', '102', '门户文章', 'News/addNews', '添加文章', '4a4c13fa-b4cf-11e9-a573-30b49efad619', '1', '1', '0', '0', null, '1564744224', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('2149a31e-b510-11e9-bd5f-30b49efad619', '55', '权限管理', 'Role/setRule', '角色规则', '01ab3922-b4d0-11e9-a21d-30b49efad619', '5', '2', '0', '0', null, '1564741649', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('243c1a3e-b515-11e9-a2ca-30b49efad619', '94', '图片素材', 'Picture/setStatus', '设置状态', '6f25c0ea-b4cf-11e9-af4f-30b49efad619', '3', '3', '0', '0', null, '1564743801', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('2701e018-b4d0-11e9-95c1-30b49efad619', '25', '广告管理', 'Advert/tindex', '广告位', 'bc86da7a-b4cc-11e9-80e9-30b49efad619', '2', '2', '1', '0', null, '1564714171', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('27033a50-b514-11e9-9657-30b49efad619', '87', '发布在线文档', 'Helpdoc/updateDoc', '修改文档', '8e403ec4-b4cf-11e9-ae34-30b49efad619', '2', '2', '0', '0', null, '1564743377', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('29de9684-b5be-11e9-acfb-30b49efad619', '111', '主题设置', 'Tepname/addTemplate', '添加主题', 'c6126784-b5bd-11e9-93c0-30b49efad619', '1', '1', '0', '0', null, '1564816396', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('3173fa86-b4d0-11e9-822c-30b49efad619', '26', '友情链接', 'Link/index', '链接列表', 'bc86da7a-b4cc-11e9-80e9-30b49efad619', '3', '2', '1', '0', '', '1564714188', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('32158dfe-b50e-11e9-8813-30b49efad619', '42', '友情链接', 'Link/newLink', '添加链接', '3173fa86-b4d0-11e9-822c-30b49efad619', '1', '1', '0', '0', null, '1564740818', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('325088de-b511-11e9-9836-30b49efad619', '64', '专题管理', 'Special/updateSpec', '修改专题', 'e00aa334-b4cf-11e9-b2be-30b49efad619', '2', '2', '0', '0', null, '1564742107', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('32aab1be-b512-11e9-9a74-30b49efad619', '72', '培训视频分类', 'Videocate/move', '移动分类合并', 'b65e9ba8-b4cf-11e9-b41e-30b49efad619', '6', '3', '0', '0', null, '1564742537', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('35e62030-b516-11e9-91c9-30b49efad619', '103', '门户文章', 'News/updateNews', '修改文章', '4a4c13fa-b4cf-11e9-a573-30b49efad619', '2', '2', '0', '0', null, '1564744260', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('3701ccd6-b510-11e9-8f45-30b49efad619', '56', '权限管理', 'Role/roleRule', '分配权限', '01ab3922-b4d0-11e9-a21d-30b49efad619', '6', '3', '0', '0', null, '1564741685', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('407adffe-b5ac-11e9-8ddd-30b49efad619', '108', '缓存处理', 'Usertool/caches', '数据缓存', '454eeb5a-b4cc-11e9-a98c-30b49efad619', '2', '2', '1', '0', null, '1564808703', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('419a6906-b514-11e9-9fdf-30b49efad619', '88', '发布在线文档', 'Helpdoc/setStatus', '设置状态', '8e403ec4-b4cf-11e9-ae34-30b49efad619', '3', '2', '0', '0', null, '1564743421', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('45076772-b4d0-11e9-addd-30b49efad619', '27', '系统日志', 'Syslogs/index', '操作日志', 'bc86da7a-b4cc-11e9-80e9-30b49efad619', '4', '2', '1', '0', null, '1564714221', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('454eeb5a-b4cc-11e9-a98c-30b49efad619', '1', null, 'sys', '管理首页', '00000000-0000-0000-0000-000000000000', '1', '1', '1', '0', null, '1564712504', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('48214ed4-b5be-11e9-8196-30b49efad619', '112', '主题设置', 'Tepname/updateTemplate', '修改主题', 'c6126784-b5bd-11e9-93c0-30b49efad619', '2', '2', '0', '0', null, '1564816447', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('4a4c13fa-b4cf-11e9-a573-30b49efad619', '10', '门户文章', 'News/index', '文章管理', '56f993f0-b4cc-11e9-b2b0-30b49efad619', '2', '2', '1', '0', '', '1564713800', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('4b188248-b50e-11e9-b230-30b49efad619', '43', '友情链接', 'Link/updateLink', '修改链接', '3173fa86-b4d0-11e9-822c-30b49efad619', '2', '2', '0', '0', null, '1564740860', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('4b4fe612-b508-11e9-87ff-30b49efad619', '31', '权限管理', 'Account/updateAccount', '修改管理员', 'f594b762-b4cf-11e9-93dc-30b49efad619', '2', '2', '0', '0', null, '1564738283', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('4f49d378-b516-11e9-9703-30b49efad619', '104', '门户文章', 'News/setStatus', '设置状态', '4a4c13fa-b4cf-11e9-a573-30b49efad619', '3', '2', '0', '0', null, '1564744303', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('51a83e12-b510-11e9-99d2-30b49efad619', '57', '权限管理', 'Rule/newRule', '添加规则', '0cd5a9c2-b4d0-11e9-b2e5-30b49efad619', '1', '1', '0', '0', null, '1564741730', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('525c1328-b4d0-11e9-b8fe-30b49efad619', '28', '图片管理', 'Sysimages/index', '系统图片', 'bc86da7a-b4cc-11e9-80e9-30b49efad619', '5', '2', '1', '0', null, '1564714243', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('52ab6060-b50f-11e9-a4e4-30b49efad619', '51', '权限管理', 'Role/newRole', '添加角色', '01ab3922-b4d0-11e9-a21d-30b49efad619', '1', '1', '0', '0', null, '1564741302', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('533ae414-b4cf-11e9-b167-30b49efad619', '11', '门户文章', 'News/back', '文章回收站', '56f993f0-b4cc-11e9-b2b0-30b49efad619', '3', '2', '1', '0', null, '1564713815', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('5576f468-b513-11e9-af6c-30b49efad619', '80', '在线文档分类', 'Helpcate/newMenu', '添加文档分类', '82c8be72-b4cf-11e9-93af-30b49efad619', '1', '1', '0', '0', null, '1564743025', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('56f993f0-b4cc-11e9-b2b0-30b49efad619', '2', null, 'web', '网站门户', '00000000-0000-0000-0000-000000000000', '2', '2', '1', '0', null, '1564712533', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('572ccde8-b511-11e9-922c-30b49efad619', '65', '专题管理', 'Special/setStatus', '设置状态', 'e00aa334-b4cf-11e9-b2be-30b49efad619', '3', '2', '0', '0', null, '1564742169', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('5aeb29ee-b515-11e9-8126-30b49efad619', '95', '图片素材', 'Picture/delPic', '删除图集', '6f25c0ea-b4cf-11e9-af4f-30b49efad619', '4', '3', '0', '0', null, '1564743893', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('5ce8188a-b50e-11e9-ae5b-30b49efad619', '44', '友情链接', 'Link/setStatus', '设置状态', '3173fa86-b4d0-11e9-822c-30b49efad619', '3', '2', '0', '0', null, '1564740890', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('5d5da5d8-b512-11e9-a9d4-30b49efad619', '73', '培训视频分类', 'Videocate/importVideo', '导入视频', 'b65e9ba8-b4cf-11e9-b41e-30b49efad619', '7', '3', '0', '0', null, '1564742609', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('5d8ee856-b4d0-11e9-b286-30b49efad619', '29', '数据管理', 'Sysdatabase/index', '备份数据', 'bc86da7a-b4cc-11e9-80e9-30b49efad619', '6', '2', '1', '0', '', '1564714262', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('5e13f368-b514-11e9-a53d-30b49efad619', '89', '发布在线文档', 'Helpdoc/delDoc', '删除到回收站', '991a925e-b4cf-11e9-a57b-30b49efad619', '4', '2', '0', '0', null, '1564743469', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('5f72915e-b516-11e9-ac00-30b49efad619', '105', '门户文章', 'News/delNews', '删除文章', '533ae414-b4cf-11e9-b167-30b49efad619', '4', '2', '0', '0', null, '1564744330', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('5fba7c52-b508-11e9-8607-30b49efad619', '32', '权限管理', 'setForbidden', '设置状态', 'f594b762-b4cf-11e9-93dc-30b49efad619', '3', '2', '0', '0', null, '1564738318', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('617ff9f4-b4cc-11e9-99d3-30b49efad619', '3', null, 'document', '在线文档', '00000000-0000-0000-0000-000000000000', '3', '2', '1', '0', null, '1564712551', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('67213afa-b510-11e9-9ae6-30b49efad619', '58', '权限管理', 'Rule/updateRule', '修改规则', '0cd5a9c2-b4d0-11e9-b2e5-30b49efad619', '2', '2', '0', '0', null, '1564741766', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('68a1cc88-b50f-11e9-8292-30b49efad619', '52', '权限管理', 'Role/updateRole', '修改角色', '01ab3922-b4d0-11e9-a21d-30b49efad619', '2', '2', '0', '0', null, '1564741339', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('6ba44156-b4cc-11e9-b3e5-30b49efad619', '4', null, 'video', '在线视频', '00000000-0000-0000-0000-000000000000', '4', '2', '1', '0', null, '1564712568', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('6f25c0ea-b4cf-11e9-af4f-30b49efad619', '12', '图片素材', 'Picture/index', '图片展示', '56f993f0-b4cc-11e9-b2b0-30b49efad619', '4', '2', '1', '0', null, '1564713862', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('6f27fe70-b50e-11e9-9097-30b49efad619', '45', '友情链接', 'Link/delLink', '删除链接', '3173fa86-b4d0-11e9-822c-30b49efad619', '4', '2', '0', '0', null, '1564740921', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('72c8a644-b516-11e9-b91d-30b49efad619', '106', '门户文章', 'News/backNews', '还原文章', '533ae414-b4cf-11e9-b167-30b49efad619', '1', '1', '0', '0', null, '1564744363', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('730a15fc-b511-11e9-896a-30b49efad619', '66', '专题管理', 'Special/delSpecTrue', '删除专题', 'e00aa334-b4cf-11e9-b2be-30b49efad619', '4', '2', '0', '0', null, '1564742216', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('757fdc8a-b5ad-11e9-9456-30b49efad619', '109', '缓存处理', 'Usertool/clearCache', '清除缓存', '407adffe-b5ac-11e9-8ddd-30b49efad619', '3', '3', '0', '0', null, '1564809221', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('7a06435a-b50f-11e9-9f6a-30b49efad619', '53', '权限管理', 'Role/setStatus', '设置状态', '01ab3922-b4d0-11e9-a21d-30b49efad619', '3', '2', '0', '0', null, '1564741368', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('7a069228-b515-11e9-810b-30b49efad619', '96', '门户文章', 'Menudoor/newMenu', '添加网站栏目', '0401c838-b4cd-11e9-82f9-30b49efad619', '1', '1', '0', '0', null, '1564743945', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('7b4fbdce-b508-11e9-9334-30b49efad619', '33', '权限管理', 'Account/delAccount', '删除管理员', 'f594b762-b4cf-11e9-93dc-30b49efad619', '4', '2', '0', '0', null, '1564738364', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('7d706396-b513-11e9-b908-30b49efad619', '81', '在线文档分类', 'Helpcate/updateMenu', '修改文档分类', '82c8be72-b4cf-11e9-93af-30b49efad619', '2', '2', '0', '0', null, '1564743092', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('7ed4572a-b4cc-11e9-8d8b-30b49efad619', '5', null, 'special', '专题管理', '00000000-0000-0000-0000-000000000000', '5', '2', '1', '0', null, '1564712600', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('7fe37bca-b510-11e9-ad85-30b49efad619', '59', '权限管理', 'Rule/setStatus', '设置状态', '0cd5a9c2-b4d0-11e9-b2e5-30b49efad619', '3', '2', '0', '0', null, '1564741808', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('82c8be72-b4cf-11e9-93af-30b49efad619', '13', '在线文档分类', 'Helpcate/index', '文档分类', '617ff9f4-b4cc-11e9-99d3-30b49efad619', '1', '1', '1', '0', '', '1564713895', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('82c982ce-b512-11e9-bf4a-30b49efad619', '74', '发布在线视频', 'Video/addDoc', '添加视频', 'c4da668a-b4cf-11e9-afdb-30b49efad619', '1', '1', '0', '0', null, '1564742671', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('8e0f7d90-b509-11e9-9a24-30b49efad619', '35', '广告管理', 'Advert/newAdvert', '添加广告', '1c83b792-b4d0-11e9-a91f-30b49efad619', '1', '1', '0', '0', null, '1564738825', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('8e403ec4-b4cf-11e9-ae34-30b49efad619', '14', '发布在线文档', 'Helpdoc/index', '文档列表', '617ff9f4-b4cc-11e9-99d3-30b49efad619', '2', '2', '1', '0', null, '1564713914', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('8f768d94-b50f-11e9-aabd-30b49efad619', '54', '权限管理', 'Role/delRole', '删除角色', '01ab3922-b4d0-11e9-a21d-30b49efad619', '3', '2', '0', '0', null, '1564741404', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('9321f5ca-b508-11e9-b7f6-30b49efad619', '34', '权限管理', 'Account/modifyPass', '修改密码', 'f594b762-b4cf-11e9-93dc-30b49efad619', '5', '2', '0', '0', null, '1564738404', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('93a2db60-b510-11e9-a37b-30b49efad619', '60', '权限管理', 'Rule/delRule', '删除规则', '0cd5a9c2-b4d0-11e9-b2e5-30b49efad619', '4', '2', '0', '0', null, '1564741841', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('954684c4-b4cc-11e9-b507-30b49efad619', '6', null, 'rule', '权限管理', '00000000-0000-0000-0000-000000000000', '6', '2', '1', '0', null, '1564712638', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('9652fd7a-b50d-11e9-8b5d-30b49efad619', '36', '广告管理', 'Advert/updateAdvert', '修改广告', '1c83b792-b4d0-11e9-a91f-30b49efad619', '2', '2', '0', '0', null, '1564740557', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('9704e48a-b50e-11e9-ab75-30b49efad619', '46', '系统日志', 'Syslogs/deleteLogs', '删除日志', '45076772-b4d0-11e9-addd-30b49efad619', '1', '1', '0', '0', null, '1564740987', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('97658a02-b512-11e9-ac2e-30b49efad619', '75', '发布在线视频', 'Video/updateDoc', '修改视频', 'c4da668a-b4cf-11e9-afdb-30b49efad619', '2', '2', '0', '0', null, '1564742706', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('991a925e-b4cf-11e9-a57b-30b49efad619', '15', '发布在线文档', 'Helpdoc/back', '回收站', '617ff9f4-b4cc-11e9-99d3-30b49efad619', '3', '2', '1', '0', null, '1564713933', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('9b7c058e-b513-11e9-8a06-30b49efad619', '82', '在线文档分类', 'Helpcate/setStatus', '设置状态', '82c8be72-b4cf-11e9-93af-30b49efad619', '3', '2', '0', '0', null, '1564743142', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('9e08527e-b515-11e9-ab4b-30b49efad619', '97', '门户文章', 'Menudoor/updateMenu', '修改网站栏目', '0401c838-b4cd-11e9-82f9-30b49efad619', '2', '2', '0', '0', null, '1564744006', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('a2e9bb10-b511-11e9-9a4b-30b49efad619', '67', '培训视频分类', 'Videocate/newMenu', '添加视频分类', 'b65e9ba8-b4cf-11e9-b41e-30b49efad619', '1', '1', '0', '0', null, '1564742296', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('a64a37da-b516-11e9-9ac0-30b49efad619', '107', '门户文章', 'News/delNewsTrue', '彻底文章', '4a4c13fa-b4cf-11e9-a573-30b49efad619', '4', '2', '0', '0', null, '1564744449', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('aaa185d2-b4cf-11e9-bac0-30b49efad619', '16', '常见问题', 'Question/index', '发布问题', '617ff9f4-b4cc-11e9-99d3-30b49efad619', '4', '2', '1', '0', null, '1564713962', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('ac1168d6-b50d-11e9-957b-30b49efad619', '37', '广告管理', 'setStatus', '设置状态', '1c83b792-b4d0-11e9-a91f-30b49efad619', '5', '2', '0', '0', null, '1564740593', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('ad0d1e76-b510-11e9-bcdf-30b49efad619', '61', '权限管理', 'Rule/operate', '权限移动', '0cd5a9c2-b4d0-11e9-b2e5-30b49efad619', '5', '2', '0', '0', null, '1564741883', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('af095e4a-b512-11e9-ad16-30b49efad619', '76', '发布在线视频', 'Video/setStatus', '设置状态', 'c4da668a-b4cf-11e9-afdb-30b49efad619', '3', '2', '0', '0', null, '1564742746', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('b462d918-b515-11e9-ace1-30b49efad619', '98', '门户文章', 'Menudoor/setStatus', '设置状态', '0401c838-b4cd-11e9-82f9-30b49efad619', '3', '2', '0', '0', null, '1564744043', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('b5e17530-b513-11e9-aee5-30b49efad619', '83', '在线文档分类', 'Helpcate/delMenu', '删除文档分类', '82c8be72-b4cf-11e9-93af-30b49efad619', '4', '2', '0', '0', null, '1564743187', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('b65e9ba8-b4cf-11e9-b41e-30b49efad619', '17', '培训视频分类', 'Videocate/index', '视频分类', '6ba44156-b4cc-11e9-b3e5-30b49efad619', '1', '1', '1', '0', '', '1564713982', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('b67f0ffc-b50e-11e9-9747-30b49efad619', '47', '图片管理', 'Sysimages/delPic', '删除图片', '525c1328-b4d0-11e9-b8fe-30b49efad619', '1', '1', '0', '0', null, '1564741040', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('bb2eeea4-b514-11e9-9ade-30b49efad619', '90', '发布在线文档', 'Helpdoc/delDocTrue', '彻底删除文档', '8e403ec4-b4cf-11e9-ae34-30b49efad619', '4', '2', '0', '0', null, '1564743625', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('bc86da7a-b4cc-11e9-80e9-30b49efad619', '7', null, 'extend', '扩展管理', '00000000-0000-0000-0000-000000000000', '7', '2', '1', '0', null, '1564712704', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('bff62b48-b50d-11e9-89d9-30b49efad619', '38', '广告管理', 'delAdvert', '删除广告', '1c83b792-b4d0-11e9-a91f-30b49efad619', '4', '2', '0', '0', null, '1564740627', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('c210bc32-b511-11e9-968f-30b49efad619', '68', '培训视频分类', 'Videocate/updateMenu', '修改视频分类', 'b65e9ba8-b4cf-11e9-b41e-30b49efad619', '2', '2', '0', '0', null, '1564742348', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('c3bb5ece-b512-11e9-b51c-30b49efad619', '77', '发布在线视频', 'Video/delDoc', '删除到回收站', 'd3a22fb8-b4cf-11e9-827a-30b49efad619', '2', '2', '0', '0', null, '1564742780', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('c4da668a-b4cf-11e9-afdb-30b49efad619', '18', '发布在线视频', 'Video/index', '视频列表', '6ba44156-b4cc-11e9-b3e5-30b49efad619', '2', '2', '1', '0', null, '1564714006', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('c6126784-b5bd-11e9-93c0-30b49efad619', '110', '主题设置', 'Tepname/index', '主题模板', 'bc86da7a-b4cc-11e9-80e9-30b49efad619', '1', '2', '1', '0', null, '1564816228', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('c998f894-b510-11e9-b908-30b49efad619', '62', '权限管理', 'Rule/move', '移动合并规则', '0cd5a9c2-b4d0-11e9-b2e5-30b49efad619', '6', '2', '0', '0', null, '1564741931', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('cf833706-b515-11e9-96c7-30b49efad619', '99', '门户文章', 'Menudoor/delMenu', '删除网站栏目', '0401c838-b4cd-11e9-82f9-30b49efad619', '4', '2', '0', '0', null, '1564744089', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('d05f9d4c-b513-11e9-939b-30b49efad619', '84', '在线文档分类', 'Helpcate/operate', '分类移动', '82c8be72-b4cf-11e9-93af-30b49efad619', '5', '2', '0', '0', null, '1564743231', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('d2db0074-b514-11e9-9e98-30b49efad619', '91', '发布在线文档', 'Helpdoc/backDoc', '还原文档', '991a925e-b4cf-11e9-a57b-30b49efad619', '2', '3', '0', '0', null, '1564743665', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('d3a22fb8-b4cf-11e9-827a-30b49efad619', '19', '发布在线视频', 'Video/back', '视频回收站', '6ba44156-b4cc-11e9-b3e5-30b49efad619', '3', '2', '1', '0', null, '1564714031', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('d904d91c-b50e-11e9-88bd-30b49efad619', '48', '数据管理', 'Sysdatabase/export', '备份数据库', '5d8ee856-b4d0-11e9-b286-30b49efad619', '1', '1', '0', '0', null, '1564741098', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('db0746c4-b50d-11e9-b979-30b49efad619', '39', '广告管理', 'Advert/addType', '添加广告位', '2701e018-b4d0-11e9-95c1-30b49efad619', '1', '1', '0', '0', null, '1564740672', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('dcaa0ddc-b511-11e9-8643-30b49efad619', '69', '培训视频分类', 'Videocate/setStatus', '设置状态', 'b65e9ba8-b4cf-11e9-b41e-30b49efad619', '3', '2', '0', '0', null, '1564742393', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('e00aa334-b4cf-11e9-b2be-30b49efad619', '20', '专题管理', 'Special/index', '发布专题', '7ed4572a-b4cc-11e9-8d8b-30b49efad619', '1', '1', '1', '0', null, '1564714052', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('e18a090a-b4cc-11e9-b47f-30b49efad619', '8', '基本配置', 'Sysoptions/index', '基本配置', '454eeb5a-b4cc-11e9-a98c-30b49efad619', '1', '1', '1', '0', '', '1564712766', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('e69cb068-b513-11e9-af49-30b49efad619', '85', '在线文档分类', 'Helpcate/move', '移动合并分类', '82c8be72-b4cf-11e9-93af-30b49efad619', '6', '2', '0', '0', null, '1564743268', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('e6fd75d4-b512-11e9-b0ab-30b49efad619', '78', '发布在线视频', 'Video/backDoc', '还原视频', 'd3a22fb8-b4cf-11e9-827a-30b49efad619', '1', '1', '0', '0', null, '1564742840', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('e88bf7ba-b515-11e9-9270-30b49efad619', '100', '门户文章', 'Menudoor/operate', '栏目移动', '0401c838-b4cd-11e9-82f9-30b49efad619', '5', '2', '0', '0', null, '1564744131', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('ee99c950-b50d-11e9-88fc-30b49efad619', '40', '广告管理', 'Advert/updateType', '修改广告位', '2701e018-b4d0-11e9-95c1-30b49efad619', '2', '2', '0', '0', null, '1564740705', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('ef8a1a84-b514-11e9-8228-30b49efad619', '92', '图片素材', 'Picture/addPic', '添加图集', '6f25c0ea-b4cf-11e9-af4f-30b49efad619', '1', '1', '0', '0', null, '1564743713', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('f59226b8-b511-11e9-ab95-30b49efad619', '70', '培训视频分类', 'Videocate/delMenu', '删除视频分类', 'b65e9ba8-b4cf-11e9-b41e-30b49efad619', '4', '2', '0', '0', null, '1564742435', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('f594b762-b4cf-11e9-93dc-30b49efad619', '21', '权限管理', 'Account/index', '用户管理', '954684c4-b4cc-11e9-b507-30b49efad619', '1', '1', '1', '0', '', '1564714088', null, null, '1');
INSERT INTO `sunny_auth_rule` VALUES ('f8e234a0-b50e-11e9-93a8-30b49efad619', '49', '数据管理', 'Sysdatabase/optimize', '优化数据表', '5d8ee856-b4d0-11e9-b286-30b49efad619', '2', '2', '0', '0', null, '1564741152', null, null, '1');

-- ----------------------------
-- Table structure for sunny_backmsg
-- ----------------------------
DROP TABLE IF EXISTS `sunny_backmsg`;
CREATE TABLE `sunny_backmsg` (
  `ID` char(36) NOT NULL COMMENT '主键 32位',
  `project` varchar(60) NOT NULL DEFAULT '' COMMENT '项目分类所属',
  `userID` char(36) DEFAULT '' COMMENT '用户ID',
  `baktitle` varchar(120) DEFAULT '' COMMENT '反馈内容标题',
  `bakcontent` varchar(500) DEFAULT '' COMMENT '反馈内容',
  `pics` varchar(500) DEFAULT '' COMMENT '图片路径',
  `Handleinfo` varchar(500) DEFAULT '' COMMENT '处理内容 ',
  `HandleType` tinyint(1) DEFAULT '0' COMMENT '处理归档 1使用问题 2错误问题 3需求问题',
  `isHandle` tinyint(1) DEFAULT '0' COMMENT '处理状态 0未处理  1已处理',
  `handleTime` int(11) DEFAULT '0' COMMENT '处理时间 ',
  `bakTime` int(11) DEFAULT '0' COMMENT '反馈时间',
  `handleName` varchar(60) DEFAULT '' COMMENT '处理人名称',
  `handleID` char(36) DEFAULT '' COMMENT '处理人ID',
  `IP` char(15) DEFAULT '' COMMENT 'ip地址',
  `browser` varchar(200) DEFAULT '' COMMENT '浏览器',
  `osinfo` varchar(60) DEFAULT '' COMMENT '访问设备',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='反馈表';

-- ----------------------------
-- Records of sunny_backmsg
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_comments
-- ----------------------------
DROP TABLE IF EXISTS `sunny_comments`;
CREATE TABLE `sunny_comments` (
  `ID` char(36) NOT NULL COMMENT '评论主键ID',
  `parentID` char(36) DEFAULT NULL COMMENT '评论父级id',
  `articleID` char(36) DEFAULT '' COMMENT '文章ID',
  `userID` char(36) DEFAULT NULL COMMENT '用户ID',
  `uname` varchar(60) DEFAULT '' COMMENT '用户名称',
  `to_uid` char(36) DEFAULT '' COMMENT '被评论的用户id',
  `c_type` tinyint(1) DEFAULT '0' COMMENT '评论类型 1用户评论 0游客评论 ',
  `content` varchar(500) DEFAULT '' COMMENT '评论内容',
  `create_time` int(11) DEFAULT '0' COMMENT '回复时间',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态，1已审核，0未审核',
  `IP` char(32) DEFAULT '0' COMMENT 'IP地址',
  `path` varchar(45) DEFAULT NULL COMMENT '层次',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论表';

-- ----------------------------
-- Records of sunny_comments
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_filedocument
-- ----------------------------
DROP TABLE IF EXISTS `sunny_filedocument`;
CREATE TABLE `sunny_filedocument` (
  `ID` char(36) NOT NULL,
  `title` varchar(120) DEFAULT '' COMMENT '操作文档标题',
  `info` varchar(500) DEFAULT '' COMMENT '操作文档简介',
  `content` text COMMENT '概要',
  `pic` varchar(100) DEFAULT '' COMMENT '封面图片',
  `click` smallint(10) DEFAULT '0' COMMENT '点击数',
  `comments` smallint(10) DEFAULT '0' COMMENT '评论数',
  `status` tinyint(1) DEFAULT NULL COMMENT '是否显示 0不显示 1显示的',
  `authorID` char(36) DEFAULT NULL COMMENT '作者ID',
  `author` varchar(60) DEFAULT NULL COMMENT '作者',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作文档表';

-- ----------------------------
-- Records of sunny_filedocument
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_flag
-- ----------------------------
DROP TABLE IF EXISTS `sunny_flag`;
CREATE TABLE `sunny_flag` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `flag` varchar(30) DEFAULT '' COMMENT '标签值',
  `articleID` char(36) DEFAULT '' COMMENT '文章id',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标签表';

-- ----------------------------
-- Records of sunny_flag
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_link
-- ----------------------------
DROP TABLE IF EXISTS `sunny_link`;
CREATE TABLE `sunny_link` (
  `ID` char(36) NOT NULL,
  `linkname` varchar(100) NOT NULL DEFAULT '' COMMENT '链接名称',
  `link` varchar(120) NOT NULL DEFAULT '' COMMENT '链接地址',
  `pic` varchar(150) NOT NULL DEFAULT '' COMMENT '链接图片',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 不显示  1显示',
  `sort` smallint(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `mark` varchar(500) NOT NULL COMMENT '备注',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友情链接';

-- ----------------------------
-- Records of sunny_link
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_login_log
-- ----------------------------
DROP TABLE IF EXISTS `sunny_login_log`;
CREATE TABLE `sunny_login_log` (
  `ID` char(36) NOT NULL,
  `sessionID` varchar(32) DEFAULT NULL,
  `uid` char(36) DEFAULT NULL COMMENT '用户ID',
  `uname` varchar(100) DEFAULT NULL COMMENT '用户名称',
  `IP` char(15) DEFAULT '' COMMENT '登陆IP',
  `vtime` int(11) DEFAULT '0' COMMENT '访问时间 ',
  `browser` varchar(200) DEFAULT '' COMMENT '浏览器',
  `osname` varchar(60) DEFAULT '' COMMENT '访问设备',
  `state` tinyint(1) DEFAULT '0' COMMENT '是否登录成功 0      2不成功 1成功',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登陆信息记录表';

-- ----------------------------
-- Records of sunny_login_log
-- ----------------------------
INSERT INTO `sunny_login_log` VALUES ('0275c4ea-b74a-11e9-bb56-30b49efad619', 'q3ja8o89smpndqmsrm322in063', '3e78ad7e-a83e-11e9-9dc5-30b49efad619', 'adminxzc', '127.0.0.1', '1564986410', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36', 'windows', '1');

-- ----------------------------
-- Table structure for sunny_menu
-- ----------------------------
DROP TABLE IF EXISTS `sunny_menu`;
CREATE TABLE `sunny_menu` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `name` varchar(60) DEFAULT '' COMMENT '分类名称',
  `pid` char(36) DEFAULT NULL COMMENT '父级分类',
  `status` tinyint(1) DEFAULT '0' COMMENT '显示状态 0 不显示 1显示',
  `sort` smallint(10) DEFAULT '0' COMMENT '排序',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门户菜单';

-- ----------------------------
-- Records of sunny_menu
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_msg
-- ----------------------------
DROP TABLE IF EXISTS `sunny_msg`;
CREATE TABLE `sunny_msg` (
  `ID` char(36) NOT NULL COMMENT '主键 32位',
  `project` char(36) DEFAULT '0' COMMENT '咨询项目分类',
  `userID` char(36) DEFAULT '' COMMENT '用户ID',
  `uname` varchar(60) DEFAULT '' COMMENT '姓名',
  `mobile` varchar(20) DEFAULT '' COMMENT '手机号',
  `qq` varchar(20) DEFAULT '' COMMENT 'qq号',
  `weixin` varchar(60) DEFAULT '' COMMENT '微信号',
  `email` varchar(100) DEFAULT '' COMMENT '邮箱',
  `msgcontent` varchar(500) DEFAULT '' COMMENT '内容',
  `create_time` int(11) DEFAULT '0' COMMENT '留言时间',
  `IP` char(15) DEFAULT '0' COMMENT 'IP地址',
  `osname` varchar(60) DEFAULT '' COMMENT '访问设备',
  `browser` varchar(120) DEFAULT '' COMMENT '浏览器版本 ',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='留言表';

-- ----------------------------
-- Records of sunny_msg
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_news
-- ----------------------------
DROP TABLE IF EXISTS `sunny_news`;
CREATE TABLE `sunny_news` (
  `ID` varchar(36) NOT NULL,
  `news_title` varchar(255) NOT NULL COMMENT '文章标题',
  `news_titleshort` varchar(100) DEFAULT NULL COMMENT '简短标题',
  `news_columnid` varchar(36) NOT NULL COMMENT '分类',
  `news_key` varchar(100) DEFAULT NULL COMMENT '文章关键字',
  `news_tag` varchar(50) DEFAULT '' COMMENT '文章标签',
  `news_auto` varchar(20) NOT NULL COMMENT '作者',
  `news_content` longtext NOT NULL COMMENT '新闻内容',
  `news_scontent` varchar(200) NOT NULL DEFAULT '',
  `news_hits` int(11) NOT NULL DEFAULT '200' COMMENT '点击率',
  `news_img` varchar(100) DEFAULT '' COMMENT '大图地址',
  `news_pic_type` tinyint(2) NOT NULL COMMENT '1=普通模式 2=腾讯模式',
  `news_pic_allurl` text COMMENT '多图路径',
  `news_time` int(11) NOT NULL,
  `listorder` int(11) unsigned DEFAULT '50',
  `news_modified` int(11) unsigned DEFAULT '0' COMMENT '修改时间',
  `news_flag` set('h','c','f','a','s','p','j','d','cp') NOT NULL DEFAULT '' COMMENT '文章属性',
  `news_zaddress` varchar(100) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `news_back` int(2) NOT NULL DEFAULT '0' COMMENT '是否为回收站 0正常  1回收站',
  `news_open` varchar(2) DEFAULT '0' COMMENT '0代表审核不通过 1代表审核通过',
  `comment_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=可评论 0=不可评论',
  `comment_count` int(11) unsigned DEFAULT '0' COMMENT '评论数',
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门户文章管理';

-- ----------------------------
-- Records of sunny_news
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_oplog
-- ----------------------------
DROP TABLE IF EXISTS `sunny_oplog`;
CREATE TABLE `sunny_oplog` (
  `ID` varchar(36) NOT NULL DEFAULT '' COMMENT '主键ID 32位',
  `operationID` varchar(36) NOT NULL DEFAULT '' COMMENT '操作人ID',
  `operationName` varchar(45) NOT NULL DEFAULT '' COMMENT '操作人名称',
  `contents` varchar(1000) NOT NULL DEFAULT '' COMMENT '操作描述',
  `IP` char(15) NOT NULL DEFAULT '' COMMENT 'IP地址',
  `optime` int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
  `delete_time` int(11) DEFAULT NULL,
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作日志表';

-- ----------------------------
-- Records of sunny_oplog
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_options
-- ----------------------------
DROP TABLE IF EXISTS `sunny_options`;
CREATE TABLE `sunny_options` (
  `id` char(36) NOT NULL COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL COMMENT '配置说明',
  `value` text NOT NULL COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可见性',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `group` (`group`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='配置';

-- ----------------------------
-- Records of sunny_options
-- ----------------------------
INSERT INTO `sunny_options` VALUES ('0f14c840-b291-11f9-b2e6-3jb49etad619', 'template_type', '3', '模板分类', '2', '', '模板访问设备分类', '1:电脑端\r\n2:移动端', '3', '0');
INSERT INTO `sunny_options` VALUES ('0fa368a6-b291-11e9-92bd-30b49efad619', 'comment_key', '2', '评论敏感词', '2', '', '评论敏感词,每行一个', 'www\nhttp://\n.com', '8', '1');
INSERT INTO `sunny_options` VALUES ('0fa368a6-b291-11e9-92bd-31b49efad619', 'document_position', '3', '常见问题属性', '2', '', '多个位置KEY值相加即可', '1:最新\r\n2:最热\r\n3:实用\r\n4:置顶', '3', '0');
INSERT INTO `sunny_options` VALUES ('0fa38fb6-b291-11e9-9deb-30b49efad619', 'data_save_compress_level', '6', '数据压缩等级', '2', '1:普通\r\n4:一般\r\n9:最高', '', '4', '2', '1');
INSERT INTO `sunny_options` VALUES ('0fa38fb6-b291-11e9-aac4-30b49efad619', 'data_save_compress', '4', '数据压缩', '2', '0:关闭\r\n1:开启', '是否启用数据压缩，在添加小说数据前修改，有了小说数据后不要修改否则会到导致出错', '1', '2', '1');
INSERT INTO `sunny_options` VALUES ('0fa38fb6-b291-11e9-b140-30b49efad619', 'config_group_list', '3', '配置分组', '4', '', '配置分组', '1:基本\r\n2:内容\r\n3:用户\r\n4:备份\r\n5:附件', '4', '0');
INSERT INTO `sunny_options` VALUES ('0fa3b6c6-b291-11e9-84e8-30b49efad619', 'user_allow_register', '4', '注册开关', '3', '0:关闭\r\n1:开启', '是否开放用户注册', '1', '1', '1');
INSERT INTO `sunny_options` VALUES ('0fa3b6c6-b291-11e9-9759-30b49efad619', 'data_backup_compress', '4', '启用压缩', '4', '0:不压缩\r\n1:压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '1', '3', '1');
INSERT INTO `sunny_options` VALUES ('0fa3b6c6-b291-11e9-9799-30b49efad619', 'data_backup_path', '0', '根路径', '4', '', '路径必须以 / 结尾', './database/', '1', '1');
INSERT INTO `sunny_options` VALUES ('0fa3b6c6-b291-11e9-b054-30b49efad619', 'data_backup_part_size', '0', '份卷大小', '4', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '20971520', '2', '1');
INSERT INTO `sunny_options` VALUES ('0fa3b6c6-b291-11e9-be33-30b49efad619', 'list_rows', '0', '后台记录数', '2', '', '后台数据每页显示记录数', '20', '0', '1');
INSERT INTO `sunny_options` VALUES ('0fa3ddd6-b291-11e9-8b42-30b49efad619', 'meta_title', '1', '网站名称', '1', '', '网站名称', '医诊通管理平台', '1', '1');
INSERT INTO `sunny_options` VALUES ('0fa3ddd6-b291-11e9-9a8c-30b49efad619', 'url', '1', '网站地址', '1', '', '网站域名地址', 'http://yizhentong.vip', '2', '1');
INSERT INTO `sunny_options` VALUES ('0fa3ddd6-b291-11e9-aa1f-30b49efad619', 'data_backup_compress_level', '6', '压缩级别', '4', '1:普通\r\n4:一般\r\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '9', '4', '1');
INSERT INTO `sunny_options` VALUES ('0fa3ddd6-b291-11e9-b80b-30b49efad619', 'logo', '7', '网站logo', '1', '', '', '\\uploads\\logo\\2019-08-01\\5d4255cbd5bcb.png', '3', '1');
INSERT INTO `sunny_options` VALUES ('0fa3ddd6-b291-11e9-be32-30b49efad619', 'meta_description', '2', 'SEO描述', '1', '', '网站搜索引擎描述', '医诊通管理平台', '6', '1');
INSERT INTO `sunny_options` VALUES ('0fa404e6-b291-11e9-a9fb-30b49efad619', 'search_on', '4', '搜索开关', '2', '0:关闭\r\n1:开启', '搜索开关', '1', '1', '1');
INSERT INTO `sunny_options` VALUES ('0fa404e6-b291-11e9-b2d2-30b49efad619', 'search_timespan', '0', '搜索间隔', '2', '', '单位秒，建议设置为3秒以上', '3', '2', '1');
INSERT INTO `sunny_options` VALUES ('0fa404e6-b291-11e9-b2eb-30b49efad619', 'meta_keywords', '2', 'SEO关键字', '1', '', '网站搜索引擎关键字', '医诊通管理平台', '5', '1');
INSERT INTO `sunny_options` VALUES ('0fa404e6-b291-11e9-be10-30b49efad619', 'default_tpl', '1', '模板目录', '1', '', '', 'template/home', '0', '0');
INSERT INTO `sunny_options` VALUES ('0fa42c00-b291-11e9-9845-30b49efad619', 'close', '4', '站点状态', '1', '0:关闭\r\n1:开启', '站点关闭后不能访问', '1', '8', '1');
INSERT INTO `sunny_options` VALUES ('0fa42c00-b291-11e9-a057-30b49efad619', 'user_model_status', '4', '会员模块', '3', '0:关闭\r\n1:开启', '是否开启会员模块', '1', '0', '1');
INSERT INTO `sunny_options` VALUES ('0fa42c00-b291-11e9-b1f5-30b49efad619', 'icp', '1', '网站备案号', '1', '', '设置在网站底部显示的备案号', '医诊通管理平台', '7', '1');
INSERT INTO `sunny_options` VALUES ('0fa42c00-b291-11e9-b44e-30b49efad619', 'close_tip', '2', '关闭提示', '1', '', '', '网站维护中，请稍后访问。', '9', '1');
INSERT INTO `sunny_options` VALUES ('0fa45310-b291-11e9-8ae3-30b49efad619', 'user_reg_status', '4', '注册状态', '3', '0:未审\r\n1:已审', '', '1', '2', '1');
INSERT INTO `sunny_options` VALUES ('0fa45310-b291-11e9-97b4-30b49efad619', 'user_login_verify', '4', '登录验证码', '3', '0:关闭\r\n1:开启', '', '0', '4', '1');
INSERT INTO `sunny_options` VALUES ('0fa45310-b291-11e9-9fae-30b49efad619', 'user_reg_verify', '4', '注册验证码', '3', '0:关闭\r\n1:开启', '', '0', '3', '1');
INSERT INTO `sunny_options` VALUES ('0fa45310-b291-11e9-aa8e-30b49efad619', 'data_cache', '4', '数据缓存', '2', '0:关闭\r\n1:开启', '', '0', '3', '1');
INSERT INTO `sunny_options` VALUES ('0fa47a20-b291-11e9-8b0f-30b49efad619', 'upload_path', '0', '上传目录', '5', '', '', 'uploads', '0', '1');
INSERT INTO `sunny_options` VALUES ('0fa47a20-b291-11e9-8c37-30b49efad619', 'html_cache', '4', '页面缓存', '2', '0:关闭\r\n1:开启', '', '0', '5', '1');
INSERT INTO `sunny_options` VALUES ('0fa4c840-b291-11e9-b2e6-30b49efad619', 'version', '0', '系统版本', '1', '', '', '1.0.0', '10', '1');

-- ----------------------------
-- Table structure for sunny_picfiles
-- ----------------------------
DROP TABLE IF EXISTS `sunny_picfiles`;
CREATE TABLE `sunny_picfiles` (
  `ID` char(36) NOT NULL COMMENT '主键 32位',
  `dirName` varchar(45) NOT NULL DEFAULT '' COMMENT '文件夹目录',
  `fileName` varchar(60) NOT NULL COMMENT '文件名称',
  `filePath` varchar(150) NOT NULL COMMENT '文件路径',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '图片状态   未使用  1使用',
  `size` varchar(45) NOT NULL DEFAULT '0' COMMENT '文件大小',
  `imgType` varchar(45) NOT NULL DEFAULT '' COMMENT '文件类型',
  `strPath` varchar(100) NOT NULL COMMENT '文件路径MD5加密 用于比较',
  `uploadTime` int(11) NOT NULL DEFAULT '0' COMMENT '上传时间',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图片管理表';

-- ----------------------------
-- Records of sunny_picfiles
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_picture
-- ----------------------------
DROP TABLE IF EXISTS `sunny_picture`;
CREATE TABLE `sunny_picture` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `cateID` char(36) DEFAULT NULL COMMENT '所属分类',
  `ptitle` varchar(150) DEFAULT NULL COMMENT '标题',
  `imgs` text COMMENT '多图地址',
  `picinfo` text COMMENT '描述',
  `link` varchar(255) DEFAULT NULL COMMENT '链接地址',
  `status` tinyint(1) DEFAULT '0' COMMENT '1显示',
  `sort` smallint(10) DEFAULT NULL COMMENT '排序',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图集';

-- ----------------------------
-- Records of sunny_picture
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_problem
-- ----------------------------
DROP TABLE IF EXISTS `sunny_problem`;
CREATE TABLE `sunny_problem` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `projectID` char(36) DEFAULT '' COMMENT '项目分类ID',
  `question` varchar(200) DEFAULT '' COMMENT '问题描述',
  `answer` varchar(500) DEFAULT '' COMMENT '问题详解',
  `status` tinyint(1) DEFAULT '0' COMMENT '审核显示 0 不显示1显示',
  `flag` tinyint(1) DEFAULT '0' COMMENT '问题属性 1 最新问题 2 最热问题 3最实用问题 4top问题',
  `author` varchar(60) DEFAULT '' COMMENT '作者名称',
  `authorID` char(36) DEFAULT '' COMMENT '作者ID',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='常见问题';

-- ----------------------------
-- Records of sunny_problem
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_project
-- ----------------------------
DROP TABLE IF EXISTS `sunny_project`;
CREATE TABLE `sunny_project` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `project` varchar(60) DEFAULT '' COMMENT '项目名称 ',
  `pinfo` varchar(1000) DEFAULT '' COMMENT '项目介绍',
  `teamInfo` varchar(1000) DEFAULT '' COMMENT '开发团队介绍',
  `kfinfo` varchar(1000) DEFAULT '' COMMENT '客服团队介绍',
  `skillInfo` varchar(1000) DEFAULT '' COMMENT '技术介绍',
  `sort` smallint(10) DEFAULT '0' COMMENT '排序',
  `authorID` char(36) DEFAULT NULL COMMENT '作者id',
  `author` varchar(60) DEFAULT '' COMMENT '作者',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目表';

-- ----------------------------
-- Records of sunny_project
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_question
-- ----------------------------
DROP TABLE IF EXISTS `sunny_question`;
CREATE TABLE `sunny_question` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `question` varchar(200) DEFAULT '' COMMENT '问题描述',
  `answer` varchar(500) DEFAULT '' COMMENT '问题详解',
  `status` tinyint(1) DEFAULT '0' COMMENT '审核显示 0 不显示1显示',
  `flag` tinyint(1) DEFAULT '0' COMMENT '问题属性 1 最新问题 2 最热问题 3最实用问题 4top问题',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL,
  `sort` smallint(10) DEFAULT NULL,
  `clicks` smallint(10) DEFAULT '0' COMMENT '点击率',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='常见问题';

-- ----------------------------
-- Records of sunny_question
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_sms_template
-- ----------------------------
DROP TABLE IF EXISTS `sunny_sms_template`;
CREATE TABLE `sunny_sms_template` (
  `ID` varchar(36) NOT NULL,
  `signature` varchar(20) NOT NULL DEFAULT '' COMMENT '短信签名',
  `content` varchar(255) NOT NULL COMMENT '短信内容',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信模板表';

-- ----------------------------
-- Records of sunny_sms_template
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_special
-- ----------------------------
DROP TABLE IF EXISTS `sunny_special`;
CREATE TABLE `sunny_special` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `sptitle` varchar(150) DEFAULT '' COMMENT '专题标题',
  `shortitle` varchar(120) DEFAULT NULL COMMENT '简短标题',
  `spinfo` varchar(300) DEFAULT '' COMMENT '专题介绍',
  `spcontent` longtext COMMENT '专题内容',
  `imgs` varchar(100) DEFAULT '' COMMENT '专题封面图片 ',
  `status` tinyint(1) DEFAULT '0' COMMENT '是否显示 0 不显示 1显示',
  `clicks` int(11) DEFAULT '0' COMMENT '点击量',
  `create_time` int(11) DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) DEFAULT '0' COMMENT '修改时间 ',
  `delete_time` int(11) DEFAULT NULL,
  `sort` smallint(11) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='专题表';

-- ----------------------------
-- Records of sunny_special
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_templated
-- ----------------------------
DROP TABLE IF EXISTS `sunny_templated`;
CREATE TABLE `sunny_templated` (
  `ID` char(36) NOT NULL,
  `imgs` varchar(255) DEFAULT NULL COMMENT '封面图片',
  `tname` varchar(60) DEFAULT NULL COMMENT '主题目录名称',
  `title` varchar(60) DEFAULT NULL COMMENT '主题描述',
  `status` tinyint(1) DEFAULT '0' COMMENT '1显示安装 0隐藏卸载',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `update_time` int(11) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1 PC 2 WAP 3自适应',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主题模板';

-- ----------------------------
-- Records of sunny_templated
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_user
-- ----------------------------
DROP TABLE IF EXISTS `sunny_user`;
CREATE TABLE `sunny_user` (
  `ID` varchar(36) NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '登录账号',
  `upassword` char(36) NOT NULL DEFAULT '' COMMENT '登录密码',
  `pwd_salt` char(10) NOT NULL DEFAULT '' COMMENT '密码盐值',
  `uname` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名称',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `umobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `uemail` varchar(100) DEFAULT NULL COMMENT '用户邮箱',
  `sex` tinyint(1) DEFAULT '0' COMMENT '性别',
  `headPic` varchar(100) DEFAULT NULL COMMENT '用户头像',
  `status` tinyint(1) DEFAULT NULL COMMENT '锁定审核状态',
  `is_moble` tinyint(1) DEFAULT '0' COMMENT '是否验证手机 0 未验证 1验证',
  `is_email` tinyint(1) DEFAULT '0' COMMENT '是否验证邮箱0 未验证 1验证',
  `regTime` int(11) DEFAULT '0' COMMENT '注册时间',
  `offTime` int(11) DEFAULT '0' COMMENT '注销时间',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站用户表';

-- ----------------------------
-- Records of sunny_user
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_video
-- ----------------------------
DROP TABLE IF EXISTS `sunny_video`;
CREATE TABLE `sunny_video` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `chapterID` varchar(60) DEFAULT '' COMMENT '章节id',
  `vititle` varchar(150) DEFAULT '' COMMENT '视频标题',
  `shortitle` varchar(100) DEFAULT NULL COMMENT '简短标题',
  `tags` varchar(255) DEFAULT NULL COMMENT '标签',
  `info` varchar(1000) DEFAULT '' COMMENT '视频描述',
  `imgs` varchar(120) DEFAULT NULL COMMENT '视频封面',
  `videourl` varchar(150) DEFAULT '' COMMENT '视频链接地址 ',
  `status` tinyint(1) DEFAULT '0' COMMENT '0 隐藏 1显示',
  `sort` smallint(10) DEFAULT '0' COMMENT '排序',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间 ',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `is_back` tinyint(1) DEFAULT '0' COMMENT '1到回收站',
  `clicks` int(10) DEFAULT '0',
  `comments` int(10) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='视频模块';

-- ----------------------------
-- Records of sunny_video
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_video_chapter
-- ----------------------------
DROP TABLE IF EXISTS `sunny_video_chapter`;
CREATE TABLE `sunny_video_chapter` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `cname` varchar(60) NOT NULL DEFAULT '' COMMENT '分类名称',
  `pid` char(36) NOT NULL COMMENT '父级分类',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '显示状态 0 不显示 1显示',
  `sort` smallint(10) DEFAULT '0' COMMENT '排序',
  `create_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='视频章节表';

-- ----------------------------
-- Records of sunny_video_chapter
-- ----------------------------

-- ----------------------------
-- Table structure for sunny_web_log
-- ----------------------------
DROP TABLE IF EXISTS `sunny_web_log`;
CREATE TABLE `sunny_web_log` (
  `ID` varchar(36) NOT NULL DEFAULT '' COMMENT '主键ID 32位',
  `userID` varchar(36) NOT NULL DEFAULT '' COMMENT '用户ID 32位',
  `IP` char(15) NOT NULL DEFAULT '' COMMENT '用户访问IP',
  `osType` varchar(100) NOT NULL DEFAULT '' COMMENT '访问设备',
  `browser` varchar(100) NOT NULL DEFAULT '' COMMENT '访问浏览器',
  `vtime` int(10) NOT NULL DEFAULT '0' COMMENT '访问时间',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '访问地址',
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '访问模块',
  `controller` varchar(45) NOT NULL DEFAULT '' COMMENT '访问控制器',
  `action` varchar(45) NOT NULL DEFAULT '' COMMENT '访问方法',
  `method` varchar(45) NOT NULL DEFAULT '' COMMENT '请求方式',
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站日志表 ';

-- ----------------------------
-- Records of sunny_web_log
-- ----------------------------

-- ----------------------------
-- Table structure for suuny_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `suuny_auth_group_access`;
CREATE TABLE `suuny_auth_group_access` (
  `ID` char(36) NOT NULL COMMENT '主键',
  `userid` char(36) DEFAULT NULL COMMENT '用户ID',
  `group_id` char(36) DEFAULT NULL COMMENT '角色id',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色与 权限中间表';

-- ----------------------------
-- Records of suuny_auth_group_access
-- ----------------------------
