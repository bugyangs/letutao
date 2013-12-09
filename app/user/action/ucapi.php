<?php
defined('IN_TS') or die('Access Denied.');
require_once THINKROOT.'/uc_client/client.php';
require_once THINKROOT.'/api/uc_config.php';

switch($ts){

	
	//执行登录
	case "activation":
	if(!$_SESSION['tuntron']['activation'] && $_SESSION['tuntron']['password'])  qiMsg("激活参数错误，请重新登录尝试");
	$userdata =$db -> once_fetch_assoc("select * from ".dbprefix."user_info where email='".$_SESSION['tuntron']['activation']."'"); 
	//开始激活
	$uid = uc_user_register($userdata['username'], $_SESSION['tuntron']['password'], $userdata['email']);
   if($uid<0){
    if($uid == -1) {
		qiMsg('用户名不合法');
	} elseif($uid == -2) {
		qiMsg('包含要允许注册的词语');
	} elseif($uid == -3) {
		qiMsg('用户名已经存在');
	} elseif($uid == -4) {
		qiMsg( 'Email 格式有误');
	} elseif($uid == -5) {
		qiMsg( 'Email 不允许注册');
	} elseif($uid == -6) {
		qiMsg('该 Email 已经被注册');
	} else {
		qiMsg( '未定义' );
	}
	}else{
	  unset($_SESSION['tuntron']);
	  $db->query("update ".dbprefix."user_info set `ucid`='$uid' where userid=".$userdata['userid']."");
	  qiMsg( '激活成功，请重新登录' ,'马上去登录！',SITE_URL.tsUrl('user','login') );
	  header('Location: '.SITE_URL.'index.php');
	 
	}
    	
	 break;
}