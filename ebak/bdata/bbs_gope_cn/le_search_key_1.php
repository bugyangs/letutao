<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_search_key`;");
E_C("CREATE TABLE `le_search_key` (
  `keyid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `keyword` char(32) NOT NULL DEFAULT '',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`keyid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='搜索关键词'");

require("../../inc/footer.php");
?>