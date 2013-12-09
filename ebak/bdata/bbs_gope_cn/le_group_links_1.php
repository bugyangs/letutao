<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_group_links`;");
E_C("CREATE TABLE `le_group_links` (
  `groupid` int(11) NOT NULL DEFAULT '0',
  `linkid` int(11) NOT NULL DEFAULT '0',
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>