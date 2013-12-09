<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_diskyun_options`;");
E_C("CREATE TABLE `le_diskyun_options` (
  `optionid` int(11) NOT NULL AUTO_INCREMENT COMMENT '选项ID',
  `optionname` char(32) NOT NULL DEFAULT '' COMMENT '选项名字',
  `optionvalue` char(255) NOT NULL DEFAULT '' COMMENT '选项内容',
  PRIMARY KEY (`optionid`),
  UNIQUE KEY `optionname` (`optionname`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='云储存配置'");
E_D("replace into `le_diskyun_options` values('1','isopen','0');");
E_D("replace into `le_diskyun_options` values('2','YunCom','');");
E_D("replace into `le_diskyun_options` values('3','AK','');");
E_D("replace into `le_diskyun_options` values('4','SK','');");
E_D("replace into `le_diskyun_options` values('6','Bucket','research');");
E_D("replace into `le_diskyun_options` values('7','loadUrl','http://bcs.duapp.com/research/');");
E_D("replace into `le_diskyun_options` values('8','isdel','0');");

require("../../inc/footer.php");
?>