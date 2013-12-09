<?php

/*
 * 乐兔淘购物分享系统_APP入口
 * @copyright (c) 2010-2015 Tuntron All Rights Reserved
 * @Email:70020765@qq.com
 */
 
defined('IN_TS') or die('Access Denied.');

$isupdate = 0;
$update_apparr = array('system','update');
if(is_file(THINKROOT.'/app/update/action/index.php')&&!in_array($app,$update_apparr)) qiMsg("网站升级中，请稍候...",'');

if(is_file(THINKROOT.'/app/update/action/index.php')) $isupdate = 1;

define('IS_POST', (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'));

	$TS_SITE['base'] = fileRead('options.php','data','system');
	if($TS_SITE['base']['is_open']==0&&!in_array($app,$update_apparr)) qiMsg($TS_SITE['base']['close_tip'],'');
	
	$DISK_YUN = fileRead('options.php','data','diskyun');
	$app = empty($_GET['app'])?$TS_SITE['base']['site_indexcut']:$_GET['app'];
	
	$LE_APPone = fileRead('appnav.php','data','top');

	
	$cate_appname = $themeid = $app;
	$goods_id=$leac=$likes=$news=$ac;
	
	if(in_array($app,array_keys($LE_APPone))) $app = 'cate';
	
	if($app==$TS_SITE['base']['goodlink']) {$app='baobei';}
	if($app =='baobei' ||$app =='buy' ||$app =='pic'|| $app =='zhuti'|| $app =='feed') $ac ='index';
	if(strstr($app,'zhuti') && strlen($app)>5) {
		$app = 'zhuti';
		$ac  = 'theme';
	}
	

//APP模板CSS,IMG,INC
$TS_APP['tpl']	= array(
	'skin'	=> 'app/'.$app.'/skins/',
	'js'	=> 'app/'.$app.'/js/',
);
 
//system系统管理模板CSS,IMG
$TS_APP['system']	= array(
	'skin'	=> 'app/system/skins/',
	'js'	=> 'app/system/js/',
);

//登陆开启判断

$isL_Open = fileRead('plugins.php','data','pubs');

//加载APP应用首页和配置文件

if(is_file(THINKROOT.'/app/'.$app.'/action/'.$ac.'.php')){
	

	
	//加载系统缓存文件
	$TS_SITE['base'] = fileRead('options.php','data','system');
	
	
	
	//语言
	$hl_c = isset($_COOKIE['ts_lang']) ? $_COOKIE['ts_lang'] : '';
	if($hl_c){
		$hl = $hl_c;
	}else{
		$hl = $TS_SITE['base']['lang'];
	}
	
	//设置时区
	date_default_timezone_set($TS_SITE['base']['timezone']);
	
	
	//启用UC
	

	if($TS_SITE['base']['isucenter']==1){
		require_once THINKROOT.'/uc_client/client.php';
		require_once THINKROOT.'/api/uc_config.php';
	}

	
	//加载分类导航
	$TS_SITE['appnav'] = fileRead('appnav.php','data','top');
	//加载系统导航
	$TS_SITE['sysnav'] = fileRead('appnav.php','data','sys');
	
	define('SITE_URL', $TS_SITE['base']['site_url']);
	define('BCS_URL', $DISK_YUN['loadUrl']);
	
	//主题
	$ts_theme = isset($_COOKIE['ts_theme']) ? $_COOKIE['ts_theme'] : '';
	if($ts_theme){
		if(is_file(THINKROOT.'/theme/'.$ts_theme.'/preview.gif')){
			$site_theme = $ts_theme;
		}else{
			$site_theme = $TS_SITE['base']['site_theme'];
		}
	}else{
		$site_theme = $TS_SITE['base']['site_theme'];
	}
	
	
	//加载APP配置缓存文件
	if($app!=='system'){
		
		
			$TS_APP['options'] = fileRead('options.php','data',$app);
			
			if($TS_APP['options']['isenable']=='1' && $ac != 'admin') qiMsg($app."应用关闭，请开启后访问！");
		
	}
	
	

	//加载APP配置文件
	include_once 'app/'.$app.'/config.php';
	
	

	//连接数据库
	if($TS_DB['sql']=='0'){
		include_once 'letutao/mysql.php';
	}elseif($TS_DB['sql']=='1'){
		include_once 'letutao/pdo_mysql.php';
	}
	
	
	
	$db = new MySql($TS_DB);
	
	//加载APP数据库操作类并建立对象
	include_once 'app/'.$app.'/class.'.$app.'.php';
	$new[$app] = new $app($db);

	//控制前台ADMIN访问权限
	if($ac == 'admin' && $TS_USER['admin']['isadmin']!=1 && $app != 'system'){
		header("Location: ".SITE_URL."index.php");
		exit;
	}
	
	//控制后台访问权限
	if($TS_USER['admin']['isadmin'] != 1 && $app=='system' && $ac != 'login'){
		header("Location: ".SITE_URL."index.php?app=system&ac=login");
		exit;
	}
	
	//控制插件设置权限
	if($TS_USER['admin']['isadmin'] != 1 && $in == 'edit'){
		header("Location: ".SITE_URL."index.php?app=system&ac=login");
		exit;
	}
	
	//判断用户是否上传头像
	if($TS_SITE['base']['isface']==1 && $TS_USER['user'] != '' && $app != 'system' && $ac != 'admin'){
		$faceUser = $db->once_fetch_assoc("select face from ".dbprefix."user_info where userid='".intval($TS_USER['user']['userid'])."'");
		if($faceUser['face']=='' && $ts != 'face'){
			header("Location: ".SITE_URL."index.php?app=user&ac=set&ts=face");
		}
	}
	
	//运行统计结束
	$time_end = getmicrotime();
	
	$runTime = $time_end - $time_start;
	$runTime = number_format($runTime,6);
	
	//用户自动登录
	if($TS_USER['user']=='' && $_COOKIE['ts_email']!='' && $_COOKIE['ts_pwd'] !='' ){
		
		$loginUserNum = $db->once_num_rows("select * from ".dbprefix."user where email='".$_COOKIE['ts_email']."' and pwd='".$_COOKIE['ts_pwd']."'");
	
		if($loginUserNum > 0){
			$loginUserData = $db->once_fetch_assoc("select  userid,username,areaid,path,face,count_score,isadmin,uptime from ".dbprefix."user_info where email='".$_COOKIE['ts_email']."'");
			//用户session信息
			$_SESSION['tsuser']	= $loginUserData;
			$TS_USER = array(
				'user'		=> $_SESSION['tsuser'],
			);
			//更新登录时间
			$db->query("update ".dbprefix."user_info set `uptime`='".time()."' where userid='".$loginUserData['userid']."'");	
		}
	}
	
	
	$tsHooks = array();
	
	if($app != 'system' && $app !='pubs'){

		//加载公用插件 
		if(is_file(THINKROOT.'/data/pubs_plugins.php')){
			$public_plugins = fileRead('plugins.php','data','pubs');
		
			if ($public_plugins && is_array($public_plugins)) {
				foreach($public_plugins as $item) {
					if(is_file('plugins/pubs/'.$item.'/'.$item.'.php')) {
						include 'plugins/pubs/'.$item.'/'.$item.'.php';
					}
				}
			}
		}
	
		//加载APP插件
		if(is_file(THINKROOT.'/data/'.$app.'_plugins.php')){
			$active_plugins = fileRead('plugins.php','data',$app);
			if ($active_plugins && is_array($active_plugins)) {
				foreach($active_plugins as $item) {
					if(is_file('plugins/'.$app.'/'.$item.'/'.$item.'.php')) {
						include 'plugins/'.$app.'/'.$item.'/'.$item.'.php';
					}
				}
			}
		}
	}
	
	//加载语言包，公共语言包和APP语言包
	if(is_file(THINKROOT.'/public/lang/'.$hl.'.php')){
		$TS_HL['pub'] = include 'public/lang/'.$hl.'.php';
	}else{
		if(is_file('public/lang/zh_cn.php')){
			$TS_HL['pub'] = include 'public/lang/zh_cn.php';
		}
	}
	
	if(is_file(THINKROOT.'/app/'.$app.'/lang/'.$hl.'.php')){
		
		$TS_HL['app'] = include 'app/'.$app.'/lang/'.$hl.'.php';
	}else{
		if(is_file(THINKROOT.'/app/'.$app.'/lang/zh_cn.php')){
			$TS_HL['app'] = include 'app/'.$app.'/lang/zh_cn.php';
		}
	}
	
	//生成头像
	if($TS_USER['user']['userid']){
		
	$huserData	= $db->once_fetch_assoc("select  face,path from ".dbprefix."user_info where userid='".$TS_USER['user']['userid']."'");
	if($TS_USER['user']['figureurl_qq_1']){
		$hface = $TS_USER['user']['figureurl_qq_1'];
	}else{
		$hface = $huserData['face']?SITE_URL.miniimg($huserData['face'],'user',32,32,$huserData['path'],1):SITE_URL.'public/images/noavatar.gif';
		}
	}
	
	//判断瀑布流&画板session
	$_SESSION["style"] = in_array($_GET['style'],array('pin','boards')) ? $_GET['style'] :$_SESSION["style"];
	$is_pin=$_SESSION["style"]?$_SESSION["style"]:$TS_SITE['base']['liststyle'];
	$arrcate = $db->fetch_all_assoc("select cate_name,cate_id from ".dbprefix."goods_cate where cate_id>1 and parent_id=0 order by cate_id asc");

	foreach($arrcate as $key=>$item){
			$c	= $db->fetch_all_assoc("select cate_name from ".dbprefix."goods_cate where parent_id ='".$item['cate_id']."'");
			$cate_html .= '<li value="coats" default="'.$item['cate_name'].'" class="over out">'.$item['cate_name'].'</li>';
		}

	foreach($LE_APPone as $key=>$item){
		$htmlstr.= '<li value="'.$key.'" default="'.$item.'" class="over out">'.$item.'</li>';
	}
	$resulthtml ='<ul>'.$cate_html.'</ul>';
	//开始执行APP action
	include $app.'/action/'.$ac.'.php';
	
	
}else{
	//加载系统缓存文件
	$TS_SITE['base'] = fileRead('options.php','data','system');
	define('SITE_URL', $TS_SITE['base']['site_url']);
	@header("http/1.1 404 not found"); 
	@header("status: 404 not found");
	include template("404");
	exit;
}