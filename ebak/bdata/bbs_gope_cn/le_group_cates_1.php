<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_group_cates`;");
E_C("CREATE TABLE `le_group_cates` (
  `cateid` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `catename` char(32) NOT NULL DEFAULT '' COMMENT '分类名字',
  `catereferid` int(11) NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `count_group` int(11) NOT NULL DEFAULT '0' COMMENT '群组个数',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`cateid`),
  KEY `referid` (`catereferid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>