<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
	case "":
	
		$title = '管理员密码设置';
		include template("adminmm");
		break;
		
	case "do":
		
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		if($password1=='')qiMsg("密码不能为空");
		if($password1 <> $password2) qiMsg("您输入的两次密码不一样！");
		$db->query("update ".dbprefix."user set `pwd`='".md5($password1)."' where userid ='".$TS_USER['admin']['userid']."'");
		
		qiMsg("密码修改成功，请牢记！");
		
	
		break;
}