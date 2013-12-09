<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_goods_cate`;");
E_C("CREATE TABLE `le_goods_cate` (
  `cate_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) DEFAULT '0',
  `cate_name` varchar(80) DEFAULT '',
  `appname` varchar(80) DEFAULT '',
  `tag_num` int(5) NOT NULL DEFAULT '20',
  `seo_keywords` varchar(255) DEFAULT '',
  `seo_desc` varchar(255) DEFAULT '',
  `sort` int(11) DEFAULT '0',
  `is_nav` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cate_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8");
E_D("replace into `le_goods_cate` values('1','0','发现','','20','','','100','0');");
E_D("replace into `le_goods_cate` values('2','0','上装','coats','0','','','100','1');");
E_D("replace into `le_goods_cate` values('3','0','下装','pants','0','','','100','1');");
E_D("replace into `le_goods_cate` values('4','0','鞋子','shoes','0','','','100','1');");
E_D("replace into `le_goods_cate` values('5','0','包包','bags','0','','','100','1');");
E_D("replace into `le_goods_cate` values('6','0','配饰','accessories','0','','','100','1');");
E_D("replace into `le_goods_cate` values('7','0','美妆','beauties','0','','','100','1');");
E_D("replace into `le_goods_cate` values('8','0','家居','home','0','','','100','1');");
E_D("replace into `le_goods_cate` values('48','2','潮流单品','coats','20','','','0','1');");
E_D("replace into `le_goods_cate` values('47','2','流行元素','coats','20','','','0','1');");
E_D("replace into `le_goods_cate` values('46','2','热门风格','coats','20','','','0','1');");
E_D("replace into `le_goods_cate` values('45','2','材质','coats','20','','','0','1');");
E_D("replace into `le_goods_cate` values('67','7','护肤','beauties','20','','','0','1');");
E_D("replace into `le_goods_cate` values('66','7','彩妆','beauties','20','','','0','1');");
E_D("replace into `le_goods_cate` values('65','6','首饰盒','accessories','20','','','0','1');");
E_D("replace into `le_goods_cate` values('64','6','饰品','accessories','20','','','0','1');");
E_D("replace into `le_goods_cate` values('63','6','风格','accessories','20','','','0','1');");
E_D("replace into `le_goods_cate` values('62','6','元素','accessories','20','','','0','1');");
E_D("replace into `le_goods_cate` values('61','5','热款','bags','20','','','0','1');");
E_D("replace into `le_goods_cate` values('60','5','时尚手袋','bags','20','','','0','1');");
E_D("replace into `le_goods_cate` values('59','5','元素','bags','20','','','0','1');");
E_D("replace into `le_goods_cate` values('58','5','材质','bags','20','','','0','1');");
E_D("replace into `le_goods_cate` values('57','4','热门','shoes','20','','','0','1');");
E_D("replace into `le_goods_cate` values('55','4','元素','shoes','20','','','0','1');");
E_D("replace into `le_goods_cate` values('54','4','休闲','shoes','20','','','0','1');");
E_D("replace into `le_goods_cate` values('51','3','裙子','pants','20','','','0','1');");
E_D("replace into `le_goods_cate` values('52','3','元素','pants','20','','','0','1');");
E_D("replace into `le_goods_cate` values('53','4','单鞋','shoes','20','','','0','1');");
E_D("replace into `le_goods_cate` values('50','3','裤子','pants','20','','','0','1');");
E_D("replace into `le_goods_cate` values('49','3','风格材质','pants','20','','','0','1');");
E_D("replace into `le_goods_cate` values('68','7','功效','beauties','20','','','0','1');");
E_D("replace into `le_goods_cate` values('69','7','品牌','beauties','20','','','0','1');");
E_D("replace into `le_goods_cate` values('70','8','推荐','home','20','','','0','1');");
E_D("replace into `le_goods_cate` values('71','8','起居','home','20','','','0','1');");
E_D("replace into `le_goods_cate` values('72','8','卧室','home','20','','','0','1');");
E_D("replace into `le_goods_cate` values('73','8','厨房','home','20','','','0','1');");

require("../../inc/footer.php");
?>