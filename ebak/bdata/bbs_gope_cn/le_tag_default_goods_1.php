<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_tag_default_goods`;");
E_C("CREATE TABLE `le_tag_default_goods` (
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '分享ID',
  `tagid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `goods_id_2` (`goods_id`,`tagid`),
  KEY `goods_id` (`goods_id`),
  KEY `tagid` (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>