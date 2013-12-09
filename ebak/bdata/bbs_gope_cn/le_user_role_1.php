<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_user_role`;");
E_C("CREATE TABLE `le_user_role` (
  `roleid` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `rolename` char(32) NOT NULL DEFAULT '' COMMENT '角色名称',
  PRIMARY KEY (`roleid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='角色'");
E_D("replace into `le_user_role` values('1','列兵');");
E_D("replace into `le_user_role` values('2','下士');");
E_D("replace into `le_user_role` values('3','中士');");
E_D("replace into `le_user_role` values('4','上士');");
E_D("replace into `le_user_role` values('5','三级准尉');");
E_D("replace into `le_user_role` values('6','二级准尉');");
E_D("replace into `le_user_role` values('7','一级准尉');");
E_D("replace into `le_user_role` values('8','少尉');");
E_D("replace into `le_user_role` values('9','中尉');");
E_D("replace into `le_user_role` values('10','上尉');");
E_D("replace into `le_user_role` values('11','少校');");
E_D("replace into `le_user_role` values('12','中校');");
E_D("replace into `le_user_role` values('13','上校');");
E_D("replace into `le_user_role` values('14','准将');");
E_D("replace into `le_user_role` values('15','少将');");
E_D("replace into `le_user_role` values('16','中将');");
E_D("replace into `le_user_role` values('17','上将');");

require("../../inc/footer.php");
?>