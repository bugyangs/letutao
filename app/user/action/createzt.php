<?php
defined('IN_TS') or die('Access Denied.');
//主题创建
$userid = intval($TS_USER['user']['userid']);

//用户数据统计
require_once 's_count.php';

$cate =urldecode(trim($_GET['cate']));

$pageUrl = pagination($followNum, 20, $page, $url);

if($userid == 0){
	header("Location: ".SITE_URL.tsurl('user','login'));
	exit;
}

$new['user']->isUser($userid);

$strUser = $new['user']->getOneUserByUserid($userid);



	$title = '创建主题';
	include template("createzt");