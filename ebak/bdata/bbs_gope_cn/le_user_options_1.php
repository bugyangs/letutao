<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_user_options`;");
E_C("CREATE TABLE `le_user_options` (
  `optionid` int(11) NOT NULL AUTO_INCREMENT COMMENT '选项ID',
  `optionname` char(12) NOT NULL DEFAULT '' COMMENT '选项名字',
  `optionvalue` char(255) NOT NULL DEFAULT '' COMMENT '选项内容',
  PRIMARY KEY (`optionid`),
  UNIQUE KEY `optionname` (`optionname`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='配置'");
E_D("replace into `le_user_options` values('1','appname','用户');");
E_D("replace into `le_user_options` values('2','appdesc','用户中心');");
E_D("replace into `le_user_options` values('3','isenable','0');");
E_D("replace into `le_user_options` values('4','isregister','0');");
E_D("replace into `le_user_options` values('5','isvalidate','0');");
E_D("replace into `le_user_options` values('6','isrewrite','0');");
E_D("replace into `le_user_options` values('7','isauthcode','0');");
E_D("replace into `le_user_options` values('8','isgroup','');");
E_D("replace into `le_user_options` values('9','isfollow','1');");

require("../../inc/footer.php");
?>