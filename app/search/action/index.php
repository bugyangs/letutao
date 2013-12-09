<?php 
defined('IN_TS') or die('Access Denied.');
switch($ts){
	case "":
		$title = '搜索';
		break;
	
	//搜索板块
	case "group":
		$title = '搜索板块';
		break;
}

include template("index");