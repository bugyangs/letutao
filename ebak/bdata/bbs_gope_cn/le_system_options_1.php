<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_system_options`;");
E_C("CREATE TABLE `le_system_options` (
  `optionid` int(11) NOT NULL AUTO_INCREMENT COMMENT '选项ID',
  `optionname` char(32) NOT NULL DEFAULT '' COMMENT '选项名字',
  `optionvalue` char(255) NOT NULL DEFAULT '' COMMENT '选项内容',
  PRIMARY KEY (`optionid`),
  UNIQUE KEY `optionname` (`optionname`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='系统管理配置'");
E_D("replace into `le_system_options` values('1','site_title','乐兔淘');");
E_D("replace into `le_system_options` values('2','site_subtitle','发现宝贝、收藏喜欢、分享美丽');");
E_D("replace into `le_system_options` values('3','site_url','http://test.gope.cn/');");
E_D("replace into `le_system_options` values('4','site_email','admin@admin.com');");
E_D("replace into `le_system_options` values('6','site_icp','苏ICP备11052261号');");
E_D("replace into `le_system_options` values('7','isface','0');");
E_D("replace into `le_system_options` values('8','site_key','乐兔淘,letutao,橙创');");
E_D("replace into `le_system_options` values('9','site_desc','乐兔淘购物分享');");
E_D("replace into `le_system_options` values('10','site_theme','miliao');");
E_D("replace into `le_system_options` values('11','site_urltype','1');");
E_D("replace into `le_system_options` values('12','isgzip','');");
E_D("replace into `le_system_options` values('13','timezone','Asia/Hong_Kong');");
E_D("replace into `le_system_options` values('14','lang','');");
E_D("replace into `le_system_options` values('15','site_sinaweibo','http://weibo.com/tuntron');");
E_D("replace into `le_system_options` values('16','site_qqweibo','http://t.qq.com/tuntron');");
E_D("replace into `le_system_options` values('17','PID','14370356');");
E_D("replace into `le_system_options` values('18','AppKey','12369186');");
E_D("replace into `le_system_options` values('19','AppSecret','5d31a6bf340c5119a292457f932a40c9');");
E_D("replace into `le_system_options` values('20','site_checkcode','&lt;meta property=&quot;qc:admins&quot; content=&quot;000000000000000000&quot; /&gt;&lt;!-- qq应用 --&gt;');");
E_D("replace into `le_system_options` values('21','site_lication','aaaaaaaa');");
E_D("replace into `le_system_options` values('22','lic_username','aaaaaaaa');");
E_D("replace into `le_system_options` values('23','site_indexcut','index');");
E_D("replace into `le_system_options` values('24','bigpic','0');");
E_D("replace into `le_system_options` values('25','isucenter','0');");
E_D("replace into `le_system_options` values('26','goodlink','goodid');");
E_D("replace into `le_system_options` values('27','is_open','1');");
E_D("replace into `le_system_options` values('28','close_tip','系统维护中...');");
E_D("replace into `le_system_options` values('29','tdj_PID','mm_14370356_4056781_13206339');");
E_D("replace into `le_system_options` values('30','liststyle','pin');");

require("../../inc/footer.php");
?>