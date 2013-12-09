<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_attach`;");
E_C("CREATE TABLE `le_attach` (
  `attachid` int(11) NOT NULL AUTO_INCREMENT COMMENT '附件ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `attachname` char(64) NOT NULL COMMENT '附件名字',
  `attachtype` char(32) NOT NULL DEFAULT '' COMMENT '附件类型',
  `attachurl` char(64) NOT NULL DEFAULT '' COMMENT '附件url',
  `attachsize` char(32) NOT NULL DEFAULT '' COMMENT '附件大小',
  `isshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`attachid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件'");

require("../../inc/footer.php");
?>