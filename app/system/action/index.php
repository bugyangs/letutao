<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 后台首页
 */

$title = '首页';
$lic_r = 0;
$return_data = aac("system")->license->check_licinfo();
$lic_r =$return_data?$return_data:10000;

/*
 *包含模版
 */
 

include template("admincp");