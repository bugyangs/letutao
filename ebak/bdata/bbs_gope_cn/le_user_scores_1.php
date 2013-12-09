<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_user_scores`;");
E_C("CREATE TABLE `le_user_scores` (
  `scoreid` int(11) NOT NULL AUTO_INCREMENT COMMENT '积分ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `scorename` char(64) NOT NULL DEFAULT '' COMMENT '积分说明',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '得分',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '积分时间',
  PRIMARY KEY (`scoreid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户积分'");

require("../../inc/footer.php");
?>