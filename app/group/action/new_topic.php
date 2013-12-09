<?php
defined('IN_TS') or die('Access Denied.');

$userid = intval($TS_USER['user']['userid']);

if($userid == 0){
	header("Location: ".SITE_URL.tsurl('user','login'));
	exit;
}

$groupid = intval($_GET['groupid']);

//板块数目
$groupNum = $db->once_fetch_assoc("select count(*) from ".dbprefix."group where groupid='$groupid'");

if($groupNum['count(*)'] == 0){
	header("Location: ".SITE_URL);
	exit;
}

//板块会员
$isGroupUser = $db->once_fetch_assoc("select count(*) from ".dbprefix."group_users where userid='$userid' and groupid='$groupid'");

$strGroup = $db->once_fetch_assoc("select * from ".dbprefix."group where groupid='$groupid'");

//允许板块成员发帖
//if($strGroup['ispost']==0 && $isGroupUser['count(*)'] == 0 && $userid != $strGroup['userid']){
	
//	qiMsg("本板块只允许板块成员发贴，请加入板块后再发帖！");
	
//}

//不允许板块成员发帖
if($strGroup['ispost'] == 1 && $userid != $strGroup['userid']){
	qiMsg("本板块只允许板块组长发帖！");
}

//话题类型
$arrGroupType = $db->fetch_all_assoc("select * from ".dbprefix."group_topics_type where groupid='".$strGroup['groupid']."'");

$title = '发布话题';

//包含模版
include template("new_topic");