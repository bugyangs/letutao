<?php
defined('IN_TS') or die('Access Denied.');

//发表评论 
if($ts=='addcomment'){
	if (IS_POST) {
		
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		
		$topicid	= intval($_POST['topicid']);
		$content	= trim($_POST['content']);
		$commentId = intval($_POST['commentId']);
		//$content = preg_replace('/(&lt;)(img.+src=\"?.+)(.+\.(jpg|gif|bmp|bnp|png)\"?.+)(&gt;)/i',"<\${2}\${3}>",$content);
		if($commentId){
			
		$referid = $commentId;
		$addtime = time();
		
		

		$db->query("insert into ".dbprefix."group_topics_comments (`referid`,`topicid`,`userid`,`content`,`addtime`) values ('$referid','$topicid','$userid','$content','$addtime')");
		
		//统计评论数
		$count_comment = $db->once_num_rows("select * from ".dbprefix."group_topics_comments where topicid='$topicid'");
		
		//更新话题最后回应时间和评论数
		$uptime = time();
		
		$db->query("update ".dbprefix."group_topics set uptime='$uptime',count_comment='$count_comment' where topicid='$topicid'");
		
		$strTopic = $db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid='$topicid'");

		$strComment = $db->once_fetch_assoc("select * from ".dbprefix."group_topics_comments where commentid='$referid'");
		
		if($topicid && $strTopic['userid'] != $TS_USER['user']['userid']){
			$msg_userid = '0';
			$msg_touserid = $strTopic['userid'];
			$msg_content = '你的话题：《'.$strTopic['title'].'》新增一条评论，快去看看给个回复吧^_^ <br />'.SITE_URL.'index.php?app=group&ac=topic&topicid='.$topicid;
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
		}
		
		if($referid && $strComment['userid'] != $TS_USER['user']['userid']){
			$msg_userid = '0';
			$msg_touserid = $strComment['userid'];
			$msg_content = '有人评论了你在话题：《'.$strTopic['title'].'》中的回复，快去看看给个回复吧^_^ <br />'.SITE_URL.'index.php?app=group&ac=topic&topicid='.$topicid;
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
		}	
		
		header("Location: ".SITE_URL.tsurl('group','topic',array('topicid'=>$topicid)));
		exit;
		}
		
		//添加评论标签
		doAction('group_comment_add','',$content,'');
		
		if($content==''){
			qiMsg('没有任何内容是不允许你通过滴^_^');
		}else{
			$arrData	= array(
				'topicid'			=> $topicid,
				'userid'			=> $userid,
				'content'	=> $content,
				'addtime'		=> time(),
			);
			
			$commentid = $db->insertArr($arrData,dbprefix.'group_topics_comments');
			
			//统计评论数
			$count_comment = $db->once_num_rows("select * from ".dbprefix."group_topics_comments where topicid='$topicid'");
			
			//更新话题最后回应时间和评论数
			$uptime = time();
			
			$db->query("update ".dbprefix."group_topics set uptime='$uptime',count_comment='$count_comment' where topicid='$topicid'");
			
			//积分记录
			$db->query("insert into ".dbprefix."user_scores (`userid`,`scorename`,`score`,`addtime`) values ('".$userid."','回帖','20','".time()."')");
			
			$strScore = $db->once_fetch_assoc("select sum(score) score from ".dbprefix."user_scores where userid='".$userid."'");
			
			//更新积分
			$db->query("update ".dbprefix."user_info set `count_score`='".$strScore['score']."' where userid='$userid'");
			
			//发送系统消息(通知楼主有人回复他的话题啦)
			$strTopic = $db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid='$topicid'");
			if($strTopic['userid'] != $TS_USER['user']['userid']){
			
				$msg_userid = '0';
				$msg_touserid = $strTopic['userid'];
				$msg_content = '你的话题：《'.$strTopic['title'].'》新增一条评论，快去看看给个回复吧^_^ <br />'
											.SITE_URL.'index.php?app=group&ac=topic&topicid='.$topicid;
				aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
				
			}
			
			
			//feed开始

			$strGroup = $db->once_fetch_assoc("select * from ".dbprefix."group where groupid=".$strTopic['groupid']."");
			$feedtype = 'topic';
			if($strTopic['typeid']==1) {
				$strTheme = $db->once_fetch_assoc("select * from ".dbprefix."theme where topicid=".$strTopic['topicid']."");
				$feedtype = 'zhuti';
			}
			$c_type = $strTopic['typeid']==0?'在板块 <a href="'.SITE_URL.tsurl('group','group',array('groupid'=>$strGroup['groupid'])).'" target="_blank">'.$strGroup['groupname'].'</a> 回复话题 <a href="{link}" target="_blank">{title}</a>':'评论主题 <a href="'.SITE_URL.tsurl('zhuti'.$strTheme['themeid']).'" target="_blank">'.$strTheme['title'].'</a>';
			$feed_template = '<span class="content mr10">：'.$c_type.'</span>';
	
			$feed_data = array(
				'link'	=> tsurl('group','topic',array('topicid'=>$topicid)),
				'topicid'	=> $topicid,
				'title'	=> $strTopic['title'],
				'content'	=> getsubstrutf8(t($content),'0','50'),
			);
			aac('feed')->addFeed($userid,$feed_template,serialize($feed_data),$feedtype);
			//feed结束
			
			
			header("Location: ".SITE_URL."index.php?app=group&ac=topic&topicid=".$topicid);
		}	
	}
}

