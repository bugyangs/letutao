<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_photo_album`;");
E_C("CREATE TABLE `le_photo_album` (
  `albumid` int(11) NOT NULL AUTO_INCREMENT COMMENT '相册ID',
  `userid` int(11) NOT NULL DEFAULT '0',
  `path` char(32) NOT NULL DEFAULT '' COMMENT '相册路径',
  `albumface` char(64) NOT NULL DEFAULT '' COMMENT '相册封面',
  `albumname` char(64) NOT NULL DEFAULT '',
  `albumdesc` varchar(400) NOT NULL DEFAULT '' COMMENT '相册介绍',
  `count_photo` int(11) NOT NULL DEFAULT '0',
  `count_view` int(11) NOT NULL DEFAULT '0',
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`albumid`),
  KEY `userid` (`userid`),
  KEY `isrecommend` (`isrecommend`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='相册'");

require("../../inc/footer.php");
?>