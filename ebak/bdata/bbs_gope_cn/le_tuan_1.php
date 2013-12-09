<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_tuan`;");
E_C("CREATE TABLE `le_tuan` (
  `tuanid` int(11) NOT NULL AUTO_INCREMENT COMMENT '团购ID',
  `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '团购分类ID',
  `title` char(64) NOT NULL DEFAULT '' COMMENT '标题',
  `images` char(64) NOT NULL DEFAULT '' COMMENT '图片',
  `price_tuan` decimal(10,2) DEFAULT '0.00' COMMENT '团购价格',
  `price_market` decimal(10,2) DEFAULT '0.00' COMMENT '市场价格',
  `count_sold` int(11) NOT NULL DEFAULT '0' COMMENT '已购买数',
  `tuan_url` varchar(1024) DEFAULT '' COMMENT '转跳地址',
  `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `isshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `addtime` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`tuanid`),
  KEY `cateid` (`cateid`),
  KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='团购'");
E_D("replace into `le_tuan` values('1','1','【裳品会+全国包邮】韩版字母印花套装1套，休闲运动透气有型','/uploadfile/tuanfile/2013-05/35_1369129840.jpg','59.00','85.00','532','http://gaopeng.qq.com/huangshan/deal/show/473907?channelid=14','0','0','1369129840');");
E_D("replace into `le_tuan` values('2','1','精致复古的一款连衣裙','/uploadfile/tuanfile/2013-05/70_1369150889.jpg','54.00','78.00','167','http://item.taobao.com/item.htm?id=19561679725','0','0','1369150889');");
E_D("replace into `le_tuan` values('3','1','红人最爱的复古高腰牛仔短裤！四色任选，显瘦得腿长，一年四季任何风格都可以hold住~！！','/uploadfile/tuanfile/2013-05/7_1369151091.jpg','39.00','89.00','5857','http://item.taobao.com/item.htm?id=23773104799','0','0','1369151091');");
E_D("replace into `le_tuan` values('4','2','原价59元现仅需39.9元还包邮 2013最新夏季夹趾豹纹平底凉鞋','/uploadfile/tuanfile/2013-05/45_1369151184.jpg','39.90','59.00','666','http://item.taobao.com/item.htm?id=23612528128','0','0','1369151184');");
E_D("replace into `le_tuan` values('5','2','亏本超值40元包邮 荧光色车菱格透气厚底懒人鞋','/uploadfile/tuanfile/2013-05/68_1369151274.jpg','40.00','59.00','103','http://item.taobao.com/item.htm?id=17897853691','0','0','1369151274');");

require("../../inc/footer.php");
?>