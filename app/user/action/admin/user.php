<?php
	/* 
	 * 用户管理
	 */
	
	switch($ts){
	
		//用户列表
		case "list":
			$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$url = 'index.php?app=user&ac=admin&mg=user&ts=list&page=';
			$arrAllUser	= $new['user']->getAllUser($page,10);
			$arrdaren = $db->fetch_all_assoc("select * from ".dbprefix."daren");
			$userNum = $new['user']->getUserNum('userid','userid');
			$pageUrl = pagination($userNum, 10, $page, $url);

			include template("admin/user_list");
			break;
		
		//用户编辑
		case "edit":
			$userid = $_GET['userid'];
			$strUser = $new['user']->getOneUserByUserid($userid);
			
			include template("admin/user_edit");
			break;
		
		//用户查看 
		case "view":
			$userid = $_GET['userid'];
			
			$strUser = $new['user']->getOneUserByUserid($userid);
			
			include template("admin/user_view");
			break;
			
			
		//删除用户
		case "del":
			$userid = $_GET['userid'];
			if($userid>1){
			$db->query("DELETE FROM ".dbprefix."user where userid='$userid'"); //删除用户账户
			
			$db->query("DELETE FROM ".dbprefix."user_info where userid='$userid'"); //删除用户信息
			
			$db->query("DELETE FROM ".dbprefix."user_follow where userid='$userid' or userid_follow='$userid'"); //删除用户跟随
			
			$db->query("DELETE FROM ".dbprefix."user_scores where userid='$userid'"); //删除用户积分
			
			$db->query("DELETE FROM ".dbprefix."group where userid='$userid'"); //删除用户创建的板块
			
			$db->query("DELETE FROM ".dbprefix."group_users where userid='$userid'"); //删除用户所在板块
			
			$db->query("DELETE FROM ".dbprefix."share_goods where uid='$userid'"); //删除用户分享
			
			$db->query("DELETE FROM ".dbprefix."share_goods_comments where userid='$userid'"); //删除用户评论
			
			$db->query("DELETE FROM ".dbprefix."share_goods_like where userid='$userid'"); //删除用户喜欢
			
			$db->query("DELETE FROM ".dbprefix."tag_user_index where userid='$userid'"); //删除用户标签
			
			$db->query("DELETE FROM ".dbprefix."theme where userid='$userid'"); //删除用户创建的主题
			}else{qiMsg("无法删除管理员账户！");}
			header("Location: ".SITE_URL."index.php?app=user&ac=admin&mg=user&ts=list");
			break;
		
		//用户停用启用
		case "isenable":
			$userid = $_GET['userid'];
			$isenable = $_GET['isenable'];
			$db->query("update ".dbprefix."user_info set `isenable`='$isenable' where userid='$userid'");
			header("Location: ".SITE_URL."index.php?app=user&ac=admin&mg=user&ts=list");
			break;
			
		//达人设置
		case "daren":
		
			$arrdaren = $db->fetch_all_assoc("select * from ".dbprefix."daren");

			include template("admin/user_daren");
			break;
			
		//添加达人
		case "adddaren":
			$arrdarenid = $_POST['darenid'];
			$arrdarenname  = $_POST['darenname'];
			$arrbackground = $_POST['background'];
			
			foreach($arrdarenname as $key=>$item){
			$darenname = trim($item);
			$darenid = trim($arrdarenid[$key]);
			$background = trim($arrbackground[$key]);
					
			$isdarenid = $db ->once_num_rows("select darenid from ".dbprefix."daren where darenid='".$darenid."'");
				if($isdarenid){
				$updatedaren = $db->query("UPDATE ".dbprefix."daren SET  darenname='".$darenname."',background='".$background."' where darenid = '".$darenid."'");
				}else{
				$insertdaren = $db->query("insert into ".dbprefix."daren SET darenname='".$darenname."',background='".$background."'");
				}
					
			}
			qiMsg("达人类型修改成功！","<a href=\"index.php?app=user&ac=admin&mg=user&ts=daren\">返回</a>");

			break;
			
			//设置达人
		case "setdaren":
			$guserid = intval($_POST['userid']);
			$gdarenid  = intval($_POST['darenid']);
			$strdaren = $db->once_fetch_assoc("select darenname	 from ".dbprefix."daren where darenid='$gdarenid'");
			$db->query("UPDATE ".dbprefix."user_info SET  darenid='".$gdarenid."' where userid = '".$guserid."'");
			if($gdarenid>0){
			$msg_userid = '0';
			$msg_touserid = $guserid;
			$msg_content = '恭喜，您已经被管理员设为《'.$strdaren['darenname'].'》啦！';
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
			}else{
				
			$msg_userid = '0';
			$msg_touserid = $guserid;
			$msg_content = '抱歉，您已经被管理员取消达人资格了，可能是因为您不够积极，再加油吧！';
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
				
				
			}
			echo 1;
			

			break;
	}