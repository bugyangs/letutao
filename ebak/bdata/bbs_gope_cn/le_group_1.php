<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_group`;");
E_C("CREATE TABLE `le_group` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT COMMENT '小组ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `groupname` char(32) NOT NULL DEFAULT '' COMMENT '群组名字',
  `groupname_en` char(32) NOT NULL DEFAULT '' COMMENT '小组英文名称',
  `groupdesc` text NOT NULL COMMENT '小组介绍',
  `path` char(32) NOT NULL DEFAULT '' COMMENT '图标路径',
  `groupicon` char(100) DEFAULT '' COMMENT '小组图标',
  `count_topic` int(11) NOT NULL DEFAULT '0' COMMENT '帖子统计',
  `count_topic_today` int(11) NOT NULL DEFAULT '0' COMMENT '统计今天发帖',
  `count_user` int(11) NOT NULL DEFAULT '0' COMMENT '小组成员数',
  `joinway` tinyint(1) NOT NULL DEFAULT '0' COMMENT '加入方式',
  `role_leader` char(32) NOT NULL DEFAULT '组长' COMMENT '组长角色名称',
  `role_admin` char(32) NOT NULL DEFAULT '管理员' COMMENT '管理员角色名称',
  `role_user` char(32) NOT NULL DEFAULT '成员' COMMENT '成员角色名称',
  `addtime` int(11) DEFAULT '0' COMMENT '创建时间',
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否公开或者私密',
  `isaudit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `ispost` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许会员发帖',
  `isshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`groupid`),
  KEY `userid` (`userid`),
  KEY `isshow` (`isshow`),
  KEY `groupname` (`groupname`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='小组'");
E_D("replace into `le_group` values('1','1','主题','','向大家打包推荐一系列的宝贝。凡是通过你创作的主题而产生购买的，宝贝相应的佣金也全部归你','','cache/groupicon/80/86eb9cd9f9_80_80.jpg','1','1','1','0','组长','管理员','成员','1376537188','1','0','0','0','0','1376537528');");
E_D("replace into `le_group` values('2','1','开学季','','开学季，书包等！','','cache/groupicon/80/fc894d37a6_80_80.jpg','0','0','1','0','组长','管理员','成员','1377564743','0','0','0','0','0','0');");

require("../../inc/footer.php");
?>