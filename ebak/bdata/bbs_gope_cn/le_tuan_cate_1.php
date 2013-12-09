<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_tuan_cate`;");
E_C("CREATE TABLE `le_tuan_cate` (
  `cate_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(80) DEFAULT '',
  `is_nav` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8");
E_D("replace into `le_tuan_cate` values('1','服饰','1');");
E_D("replace into `le_tuan_cate` values('2','鞋子','1');");
E_D("replace into `le_tuan_cate` values('3','包包','1');");
E_D("replace into `le_tuan_cate` values('4','美妆','1');");
E_D("replace into `le_tuan_cate` values('5','家居','1');");
E_D("replace into `le_tuan_cate` values('6','美食','1');");

require("../../inc/footer.php");
?>