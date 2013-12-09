<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_group_topics_type`;");
E_C("CREATE TABLE `le_group_topics_type` (
  `typeid` int(11) NOT NULL AUTO_INCREMENT COMMENT '帖子分类ID',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '小组ID',
  `typename` char(32) NOT NULL DEFAULT '' COMMENT '帖子分类名称',
  `count_topic` int(11) NOT NULL DEFAULT '0' COMMENT '统计帖子',
  PRIMARY KEY (`typeid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='帖子分类'");

require("../../inc/footer.php");
?>