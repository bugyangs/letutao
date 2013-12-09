<?php
defined('IN_TS') or die('Access Denied.');
//登录
switch($ts){
	case "":
		
		$title = '登录后台';
		if(empty($TS_SITE['base']['site_lication'])||empty($TS_SITE['base']['lic_username'])){
			header("Location: ".SITE_URL."index.php?app=lic&ac=lication");
			exit;
		}

		include template("login");
		break;
		
	case "do":
		
		$email = trim($_POST['email']);
		$pwd = trim($_POST['pwd']);
		$cktime = $_POST['cktime'];
		
		if($email=='' || $pwd=='') qiMsg("所有输入项都不能为空^_^");
		
		if(valid_email($email) == false) qiMsg("Email书写不正确^_^");
		
		$countAdmin	= $db->once_fetch_assoc("select count(userid) from ".dbprefix."user where email='$email' and pwd='".md5($pwd)."'");
		
		if($countAdmin['count(userid)'] == 0) qiMsg("Email或者密码错误！");
		
		$strAdmin = $db->once_fetch_assoc("select userid,username,isadmin from ".dbprefix."user_info where email='$email'");
		
		if($strAdmin['isadmin'] != 1) qiMsg("我们是香港皇家警察，现在正式逮捕你！");
		
		$_SESSION['tsadmin']	= $strAdmin;
		//header("Location: index.php?app=system");
		echo "<script language='javascript' type='text/javascript'>";
		echo "window.location.href='index.php?app=system'";
		echo "</script>";

		
		break;
		
	//退出 
	case "out":
		unset($_SESSION['tsadmin']);
		
		//header("Location: index.php?app=system&ac=login");
		echo "<script language='javascript' type='text/javascript'>";
		echo "window.location.href='index.php?app=system&ac=login'";
		echo "</script>";
		
		break;
}