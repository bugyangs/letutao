<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_share_theme_like`;");
E_C("CREATE TABLE `le_share_theme_like` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `themeid` int(11) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '喜欢时间',
  KEY `userid` (`userid`),
  KEY `themeid` (`themeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='喜欢的主题'");

require("../../inc/footer.php");
?>