switch ($ts) {

	case "new_topic":
	
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
	
		$groupid	= intval($_POST['groupid']);
		
		$title	= htmlspecialchars(trim($_POST['title']));
		$content	= trim($_POST['content']);
		//$content = preg_replace('/(&lt;)(img.+src=\"?.+)(.+\.(jpg|gif|bmp|bnp|png)\"?.+)(&gt;)/i',"<\${2}\${3}>",$content);
		$isask	= intval($_POST['isask']);
		
		$tag = trim($_POST['tag']);
		
		//发布话题标签
		doAction('group_topic_add',$title,$content,$tag);
		
		$typeid = intval($_POST['typeid']);
		
		$iscomment = $_POST['iscomment'];
		
		
		if($title==''){

			qiMsg('不要这么偷懒嘛，多少请写一点内容哦^_^');
			
		}elseif($content==''){

			qiMsg('没有任何内容是不允许你通过滴^_^');
			
		}elseif(mb_strlen($title,'utf8')>64){//限制发表内容多长度，默认为30
			
		 	qiMsg('标题很长很长很长很长...^_^');
		
		}elseif(mb_strlen($content,'utf8')>20000){//限制发表内容多长度，默认为1w
			
		 	qiMsg('发这么多内容干啥^_^');
		
		}else{
			
			$uptime = time();
			
			$arrData = array(
				'groupid'				=> $groupid,
				'typeid'	=> $typeid,
				'userid'				=> $TS_USER['user']['userid'],
				'title'				=> $title,
				'content'		=> $content,
				'iscomment'		=> $iscomment,
				'isask'			=> $isask,
				'addtime'			=> time(),
				'uptime'	=> $uptime,
			);
			
			//判断是否有图片和附件
			preg_match_all('/\[(photo)=(\d+)\]/is', $content, $isphoto);
			if($isphoto[2]){
				$arrData['isphoto'] = '1';
			}
			//判断附件
			preg_match_all('/\[(attach)=(\d+)\]/is', $content, $isattach);
			if($isattach[2]){
				$arrData['isattach'] = '1';
			}
			
			$topicid = $db->insertArr($arrData,dbprefix.'group_topics');
			
			$strGroup = $db->once_fetch_assoc("select groupid,groupname from ".dbprefix."group where `groupid`='$groupid'");
			
			//统计话题类型 
			if($typeid != '0'){
				$topicTypeNum = $db->once_num_rows("select * from ".dbprefix."group_topics where typeid='$typeid'");
				$db->query("update ".dbprefix."group_topics_type set `count_topic`='$topicTypeNum' where typeid='$typeid'");
			}
			//处理标签
			aac('tag')->addTag('topic','topicid',$topicid,$tag);
			
			//统计板块下话题数并更新
			$count_topic = $db->once_num_rows("select * from ".dbprefix."group_topics where groupid='$groupid'");
			
			//统计今天发布话题数
			$today_start = strtotime(date('Y-m-d 00:00:00'));
			$today_end = strtotime(date('Y-m-d 23:59:59'));
			
			$count_topic_today = $db->once_num_rows("select * from ".dbprefix."group_topics where groupid='$groupid' and addtime > '$today_start'");
			
			
			$db->query("update ".dbprefix."group set count_topic='$count_topic',count_topic_today='$count_topic_today',uptime='$uptime' where groupid='$groupid'");
			
			
			
			//积分记录
			$userid = $TS_USER['user']['userid'];
			$db->query("insert into ".dbprefix."user_scores (`userid`,`scorename`,`score`,`addtime`) values ('".$userid."','发帖','50','".time()."')");
			
			$strScore = $db->once_fetch_assoc("select sum(score) score from ".dbprefix."user_scores where userid='".$userid."'");
			
			//更新积分
			$db->query("update ".dbprefix."user_info set `count_score`='".$strScore['score']."' where userid='$userid'");
			
			//feed开始
			$feed_template = '<span class="pl">在 <a href="{group_link}">{group_name}</a> 创建了新话题：<a href="{topic_link}">{topic_title}</a></span><div class="broadsmr">{content}</div><div class="indentrec"><span><a  class="j a_rec_reply" href="{topic_link}">回应</a></span></div>';
			$feed_data = array(
				'group_link'	=> SITE_URL.tsurl('group','group',array('groupid'=>$strGroup['groupid'])),
				'group_name'	=> $strGroup['groupname'],
				'topic_link'	=> SITE_URL.tsurl('group','topic',array('topicid'=>$topicid)),
				'topic_title'	=> $title,
				'content'	=> getsubstrutf8(t($content),'0','50'),
			);
			aac('feed')->addFeed($userid,$feed_template,serialize($feed_data),'topic');
			//feed结束
			
			header("Location: ".SITE_URL."index.php?app=group&ac=topic&topicid=".$topicid);
			
		}
		break;

	//加入该板块
	case "joingroup":
		
		$userid = intval($TS_USER['user']['userid']);
		
		$groupid = intval($_POST['groupid']);
		
		$groupUserNum = $db->once_num_rows("select * from ".dbprefix."group_users where userid='$userid' and groupid='$groupid'");
		
		if($userid == '0'){
			echo '0';return false;
		}elseif($groupUserNum > 0){
			echo '1';return false;
		}else{
		
			$db->query("INSERT INTO ".dbprefix."group_users (`userid`,`groupid`,`addtime`) VALUES ('".$userid."','".$groupid."','".time()."')");
			
			//计算板块会员数
			$groupUserNum = $db->once_num_rows("select * from ".dbprefix."group_users where groupid='$groupid'");
			//更新板块成员统计
			$db->query("update ".dbprefix."group set `count_user`='$groupUserNum' where groupid='$groupid'");

			echo '2';return false;
		
		}
	
		break;
	
	//退出该板块
	case "exitgroup":
		
		$userid = intval($TS_USER['user']['userid']);
		
		$groupid = intval($_POST['groupid']);
		
		//判断是否是组长，是组长不能退出板块
		$strGroup = $db->once_fetch_assoc("select userid from ".dbprefix."group where groupid='$groupid'");
		
		if($userid == $strGroup['userid']){
			echo '0';return false;
		}else{
			$db->query("DELETE FROM ".dbprefix."group_users WHERE userid='$userid' and groupid='$groupid'");
			
			//计算板块会员数
			$groupUserNum = $db->once_num_rows("select * from ".dbprefix."group_users where groupid='$groupid'");
			
			//更新板块统计
			$db->query("update ".dbprefix."group set `count_user`='$groupUserNum' where groupid='$groupid'");
			
			echo '1';return false;
		}
		
		break;
	case "getVideo":
	if(!empty($_POST['url'])) {
		
		$urlVideo = h($_POST['url']);
		
		//优酷视频
		if(strpos($urlVideo,'youku')){
			
				preg_match_all("/id\_(\w+)[\=|.html]/",$urlVideo, $matches);
  				if(!empty($matches[1][0])){
  				 $flashid= $matches[1][0];
  				}else{
					$json['msg'] ='请输入视频播放页面的地址';
					$json['code']= 101;
					outputJson($json);
				}
			$return['code'] 	 = 100;
			$return['swf']  	 = 'http://player.youku.com/player.php/sid/'.$flashid.'/v.swf';
			
			$db->query("INSERT INTO ".dbprefix."image_file (`imageurl`,`addtime`) VALUES ('".$return['swf']."','".time()."')");
			$Videoid = $db->insert_id();
			
			$Videojson			 = file_get_contents('http://v.youku.com/player/getPlayList/VideoIDS/'.$flashid);
			$VideoinfoArr		 = json_decode($Videojson, true);
			$return['pic']		 = $VideoinfoArr['data']['0']['logo'];
			$return['title']  	 = $VideoinfoArr['data']['0']['title'];
			$return['Videoid']   = $Videoid;
			outputJson($return);
			
		}
		
		
	}else{
		
		$json['code']= 101;
		$json['msg'] ='网址不存在！';
		
		outputJson($json);
		
	}
	
	break;
	
		
	//网络图片地址存储
	
	case "net_img":
	
	
	$net_img = h($_POST['url']);
	$db->query("INSERT INTO ".dbprefix."image_file (`imageurl`,`addtime`) VALUES ('".$net_img."','".time()."')");
	$imgid = $db->insert_id();
	
	outputJson($imgid);
	
	break;
		
	
		
	//上传图片
	
	case "upload_img":
	

	
	if(!empty($_FILES['filedata']['name'])) {
		
			$f=$_FILES['filedata'];
			$uptypes = array( 
			'image/jpg',
			'image/jpeg',
			'image/png',
			'image/pjpeg',
			'image/gif',
			'image/x-png',
			);
		
		if (!in_array($f['type'],$uptypes)) {
					$json= "你上传的图片类型不正确，系统仅支持 jpg,gif,png 格式的图片!";
					 echo $json;
				}
				
			$newdir = date('Ymd',time());
			$dest_dir='uploadfile/group/'.$newdir;
			createFolders($dest_dir);
			
			//原图
			$fileInfo=pathinfo($f['name']);
			$extension=$fileInfo['extension'];
			$newphotoname = $extension;
			$dest=$dest_dir.'/'.date("Ymd_His") . '_' . rand(100,999).'.'.$newphotoname;

			move_uploaded_file($f['tmp_name'],mb_convert_encoding($dest,"gb2312","UTF-8"));
			chmod($dest, 0755);
			
			$db->query("INSERT INTO ".dbprefix."image_file (`imageurl`,`addtime`) VALUES ('$dest','".time()."')");
			$imageid = $db->insert_id();
			echo '<script>top.jQuery.guang.editor.uploadImgCallback(true,"'.SITE_URL.$dest.'","'.$imageid.'");</script>';
				
				
		
		
		
			}else{
				
				$json= "请选择要上传的图片";
				 echo $json;
			}
	
	break;
	//上传板块头像
	
	case "groupicon":
		
		$groupid = intval($_POST['groupid']);
		
		//处理目录存储方式
		$menu = substr($groupid,0,1);
		
		$uptypes = array( 
			'image/jpg',
			'image/jpeg',
			'image/png',
			'image/pjpeg',
			'image/gif',
			'image/x-png',
		);

		if(isset($_FILES['picfile'])){
		
			$f=$_FILES['picfile'];
			
			if(empty($f['name'])){
			
				qiMsg("头像不能为空！");
				
			}elseif ($f['name']){
				if (!in_array($_FILES['picfile']['type'],$uptypes)) {
					qiMsg('你上传的头像图片类型不正确，系统仅支持 jpg,gif,png 格式的图片!');
				}
			} 
			
			//存储方式
			//1000个文件一个目录 
			$menu2=intval($groupid/1000);
			$menu1=intval($menu2/1000);
			$menu = $menu1.'/'.$menu2;
			
			$newdir = $menu;
			$dest_dir='uploadfile/group/'.$newdir;
			createFolders($dest_dir);
			
			//原图
			$fileInfo=pathinfo($f['name']);
			$extension=$fileInfo['extension'];
			$newphotoname = $groupid.'.'.$extension;
			$dest=$dest_dir.'/'.$newphotoname;

			move_uploaded_file($f['tmp_name'],mb_convert_encoding($dest,"gb2312","UTF-8"));
			chmod($dest, 0755);

			$groupicon = $newdir.'/'.$newphotoname;
			
			//更新板块头像
			$db->query("update ".dbprefix."group set `path`='$menu',`groupicon`='$groupicon' where groupid='$groupid'");

			qiMsg("板块图标修改成功！");
			
		}
		
		break;
	
	//编辑板块基本信息
	case "edit_base":
	
		if($_POST['groupname']=='' || $_POST['groupdesc']=='') qiMsg("板块名称和介绍都不能为空！");
	
		$arrData = array(
			'groupname'	=> h($_POST['groupname']),
			'groupdesc'	=> trim($_POST['groupdesc']),
			'joinway'		=> intval($_POST['joinway']),
			'ispost'	=> intval($_POST['ispost']),
			'isopen'		=> intval($_POST['isopen']),
			'role_leader'	=> t($_POST['role_leader']),
			'role_admin'	=> t($_POST['role_admin']),
			'role_user'	=> t($_POST['role_user']),
		);
		
		$groupid = intval($_POST['groupid']);
		
		$db->updateArr($arrData,dbprefix.'group','where groupid='.$groupid.'');
		
		//更新所有话题中对应板块的名称
		
		header("Location: ".SITE_URL."index.php?app=group&ac=edit_group&groupid=".$groupid."&ts=base");
		
		break;
	
	//添加板块分类索引
	case "addgroupcateindex":
		$groupid = $_POST['groupid'];
		$cateid = $_POST['cateid'];
		
		$uptime = time();
		
		if($cateid > 0){
			$db->query("INSERT INTO ".dbprefix."group_cates_index (`groupid`,`cateid`) VALUES ('$groupid','$cateid')");
			//更新分类下板块数
			$groupnum = $db->once_num_rows("select * from ".dbprefix."group_cates_index where cateid='$cateid'");
			
			$db->query("update ".dbprefix."group_cates set `count_group`='$groupnum',`uptime`='$uptime' where cateid='$cateid'");
			
			
			//判断是否有顶级分类
			$strCate = $db->once_fetch_assoc("select catereferid from ".dbprefix."group_cates where cateid='$cateid'");
			$catereferid = $strCate['catereferid'];
			
			if($catereferid > 0){
				//统计顶级分类下板块数
				$grouptotal = $db->once_fetch_assoc("select sum(`count_group`) as `total` from ".dbprefix."group_cates where catereferid='$catereferid'");
				
				$total = $grouptotal['total'];
				
				$db->query("update ".dbprefix."group_cates set `count_group`='$total',`uptime`='$uptime' where cateid='$catereferid'");
			}

			
		}
		
		echo '0';

		break;
	
	//添加话题附件
	case "topic_attach_add":
		
		if($_FILES['attach']['name'][0] == '') qiMsg("上传文件不能为空！");
		
		$groupid = $_POST['groupid'];
		$topicid = $_POST['topicid'];
		
		//处理目录存储方式
		$menu = substr($topicid,0,1);
		
		$date = date('Ymd');
		
		$dest_dir='uploadfile/group/topic/'.$menu.'/'.$date.'/'.$topicid;
		createFolders($dest_dir);
	
		$score = intval($_POST['score']);
		$isview = $_POST['isview'];
		
		if(isset($_FILES['attach'])){
			$arrFileName = $_FILES['attach']['name'];
			foreach($arrFileName as $key=>$item){
				if($item != ''){
					$attachname = $item;
					$attachtype = $_FILES['attach']['type'][$key];
					$attachsize = $_FILES['attach']['size'][$key];
					
					$dest=$dest_dir.'/'.$item;
					move_uploaded_file($_FILES['attach']['tmp_name'][$key], mb_convert_encoding($dest,"gb2312","UTF-8"));
					chmod($dest, 0755);
					
					$arrData = array(
						'userid'	=> $TS_USER['user']['userid'],
						'groupid'		=> $groupid,
						'topicid'		=> $topicid,
						'attachname'	=> $attachname,
						'attachtype'	=> $attachtype,
						'attachurl'		=> $dest,
						'attachsize'		=> $attachsize,
						'score'		=> $score,
						'isview'		=> $isview,
						'addtime'	=> time(),
					);
					
					$attachid = $db->insertArr($arrData,dbprefix.'group_topics_attachs');
					
				}
				
			}
		}		
		
		//统计附件并更新
		$count_attach = $db->once_num_rows("select * from ".dbprefix."group_topics_attachs where topicid='".$topicid."'");
		$db->query("update ".dbprefix."group_topics set `count_attach`='".$count_attach."' where topicid='".$topicid."'");
		
		header("Location: ".SITE_URL."index.php?app=group&ac=topic&topicid=".$topicid);
		
		break;
	
	//创建板块
	case "group_add":
		
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		
		$oneid = intval($_POST['oneid']);
		$twoid = intval($_POST['twoid']);
		$threeid = intval($_POST['threeid']);
		
		if($oneid != 0 && $twoid==0 && $threeid==0){
			$cateid = $oneid;
		}elseif($oneid!=0 && $twoid !=0 && $threeid==0){
			$cateid = $twoid;
		}elseif($oneid!=0 && $twoid !=0 && $threeid!=0){
			$cateid = $threeid;
		}else{
			$cateid = 0;
		}
		
		if($userid=='0' || $_POST['groupname']=='' || $_POST['groupdesc']=='') qiMsg("色即是空，空即是色！");
		
		//配置文件是否需要审核
		$isaudit = intval($TS_APP['options']['isaudit']);
		
		$groupname = h($_POST['groupname']);
		
		
		
		
		$uptypes = array( 
			'image/jpg',
			'image/jpeg',
			'image/png',
			'image/pjpeg',
			'image/gif',
			'image/x-png',
		);
		$pic = $_FILES['picfile'];
		if(isset($pic)){

			$f=$pic;

		if ($f['name']){
				if (!in_array($_FILES['picfile']['type'],$uptypes)) {
					qiMsg("仅支持 jpg,gif,png 格式的图片！");
				}
			}
		}
		if($f['name']){
			$uptime = time();
			$fold = date('Ymd',$uptime);
			$random = random(14);
			$dir = "cache/thumb/theme/".$fold;
			!is_dir($dir)?mkdir($dir,0777):'';
			$dest="cache/thumb/theme/".$fold."/".$random."w960.jpg";
			move_uploaded_file($f['tmp_name'],mb_convert_encoding($dest,"gb2312","UTF-8"));
			mkdir($dest, 0777);
			$picimg= fileiimg($dest,'groupicon',80,80,'',1);
			@unlink($dest);
		}
		
		$isGroup = $db->once_fetch_assoc("select count(groupid) from ".dbprefix."group where groupname='$groupname'");
		
		if($isGroup['count(groupid)'] > 0) qiMsg("板块名称已经存在，请更换其他板块名称！");
		
		$arrData = array(
			'userid'			=> $userid,
			'groupicon'			=> $picimg,
			'groupname'			=> $groupname,
			'groupdesc'			=> $_POST['groupdesc'],
			'isaudit'			=> $isaudit,
			'addtime'			=> time(),
		);
		
		$groupid = $db->insertArr($arrData,dbprefix.'group');
		$uptime = time();
		
		//绑定板块分类开始
		if($cateid > 0){
			$db->query("INSERT INTO ".dbprefix."group_cates_index (`groupid`,`cateid`) VALUES ('$groupid','$cateid')");
			//更新分类下板块数
			$groupnum = $db->once_num_rows("select * from ".dbprefix."group_cates_index where cateid='$cateid'");
			
			$db->query("update ".dbprefix."group_cates set `count_group`='$groupnum',`uptime`='$uptime' where cateid='$cateid'");
			
			
			//判断是否有顶级分类
			$strCate = $db->once_fetch_assoc("select catereferid from ".dbprefix."group_cates where cateid='$cateid'");
			$catereferid = $strCate['catereferid'];
			
			if($catereferid > 0){
				//统计顶级分类下板块数
				$grouptotal = $db->once_fetch_assoc("select sum(`count_group`) as `total` from ".dbprefix."group_cates where catereferid='$catereferid'");
				
				$total = $grouptotal['total'];
				
				$db->query("update ".dbprefix."group_cates set `count_group`='$total',`uptime`='$uptime' where cateid='$catereferid'");
			}
		}
		//绑定板块分类结束
		
		//绑定成员
		$db->query("insert into ".dbprefix."group_users (`userid`,`groupid`,`addtime`) values ('".$userid."','".$groupid."','".time()."')");
		
		//更新
		$db->query("update ".dbprefix."group set `count_user` = '1' where groupid='".$groupid."'");

		header("Location: ".SITE_URL."index.php?app=group&ac=group&groupid=".$groupid."");
		
		break;
		
		
		
		
		//修改板块
	case "group_e":
		
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$groupid = intval($_POST['groupid']);
		$oneid = intval($_POST['oneid']);
		$twoid = intval($_POST['twoid']);
		$threeid = intval($_POST['threeid']);
		
		if($oneid != 0 && $twoid==0 && $threeid==0){
			$cateid = $oneid;
		}elseif($oneid!=0 && $twoid !=0 && $threeid==0){
			$cateid = $twoid;
		}elseif($oneid!=0 && $twoid !=0 && $threeid!=0){
			$cateid = $threeid;
		}else{
			$cateid = 0;
		}
		
		if($userid=='0' || $_POST['groupname']=='' || $_POST['groupdesc']=='') qiMsg("色即是空，空即是色！");
		

		$groupname = h($_POST['groupname']);

		$uptypes = array( 
			'image/jpg',
			'image/jpeg',
			'image/png',
			'image/pjpeg',
			'image/gif',
			'image/x-png',
		);
		$pic = $_FILES['picfile'];
		if(isset($pic)){

			$f=$pic;

		if ($f['name']){
				if (!in_array($_FILES['picfile']['type'],$uptypes)) {
					qiMsg("仅支持 jpg,gif,png 格式的图片！");
				}
			}
		}
		if($f['name']){
			$uptime = time();
			$fold = date('Ymd',$uptime);
			$random = random(14);
			$dir = "cache/thumb/theme/".$fold;
			!is_dir($dir)?mkdir($dir,0777):'';
			$dest="cache/thumb/theme/".$fold."/".$random."w960.jpg";
			move_uploaded_file($f['tmp_name'],mb_convert_encoding($dest,"gb2312","UTF-8"));
			mkdir($dest, 0777);
			$picimg= fileiimg($dest,'groupicon',80,80,'',1);
			@unlink($dest);
		}
		$thisGroup = $db->once_fetch_assoc("select groupname,userid from ".dbprefix."group where groupid='$groupid'");
		
		if($groupname!==$thisGroup['groupname']){
		$isGroup = $db->once_fetch_assoc("select count(groupid) from ".dbprefix."group where groupname='$groupname'");
		if($isGroup['count(groupid)'] > 0) qiMsg("板块名称已经存在，请更换其他板块名称！");
		}
		$picimg = $picimg?$picimg:$_POST['postpicimg'];
		$groupdesc = $_POST['groupdesc'];
		if($thisGroup['$thisGroup']==$userid||$userid==1){
		$db->query("update ".dbprefix."group set `groupicon` = '$picimg' , `groupname` =  '$groupname' , `groupdesc`= '$groupdesc' where groupid='".$groupid."'");
		}else{
			
			qiMsg("您无权修改该板块信息！");
			
		}

		header("Location: ".SITE_URL."index.php?app=group&ac=group&groupid=".$groupid."");
		
		break;
		
		
	//删除评论回帖
	case "comment_del":
		
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		
		$commentid = intval($_GET['commentid']);
		
		$strComment = $db->once_fetch_assoc("select topicid from ".dbprefix."group_topics_comments where `commentid`='$commentid'");
		
		$strTopic = $db->once_fetch_assoc("select userid,groupid from ".dbprefix."group_topics where `topicid`='".$strComment['topicid']."'");
		
		$strGroup = $db->once_fetch_assoc("select userid from ".dbprefix."group where `groupid`='".$strTopic['groupid']."'");
		
		if($strTopic['userid']==$userid || $strGroup['userid']==$userid || $TS_USER['user']['isadmin']==1){
			
			$db->query("DELETE FROM ".dbprefix."group_topics_comments WHERE commentid = '".$commentid."'");
			//统计
			$db->query("update ".dbprefix."group_topics set count_comment=count_comment-1 where topicid='".$strComment['topicid']."'");
		}
		
		//跳转回到话题页
		header("Location: ".SITE_URL.tsurl('group','topic',array('topicid'=>$strComment['topicid'])));
		
		
		break;
		
	//删除话题
	case "topic_del":
	
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		
		$groupid = $_GET['groupid'];
		$topicid = $_GET['topicid'];
		
		
		$strGroup = $db->once_fetch_assoc("select userid from ".dbprefix."group where groupid='$groupid'");
		
		$strTopic = $db->once_fetch_assoc("select userid from ".dbprefix."group_topics where topicid='$topicid'");
		
		$strGroupUser = $db->once_fetch_assoc("select * from ".dbprefix."group_users where userid='$userid' and groupid='".$groupid."'");
		
		if($userid == $strTopic['userid'] || $userid == $strGroup['userid'] || $strGroupUser['isadmin']=='1' || $TS_USER['user']['isadmin'] == '1'){
			
			//删除话题
			$db->query("DELETE FROM ".dbprefix."group_topics WHERE topicid = '".$topicid."'");
			//删除评论回复
			$db->query("DELETE FROM ".dbprefix."group_topics_comments WHERE topicid = '".$topicid."'");
			//删除tag索引
			$db->query("DELETE FROM ".dbprefix."tag_topic_index WHERE topicid = '".$topicid."'");
			
			//统计 
			$db->query("update ".dbprefix."group set count_topic=count_topic-1 where groupid='".$groupid."'");
			
			header("Location: ".SITE_URL."index.php?app=group&ac=group&groupid=".$groupid."");
			
		}else{

			header("Location: ".SITE_URL."index.php?app=group&ac=topic&topicid=".$topicid."");
		
		}
		
		break;
		
	//编辑话题 
	case "topic_eidt":
	
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		if($userid == 0){
			header("Location: ".SITE_URL);
			exit;
		}
		
		$topicid = $_POST['topicid'];
		$title = htmlspecialchars(trim($_POST['title']));
		$typeid = '0';
		$content = trim($_POST['content']);
		$isask	= intval($_POST['isask']);
		
		$iscomment = $_POST['iscomment'];
		
		if($topicid == '' || $title=='' || $content=='') qiMsg("都不能为空的哦!");
		
		$strTopic = $db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid='".$topicid."'");
		
		$strGroup = $db->once_fetch_assoc("select userid from ".dbprefix."group where groupid='".$strTopic['groupid']."'");
		
		if($strTopic['userid']==$userid || $strGroup['userid']==$userid || $TS_USER['user']['isadmin']==1){
		
			$arrData = array(
				'typeid' => $typeid,
				'title' => $title,
				'isask' => $isask,
				'content' => $content,
				'iscomment' => $iscomment,
			);
			
			//判断是否有图片和附件
			preg_match_all('/\[(photo)=(\d+)\]/is', $content, $isphoto);
			if($isphoto[2]){
				$arrData['isphoto'] = '1';
			}else{
				$arrData['isphoto'] = '0';
			}
			//判断附件
			preg_match_all('/\[(attach)=(\d+)\]/is', $content, $isattach);
			if($isattach[2]){
				$arrData['isattach'] = '1';
			}else{
				$arrData['isattach'] = '0';
			}
			
			$db->updateArr($arrData,dbprefix.'group_topics','where topicid='.$topicid.'');

			header("Location: ".SITE_URL."index.php?app=group&ac=topic&topicid=".$topicid);
			
		}else{
			header("Location: ".SITE_URL);
			exit;
		}
		
		
		break;
		
	//收藏话题
	case "topic_collect":
		
		$userid = intval($TS_USER['user']['userid']);
		
		$topicid = $_POST['topicid'];
		
		$strTopic = $db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid='".$topicid."'");
		
		$collectNum = $db->once_num_rows("select * from ".dbprefix."group_topics_collects where userid='$userid' and topicid='$topicid'");
		
		if($userid == '0'){
			echo 0;
		}elseif($userid == $strTopic['userid']){
			echo 1;
		}elseif($collectNum > 0){
			echo 2;
		}else{
			$db->query("insert into ".dbprefix."group_topics_collects (`userid`,`topicid`,`addtime`) values ('".$userid."','".$topicid."','".time()."')");
			echo 3;
		}
		
		break;
		
	//置顶话题
	case "topic_istop":
	
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		
		if($userid <> 1) qiMsg("管理员已经禁止普通用户置顶"); 
		
		$topicid = intval($_GET['topicid']);
		
		$strTopic = $db->once_fetch_assoc("select userid,groupid,istop from ".dbprefix."group_topics where topicid='$topicid'");
		
		$istop = $strTopic['istop'];
		
		$istop == 0 ? $istop = 1 : $istop = 0;
		
		$strGroup = $db->once_fetch_assoc("select userid from ".dbprefix."group where groupid='".$strTopic['groupid']."'");
		
		if($userid!=$strGroup['userid'] || $TS_USER['user']['isadmin']==1){
			$db->query("update ".dbprefix."group_topics set istop='$istop' where topicid='$topicid'");
			qiMsg("话题置顶成功！");
		}else{
			qiMsg("非法操作！");
		}
		break;
		
	//隐藏显示话题
	case "topic_isshow":
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		
		$topicid =intval($_GET['topicid']);
		
		$strTopic = $db->once_fetch_assoc("select userid,groupid,isshow from ".dbprefix."group_topics where `topicid`='$topicid'");
		
		$strGroup = $db->once_fetch_assoc("select userid from ".dbprefix."group where `groupid`='".$strTopic['groupid']."'");
		
		$isshow = intval($strTopic['isshow']);
		
		$isshow == 0 ? $isshow = 1 : $isshow = 0;
		
		if($userid == $strGroup['userid'] || $TS_USER['user']['isadmin']==1){
			$db->query("update ".dbprefix."group_topics set isshow='$isshow' where topicid='$topicid'");
			qiMsg("操作成功！");
		}else{
			qiMsg("非法操作！");
		}
		
		break;
	
	//话题标签
	case "topic_tag_ajax";
		
		$topicid = $_GET['topicid'];
		include template("topic_tag_ajax");
		break;
	
	//添加话题标签
	case "topic_tag_do":
		
		$topicid = intval($_POST['topicid']);
		
		if($topicid == 0) qiMsg("非法操作！");
		
		$tagname = t($_POST['tagname']);
		$uptime	= time();
		
		if($tagname != ''){
		
			if(strlen($tagname) > '32') qiMsg("TAG长度大于32个字节（不能超过16个汉字）");
			
			$tagcount = $db->once_num_rows("select * from ".dbprefix."tag where tagname='".$tagname."'");
			
			if($tagcount == '0'){
				$db->query("INSERT INTO ".dbprefix."tag (`tagname`,`uptime`) VALUES ('".$tagname."','".$uptime."')");
				$tagid = $db->insert_id();
				
				$tagIndexCount = $db->once_num_rows("select * from ".dbprefix."tag_topic_index where topicid='".$topicid."' and tagid='".$tagid."'");
				if($tagIndexCount == '0'){
					$db->query("INSERT INTO ".dbprefix."tag_topic_index (`topicid`,`tagid`) VALUES ('".$topicid."','".$tagid."')");
				}
				
				$tagIdCount = $db->once_num_rows("select * from ".dbprefix."tag_topic_index where tagid='".$tagid."'");
				
				$db->query("update ".dbprefix."tag set `count_topic`='".$tagIdCount."',`uptime`='".$uptime."' where tagid='".$tagid."'");
				
			}else{
				
				$tagData = $db->once_fetch_assoc("select * from ".dbprefix."tag where tagname='".$tagname."'");
				
				$tagIndexCount = $db->once_num_rows("select * from ".dbprefix."tag_topic_index where topicid='".$topicid."' and tagid='".$tagData['tagid']."'");
				if($tagIndexCount == '0'){
					$db->query("INSERT INTO ".dbprefix."tag_topic_index (`topicid`,`tagid`) VALUES ('".$topicid."','".$tagData['tagid']."')");
				}
				
				$tagIdCount = $db->once_num_rows("select * from ".dbprefix."tag_topic_index where tagid='".$tagData['tagid']."'");
				
				$db->query("update ".dbprefix."tag set `count_topic`='".$tagIdCount."',`uptime`='".$uptime."' where tagid='".$tagData['tagid']."'");
				
			}
			
			echo "<script language=JavaScript>parent.window.location.reload();</script>";
			
		}
		
		break;
		
	//话题分类
	case "topic_type":
	
		$groupid = intval($_POST['groupid']);
		$typename = t($_POST['typename']);
		if($typename != '')
		  $db->query("insert into ".dbprefix."group_topics_type (`groupid`,`typename`) values ('$groupid','$typename')");
		
		header("Location: ".SITE_URL."index.php?app=group&ac=edit_group&ts=type&groupid=".$groupid);
		
		break;
			
	//回复评论
	case "recomment":
	
		$userid = intval($TS_USER['user']['userid']);
		
		$referid = $_POST['referid'];
		$topicid = $_POST['topicid'];
		$content = trim($_POST['content']);
		$addtime = time();

		$db->query("insert into ".dbprefix."group_topics_comments (`referid`,`topicid`,`userid`,`content`,`addtime`) values ('$referid','$topicid','$userid','$content','$addtime')");
		
		//统计评论数
		$count_comment = $db->once_num_rows("select * from ".dbprefix."group_topics_comments where topicid='$topicid'");
		
		//更新话题最后回应时间和评论数
		$uptime = time();
		
		$db->query("update ".dbprefix."group_topics set uptime='$uptime',count_comment='$count_comment' where topicid='$topicid'");
		
		$strTopic = $db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid='$topicid'");
		$strComment = $db->once_fetch_assoc("select * from ".dbprefix."group_topics_comments where commentid='$referid'");
		
		if($topicid && $strTopic['userid'] != $TS_USER['user']['userid']){
			$msg_userid = '0';
			$msg_touserid = $strTopic['userid'];
			$msg_content = '你的话题：《'.$strTopic['title'].'》新增一条评论，快去看看给个回复吧^_^ <br />'.SITE_URL.'index.php?app=group&ac=topic&topicid='.$topicid;
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
		}
		
		if($referid && $strComment['userid'] != $TS_USER['user']['userid']){
			$msg_userid = '0';
			$msg_touserid = $strComment['userid'];
			$msg_content = '有人评论了你在话题：《'.$strTopic['title'].'》中的回复，快去看看给个回复吧^_^ <br />'.SITE_URL.'index.php?app=group&ac=topic&topicid='.$topicid;
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
		}
		
		echo '0';
		
		break;
	
	//编辑话题类型
	case "edit_type":
		$typeid = $_POST['id'];
		$typename = t($_POST['value']);
		if(empty($typename)){
			echo '话题类型不能为空，请点击继续编辑';
		}else{
			$db->query("update ".dbprefix."group_topics_type set `typename`='$typename' where typeid='$typeid'");
			echo $typename;
		}
		break;
	//删除话题类型 
	case "del_type":
		$typeid = $_POST['typeid'];
		$db->query("delete from ".dbprefix."group_topics_type where typeid='$typeid'");
		$db->query("update ".dbprefix."group_topics set typeid='0' where typeid='$typeid'");
		echo '0';
		break;
		
	//取消板块分类
	case "cate_cancel":
		$cateid = intval($_POST['cateid']);
		$groupid = $_POST['groupid'];
		$db->query("delete from ".dbprefix."group_cates_index where groupid='$groupid' and cateid='$cateid'");
		
		if($cateid > 0){
			
			//更新分类下板块数
			$groupnum = $db->once_num_rows("select * from ".dbprefix."group_cates_index where cateid='$cateid'");
			
			$db->query("update ".dbprefix."group_cates set `count_group`='$groupnum',`uptime`='$uptime' where cateid='$cateid'");
			
			
			//判断是否有顶级分类
			$strCate = $db->once_fetch_assoc("select catereferid from ".dbprefix."group_cates where cateid='$cateid'");
			$catereferid = $strCate['catereferid'];
			
			if($catereferid > 0){
				//统计顶级分类下板块数
				$grouptotal = $db->once_fetch_assoc("select sum(`count_group`) as `total` from ".dbprefix."group_cates where catereferid='$catereferid'");
				
				$total = $grouptotal['total'];
				
				$db->query("update ".dbprefix."group_cates set `count_group`='$total',`uptime`='$uptime' where cateid='$catereferid'");
			}
		}
		
		echo '0';
		break;
			
	//计算话题中是否有图片
	case "isphoto":
		$arrTopic = $db->fetch_all_assoc("select * from ".dbprefix."group_topics");
		foreach($arrTopic as $item){
			$content = $item['content'];
			$topicid = $item['topicid'];
			preg_match_all('/\[(photo)=(\d+)\]/is', $content, $photo);
			if($photo[2]){
				$db->query("update ".dbprefix."group_topics set `isphoto`='1' where topicid='$topicid'");
				echo '==OK==';
			}
		}
		break;
	
	case 'parseurl':
		function formPost($url,$post_data){
		  $o='';
		  foreach ($post_data as $k=>$v){
			  $o.= "$k=".urlencode($v)."&";
		  }
		  $post_data=substr($o,0,-1);
		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		  curl_setopt($ch, CURLOPT_POST, 1);
		  curl_setopt($ch, CURLOPT_HEADER, 0);
		  curl_setopt($ch, CURLOPT_URL,$url);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		  $result = curl_exec($ch);
		  return $result;
		}

		$url = $_POST['parseurl'];
		$urlArr = parse_url($url);
		$domainArr = explode('.',$urlArr['host']);
		$data['type'] = $domainArr[count($domainArr)-2];
		$str = formPost('http://share.pengyou.com/index.php?mod=usershare&act=geturlinfo',array('url'=>$url));
		echo $str;
	
		break;
		
	//移动话题
	case "topic_move":
		$groupid = $_POST['groupid'];
		$topicid = $_POST['topicid'];
		
		$db->query("update ".dbprefix."group_topics set `groupid`='$groupid' where topicid='$topicid'");
		
		header("Location: ".SITE_URL."index.php?app=group&ac=topic&topicid=".$topicid);
		
		break;
		
	//设为精华 
	case "isposts":
		//用户是否登录
		$userid = intval($TS_USER['user']['userid']);
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$topicid = intval($_GET['topicid']);
		
		if($userid == 0 || $topicid == 0) qiMsg("非法操作"); 
		
		if($userid <> 1) qiMsg("管理员已经禁止普通用户设精华"); 
		
		$strTopic = $db->once_fetch_assoc("select userid,groupid,title,isposts from ".dbprefix."group_topics where topicid='$topicid'");
		
		$strGroup = $db->once_fetch_assoc("select userid from ".dbprefix."group where groupid='".$strTopic['groupid']."'");
		
		if($userid == $strGroup['userid'] || intval($TS_USER['user']['isadmin']) == 1){
			if($strTopic['isposts']==0){
				$db->query("update ".dbprefix."group_topics set `isposts`='1' where `topicid`='$topicid'");
				
				//msg start
				$msg_userid = '0';
				$msg_touserid = $strTopic['userid'];
				$msg_content = '恭喜，你的话题：《'.$strTopic['title'].'》被评为精华帖啦^_^ <br />'.SITE_URL.'index.php?app=group&ac=topic&topicid='.$topicid;
				aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
				//msg end
				
			}else{
				$db->query("update ".dbprefix."group_topics set `isposts`='0' where `topicid`='$topicid'");
			}
			
			qiMsg("操作成功！");
		}else{
			qiMsg("非法操作！");
		}
		
		break;
		
}
