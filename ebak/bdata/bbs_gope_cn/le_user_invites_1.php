<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_user_invites`;");
E_C("CREATE TABLE `le_user_invites` (
  `inviteid` int(11) NOT NULL AUTO_INCREMENT,
  `invitecode` char(32) NOT NULL DEFAULT '' COMMENT '邀请码',
  `isused` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`inviteid`),
  KEY `isused` (`isused`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户邀请码'");

require("../../inc/footer.php");
?>