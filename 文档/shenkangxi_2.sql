/*
 Navicat Premium Data Transfer

 Source Server         : MxSr
 Source Server Type    : MySQL
 Source Server Version : 50637
 Source Host           : localhost
 Source Database       : shenkangxi

 Target Server Type    : MySQL
 Target Server Version : 50637
 File Encoding         : utf-8

 Date: 04/04/2018 12:23:56 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `skx_address`
-- ----------------------------
DROP TABLE IF EXISTS `skx_address`;
CREATE TABLE `skx_address` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `postcode` varchar(6) NOT NULL,
  `details` varchar(150) NOT NULL,
  `status` tinyint(1) DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_address`
-- ----------------------------
BEGIN;
INSERT INTO `skx_address` VALUES ('18', '10000', '王波', '15755654774', '246511', '安徽>马鞍山市>当涂县>4323423范德萨范德萨发 反倒是rewr', '5'), ('19', '10000', '王波', '15755654774', '246511', '天津>县>蓟　县>4323423范德萨范德萨发 反倒是rewr', '5'), ('20', '10000', '王波', '15755654664', '246511', '湖北>黄石市>下陆区>4323423范德萨范德萨发 反倒是', '5');
COMMIT;

-- ----------------------------
--  Table structure for `skx_admin`
-- ----------------------------
DROP TABLE IF EXISTS `skx_admin`;
CREATE TABLE `skx_admin` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `account` varchar(15) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `pas_salt` varchar(6) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `department_id` mediumint(4) NOT NULL,
  `email` varchar(20) DEFAULT NULL,
  `last_login_time` int(10) DEFAULT NULL,
  `last_login_ip` varchar(16) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT '0',
  `status` tinyint(2) DEFAULT '10',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_admin`
-- ----------------------------
BEGIN;
INSERT INTO `skx_admin` VALUES ('1', 'admin', 'admin', 'af274a028f454ccd231a93a8d06e3137', 'OORc80', '13612929081', '1', null, '1522634407', '127.0.0.1', '1', '10'), ('2', 'cs', 'cs', 'b4b56071285f36c20bcbedd14b674e85', 'C3PGHr', '13612929081', '2', null, null, null, '0', '10');
COMMIT;

-- ----------------------------
--  Table structure for `skx_admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `skx_admin_role`;
CREATE TABLE `skx_admin_role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `admin_id` mediumint(8) NOT NULL,
  `role_id` mediumint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_admin_role`
-- ----------------------------
BEGIN;
INSERT INTO `skx_admin_role` VALUES ('1', '1', '1'), ('2', '70', '2'), ('3', '71', '3');
COMMIT;

-- ----------------------------
--  Table structure for `skx_admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `skx_admin_user`;
CREATE TABLE `skx_admin_user` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(255) DEFAULT NULL,
  `admin_pwd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `skx_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `skx_auth_group`;
CREATE TABLE `skx_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `skx_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `skx_auth_group_access`;
CREATE TABLE `skx_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `skx_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `skx_auth_rule`;
CREATE TABLE `skx_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `skx_brokerage`
-- ----------------------------
DROP TABLE IF EXISTS `skx_brokerage`;
CREATE TABLE `skx_brokerage` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `key` varchar(20) NOT NULL DEFAULT '',
  `value` varchar(32) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_brokerage`
-- ----------------------------
BEGIN;
INSERT INTO `skx_brokerage` VALUES ('1', '注册积分', 'reg_1', '5', 'reg'), ('2', '注册直推', 'reg_2', '3', 'reg'), ('3', 'v0创客一级提成', 'z_v_0', '5', 'share'), ('4', 'v1创客一级提成', 'z_v_1', '10', 'share'), ('5', 'v2创客一级提成', 'z_v_2', '20', 'share'), ('6', 'v0创客消费积分比例', 'g_v_0', '0', 'share'), ('7', 'v1创客消费积分比例', 'g_v_1', '5', 'share'), ('8', 'v2创客消费积分比例', 'g_v_2', '5', 'share'), ('9', '团队月费消费奖励', 'team_sell', '5', 'team_sell'), ('10', '总监月度特别奖', 'Director_m_award', '2', 'special'), ('11', '合伙人月度特别奖', 'Partner_m_award', '3', 'special'), ('12', '伯乐奖(平级奖)', 'pyji', '15', 'pyji'), ('13', '经理最低消费', 'mini_sell_1', '500', 'conditions'), ('14', '总监最低消费', 'mini_sell_2', '1000', 'conditions'), ('15', '合伙人最低消费', 'nini_sell_3', '2000', 'conditions'), ('16', '直推一代', 'z_one', '55', 'zhitui'), ('17', '直推二代', 'z_two', '10', 'zhitui');
COMMIT;

-- ----------------------------
--  Table structure for `skx_config`
-- ----------------------------
DROP TABLE IF EXISTS `skx_config`;
CREATE TABLE `skx_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  `value` varchar(90) NOT NULL,
  `info` varchar(90) NOT NULL,
  `module` varchar(15) NOT NULL,
  `module_name` varchar(90) NOT NULL,
  `extend_value` varchar(90) DEFAULT NULL,
  `use_for` varchar(150) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '5',
  `sort` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `module_status` (`module`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_config`
-- ----------------------------
BEGIN;
INSERT INTO `skx_config` VALUES ('1', 'income_code', '12345689', '收款卡号', 'index', '', 'income', null, '5', '1'), ('2', 'income_type', '10', '银行开户行', 'index', '', 'income', null, '5', '1'), ('3', 'income_name', '5', '收款人', 'index', '', 'income', null, '5', '1'), ('4', 'web_keyword', '3', '网站keyword', 'index', '', 'web', null, '5', '1'), ('5', 'web_description', '4', '网站description', 'index', '', 'web', null, '5', '1'), ('6', 'appid', '8', '公众号appid', 'index', '', 'weixin', null, '5', '1'), ('7', 'appsecret', '11', '公众号appsecret', 'index', '', 'weixin', null, '5', '1'), ('8', 'mchid', '1443269102', '微信商户号', 'index', '', 'weixin', null, '5', '1'), ('9', 'company', '大视野', '公司名称', 'index', '', 'weixin', null, '5', '1'), ('10', 'wxshoppwd', '4adwq45A454SAD21as5d421dw4q4ea4c', '微信商户支付密钥', 'index', '', 'weixin', null, '5', '1'), ('11', 'web_goods_notice', '恭喜大视野商场开放成功！', '积分商城公告', 'index', '', 'web', null, '5', '1'), ('12', 'web_index_notice', '恭喜大视野商场开放成功！恭喜大视野商场开放成功！', '首页公告', 'index', '', 'web', null, '5', '1');
COMMIT;

-- ----------------------------
--  Table structure for `skx_department`
-- ----------------------------
DROP TABLE IF EXISTS `skx_department`;
CREATE TABLE `skx_department` (
  `id` mediumint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_department`
-- ----------------------------
BEGIN;
INSERT INTO `skx_department` VALUES ('1', '技术部', '5'), ('2', '业务部', '5'), ('3', '管理部', '5');
COMMIT;

-- ----------------------------
--  Table structure for `skx_district`
-- ----------------------------
DROP TABLE IF EXISTS `skx_district`;
CREATE TABLE `skx_district` (
  `id` mediumint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) DEFAULT NULL,
  `type` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_district`
-- ----------------------------
BEGIN;
INSERT INTO `skx_district` VALUES ('1', '江浙沪', '1'), ('2', '珠三角', '1'), ('3', '港奥台', '1'), ('4', '海外', '1'), ('5', '北京', '2'), ('6', '上海', '2'), ('7', '广州', '2'), ('8', '深圳', '2'), ('9', '杭州', '2'), ('10', '温州', '2'), ('11', '宁波', '2'), ('12', '南京', '2'), ('13', '苏州', '2'), ('14', '济南', '2'), ('15', '青岛', '2'), ('16', '大连', '2'), ('17', '无锡', '2'), ('18', '合肥', '2'), ('19', '天津', '2'), ('20', '长沙', '2'), ('21', '武汉', '2'), ('22', '郑州', '2'), ('23', '石家庄', '2'), ('24', '成都', '2'), ('25', '重庆', '2'), ('26', '西安', '2'), ('27', '昆明', '2'), ('28', '南宁', '2'), ('29', '福州', '2'), ('30', '厦门', '2'), ('31', '南昌', '2'), ('32', '东莞', '2'), ('33', '沈阳', '2'), ('34', '长春', '2'), ('35', '哈尔滨', '2'), ('36', '安徽', '3'), ('37', '福建', '3'), ('38', '甘肃', '3'), ('39', '广东', '3'), ('40', '广西', '3'), ('41', '贵州', '3'), ('42', '海南', '3'), ('43', '河北', '3'), ('44', '河南', '3'), ('45', '湖北', '3'), ('46', '湖南', '3'), ('47', '江苏', '3'), ('48', '黑龙江', '3'), ('49', '江西', '3'), ('50', '吉林', '3'), ('51', '辽宁', '3'), ('52', '内蒙古', '3'), ('53', '宁夏', '3'), ('54', '青海', '3'), ('55', '山东', '3'), ('56', '山西', '3'), ('57', '陕西', '3'), ('58', '四川', '3'), ('59', '西藏', '3'), ('60', '新疆', '3'), ('61', '云南', '3'), ('62', '浙江', '3'), ('63', '香港', '3'), ('64', '澳门', '3'), ('65', '台湾', '3');
COMMIT;

-- ----------------------------
--  Table structure for `skx_goods`
-- ----------------------------
DROP TABLE IF EXISTS `skx_goods`;
CREATE TABLE `skx_goods` (
  `id` int(10) NOT NULL,
  `goods_name` varchar(32) NOT NULL DEFAULT '',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sales_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `details` varchar(2000) NOT NULL DEFAULT '',
  `img` varchar(400) NOT NULL DEFAULT '',
  `stock` int(6) NOT NULL DEFAULT '1' COMMENT '库存',
  `status` tinyint(1) NOT NULL DEFAULT '5' COMMENT '10:上线 5：下线',
  `sort` int(10) NOT NULL DEFAULT '0',
  `add_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_goods`
-- ----------------------------
BEGIN;
INSERT INTO `skx_goods` VALUES ('1', '小商品', '10.00', '20.00', '<p><img src=\"/Uploader/ueditor/php/upload/image/20180401/1522563389969534.jpg\" title=\"1522563389969534.jpg\" alt=\"product2.jpg\"/></p>', '/Uploader/goods/20180401/0e6559dca575b7939fe5a8a05a4dfe80.jpg', '1000', '10', '1', '1522229304');
COMMIT;

-- ----------------------------
--  Table structure for `skx_goods_order`
-- ----------------------------
DROP TABLE IF EXISTS `skx_goods_order`;
CREATE TABLE `skx_goods_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(64) NOT NULL DEFAULT '',
  `uid` int(10) NOT NULL,
  `goods_id` int(10) NOT NULL,
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `buy_num` int(5) NOT NULL DEFAULT '1',
  `goods_name` varchar(64) NOT NULL,
  `address_id` int(10) NOT NULL DEFAULT '0',
  `proof` varchar(200) NOT NULL DEFAULT '' COMMENT '上传凭证',
  `status` tinyint(2) NOT NULL DEFAULT '10' COMMENT '5: 驳回 10:待上传凭证 20：已发货',
  `add_time` int(10) NOT NULL,
  `buy_time` int(10) NOT NULL DEFAULT '0',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `express_code` varchar(32) NOT NULL DEFAULT '',
  `f_time` int(10) NOT NULL DEFAULT '0',
  `pay_time` int(10) NOT NULL DEFAULT '0',
  `express_name` varchar(32) NOT NULL DEFAULT '',
  `payway` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 线上 2线下',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_goods_order`
-- ----------------------------
BEGIN;
INSERT INTO `skx_goods_order` VALUES ('1', 'sj152224442110000', '10000', '1', '20.00', '3', '小商品', '19', '', '10', '1522244421', '0', '60.00', '', '0', '0', '', '1'), ('2', 'sj152224604010000', '10000', '1', '20.00', '7', '小商品', '18', '/Uploader/Shopping/proof/20180328/5f54c97c1f413a112a3e8b60c2171bdf.jpg', '5', '1522246040', '0', '140.00', '', '0', '0', '', '1'), ('3', 'sj152224635910000', '10000', '1', '20.00', '3', '小商品', '19', '/Uploader/Shopping/proof/20180328/770365959fa1df19e3267e9f8b682af4.jpg', '5', '1522246359', '0', '60.00', '', '0', '0', '', '1');
COMMIT;

-- ----------------------------
--  Table structure for `skx_jifen`
-- ----------------------------
DROP TABLE IF EXISTS `skx_jifen`;
CREATE TABLE `skx_jifen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `username` varchar(32) NOT NULL DEFAULT '',
  `jifen` decimal(10,2) NOT NULL DEFAULT '0.00',
  `add_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `skx_menu`
-- ----------------------------
DROP TABLE IF EXISTS `skx_menu`;
CREATE TABLE `skx_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(20) NOT NULL,
  `module_id` mediumint(6) NOT NULL,
  `module_name` varchar(30) NOT NULL,
  `module` varchar(20) DEFAULT NULL,
  `controller` varchar(30) NOT NULL,
  `action` varchar(30) NOT NULL,
  `sort` tinyint(2) DEFAULT '1',
  `startTime` int(10) NOT NULL,
  `admin_id` mediumint(6) NOT NULL,
  `status` tinyint(2) DEFAULT '5',
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_menu`
-- ----------------------------
BEGIN;
INSERT INTO `skx_menu` VALUES ('2', '员工列表', '2', '员工管理', 'admin', 'Admin', 'index', '23', '1514201077', '1', '10'), ('3', '菜单列表', '1', '系统管理', 'admin', 'Menu', 'index', '99', '0', '1', '10'), ('7', '模块管理', '1', '系统管理', 'admin', 'Module', 'index', '85', '1496212220', '1', '10'), ('9', '添加菜单', '1', '系统管理', 'admin', 'Menu', 'add', '1', '1496217854', '1', '5'), ('10', '角色管理', '1', '系统管理', 'admin', 'Role', 'index', '2', '1496224732', '1', '10'), ('11', '角色权限', '1', '系统管理', 'admin', 'Privilege', 'index', '1', '1496280210', '1', '10'), ('12', '添加员工', '2', '员工管理', 'admin', 'Admin', 'add', '1', '1496367636', '1', '5'), ('13', '员工修改', '2', '员工管理', 'admin', 'Admin', 'edit', '1', '1496367697', '1', '5'), ('14', '员工删除', '2', '员工管理', 'admin', 'Admin', 'delete', '1', '1496367755', '1', '5'), ('24', '员工角色', '2', '员工管理', 'admin', 'Admin', 'adminrole', '1', '1496367755', '1', '10'), ('25', '部门管理', '2', '员工管理', 'admin', 'Department', 'index', '1', '0', '0', '10'), ('26', '升级商品列表', '7', '升级商城', null, 'Package', 'index', '99', '1522313087', '1', '10'), ('27', '升级商品编辑', '7', '升级商城', null, 'Package', 'add', '80', '1522313417', '1', '10'), ('28', '升级商品订单', '7', '升级商城', null, 'PackageOrder', 'order', '70', '1522491584', '1', '10'), ('29', '订单详情', '7', '升级商城', null, 'PackageOrder', 'order_details', '20', '1522319337', '1', '5'), ('30', '升级商品修改', '7', '升级商城', null, 'Package', 'edit', '78', '1522314149', '1', '5'), ('31', '升级商城图片上传', '7', '升级商城', null, 'Package', 'up_image', '10', '1522315215', '1', '0'), ('32', '订单删除', '7', '升级商城', null, 'Package', 'order_del', '1', '1522315253', '1', '0'), ('33', '积分商品列表', '6', '积分商城', null, 'Product', 'index', '90', '1522315465', '1', '10'), ('34', '积分商品编辑', '6', '积分商城', null, 'Product', 'add', '80', '1522315506', '1', '10'), ('35', '积分商品订单', '6', '积分商城', null, 'ProductOrder', 'order', '70', '1522491707', '1', '10'), ('36', '订单发货', '6', '积分商城', null, 'ProductOrder', 'order_fh', '10', '1522316432', '1', '5'), ('37', '修改商品', '6', '积分商城', null, 'Product', 'edit', '10', '1522316524', '1', '5'), ('38', '订单详情', '6', '积分商城', null, 'ProductOrder', 'details', '1', '1522316592', '1', '5'), ('39', '订单发货', '7', '升级商城', null, 'PackageOrder', 'order_fh', '19', '1522319348', '1', '5'), ('48', '小商店商品列表', '8', '小商城', null, 'Goods', 'index', '90', '1522318022', '1', '10'), ('52', '编辑商品', '8', '小商城', null, 'Goods', 'add', '80', '1522318855', '1', '10'), ('53', '订单列表', '8', '小商城', null, 'GoodsOrder', 'order', '70', '1522319130', '1', '10'), ('54', '订单发货', '8', '小商城', null, 'GoodsOrder', 'order_fh', '10', '1522319171', '1', '5'), ('55', '修改商品', '8', '小商城', null, 'Goods', 'edit', '10', '1522319202', '1', '5'), ('56', '订单详情', '8', '小商城', null, 'GoodsOrder', 'details', '1', '1522319232', '1', '5'), ('57', '创客列表', '9', '创客级别管理', null, 'ShoppingLevel', 'index', '90', '1522566706', '1', '10'), ('58', '创客编辑', '9', '创客级别管理', null, 'ShoppingLevel', 'edit', '80', '1522566755', '1', '10'), ('59', '会员列表', '10', '会员管理', null, 'User', 'index', '90', '1522636662', '1', '10'), ('62', '配置列表', '11', '收益配置', null, 'brokerage', 'index', '90', '1522659740', '1', '10'), ('66', '会员充值', '10', '会员管理', null, 'recharge', 'index', '70', '1522742210', '1', '10');
COMMIT;

-- ----------------------------
--  Table structure for `skx_module`
-- ----------------------------
DROP TABLE IF EXISTS `skx_module`;
CREATE TABLE `skx_module` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `sort` tinyint(2) DEFAULT '1',
  `status` tinyint(2) DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf32;

-- ----------------------------
--  Records of `skx_module`
-- ----------------------------
BEGIN;
INSERT INTO `skx_module` VALUES ('1', '系统管理', '1', '5'), ('2', '员工管理', '15', '5'), ('6', '积分商城', '30', '5'), ('7', '升级商城', '40', '5'), ('8', '小商城', '20', '5'), ('9', '创客级别管理', '50', '5'), ('10', '会员管理', '60', '5'), ('11', '收益配置', '70', '5');
COMMIT;

-- ----------------------------
--  Table structure for `skx_package`
-- ----------------------------
DROP TABLE IF EXISTS `skx_package`;
CREATE TABLE `skx_package` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pname` varchar(128) NOT NULL DEFAULT '',
  `sales_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cost_price` decimal(10,2) NOT NULL,
  `img` varchar(300) NOT NULL DEFAULT '',
  `details` varchar(2000) NOT NULL,
  `sort` int(1) unsigned NOT NULL DEFAULT '1',
  `add_time` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '5' COMMENT '0删除 5:下线 10：上线',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_package`
-- ----------------------------
BEGIN;
INSERT INTO `skx_package` VALUES ('1', '炸药包', '10000.00', '5000.00', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', 'xxxxxxxxxxxxx', '1', '1521700380', '1521700380', '10'), ('2', '炸药包', '10000.00', '5000.00', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', 'xxxxxxxxxxxxx', '1', '1521700380', '1521700380', '10'), ('3', '炸药包', '10000.00', '5000.00', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', 'xxxxxxxxxxxxx', '1', '1521700380', '1521700380', '10'), ('4', '炸药包', '10000.00', '5000.00', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', 'xxxxxxxxxxxxx', '1', '1521700380', '1521700380', '10'), ('5', '炸药包', '10000.00', '5000.00', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', 'xxxxxxxxxxxxx', '1', '1521700380', '1521700380', '0'), ('6', '炸药包', '10000.00', '5000.00', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', 'xxxxxxxxxxxxx', '1', '1521700380', '1521700380', '10'), ('7', 'das', '200.00', '100.00', '/Uploader/Package/20180330/f455770c378dc27eae0f30f8a8cde277.jpg', '<p><img src=\"/Uploader/ueditor/php/upload/image/20180330/1522403376757044.jpg\" title=\"1522403376757044.jpg\" alt=\"product2.jpg\"/></p>', '45', '1522403380', '0', '10'), ('8', 'dddd', '200.00', '100.00', '/Uploader/Package/20180330/f455770c378dc27eae0f30f8a8cde277.jpg', '<p><img src=\"/Uploader/ueditor/php/upload/image/20180330/1522403376757044.jpg\" title=\"1522403376757044.jpg\" alt=\"product2.jpg\"/></p>', '45', '1522403699', '0', '10'), ('9', 'fdsaf', '200.00', '100.00', '/Uploader/Package/20180330/f455770c378dc27eae0f30f8a8cde277.jpg', '<p><img src=\"/Uploader/ueditor/php/upload/image/20180330/1522403376757044.jpg\" title=\"1522403376757044.jpg\" alt=\"product2.jpg\"/></p>', '45', '1522403782', '0', '10'), ('10', 'dasd', '200.00', '100.00', '/Uploader/Package/20180330/f455770c378dc27eae0f30f8a8cde277.jpg', '<p><img src=\"/Uploader/ueditor/php/upload/image/20180330/1522403376757044.jpg\" title=\"1522403376757044.jpg\" alt=\"product2.jpg\"/></p>', '45', '1522403829', '0', '10'), ('11', 'dsadasxxxxxxxxx1111', '200.00', '100.00', '/Uploader/Package/20180330/f455770c378dc27eae0f30f8a8cde277.jpg', '<p><img src=\"/Uploader/ueditor/php/upload/image/20180330/1522403376757044.jpg\" title=\"1522403376757044.jpg\" alt=\"product2.jpg\"/></p>', '45', '1522403866', '0', '10');
COMMIT;

-- ----------------------------
--  Table structure for `skx_package_order`
-- ----------------------------
DROP TABLE IF EXISTS `skx_package_order`;
CREATE TABLE `skx_package_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(32) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '产品包id',
  `uid` int(10) NOT NULL,
  `pname` varchar(32) NOT NULL DEFAULT '',
  `pimg` varchar(500) NOT NULL DEFAULT '',
  `buy_num` int(3) NOT NULL DEFAULT '1',
  `sales_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '所用金额',
  `buy_time` int(10) NOT NULL DEFAULT '0',
  `payway` int(2) NOT NULL DEFAULT '1' COMMENT '1 线上支付   2线下支付',
  `proof` varchar(200) NOT NULL DEFAULT '',
  `addres_id` int(10) NOT NULL DEFAULT '0',
  `f_time` int(10) NOT NULL DEFAULT '0',
  `express_code` varchar(32) NOT NULL DEFAULT '',
  `express_name` varchar(32) NOT NULL DEFAULT '',
  `pay_time` int(10) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '10' COMMENT '0 删除 5驳回 10 待上传凭证 20已发货',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_package_order`
-- ----------------------------
BEGIN;
INSERT INTO `skx_package_order` VALUES ('1', 'sj152196215210000', '1', '10000', '炸药包', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', '3', '0.00', '30000', '1521962152', '1', '/Uploader/Shopping/proof/20180328/798c3ce3ba44245d676c7947eb542e19.jpg', '0', '0', '', '', '0', '15'), ('2', 'sj152196263810000', '1', '10000', '炸药包', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', '3', '0.00', '30000', '1521962638', '1', '', '0', '0', '', '', '0', '5'), ('3', 'sj152196263810000', '1', '10000', '炸药包', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', '3', '0.00', '30000', '1521962638', '1', '/Uploader/Shopping/proof/20180326/9578a2cb10649e3d6163d32200784cd2.jpg', '0', '0', '', '', '0', '5'), ('4', 'sj152212379210000', '1', '10000', '炸药包', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', '3', '0.00', '30000', '1522123792', '1', '/Uploader/Shopping/proof/20180327/7e5a21781f1c350d6255c1560f9f1fc6.jpg', '0', '0', '', '', '0', '5'), ('5', 'sj152220665310000', '1', '10000', '炸药包', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', '2', '0.00', '20000', '1522206653', '1', '/Uploader/Shopping/proof/20180328/e142228e08f7517c44912761138ed9f5.jpg', '0', '0', '', '', '0', '15'), ('6', 'sj152220907210000', '1', '10000', '炸药包', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', '4', '0.00', '40000', '1522209072', '1', '/Uploader/Shopping/proof/20180328/7a667d618ce2a3c4fc7ce593968017d5.jpg', '0', '0', '', '', '0', '5'), ('7', 'sj152220945710000', '1', '10000', '炸药包', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', '4', '0.00', '40000', '1522209457', '1', '', '0', '1522477855', 'fdsaf', 'fdsaf', '1522477855', '20'), ('8', 'sj152221005810000', '1', '10000', '炸药包', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', '2', '0.00', '20000', '1522210058', '1', '', '0', '0', '', '', '0', '10'), ('9', 'sj152221011610000', '1', '10000', '炸药包', 'http://skx.com/index.php/public/static/qiantai/img/rx.png', '2', '0.00', '20000', '1522210116', '1', '', '0', '0', '', '', '0', '5');
COMMIT;

-- ----------------------------
--  Table structure for `skx_privilege`
-- ----------------------------
DROP TABLE IF EXISTS `skx_privilege`;
CREATE TABLE `skx_privilege` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `role_id` mediumint(6) DEFAULT NULL,
  `menu_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_privilege`
-- ----------------------------
BEGIN;
INSERT INTO `skx_privilege` VALUES ('25', '2', '2'), ('26', '2', '12'), ('27', '2', '14'), ('28', '2', '13'), ('32', '2', '24'), ('33', '2', '25'), ('34', '3', '26'), ('35', '3', '27'), ('36', '3', '29'), ('37', '3', '28');
COMMIT;

-- ----------------------------
--  Table structure for `skx_product`
-- ----------------------------
DROP TABLE IF EXISTS `skx_product`;
CREATE TABLE `skx_product` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL DEFAULT '0',
  `product_name` varchar(32) NOT NULL,
  `stock` int(4) NOT NULL DEFAULT '0' COMMENT '库存',
  `img` varchar(500) NOT NULL DEFAULT '',
  `sort` tinyint(3) NOT NULL DEFAULT '1' COMMENT '排序',
  `product_details` varchar(2000) NOT NULL,
  `cost_jifen` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sales_jifen` decimal(10,2) NOT NULL DEFAULT '0.00',
  `details` varchar(2000) NOT NULL DEFAULT '',
  `add_time` int(10) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '10' COMMENT '0删除 5:下线 10：上线',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_product`
-- ----------------------------
BEGIN;
INSERT INTO `skx_product` VALUES ('1', '1000', '积分产品', '1000', '/Uploader/Product/20180331/f401675e878257a50f926be6fdbd3964.jpg', '90', 'xxxxxxxxxxxxxxx', '100.00', '200.00', '<p>惺惺惜惺惺想寻寻寻寻寻寻寻寻寻寻寻</p>', '1522203243', '10');
COMMIT;

-- ----------------------------
--  Table structure for `skx_product_order`
-- ----------------------------
DROP TABLE IF EXISTS `skx_product_order`;
CREATE TABLE `skx_product_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(32) NOT NULL DEFAULT '',
  `uid` int(10) NOT NULL DEFAULT '0',
  `product_id` int(10) NOT NULL DEFAULT '0',
  `product_name` varchar(32) NOT NULL DEFAULT '',
  `product_num` int(5) NOT NULL DEFAULT '1',
  `product_jifen` decimal(10,2) NOT NULL DEFAULT '0.00',
  `buy_num` int(2) NOT NULL DEFAULT '0',
  `buy_time` int(10) NOT NULL DEFAULT '0',
  `total_jifen` decimal(10,2) NOT NULL,
  `add_time` int(10) NOT NULL,
  `express_code` varchar(32) NOT NULL DEFAULT '',
  `express_name` varchar(32) NOT NULL DEFAULT '',
  `f_time` int(10) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '5：驳回 10：待发货 20：已发货',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_product_order`
-- ----------------------------
BEGIN;
INSERT INTO `skx_product_order` VALUES ('1', 'jf152222334410000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522223344', '', '', '0', '10'), ('2', 'jf152222334610000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522223346', '', '', '0', '10'), ('3', 'jf152222334810000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522223348', '', '', '0', '10'), ('4', 'jf152222335010000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522223350', '', '', '0', '10'), ('5', 'jf152222335210000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522223352', '', '', '0', '10'), ('6', 'jf152222335410000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522223354', '', '', '0', '10'), ('7', 'jf152222335610000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522223356', '', '', '0', '10'), ('8', 'jf152222335810000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522223358', '', '', '0', '10'), ('9', 'jf152222425610000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522224256', '', '', '0', '10'), ('10', 'jf152222435910000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522224359', '', '', '0', '10'), ('11', 'jf152222435910000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522224359', '', '', '0', '10'), ('12', 'jf152222436210000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522224362', '', '', '0', '10'), ('13', 'jf152222437110000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522224371', '', '', '0', '10'), ('14', 'jf152222437210000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522224372', '', '', '0', '10'), ('15', 'jf152222437210000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522224372', '', '', '0', '5'), ('16', 'jf152222437610000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522224376', '', '', '0', '5'), ('17', 'jf152222442410000', '10000', '1', '积分产品', '4', '0.00', '0', '0', '800.00', '1522224424', '', '', '0', '5');
COMMIT;

-- ----------------------------
--  Table structure for `skx_recharge`
-- ----------------------------
DROP TABLE IF EXISTS `skx_recharge`;
CREATE TABLE `skx_recharge` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) DEFAULT NULL,
  `uid` int(20) DEFAULT NULL,
  `money` mediumint(8) DEFAULT NULL,
  `add_time` int(10) DEFAULT NULL,
  `payway` tinyint(2) DEFAULT '1',
  `pay_time` int(10) DEFAULT '0',
  `proof` varchar(250) DEFAULT '0',
  `pay_code` varchar(32) DEFAULT '0',
  `status` tinyint(2) DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_recharge`
-- ----------------------------
BEGIN;
INSERT INTO `skx_recharge` VALUES ('1', 'sj152196215210000', '10000', '100', '1514736000', '1', '1522771200', '20', 'dsfsfds', '10');
COMMIT;

-- ----------------------------
--  Table structure for `skx_role`
-- ----------------------------
DROP TABLE IF EXISTS `skx_role`;
CREATE TABLE `skx_role` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `sort` tinyint(2) DEFAULT '1',
  `status` tinyint(2) DEFAULT '5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_role`
-- ----------------------------
BEGIN;
INSERT INTO `skx_role` VALUES ('2', '管理员', '20', '5'), ('3', '员工', '20', '5');
COMMIT;

-- ----------------------------
--  Table structure for `skx_shopping_level`
-- ----------------------------
DROP TABLE IF EXISTS `skx_shopping_level`;
CREATE TABLE `skx_shopping_level` (
  `id` mediumint(3) NOT NULL AUTO_INCREMENT,
  `level` tinyint(3) DEFAULT '1',
  `name` varchar(30) NOT NULL,
  `price` mediumint(8) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_shopping_level`
-- ----------------------------
BEGIN;
INSERT INTO `skx_shopping_level` VALUES ('1', '1', '创客v0', '0'), ('8', '2', '创客v1', '680'), ('9', '3', '创客v2', '5000');
COMMIT;

-- ----------------------------
--  Table structure for `skx_team_all_money`
-- ----------------------------
DROP TABLE IF EXISTS `skx_team_all_money`;
CREATE TABLE `skx_team_all_money` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `team_all_money` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_team_all_money`
-- ----------------------------
BEGIN;
INSERT INTO `skx_team_all_money` VALUES ('1', '10000', '10000.00');
COMMIT;

-- ----------------------------
--  Table structure for `skx_team_money`
-- ----------------------------
DROP TABLE IF EXISTS `skx_team_money`;
CREATE TABLE `skx_team_money` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `team_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `add_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `skx_user`
-- ----------------------------
DROP TABLE IF EXISTS `skx_user`;
CREATE TABLE `skx_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL COMMENT '''''',
  `password` varchar(32) NOT NULL COMMENT '''''',
  `salt` varchar(16) NOT NULL DEFAULT '',
  `nickname` varchar(16) NOT NULL DEFAULT '',
  `phone` varchar(32) NOT NULL DEFAULT '',
  `real_name` varchar(32) NOT NULL DEFAULT '',
  `id_card` varchar(32) NOT NULL DEFAULT '',
  `img` varchar(128) NOT NULL DEFAULT '',
  `zijin_pwd` varchar(32) NOT NULL DEFAULT '',
  `zijin_salt` varchar(16) NOT NULL DEFAULT '',
  `add_time` int(64) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1：正常 2：不需要的用户',
  `last_login_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_user`
-- ----------------------------
BEGIN;
INSERT INTO `skx_user` VALUES ('10000', 'wangbo', '16772928562fc8635e52472beb8f332f', 'CjzMn0', 'wangbo', '15755654774', '王波', '340826198909144418', '/static/qiantai/img/wo.png', '109bfc298d93a71344e05aca3395037f', '0nK7YQ', '1521623612', '1', '1522288726');
COMMIT;

-- ----------------------------
--  Table structure for `skx_user_details`
-- ----------------------------
DROP TABLE IF EXISTS `skx_user_details`;
CREATE TABLE `skx_user_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '10000',
  `pid` int(10) NOT NULL DEFAULT '0',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '主键id',
  `manage_lever` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:普通会员 2:经理 3：总监 4：合伙人',
  `lever` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:vo  2:v1 3:v2',
  `total_yeji` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_profit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总收益',
  `jifen` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分',
  `jifen_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '统计用的总积分',
  `vip_num` mediumint(5) NOT NULL DEFAULT '0',
  `jl_num` mediumint(5) NOT NULL,
  `zj_num` mediumint(4) NOT NULL,
  `bonus` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '奖金',
  `cash` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:正常用户  2：需要删除的用户',
  `add_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `skx_user_details`
-- ----------------------------
BEGIN;
INSERT INTO `skx_user_details` VALUES ('2', '10000', '0', 'wangbo', '2', '2', '0.00', '0.00', '1982400.00', '0.00', '0', '0', '0', '0.00', '0.00', '1', '1521623612');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
