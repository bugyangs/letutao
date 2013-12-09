<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 系统设置
 */
if(!($arrOptions = fileRead('options.php','data','system'))){
	$arrOptions = $db->fetch_all_assoc("select optionname,optionvalue from ".dbprefix."system_options");
}

foreach($arrOptions as $key=>$item){
	$strOption[$key] = stripslashes($item);
}

//时区和语言
$arrTime = fileRead('timezone.php','data','system');
$arrLang = fileRead('lang.php','data','system');

include template("options");