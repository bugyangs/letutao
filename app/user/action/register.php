<?php
defined('IN_TS') or die('Access Denied.');
//用户注册
switch($ts){
	case "":
		if(intval($TS_USER['user']['userid']) > 0) qiMsg("请退出后再注册！","<a href=\"".SITE_URL."\">返回首页</a>");
		
		//邀请用户ID
		$fuserid = intval($_GET['fuserid']);
	
		$title = '注册';
		
		//调出省份数据
		$arrOne = $db->fetch_all_assoc("select * from ".dbprefix."area where referid='0'");
		
		include template("register");
		break;

	case "do":

		$email		= trim($_POST['email']);
		$pwd			= trim($_POST['pwd']);
		$repwd		= trim($_POST['repwd']);
		$username		= t($_POST['username']);
		
		$fuserid = intval($_POST['fuserid']);
		
		$authcode = strtoupper($_POST['authcode']); //strtoupper将字符转成大写
		
		//是否开启邀请注册
		if($TS_APP['options']['isregister']=='1'){
		
			$invitecode = trim($_POST['invitecode']);
			if($invitecode == '') qiMsg("邀请码不能为空！");
			$codeNum = $db->once_num_rows("select * from ".dbprefix."user_invites where invitecode='$invitecode' and isused='0'");
			if($codeNum == '0') qiMsg("邀请码无效，请更换邀请码！");
		
		}

		$isEmail = $db->once_num_rows("SELECT * FROM ".dbprefix."user WHERE email='$email'");
		$isusername = $db->once_num_rows("select * from ".dbprefix."user_info where username='$username'");
		
		
		if(empty($email) || empty($pwd) || empty($repwd) || empty($username)){
			qiMsg('所有必选项都不能为空！');
		}elseif(valid_email($email) == false){
			qiMsg('Email邮箱输入有误!');
		}elseif($isEmail != '0'){
			qiMsg('Email已经注册^_^');
		}elseif($pwd != $repwd){
			qiMsg('两次输入密码不正确！');
		}elseif(strlen($username) < 4 || strlen($username) > 20){
			qiMsg('姓名长度必须在4和20之间!');
		}elseif($username > 0){
			qiMsg("用户名不能使用数字开头！");
		}elseif($authcode != $_SESSION['authcode']){
			qiMsg("验证码输入有误，请重新输入！");
		}else{
			
			//注册Ucenter
			$uid=0;
			if($TS_SITE['base']['isucenter']==1){
				$uid = uc_user_register($username, $pwd, $email);
				if($uid <= 0) {
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
				} 
			}	
			
			//写入本地
			$salt = md5(rand());

			$db->query("insert into ".dbprefix."user (`pwd` , `salt`,`email`) values ('".md5($salt.$pwd)."', '$salt' ,'$email');");
			
			$userid = $db->insert_id();
			
			//积分
			$db->query("insert into ".dbprefix."user_scores (`userid`,`scorename`,`score`,`addtime`) values ('".$userid."','注册','10','".time()."')");
			
			//用户信息
			$arrData = array(
				'userid'	=> $userid,
				'fuserid'	=> $fuserid,
				'username' 	=> $username,
				'email'		=> $email,
				'ip'			=> getIp(),
				'count_score'	=> '10',
				'addtime'	=> time(),
				'uptime'	=> time(),
				'ucid'      => $uid,
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
						$count_user = $db->once_num_rows("select * from ".dbprefix."group_users where groupid='".$item."'");
						$db->query("update ".dbprefix."group set `count_user`='".$count_user."' where groupid='".$item."'");
					}
				}
			}
			
			//默认关注的人
			$isfollow = $db->once_fetch_assoc("select optionvalue from ".dbprefix."user_options where optionname='isfollow'");
			if($isfollow['optionvalue'] != ''){
				$arrGroup = explode(',',$isfollow['optionvalue']);
				foreach($arrGroup as $item){
					
					$userid_follow = $item;
					
				$db->query("insert into ".dbprefix."user_follow (`userid`,`userid_follow`,`addtime`) values ('$userid','$userid_follow','".time()."')");
			
			//统计更新关注和被关注数
			//统计自己的
			$count_follow = $db->once_num_rows("select * from ".dbprefix."user_follow where userid='$userid'");
			$count_followed = $db->once_num_rows("select * from ".dbprefix."user_follow where userid_follow='$userid'");
			
			$db->query("update ".dbprefix."user_info set `count_follow`='$count_follow',`count_followed`='$count_followed' where userid='$userid'");
			
			//统计别人的
			$count_follow_userid = $db->once_num_rows("select * from ".dbprefix."user_follow where userid='$userid_follow'");
			$count_followed_userid = $db->once_num_rows("select * from ".dbprefix."user_follow where userid_follow='$userid_follow'");
			
			$db->query("update ".dbprefix."user_info set `count_follow`='$count_follow_userid',`count_followed`='$count_followed_userid' where userid='$userid_follow'");
			
			//发送系统消息
			
			$strUser = $db->once_fetch_assoc("select userid,username,path,face from ".dbprefix."user_info where `userid`='$userid_follow'");
			
			//feed开始
			$feed_template = '<a href="{link}"><img title="{username}" alt="{username}" src="{face}" class="broadimg"></a>
			<span class="pl">关注<a href="{link}">{username}</a></span>';
			
			$feed_data = array(
				'link'	=> SITE_URL.tsurl('user','space',array('userid'=>$userid_follow)),
				'username'	=> $strUser['username'],
			);
			
			if($strUser['face']!=''){
				$feed_data['face'] = SITE_URL.miniimg($strUser['face'],'user',48,48,$strUser['path']);
			}else{
				$feed_data['face'] = SITE_URL.'public/images/noavatar.gif';
			}
			
			aac('feed')->addFeed($userid,$feed_template,serialize($feed_data),'friend');
			//feed结束
					
						
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
				$db->query("update ".dbprefix."user_invites set `isused`='1' where invitecode='$invitecode'");
			}
			
			//跳转
			header('Location: '.SITE_URL.'index.php');
			
		}
	break;
}