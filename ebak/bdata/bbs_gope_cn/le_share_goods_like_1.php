<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_share_goods_like`;");
E_C("CREATE TABLE `le_share_goods_like` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `goods_id` int(11) NOT NULL DEFAULT '0',
  `commentType` tinyint(2) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '喜欢时间',
  KEY `userid` (`userid`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='喜欢的分享'");

require("../../inc/footer.php");
?>