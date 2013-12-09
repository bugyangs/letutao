<?php
defined('IN_TS') or die('Access Denied.');
//主题创建
$userid = intval($TS_USER['user']['userid']);

$themeid = intval($_GET['themeid']);

//用户数据统计
require_once 's_count.php';




$pageUrl = pagination($followNum, 20, $page, $url);

if($userid == 0){
	header("Location: ".SITE_URL);
	exit;
}

$new['user']->isUser($userid);

$strUser = $new['user']->getOneUserByUserid($userid);


$strtheme	 = $db->once_fetch_assoc("select * from ".dbprefix."theme where themeid='".$themeid."'");



	$title = '修改主题';
	include template("editzt");