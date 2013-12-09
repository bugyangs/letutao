<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_feed`;");
E_C("CREATE TABLE `le_feed` (
  `feedid` int(11) NOT NULL AUTO_INCREMENT,
  `feedtype` enum('goods','friend','topic','zhuti') DEFAULT 'goods',
  `connectid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `template` varchar(1024) NOT NULL DEFAULT '' COMMENT '动态模板',
  `data` varchar(1024) NOT NULL DEFAULT '' COMMENT '动态数据',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`feedid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='全站动态'");

require("../../inc/footer.php");
?>