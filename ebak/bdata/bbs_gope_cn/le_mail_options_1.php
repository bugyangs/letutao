<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_mail_options`;");
E_C("CREATE TABLE `le_mail_options` (
  `optionid` int(11) NOT NULL AUTO_INCREMENT COMMENT '选项ID',
  `optionname` char(12) NOT NULL DEFAULT '' COMMENT '选项名字',
  `optionvalue` char(255) NOT NULL DEFAULT '' COMMENT '选项内容',
  PRIMARY KEY (`optionid`),
  UNIQUE KEY `optionname` (`optionname`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='配置'");
E_D("replace into `le_mail_options` values('1','appname','邮件');");
E_D("replace into `le_mail_options` values('2','appdesc','乐兔淘');");
E_D("replace into `le_mail_options` values('3','isenable','0');");
E_D("replace into `le_mail_options` values('4','mailhost','smtp.qq.com');");
E_D("replace into `le_mail_options` values('5','mailport','25');");
E_D("replace into `le_mail_options` values('6','mailuser','');");
E_D("replace into `le_mail_options` values('7','mailpwd','');");

require("../../inc/footer.php");
?>