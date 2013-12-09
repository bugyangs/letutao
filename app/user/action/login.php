<?php
defined('IN_TS') or die('Access Denied.');
//程序主体
switch($ts){
	case "":
		if(intval($TS_USER['user']['userid']) > 0)  header("Location: ".SITE_URL."index.php");
		
		//记录上次访问地址
		$jump = $_SERVER['HTTP_REFERER'];

		$title = '登录';
		include template("login");
		break;
		
	//执行登录
	case "do":
		if($TS_USER['user'] != '') header("Location: ".SITE_URL."index.php");
		
		$isajax = intval($_POST['isajax'])?intval($_POST['isajax']):0;
		
		$jump = trim($_POST['jump']);
		$email = trim($_POST['email']);
		$pwd = trim($_POST['pwd']);
		
		$authcode = strtoupper($_POST['authcode']); //strtoupper将字符转成大写
		
		$cktime = $_POST['cktime'];
		
		$strUser =  $db -> once_fetch_assoc("select * from ".dbprefix."user where email='$email'");
		
		$salt = $strUser['salt'];
		
		$pwd19 = md5($salt.$pwd);

		$userNum	= $db->once_num_rows("select * from ".dbprefix."user where email='$email' and pwd='$pwd19'");
		
		$emailNum = $db->once_num_rows("select * from ".dbprefix."user where email='$email'");
		
		
		
		if($email=='' || $pwd==''){
			
			$json = array(
					'code'=>101,
					'email'=> $email,
					'message'=> '所有输入项都不能为空^_^',
					);
			$isajax?header('Content-type:text/json'):'';
			$isajax?outputJson($json):qiMsg('所有输入项都不能为空^_^');
		}elseif(valid_email($email) == false){
			$json = array(
					'code'=>101,
					'email'=> $email,
					'message'=> 'Email书写不正确^_^',
					);
			$isajax?header('Content-type:text/json'):'';
			$isajax?outputJson($json):qiMsg('Email书写不正确^_^');
		}
		
		
				//UC登录开始
			
		   if($TS_SITE['base']['isucenter']==1){
		     
               list($uid, $username, $password, $uc_email) = uc_user_login($email, trim($_POST['pwd']),2);
			   
			   
			   $isLuid =$db -> once_fetch_assoc("select userid from ".dbprefix."user_info where email='$email'"); 
			   
                 if($uid > 0) {
				      
					    //UC有账户，但本地没有，则创建本地账户
			if($isLuid['userid']<1){
			
		    $salt = md5(rand());
			
			$db->query("insert into ".dbprefix."user (`pwd` , `salt`,`email`) values ('".md5($salt.$pwd)."', '$salt' ,'$email');");
			
			$userid = $db->insert_id();
			
			//积分
			$db->query("insert into ".dbprefix."user_scores (`userid`,`scorename`,`score`,`addtime`) values ('".$userid."','注册','1000','".time()."')");
			
			//用户信息
			$arrData = array(
				'userid'	=> $userid,
				'ucid'      => $uid,
				'fuserid'	=> $fuserid,
				'username' 	=> $username,
				'email'		=> $email,
				'ip'			=> getIp(),
				'count_score'	=> '100',
				'addtime'	=> time(),
				'uptime'	=> time(),
				
			);
			
			//插入用户信息
			$db->insertArr($arrData,dbprefix.'user_info');
			
			//默认加入板块
			$isgroup = $db->once_fetch_assoc("select optionvalue from ".dbprefix."user_options where optionname='isgroup'");
			if($isgroup['optionvalue'] != ''){
				$arrGroup = explode(',',$isgroup['optionvalue']);
				foreach($arrGroup as $item){
					$groupusernum = $db->once_num_rows("select * from ".dbprefix."group_users where `userid`='".$userid."' and `groupid`='".$item."'");
					if($groupusernum == '0'){
						$db->query("insert into ".dbprefix."group_users (`userid`,`groupid`,`addtime`) values('".$userid."','".$item."','".time()."')");
						//统计更新
						$count_user = $db->once_num_rows("select * from ".dbprefix."group_users where `groupid`='".$item."'");
						$db->query("update ".dbprefix."group set `count_user`='".$count_user."' where `groupid`='".$item."'");
					}
				}
			}
			
			//用户信息
			$userData = $db->once_fetch_assoc("select * from ".dbprefix."user_info where userid='$userid'");
			
			//用户session信息
			$sessionData = array(
				'userid' => $userData['userid'],
				'username'	=> $userData['username'],
				'areaid'	=> $userData['areaid'],
				'path'	=> $userData['path'],
				'face'	=> $userData['face'],
				'count_score'	=> $userData['count_score'],
				'isadmin'	=> $userData['isadmin'],
				'uptime'	=> $userData['uptime'],
			);
			$_SESSION['tsuser']	= $sessionData;
			
			//发送系统消息(恭喜注册成功)
			$msg_userid = '0';
			$msg_touserid = $userid;
			$msg_content = '亲爱的 '.$username.' ：<br />您成功加入了 '
										.$TS_SITE['base']['site_title'].'<br />在遵守本站的规定的同时，享受您的愉快之旅吧!';
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
			
			//注销邀请码
			if($TS_APP['options']['isregister']=='1'){
				$db->query("update ".dbprefix."user_invites set `isused`='1' where `invitecode`='$invitecode'");
			}
			
						 qiMsg('登录成功');
						 }else{
							 
							//用户信息
							$userData = $db->once_fetch_assoc("select * from ".dbprefix."user_info where email='$email'");
			
							//用户session信息
							$sessionData = array(
								'userid' => $userData['userid'],
								'username'	=> $userData['username'],
								'areaid'	=> $userData['areaid'],
								'path'	=> $userData['path'],
								'face'	=> $userData['face'],
								'count_score'	=> $userData['count_score'],
								'isadmin'	=> $userData['isadmin'],
								'uptime'	=> $userData['uptime'],
							);
							$_SESSION['tsuser']	= $sessionData;
						     $syn= uc_user_synlogin($uid);
							 qiMsg( '登录成功'.$syn ,'去首页！',SITE_URL);
							 
						 }
						
						
	                  
               } elseif($uid == -1) {
			        if($isLuid['userid']>0){
					   
					   $_SESSION['tuntron']['activation']=$email;
					   
					   $_SESSION['tuntron']['password']=$pwd;
					   
					   if(md5($strUser['salt'].$pwd)!==$strUser['pwd']) {
						   $json = array(
							'code'=>101,
							'email'=> $email,
							'message'=> 'Email或者密码错误……',
							);
							$isajax?header('Content-type:text/json'):'';
						   $isajax?outputJson($json):qiMsg('Email或者密码错误……');
						   
					   }
		               qiMsg( '账号<strong>'.$email.'</strong>需要激活，<a href="'.SITE_URL.tsUrl('user','ucapi',array('ts'=>'activation')).'">立即激活</a>');
					}
               } elseif($uid == -2) {
			         //判断此账号是否为本地老账号，针对需要整合UC的老网站
			        
					  		 $applist=uc_app_ls();
				             $msg= '密码错误，请尝试该账号<strong>'.$email.'</strong>在下面站点的密码^ ^<br />';   
					  foreach($applist as $value){
			               $msg.= '<a href="'.$value['url'].'" style="margin-right:40px;">'.$value['name'].'</a>';
					  }
			   		 
					  qiMsg($msg);
					      
					 
               } else {
	                 qiMsg($uid );
               }
		   
		   }
		//uc整合结束
		
		
		
		if($emailNum == '0'){
			
			$json = array(
					'code'=>101,
					'email'=> $email,
					'message'=> '你还没有注册呢，请注册吧^_^',
					);
					$isajax?header('Content-type:text/json'):'';
					$isajax?outputJson($json):qiMsg('你还没有注册呢，请注册吧^_^');
			
		}elseif($emailNum > '0' && $userNum == '0'){
			
			$json = array(
							'code'=>101,
							'email'=> $email,
							'message'=> 'Email或者密码错误……',
							);
			$isajax?header('Content-type:text/json'):'';
			$isajax?outputJson($json):qiMsg('Email或者密码错误……');
			
		}else{
		
			$userData	= $db->once_fetch_assoc("select  * from ".dbprefix."user_info where email='$email'");
			
			if($userData['isenable'] == 1) qiMsg("sorry，你的帐号已被禁用！");
			
			//记住登录Cookie
			 if($cktime != ''){   
				 setcookie("ts_email", $email, time()+$cktime,'/');   
				 setcookie("ts_pwd", $pwd19, time()+$cktime,'/');
			 }   
			
			//用户session信息
			
			$sessionData = array(
				'userid' => $userData['userid'],
				'username'	=> $userData['username'],
				'areaid'	=> $userData['areaid'],
				'path'	=> $userData['path'],
				'face'	=> $userData['face'],
				'count_score'	=> $userData['count_score'],
				'isadmin'	=> $userData['isadmin'],
				'uptime'	=> $userData['uptime'],
			);
			$_SESSION['tsuser']	= $sessionData;
			
			//用户userid
			$userid = $userData['userid'];
			
			
			//积分记录
			$db->query("insert into ".dbprefix."user_scores (`userid`,`scorename`,`score`,`addtime`) values ('".$userid."','登录','10','".time()."')");
			
			$strScore = $db->once_fetch_assoc("select sum(score) score from ".dbprefix."user_scores where userid='".$userid."'");
			
			//更新登录时间
			$db->query("update ".dbprefix."user_info set `uptime`='".time()."' , `count_score`='".$strScore['score']."' where userid='$userid'");

			//跳转
			if($jump != ''){
				$isajax?header('Content-type:text/json'):'';
				$isajax?outputJson(array('code'=>100)):header("Location: ".$jump);
				
			}else{
				$isajax?header('Content-type:text/json'):'';
				$isajax?outputJson(array('code'=>100)): header('Location: '.SITE_URL);
			}
		
		}
		
		break;
	
	
	//退出	
	case "out":
		
		$jump = $_SERVER['HTTP_REFERER'];
		
		session_destroy();
		setcookie("ts_email", '', time()+3600,'/');   
		setcookie("ts_pwd", '', time()+3600,'/');
		
		if($jump != ''){
			header('Location: '.$jump);
		}else{
			header('Location: '.SITE_URL);
		}
		
		break;
}