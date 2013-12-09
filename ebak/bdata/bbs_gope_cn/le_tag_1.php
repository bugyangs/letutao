<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_tag`;");
E_C("CREATE TABLE `le_tag` (
  `tagid` int(11) NOT NULL AUTO_INCREMENT,
  `tagname` char(16) NOT NULL DEFAULT '',
  `count_user` int(11) NOT NULL DEFAULT '0',
  `count_group` int(11) NOT NULL DEFAULT '0',
  `count_topic` int(11) NOT NULL DEFAULT '0',
  `count_bang` int(11) NOT NULL DEFAULT '0',
  `count_article` int(11) NOT NULL DEFAULT '0',
  `isenable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可用',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`tagid`),
  UNIQUE KEY `tagname` (`tagname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>