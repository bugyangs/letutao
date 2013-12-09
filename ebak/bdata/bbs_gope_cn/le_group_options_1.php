<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_group_options`;");
E_C("CREATE TABLE `le_group_options` (
  `optionname` char(12) NOT NULL DEFAULT '' COMMENT '选项名字',
  `optionvalue` char(255) NOT NULL DEFAULT '' COMMENT '选项内容',
  UNIQUE KEY `optionname` (`optionname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='配置'");
E_D("replace into `le_group_options` values('appname','讨论');");
E_D("replace into `le_group_options` values('appdesc','乐兔淘讨论');");
E_D("replace into `le_group_options` values('isenable','0');");
E_D("replace into `le_group_options` values('iscreate','0');");
E_D("replace into `le_group_options` values('isaudit','0');");
E_D("replace into `le_group_options` values('iscate','1');");
E_D("replace into `le_group_options` values('ismode','0');");

require("../../inc/footer.php");
?>