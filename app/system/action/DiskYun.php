<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 云存储设置
 */
	
$YunOptions = $db->fetch_all_assoc("select optionname,optionvalue from ".dbprefix."diskyun_options");

foreach($YunOptions as $item){
	$YunOption[$item['optionname']] = stripslashes($item['optionvalue']);
}

include template("DiskYun");