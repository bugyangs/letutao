<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
	case "":
		$arrOptions = fileRead('options.php','data','system');

	foreach($arrOptions as $key => $item){
	$strOption[$key] = stripslashes($item);
	}
		$title = '微博收听地址设置';
		include template("weibo");
		break;
		
	case "do":
	
		$site_weibo = $_POST['site_weibo'];
		$arrOptions = fileRead('options.php','data','system');
		$arrOptions['site_weibo'] = $site_weibo;
		
		fileWrite('system_options.php','data',$arrOption);
		
	
		break;
}