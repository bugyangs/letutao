<?php
defined('IN_TS') or die('Access Denied.');

//设置用户信息
$userid = $TS_USER['user']['userid'];

if($userid == 0){
	header("Location: ".SITE_URL);
	exit;
}

$strUser = $new['user']->getOneUserByUserid($userid);

if($strUser['count_score'] <2000) qiMsg(">_< 您暂时没有权限创建主题！");

$title = '创建主题';

include template("addtheme");