<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_user_info`;");
E_C("CREATE TABLE `le_user_info` (
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `ucid` int(11) NOT NULL DEFAULT '0' COMMENT 'Ucenter通信ID',
  `fuserid` int(11) NOT NULL DEFAULT '0' COMMENT '来自邀请用户',
  `username` char(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` char(32) NOT NULL DEFAULT '',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `phone` char(16) NOT NULL DEFAULT '' COMMENT '电话号码',
  `roleid` int(11) NOT NULL DEFAULT '1' COMMENT '角色ID',
  `areaid` int(11) NOT NULL DEFAULT '0' COMMENT '区县ID',
  `darenid` int(11) DEFAULT '0',
  `path` char(32) NOT NULL DEFAULT '' COMMENT '头像路径',
  `face` char(64) NOT NULL DEFAULT '' COMMENT '会员头像',
  `net_face` varchar(64) DEFAULT NULL,
  `signed` char(64) NOT NULL DEFAULT '' COMMENT '签名',
  `blog` char(32) NOT NULL DEFAULT '' COMMENT '博客',
  `about` char(255) NOT NULL DEFAULT '' COMMENT '关于我',
  `ip` varchar(16) NOT NULL DEFAULT '' COMMENT '登陆IP',
  `address` char(64) NOT NULL DEFAULT '',
  `qq_openid` char(32) NOT NULL DEFAULT '',
  `qq_token` char(32) NOT NULL DEFAULT '',
  `qq_token2.0` char(32) NOT NULL DEFAULT '',
  `qq_secret` char(32) NOT NULL DEFAULT '',
  `qqt_oauth_token` char(32) NOT NULL DEFAULT '',
  `qqt_oauth_token_secret` char(32) NOT NULL DEFAULT '',
  `isqqt` tinyint(1) NOT NULL DEFAULT '0',
  `sina_access_token` char(64) NOT NULL DEFAULT '',
  `taobao_access_token` char(32) NOT NULL DEFAULT '',
  `count_score` int(11) NOT NULL DEFAULT '0' COMMENT '统计积分',
  `count_follow` int(11) NOT NULL DEFAULT '0' COMMENT '统计用户跟随的',
  `count_followed` int(11) NOT NULL DEFAULT '0' COMMENT '统计用户被跟随的',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是管理员',
  `isenable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用：0启用1禁用',
  `isverify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未验证1验证',
  `verifycode` char(11) NOT NULL DEFAULT '' COMMENT '验证码',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `uptime` int(11) DEFAULT '0' COMMENT '登陆时间',
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `userid` (`userid`),
  UNIQUE KEY `username` (`username`),
  KEY `qq_openid` (`qq_openid`),
  KEY `fuserid` (`fuserid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户'");
E_D("replace into `le_user_info` values('1','0','0','admin','admin@admin.com','0','','1','0','0','','',NULL,'','','','','','','','','','','','0','','','0','0','0','1','0','0','','1382218001','1382218001');");

require("../../inc/footer.php");
?>