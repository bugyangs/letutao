<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_daren`;");
E_C("CREATE TABLE `le_daren` (
  `darenid` int(11) NOT NULL AUTO_INCREMENT,
  `darenname` varchar(32) NOT NULL DEFAULT '',
  `background` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`darenid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='达人'");
E_D("replace into `le_daren` values('1','健康达人','images/daren-1.png');");
E_D("replace into `le_daren` values('2','美食达人','images/daren-2.png');");
E_D("replace into `le_daren` values('3','美容美体达人','images/daren-3.png');");
E_D("replace into `le_daren` values('4','配饰达人','images/daren-4.png');");
E_D("replace into `le_daren` values('5','居家达人','images/daren-5.png');");

require("../../inc/footer.php");
?>