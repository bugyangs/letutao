<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_image_file`;");
E_C("CREATE TABLE `le_image_file` (
  `imageid` int(11) NOT NULL AUTO_INCREMENT,
  `imageurl` char(120) NOT NULL DEFAULT '',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`imageid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='图片附件表'");
E_D("replace into `le_image_file` values('1','uploadfile/group/20130815/20130815_112819_250.jpg','1376537299');");
E_D("replace into `le_image_file` values('2','uploadfile/group/20130815/20130815_113135_259.png','1376537495');");
E_D("replace into `le_image_file` values('3','uploadfile/group/20130815/20130815_113144_603.png','1376537504');");
E_D("replace into `le_image_file` values('4','uploadfile/group/20130815/20130815_113158_333.jpg','1376537518');");
E_D("replace into `le_image_file` values('5','uploadfile/group/20130815/20130815_113204_519.jpg','1376537524');");

require("../../inc/footer.php");
?>