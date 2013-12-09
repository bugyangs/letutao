<?php
//email验证页
switch($ts){
	case "":
		$email = $_GET['email'];
		$isemail = $db->once_num_rows("select * from ".dbprefix."user where email='$email'");
		if($isemail > 0){
		
			$title = "绑定新浪帐号";
			include "email.html";
		
		}else{
			echo '<script>
			if(window.opener){
				window.opener.followGuang(100,"","","false",true);
			}
			window.close();	
		</script>';
		exit;
		}
		break;
		
	case "do":
		$email = trim($_POST['email']);
		$pwd = trim($_POST['pwd']);
		$strUser = $db->once_fetch_assoc("select * from ".dbprefix."user where email='$email'");
		
		if($pwd == ''){
			qiMsg("密码不能为空！");
		}elseif($strUser['pwd'] != md5($pwd)){
			qiMsg("密码输入有误！");
		}else{
		
			$db->query("update ".dbprefix."user_info set `sina_access_token`='".$_SESSION['token']['access_token']."' where email='$email'");
		
			$userData = $db->once_fetch_assoc("select * from ".dbprefix."user_info where email='$email'");
			
			//发送系统消息(恭喜注册成功)
			$userid = $userData['userid'];
			$username = $userData['username'];
			
			$msg_userid = '0';
			$msg_touserid = $userid;
			$msg_content = '亲爱的 '.$username.' ：<br />恭喜你成功绑定新浪登录信息。<br />现在你除了可以用Email登录，同时还可以使用新浪账户登录！<br />感谢你对Letutao的支持！';
			aac('message',$db)->sendmsg($msg_userid,$msg_touserid,$msg_content);
			
			$_SESSION['tsuser']	= $userData;
		
		echo '<script>
			if(window.opener){
				window.opener.followGuang(100,"","","false",true);
			}
			window.close();	
		</script>';
		exit;
			
		}
		
		break;
}