<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_theme_cate`;");
E_C("CREATE TABLE `le_theme_cate` (
  `cateid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '分类名',
  PRIMARY KEY (`cateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='主题分类'");

require("../../inc/footer.php");
?>