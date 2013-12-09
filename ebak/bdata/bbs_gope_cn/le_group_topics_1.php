<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_group_topics`;");
E_C("CREATE TABLE `le_group_topics` (
  `topicid` int(11) NOT NULL AUTO_INCREMENT COMMENT '话题ID',
  `typeid` int(11) NOT NULL DEFAULT '0' COMMENT '帖子分类ID,0代表普通，1代表主题讨论帖',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '小组ID',
  `themeid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` char(64) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `count_comment` int(11) NOT NULL DEFAULT '0' COMMENT '回复统计',
  `count_view` int(11) NOT NULL DEFAULT '0' COMMENT '帖子展示数',
  `count_attach` int(11) NOT NULL DEFAULT '0' COMMENT '统计附件',
  `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `isshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `iscomment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许评论',
  `isphoto` tinyint(1) NOT NULL DEFAULT '0',
  `isattach` tinyint(1) NOT NULL DEFAULT '0',
  `isnotice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否通知',
  `isposts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否精华帖子',
  `isask` tinyint(1) DEFAULT '0',
  `addtime` int(11) DEFAULT '0' COMMENT '创建时间',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`topicid`),
  KEY `groupid` (`groupid`),
  KEY `userid` (`userid`),
  KEY `title` (`title`),
  KEY `groupid_2` (`groupid`,`isshow`),
  KEY `typeid` (`typeid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='小组话题'");
E_D("replace into `le_group_topics` values('1','0','1','0','1','主题教程，新手必看。','[p] [b][图片2] [br] [/b] [/p] [p] [b]如何创建主题呢？ [/b] [/p] [b]第一步、创建主题 [/b] [p] [b][图片1] [br] [/b] [/p] [p] [b]第二步、添加宝贝 [/b] [/p] [p] [b][图片4] [br] [/b] [/p] [p] [b][图片5] [br] [/b] [/p]','2','29','0','0','0','0','0','0','0','0','0','1376537528','1376885063');");
E_D("replace into `le_group_topics` values('2','1','0','0','1','开学季','书包','0','0','0','0','0','0','0','0','0','0','0','1377564398','1377564398');");
E_D("replace into `le_group_topics` values('3','1','0','0','2','性感','性感','0','0','0','0','0','0','0','0','0','0','0','1377565439','1377565439');");

require("../../inc/footer.php");
?>