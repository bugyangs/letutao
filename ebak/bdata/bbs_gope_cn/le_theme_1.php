<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_theme`;");
E_C("CREATE TABLE `le_theme` (
  `themeid` int(11) NOT NULL AUTO_INCREMENT,
  `topicid` int(11) NOT NULL DEFAULT '0',
  `title` char(64) NOT NULL,
  `desc` char(200) NOT NULL DEFAULT '' COMMENT '主题描述',
  `cate` varchar(225) DEFAULT NULL COMMENT '分类id',
  `userid` int(11) NOT NULL COMMENT '创建者',
  `goodsnum` int(11) NOT NULL DEFAULT '0' COMMENT '主题商品数',
  `strgoodid` varchar(1024) DEFAULT NULL,
  `likenum` int(11) DEFAULT '0',
  `istop` tinyint(1) NOT NULL DEFAULT '0',
  `recom` int(1) NOT NULL DEFAULT '0',
  `strtag` varchar(100) NOT NULL DEFAULT '',
  `topStyle` varchar(1024) DEFAULT NULL COMMENT '主题背景',
  `simg` varchar(225) DEFAULT NULL,
  `pageStyle` varchar(1024) DEFAULT NULL,
  `pagePhoto` varchar(255) DEFAULT NULL,
  `headerPhoto` varchar(255) DEFAULT NULL,
  `addtime` int(11) DEFAULT '0' COMMENT '添加时间',
  `uptime` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`themeid`),
  KEY `cate_id` (`cate`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='主题'");

require("../../inc/footer.php");
?>