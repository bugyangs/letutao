<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_group_cates_index`;");
E_C("CREATE TABLE `le_group_cates_index` (
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '小组ID',
  `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '分类ID',
  UNIQUE KEY `groupid_2` (`groupid`,`cateid`),
  KEY `groupid` (`groupid`),
  KEY `cateid` (`cateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小组分类索引'");

require("../../inc/footer.php");
?>