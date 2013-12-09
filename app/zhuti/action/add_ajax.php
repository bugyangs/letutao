<?php 
defined('IN_TS') or die('Access Denied.');
switch($ts){
	case "upfileimg":
		if(!isset($_FILES['picfile']) || empty($_FILES['picfile'])) qiMsg("请上传选择文件！");
		$userid = intval($TS_USER['user']['userid']);
		if($userid == '0') qiMsg("非法操作！");
		$themeid = trim($_POST['themeid']);
		$titlecolor = h($_POST['titlecolor']);
		$desccolor = h($_POST['desccolor']);
		$backcolor = h($_POST['backcolor']);
		$strTheme = $db->once_fetch_assoc("select * from ".dbprefix."theme where themeid='$themeid'");
		
		if($userid ==$strTheme['userid'] || $TS_USER['user']['isadmin']==1){
		
		if(strlen($titlecolor)>7 || strlen($backcolor)>7){
		 qiMsg("当前颜色支持16进制..");
		 exit();
		}

		
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
			$img_info = getimagesize($f['tmp_name']);
			$imgheigt =  $img_info[1];
			$imgwith =  $img_info[0];
			if($imgheigt<250 || $imgwith<800){	
			qiMsg("建议图片大小为960X270，不然会很难看...");
			exit();
			}
			$uptime = time();
			$fold = date('Ymd',$uptime);
			$random = random(14);
			$dir = "cache/thumb/theme/".$fold;
			!is_dir($dir)?mkdir($dir,0777):'';
			$dest="cache/thumb/theme/".$fold."/".$random."w960.jpg";
			move_uploaded_file($f['tmp_name'],mb_convert_encoding($dest,"gb2312","UTF-8"));
			mkdir($dest, 0777);
		}
		$background = $dest?$dest:'';
			//更新数据
			if($background){
			$db->query("update ".dbprefix."theme set `background`='$background',`titlecolor`='$titlecolor',`desccolor`='$desccolor',`backcolor`='$backcolor' where themeid='$themeid'");
			}else{
				$db->query("update ".dbprefix."theme set `titlecolor`='$titlecolor',`desccolor`='$desccolor',`backcolor`='$backcolor' where themeid='$themeid'");
			}
			 qiMsg("设置主题风格成功！");
		}else{
		 qiMsg("您无上传权限..");
		 exit();
		}
		break;
		
	case "del":
		$userid = intval($TS_USER['user']['userid']);
		if($userid == '0') qiMsg("非法操作！");
		$themeid = isset($_GET['themeid'])?intval($_GET['themeid']):'';
		$strTheme = $db->once_fetch_assoc("select * from ".dbprefix."theme where themeid='".$themeid."'");
		$themeuserid = intval($strTheme['userid']);
		
		if($userid==$themeuserid||$userid==1){
		$isdel = $db->query("DELETE FROM ".dbprefix."theme WHERE themeid	=".$themeid);
		 qiMsg("删除主题成功..",'<a href="'.SITE_URL.'index.php?app=zhuti">返回主题街</a>');
		 }else{
			qiMsg("您无权删除该主题..",'<a href="'.SITE_URL.'index.php?app=zhuti">返回主题街</a>');
		 exit(); 
		 }
	break;
		
	case "add":
		$userid = intval($TS_USER['user']['userid']);
		
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$title = trim($_POST['title']);
		$keywords = trim($_POST['keywords']);
		$desc = trim($_POST['desc']);
		$cate = trim($_POST['cate']);
		
		//$tagsid = $new['tag']->addTag($objname,$idname,$objid,$tags);
		if(strlen($title)<2)
		{
						qiMsg('不别忘了填写主题名...^_^');
		}
		
	
	$strtag = h($keywords);
	$db->query("insert into ".dbprefix."theme (`title`,`desc`,`cate`,`userid`,`goodsnum`,`strtag`,`background`,`addtime`,`uptime`) VALUES ('$title','$desc',$cate,'$userid','0','$strtag','','".time()."','".time()."')");
	$themeid = mysql_insert_id($db->conn);
	//$systemscore = $TS_SITE['base']['TaobaoCNum'];
	//$db->query("update ".dbprefix."user_info set `count_score`=count_score-".$systemscore." where userid='".$userid."'");
	
	
			//feed开始

			//feed结束
	
	
	
	header("Location: ".SITE_URL.tsurl('zhuti'.$themeid));
	
	
		break;
		
		case "update":
		
		$userid = intval($TS_USER['user']['userid']);
		
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$themeId = trim($_POST['themeId']);
		$title = trim($_POST['title']);
		$keywords = trim($_POST['keywords']);
		$desc = trim($_POST['desc']);
		
		//$tagsid = $new['tag']->addTag($objname,$idname,$objid,$tags);
		if(strlen($title)<2)
		{
						$json['status'] = 0;
						$json['msg'] = "别忘了填写主题名...";
						outputJson($json);
						exit();
		}
		
		
		if(empty($keywords))
		{
						$json['status'] = 0;
						$json['msg'] = "至少要填一个关键词吧...";
						outputJson($json);
						exit();
		}
		
				if(strlen($desc)<2)
		{
						$json['status'] = 0;
						$json['msg'] = "别忘了填写描述...";
						outputJson($json);
						exit();
		}
		
	
	$strtag = h($keywords);
	
	
	$db->query("update ".dbprefix."theme set `title`='$title',`desc`='$desc',`strtag`='$strtag' where themeid='$themeId'");
	
	$json['status'] = 1;
	$json['themeid'] = $themeId;
	outputJson($json);
	
	
	break;
	
	
	case "editStyle":
	
	$json['code'] = 100;
	outputJson($json);
	
    break;
}