<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_indexslide`;");
E_C("CREATE TABLE `le_indexslide` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '幻灯ID',
  `title` char(64) DEFAULT '' COMMENT '幻灯标题',
  `desc` text COMMENT '幻灯简介',
  `url` char(100) NOT NULL COMMENT '幻灯链接',
  `img` char(100) NOT NULL COMMENT '幻灯图片',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '幻灯排序',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='幻灯/广告'");
E_D("replace into `le_indexslide` values('1','','','http://www.letushuo.com/','cache/bigpic/20130824/1377354335.jpg','0','1377354337');");
E_D("replace into `le_indexslide` values('2','我的午后时光','静谧的角落，明媚的阳光\r\n一杯热气腾腾的咖啡 \r\n 午后的时光总会镀上慵懒的味道\r\n  放慢脚步，享受这一切','http://bbs.gope.cn/','cache/bigpic/20130814/1376473705.jpg','0','1377354337');");
E_D("replace into `le_indexslide` values('3','弄堂里的味道','每天上学奔跑嬉闹的那条弄堂\r\n 每到放学热闹非凡的那条弄堂 \r\n多少少年时缤纷的梦想\r\n永远留在了那条记忆中的弄堂','http://www.letushuo.com/','cache/bigpic/20130814/1376473711.jpg','0','1377354337');");
E_D("replace into `le_indexslide` values('5','流浪，一路向西','你有没有想过，有些事\r\n如果你现在不做，可能以后都没有机会再做了\r\n凤凰、敦煌、拉萨，向更远的西边\r\n一个背包，一台单反，一颗说走就走的心','http://www.letushuo.com/','cache/bigpic/20130814/1376473714.jpg','0','1377354337');");
E_D("replace into `le_indexslide` values('4','别怕秋老虎','进入秋天，秋老虎又来横行霸道。\r\n它把一年里毒辣炎热的温度抛给了我们，\r\n于是，我们要奋起抵抗，\r\n坚决不能让秋老虎将我们打败！','http://www.letushuo.com/','cache/bigpic/20130814/1376473716.jpg','0','1377354337');");

require("../../inc/footer.php");
?>