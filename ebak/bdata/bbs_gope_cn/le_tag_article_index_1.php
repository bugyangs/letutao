<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_tag_article_index`;");
E_C("CREATE TABLE `le_tag_article_index` (
  `articleid` int(11) NOT NULL DEFAULT '0' COMMENT '帖子ID',
  `tagid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `articleid_2` (`articleid`,`tagid`),
  KEY `articleid` (`articleid`),
  KEY `tagid` (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>