<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_user`;");
E_C("CREATE TABLE `le_user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `pwd` char(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `salt` char(32) NOT NULL DEFAULT '' COMMENT '加点盐',
  `email` char(32) NOT NULL DEFAULT '' COMMENT '用户email',
  `resetpwd` char(32) NOT NULL DEFAULT '' COMMENT '重设密码',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `pwd` (`pwd`,`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户'");
E_D("replace into `le_user` values('1','310606aa9a0e4a8a3460b1c8f0c7a67a','','admin@admin.com','');");

require("../../inc/footer.php");
?>