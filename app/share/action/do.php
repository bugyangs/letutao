<?php
defined('IN_TS') or die('Access Denied.');

//用户是否登录
$userid = intval($TS_USER['user']['userid']);
switch ($le) {
	
	case "add_good":
	
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		
		if($goodsid=aac('share')->add_good($_POST,$userid)){
				$json['code'] = 100;
				$json['themeid'] = $themeid;
				$json['backurl'] = tsurl('baobei',$goodsid);
		}
		else{
				$json['status'] = 0;
				$json['msg'] = "发布失败";
		}
		outputJson($json);
		
	break;
	
	
	
	
	
	case "addToTopic":
	
	if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
	
	$title = trim($_POST['topicName']);
	
	$productId = intval($_POST['productId']);

	$topicId = intval($_POST['topicIds']);
	
	$userComment = trim($_POST['userComment']);
	
	$cate = trim($_POST['cate']);
	
	if($title){
		
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		
		//$tagsid = $new['tag']->addTag($objname,$idname,$objid,$tags);
		if(strlen($title)<2)
		{
						qiMsg('不别忘了填写主题名...^_^');
		}
		
	
	$strtag = h($keywords);
	
	$simgurl =  aac('zhuti')->themesimg($productId);
	
	//同步创建主题话题
			$arrData = array(
				'typeid'	=> '1',
				'userid'	=> $userid,
				'title'		=> $title,
				'content'	=> $userComment?$userComment:$title,
				'addtime'	=> time(),
				'uptime'	=> time(),
			);
	$topicids = $db->insertArr($arrData,dbprefix.'group_topics');
	
	
	$db->query("insert into ".dbprefix."theme (`topicid`,`title`,`desc`,`cate`,`strgoodid`,`userid`,`goodsnum`,`strtag`,`addtime`,`uptime`) VALUES ('$topicids','$title','$userComment','$cate','$productId','$userid','0','$strtag','".time()."','".time()."')");
	$themeid = mysql_insert_id($db->conn);
	
	//feed开始
	$feed_template = '<a href="{link}" title="{title}"><img src="{img}" width="120" alt="{title}" title="{title}"></a></div><div class="pro-info"><h3 class="ofh"><a href="{link}" target="_blank">{title}</a></h3><p class="pro-intro">{content}</p><div class="friend-comment-list">';

	$feed_data = array(
		'link'	=>  tsurl('zhuti'.$themeid),
		'title'	=> $title,
		'ctyle' => '创建了主题',
		'themeid' => $themeid,
		'img'	=> $simgurl,
		'content'	=> getsubstrutf8(t($userComment),'0','50'),
	);
	aac('feed')->addFeed($userid,$feed_template,serialize($feed_data),'zhuti',$themeid);
	//feed结束
	
	
	//$systemscore = $TS_SITE['base']['TaobaoCNum'];
	//$db->query("update ".dbprefix."user_info set `count_score`=count_score-".$systemscore." where userid='".$userid."'");
	
		$json['topicId'] = $themeid;
		$json['url'] = SITE_URL.tsurl('zhuti'.$themeid);
		$json['code'] = 100;
		outputJson($json);
	}elseif($topicId){
		
		$tData = $db->once_fetch_assoc("select strgoodid,simg from ".dbprefix."theme where themeid='".$topicId."'");

		$strid = $tData['strgoodid']?$tData['strgoodid'].','.$productId:$productId;
		
		if(!$tData['simg']){

			$simgurl = aac('zhuti')->themesimg($productId);
			$db->query("update ".dbprefix."theme set `simg`='$simgurl' where themeid='".$topicId."'");
			
		}

		$arr = explode(',',$tData['strgoodid']);
		if(!in_array($productId,$arr)){
		$db->query("update ".dbprefix."theme set `strgoodid`='$strid',uptime='".time()."' where themeid='$topicId'");
		}
		//评论
	if($userComment){
	$arrData	= array(
					'shareid'			=> $productId,
					'userid'			=> $userid,
					'content'	        => t($userComment),
					'commentType'		=> '0',
					'addtime'		    => time(),
				);
	$strShare =  $db->once_fetch_assoc("select * from ".dbprefix."share_goods where goods_id='$productId'");
	
	$commentid = $db->insertArr($arrData,dbprefix.'share_goods_comments');
	
	$count_comment = $db->once_num_rows("select * from ".dbprefix."share_goods_comments where shareid='$productId'");
				
	$uptime = time();
			
	$db->query("update ".dbprefix."share_goods set uptime='$uptime',count_comment='$count_comment' where goods_id='$productId'");
	}
	//评论结束
		$json['url'] = SITE_URL.tsurl('zhuti'.$topicId);
		$json['code'] = 100;
		outputJson($json);
	}
	
	
	
	
	
	break;
	
	//收藏getJSON
	case "getzhutiJSON":
	
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}

		foreach($LE_APPone as $key=>$item){

		$catestr.= '{"name":"'.$item.'"},';
	}
	$arrtheme = $db->fetch_all_assoc("select themeid,title from ".dbprefix."theme where userid=".$userid." order by addtime desc limit 0,36");
	
	foreach($arrtheme as $key=>$item){
		
		$themeidstr.= '{"themeid":'.$item['themeid'].',"title":"'.$item['title'].'"},';
	}
	
	$catestr = substr($catestr, 0, -1);
	
	$themeidstr = substr($themeidstr, 0, -1);
	
	$code = empty($arrtheme)?'110':'100';
	
	echo '{"galleryList":['.$catestr.'],"userTopics":['.$themeidstr.'],"code":'.$code.'}';
	
	break;
	
	
	//回复主题话题
	case "SideCmt":
	
	
	if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		
		if($userid == 0){
			$json['code'] = 200;
			outputJson($json);
			exit;
		}
		$topicid= intval($_POST['topicid']);
		$content = trim($_POST['content']);
		$referid = 0;
		$addtime = time();
		
		if($topicid == 0){
			$json['code'] = 101;
			$json['msg'] = '该主题未关联讨论板块';
			outputJson($json);
			exit;
		}
		
		if(empty($content)){
			$json['code'] = 201;
			outputJson($json);
			exit;
		}
		
		//限制发帖速度
		$str_limit_time = $db->once_fetch_assoc("select addtime from ".dbprefix."group_topics_comments where topicid='$topicid' and userid='$userid' order by addtime desc");
		
		if($addtime-$str_limit_time['addtime']<3){
			
			$json['code'] = 441;
			outputJson($json);
			exit;
			
		}
		

		$db->query("insert into ".dbprefix."group_topics_comments (`referid`,`topicid`,`userid`,`content`,`addtime`) values ('$referid','$topicid','$userid','$content','$addtime')");
		
		
		//统计评论数
		$count_comment = $db->once_num_rows("select * from ".dbprefix."group_topics_comments where topicid='$topicid'");
		
		//更新话题最后回应时间和评论数
		$uptime = time();
		
		$db->query("update ".dbprefix."group_topics set uptime='$uptime',count_comment='$count_comment' where topicid='$topicid'");
		$struser = $db->once_fetch_assoc("select darenid from ".dbprefix."user_info where userid='$userid'");
		
		
		//feed开始
					$strTopic = $db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid='$topicid'");
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
			aac('feed')->addFeed($userid,$feed_template,serialize($feed_data),$feedtype,$topicid);
		
		//feed结束
		
		
		$json['code'] = 100;
		$json['reply'] = array('content'=>$content,'showTime'=>date('m-d H:i',time()));
		$json['userLevel'] = $struser['darenid']?"daren":"";
		outputJson($json);
	
	break;
	
	
	
	//创建主题
	case "add_zhuti":
	
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}

		$title = trim($_POST['title']);
		$keywords = trim($_POST['keywords']);
		$desc = $_POST['desc'];
		$cate = trim($_POST['cate'])?trim($_POST['cate']):'其他';
		
		//$tagsid = $new['tag']->addTag($objname,$idname,$objid,$tags);
		if(strlen($title)<2)
		{
						qiMsg('不别忘了填写主题名...^_^');
		}
		
	
	$strtag = h($keywords);
	
	//同步创建主题话题
			$arrData = array(

				'typeid'	=> '1',
				'userid'	=> $userid,
				'title'		=> $title,
				'content'	=> $desc?$desc:$title,
				'addtime'	=> time(),
				'uptime'	=> time(),
			);
			
	$topicid = $db->insertArr($arrData,dbprefix.'group_topics');
	
	
	$db->query("insert into ".dbprefix."theme (`topicid`,`title`,`desc`,`cate`,`userid`,`goodsnum`,`strtag`,`addtime`,`uptime`) VALUES ('$topicid','$title','$desc','$cate','$userid','0','$strtag','".time()."','".time()."')");
	$themeid = mysql_insert_id($db->conn);
	//$systemscore = $TS_SITE['base']['TaobaoCNum'];
	//$db->query("update ".dbprefix."user_info set `count_score`=count_score-".$systemscore." where userid='".$userid."'");
	
	
			//feed开始
	$feed_template = '<a href="{link}" title="{title}"><img src="{img}" width="120" alt="{title}" title="{title}"></a></div><div class="pro-info"><h3 class="ofh"><a href="{link}" target="_blank">{title}</a></h3><p class="pro-intro">{content}</p><div class="friend-comment-list">';

	$feed_data = array(
		'link'	=>  tsurl('zhuti'.$themeid),
		'title'	=> $title,
		'ctyle' => '创建了主题',
		'themeid' => $themeid,
		'img'	=> 'images/none-z-b.gif',
		'content'	=> getsubstrutf8(t($desc),'0','50'),
	);
	aac('feed')->addFeed($userid,$feed_template,serialize($feed_data),'zhuti',$themeid);
	//feed结束
	
	
	
	
	header("Location: ".SITE_URL.tsurl('zhuti'.$themeid));
	
	
	break;
	
	
	//删除主题
	case "del_zhuti":
	
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		
		if($userid == '0'){
					$json['code'] = 101;
					outputJson($json);
					exit;
		};
		
		$themeid = isset($_POST['themeid'])?intval($_POST['themeid']):'';
		$topicid = isset($_POST['topicid'])?intval($_POST['topicid']):'';
		$strTheme = $db->once_fetch_assoc("select * from ".dbprefix."theme where themeid='".$themeid."'");
		$themeuserid = intval($strTheme['userid']);
		
		if($userid==$themeuserid||$userid==1){
		$isdel = $db->query("DELETE FROM ".dbprefix."theme WHERE themeid	=".$themeid);
		$db->query("DELETE FROM ".dbprefix."group_topics WHERE topicid	=".$topicid);
		unlink($strTheme['simg']);
		unlink($strTheme['headerPhoto']);
		unlink($strTheme['pagePhoto']);
		
		//删除动态
		$db->query("DELETE FROM ".dbprefix."feed WHERE feedtype='zhuti' and connectid=".$themeid);
		
		 
		$json['code'] = 100;
		$json['backurl'] = SITE_URL.tsurl('zhuti'.$themeid);
		outputJson($json);
		exit;
		 
		 
		 
		 }else{
					$json['code'] = 105;
					outputJson($json);
					exit;
		 }
	break;
	
	
	//移除主题
	case "removeGood":
	
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		
		if($userid == '0'){
					$json['code'] = 101;
					outputJson($json);
					exit;
		};
		
		$themeid = isset($_POST['topicId'])?intval($_POST['topicId']):'';
		$goods_id = isset($_POST['tpId'])?intval($_POST['tpId']):'';
		
		$strTheme = $db->once_fetch_assoc("select * from ".dbprefix."theme where themeid='".$themeid."'");
		
		$arr_goods_ids = explode(',',$strTheme['strgoodid']);
		
		foreach($arr_goods_ids as $key=>$item){
			
			if($item<>$goods_id){
				$strgoodid .= $item.',';
			}
		
		}	
		$strgoodid = substr($strgoodid,0,-1);

		unlink($strTheme['simg']);
		$db->query("update ".dbprefix."theme set `strgoodid`='$strgoodid', `simg`='' where themeid='$themeid'");

		$json['code'] = 100;
		outputJson($json);

		
	break;
	
	
	//编辑主题
	case "edit_zhuti":
	
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$themeid	  = intval($_POST['themeid']);
		$title	      = trim($_POST['title']);
		$keywords     = trim($_POST['keywords']);
		$desc	      = $_POST['desc'];
		$cate	      = trim($_POST['cate']);
		
		//$tagsid = $new['tag']->addTag($objname,$idname,$objid,$tags);
		if(strlen($title)<2)
		{
						qiMsg('不别忘了填写主题名...^_^');
		}
		
	
	$strtag = h($keywords);
	$db->query("update ".dbprefix."theme set `title`='$title', `desc`='$desc',`cate`='$cate',`strtag`='$keywords',`strtag`='$strtag' where themeid='$themeid'");

	//同步修改主题讨论
	$strTheme = $db->once_fetch_assoc("select topicid from ".dbprefix."theme where themeid='".$themeid."'");
	$db->query("update ".dbprefix."group_topics set `title`='$title', `content`='$desc' where topicid='".$strTheme['topicid']."'");
	
	
	
	header("Location: ".SITE_URL.tsurl('zhuti'.$themeid));
	
	
	break;
	
	
	
	
	
	case "add_pic":
	
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}

		$catename	 = $_POST['catename'];
		$strcate	 = $db->once_fetch_assoc("select * from ".dbprefix."goods_cate where cate_name LIKE '%".$catename."%'");
		$pprice		 = str_replace('￥','',trim($_POST['price']));
		$oldimg	     = trim($_POST['img_url']);
		$name	     = trim($_POST['content']);
		$price	     = intval($pprice);
		$taoke_url	 = trim($_POST['taoke_url']);
		$url         = trim($_POST['taoke_url']);
		$content	 = trim($_POST['content']);
		$tags        = trim($_POST['tags']);
		$cate_id     = intval($strcate['cate_id']);
		$comment     = trim($_POST['content']);
		$islike      = trim($_POST['tomyfav']);
		
		/*
		$Num = $db->once_num_rows("select * from ".dbprefix."share_goods where url ='$url' and uid =".$userid);
			if($Num){
			qiMsg("您已经分享过该商品啦！");
			exit();
			}
		*/
		if(empty($comment))
		{

						qiMsg("别忘了填写评论...");
		}
		
		
		$uptime = time();
		$fold = date('Ymd',$uptime);
		
		$random = random(14);
		$dir = "cache/thumb/index/".$fold;
		!is_dir($dir)?mkdir($dir,0777):'';
		$imgurl="cache/thumb/index/".$fold."/".$random."w210.jpg";
		$oldimg = str_replace('_100x100.jpg','',$oldimg);
		require_once 'letutao/class.image.php';
		$resizeimage = new tsImg( "$oldimg", "210", "", "0", "$imgurl" );
		$img = $imgurl;
			$arrData = array(
				'uid'				=> intval($userid),
				'themeid'			=> intval($themeid),
				'img'				=> $img,
				'oldimg'			=> $oldimg,
				'name'	            => $name,
				'price'				=> intval($price),
				'taoke_url'		    => $taoke_url,
				'url'		        => $url,
				'cate_id'		    => intval($cate_id),
				'comment'		    => $comment,
				'uptime'		    => time(),
			);
	$goodsid = $db->insertArr($arrData,dbprefix.'share_goods');
	$tags=str_replace(',',' ',$tags);
	$tags=str_replace('，',' ',$tags);
	$tags=str_replace(' ',' ',$tags);
	aac('sharetag')->addTag('share','goods_id',$goodsid,$tags);
	aac('sharetag')->addTag('default','goods_id',$goodsid,$tags);
	
			//更新积分
	$db->query("update ".dbprefix."user_info set `count_score`=count_score+2 where userid='$userid'");
	
	//feed开始
	$feed_template = '<a href="{link}" title="{title}"><img src="{img}" width="120" alt="{title}" title="{title}"></a></div><div class="pro-info"><h3 class="ofh"><a href="{link}" target="_blank">{title}</a></h3><p class="pro-intro">{content}</p><div class="friend-comment-list">';

	$feed_data = array(
		'link'	=>  tsurl('baobei',$goodsid),
		'title'	=> $name,
		'ctyle' => '发布了图片',
		'goods_id' => $goods_id,
		'img'	=> $img,
		'content'	=> getsubstrutf8(t($comment),'0','50'),
	);
	aac('feed')->addFeed($userid,$feed_template,serialize($feed_data),'goods',$goodsid);
	//feed结束
	
	//更新喜欢
if($islike){
	$db->query("insert into ".dbprefix."share_goods_like (`userid`,`goods_id`,`commentType`,`addtime`) values ('".$userid."','".$goodsid."','0','".time()."')");
	$db->query("update ".dbprefix."share_goods set count_like=count_like+1 where goods_id='$goodsid'");
}
			if($goodsid){
			qiMsg("恭喜，发布图片成功");
	}
	else{
			qiMsg("Sorry，发布失败");
	}
	break;
	
	case "del_ilike":
	

		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$goodsid	    = intval(trim($_POST['goodsId']));
		
		$arrLike = $db->fetch_all_assoc("select userid from ".dbprefix."share_goods_like where `goods_id`='".$goodsid."'");
		
		foreach($arrLike as $item){
			$str .=$item['userid']."',";
		}
		
		$str_arr = explode(',',$str);
		if(!in_array($userid,$str_arr)) {
			$json['code'] = 101;
			$json['msg'] = '您无权取消该喜欢';
			outputJson($json);
		}
				//删除喜欢
		$db->query("DELETE FROM ".dbprefix."share_goods_like WHERE goods_id = '".$goodsid."'");
		$db->query("update ".dbprefix."share_goods set count_like=count_like-1 where goods_id='$goodsid'");
			$json['code'] = 100;
			outputJson($json);
	
	break;
	
	case "del_good":
	

		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$goodsid	    = intval(trim($_POST['goodsId']));
		$strgoods       = $db->once_fetch_assoc("select themeid,uid,img,bigpic FROM ".dbprefix."share_goods WHERE goods_id	=".$goodsid);
		
		if($userid<>1&&$userid<>$strgoods['uid']){
			
			$json['code'] = 101;
			$json['msg'] = "无权删除该商品";
			outputJson($json);	
			
		}
		
		$isdel = $db->query("DELETE FROM ".dbprefix."share_goods WHERE goods_id	=".$goodsid);
		
		//删除评论回复
		$db->query("DELETE FROM ".dbprefix."share_goods_comments WHERE shareid = '".$goodsid."'");
		
		//删除动态
		$db->query("DELETE FROM ".dbprefix."feed WHERE feedtype='goods' and connectid=".$goodsid);
		
		//删除喜欢
		$db->query("DELETE FROM ".dbprefix."share_goods_like WHERE goods_id = '".$goodsid."'");
		
		//删除tag索引
		//$db->query("DELETE FROM ".dbprefix."tag_topic_index WHERE topicid = '".$topicid."'");
		
		//更新积分
		if($userid==1){
		$db->query("update ".dbprefix."user_info set `count_score`=count_score-4 where userid='$userid'");
		}else{
		$db->query("update ".dbprefix."user_info set `count_score`=count_score-2 where userid='$userid'");	
		}
		//统计 
		if($strgoods['themeid']){
		$db->query("update ".dbprefix."theme set `goodsnum`=goodsnum-1 where themeid='".$strgoods['themeid']."'");
		}
		
	unlink($strgoods['img']);//删除缩略图
	if($DISK_YUN['isopen']) aac('system')->DiskYun_baidu_delete($strgoods['img']);
	
	if(strlen($strgoods['bigpic'])>10){
		unlink($strgoods['bigpic']); //删除本地化大图
		if($DISK_YUN['isopen']) aac('system')->DiskYun_baidu_delete($strgoods['bigpic']);
	}
	
	
	if($isdel){
			
			$json['code'] = 100;
			outputJson($json);
	}
	else{
			$json['code'] = 101;
			$json['msg'] = "删除失败";
			outputJson($json);
	}
	
	break;
	
	
	case "top_good":
	

		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		if($userid!==1){
			$json['code'] = 101;
			$json['msg'] = "已关闭个人置顶";
			outputJson($json);
			exit();
	}
		
		$goods_id	    = intval(trim($_POST['goodsId']));
		
		$datatype	    = intval(trim($_POST['datatype']));
		
		$istop     = $db->query("update ".dbprefix."share_goods set istop='$datatype' where goods_id='$goods_id'");

	if($istop){
			$json['code'] = 100;
			$json['html'] = $datatype==1?"取消置顶":"置顶";
			$json['datatype'] = $datatype==1?"0":"1";
			$json['msg'] = $datatype==1?"置顶成功":"取消置顶成功";
	}
	else{
			$json['code'] = 101;
			$json['msg'] = "置顶失败";
	}
	
	outputJson($json);
	break;
	
	
	case "top_theme":
	

		
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		if($userid!==1){
			$json['code'] = 101;
			$json['msg'] = "已关闭个人置顶";
			outputJson($json);
			exit();
	}
		
		$themeId	    = intval(trim($_POST['themeId']));
		
		$datatype	    = intval(trim($_POST['datatype']));
		
		$istop     = $db->query("update ".dbprefix."theme set istop='$datatype' where themeid='$themeId'");
		

	if($istop){
			$json['code'] = 100;
			$json['html'] = $datatype==1?"取消置顶":"置顶";
			$json['datatype'] = $datatype==1?"0":"1";
			$json['msg'] = $datatype==1?"已置顶":"已取消置顶";
	}
	else{
			$json['code'] = 101;
			$json['msg'] = "操作失败";
	}
	outputJson($json);
	break;
	
	
	case "Recom_theme":
	

		
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		if($userid!==1){
			$json['code'] = 101;
			$json['msg'] = "已关闭个人推荐";
			outputJson($json);
			exit();
	}
		
		$themeId	    = intval(trim($_POST['themeId']));
		
		$datatype	    = intval(trim($_POST['datatype']));
		
		$isrecom     = $db->query("update ".dbprefix."theme set recom='$datatype' where themeid='$themeId'");
		

	if($isrecom){
			$json['code'] = 100;
			$json['html'] = $datatype==1?"取消推荐":"推荐";
			$json['datatype'] = $datatype==1?"0":"1";
			$json['msg'] = $datatype==1?"已推荐":"已取消推荐";
	}
	else{
			$json['code'] = 101;
			$json['msg'] = "操作失败";
	}
	outputJson($json);
	break;
	
	
	case "comment":
	

		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$goods_id      		= intval(trim($_POST['productId']))?intval(trim($_POST['productId'])):intval(trim($_POST['id']));
		$commentContent     = trim($_POST['commentContent'])?trim($_POST['commentContent']):trim($_POST['comment']);
		$commentType    = intval(trim($_POST['commentType']))?intval(trim($_POST['commentType'])):'1';
		$referid        = intval(trim($_POST['referid']))?intval(trim($_POST['referid'])):'0';
		$andlike        = intval(trim($_POST['andlike']))?intval(trim($_POST['andlike'])):intval(trim($_POST['favor']));
		$referid?$commentType=10:$commentType=$commentType;
		$arrData	= array(
					'shareid'			=> $goods_id,
					'userid'			=> $userid,
					'content'	        => t($commentContent),
					'commentType'		=> $commentType,
					'referid'			=>  $referid,
					'addtime'		    => time(),
				);
	$strShare =  $db->once_fetch_assoc("select * from ".dbprefix."share_goods where goods_id='$goods_id'");
	
	$commentid = $db->insertArr($arrData,dbprefix.'share_goods_comments');
	
	$count_comment = $db->once_num_rows("select * from ".dbprefix."share_goods_comments where shareid='$goods_id'");
				
	$uptime = time();
			
	$db->query("update ".dbprefix."share_goods set uptime='$uptime',count_comment='$count_comment' where goods_id='$goods_id'");
	
			
		if($commentType=='2'){
			
		//$db->query("update ".dbprefix."user_info set `count_score`=count_score-1 where userid='".$strShare['uid']."'");
		
		}else{
			
		//$db->query("update ".dbprefix."user_info set `count_score`=count_score+1 where userid='".$strShare['uid']."'");
			
		}
		if($andlike){
			
		
		$likeNum = $db->once_num_rows("select * from ".dbprefix."share_goods_like where userid='$userid' and goods_id='$goods_id' and commentType = '$commentType' ");
		
		
	if($userid == $strShare['uid'])
	{}elseif($likeNum > 0){}else{
			$db->query("insert into ".dbprefix."share_goods_like (`userid`,`goods_id`,`commentType`,`addtime`) values ('".$userid."','".$goods_id."','0','".time()."')");
			$db->query("update ".dbprefix."share_goods set count_like=count_like+1 where goods_id='$goods_id'");
			
			//feed开始
	$feed_template = '<a href="{link}" title="{title}"><img src="{img}" width="120" alt="{title}" title="{title}"></a></div><div class="pro-info"><h3 class="ofh"><a href="{link}" target="_blank">{title}</a></h3><p class="pro-intro">{content}</p><div class="friend-comment-list">';
	

	$ctyle = "喜欢了它";

	$feed_data = array(
				'link'	=>  tsurl('baobei',$goods_id),
				'title'	=> $strShare['name'],
				'ctyle' => $ctyle,
				'goods_id' => $goods_id,
				'img'	=> $strShare['img'],
				'content'	=> getsubstrutf8(t($strShare['comment']),'0','80'),
	);
	aac('feed')->addFeed($userid,$feed_template,serialize($feed_data),'goods',$goods_id);
	//feed结束
	
	
	}
			
			
		}
		
		
	if($commentid)
	{	
	
			if($strShare['uid'] <> $TS_USER['user']['userid']){
			$msg_userid = '0';
			$msg_touserid = $strShare['uid'];
			$msg_content = '你发布的宝贝：《'.$strShare['name'].'》新增一条评论，快去看看吧^_^ <br />'.SITE_URL.tsurl('baobei',$goods_id);
			aac('message')->sendmsg($msg_userid,$msg_touserid,$msg_content);
		}
	
			$json['backurl'] = tsurl('baobei',$goods_id);
			$json['code'] = 100;
	}else{
			$json['code'] = 101;
			$json['msg'] = "评论失败！'";
	}
	outputJson($json);
	break;
	
	case "like":
	

		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$goods_id      		= intval(trim($_POST['productId']));
		$commentType        = intval(trim($_POST['commentType']));
		
		$strShare = $db->once_fetch_assoc("select * from ".dbprefix."share_goods where goods_id='".$goods_id."'");
		
		$likeNum = $db->once_num_rows("select * from ".dbprefix."share_goods_like where userid='$userid' and goods_id='$goods_id' and commentType = '$commentType' ");
		
		
	if($userid == $strShare['uid'])
	{
			$json['code'] = 101;
			$json['msg'] = "你分享的你一定喜欢^_^'";
	}
	elseif($likeNum > 0){
			$json['code'] = 103;
			$json['desirable'] = 0;
	}else{
			$json['code'] = 100;
			$db->query("insert into ".dbprefix."share_goods_like (`userid`,`goods_id`,`commentType`,`addtime`) values ('".$userid."','".$goods_id."','".$commentType."','".time()."')");
			$db->query("update ".dbprefix."share_goods set count_like=count_like+1 where goods_id='$goods_id'");
			
			//feed开始
	$feed_template = '<a href="{link}" title="{title}"><img src="{img}" width="120" alt="{title}" title="{title}"></a></div><div class="pro-info"><h3 class="ofh"><a href="{link}" target="_blank">{title}</a></h3><p class="pro-intro">{content}</p><div class="friend-comment-list">';
	
	if($commentType=='0'){
			$ctyle = "喜欢了它"; 
			}elseif($commentType=='1'){
			$ctyle = "认为值得"; 
			}elseif($commentType=='2'){
			$ctyle = "认为不值得"; 
			}else{
			$ctyle = '';
			}

	$feed_data = array(
				'link'	=>  tsurl('baobei',$goods_id),
				'title'	=> $strShare['name'],
				'ctyle' => $ctyle,
				'goods_id' => $goods_id,
				'img'	=> $strShare['img'],
				'content'	=> getsubstrutf8(t($strShare['comment']),'0','80'),
	);
	aac('feed')->addFeed($userid,$feed_template,serialize($feed_data),'goods',$goods_id);
	//feed结束
	}
	
	
	outputJson($json);
	break;
	
	
	case "like-s":
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$postid      		= intval(trim($_POST['postid']));
		$commentType        = trim($_POST['commentType']);
	if($commentType=='g'){
		$groupid=$postid;
		
		$strgroup = aac('group')->getOneGroup($groupid);
		
		$groupUserNum = $db->once_num_rows("select * from ".dbprefix."group_users where userid='$userid' and groupid='$groupid'");

			
			if(intval($groupUserNum)==0){
			$db->query("INSERT INTO ".dbprefix."group_users (`userid`,`groupid`,`addtime`) VALUES ('".$userid."','".$groupid."','".time()."')");
			
			//计算板块会员数
			$UserNum = $db->once_num_rows("select * from ".dbprefix."group_users where groupid='$groupid'");
			//更新板块成员统计
			$db->query("update ".dbprefix."group set `count_user`='$UserNum' where groupid='$groupid'");
			
			
			//feed开始
	
			//feed结束
			
			}
		
		
		
		
	$json['code'] = $groupUserNum>0?101:100;
	$json['msg'] = $groupUserNum>0?"您已经喜欢过了":"喜欢了";
	outputJson($json);
	exit;
		
		
		
		
	}else{
	
		$themeid=$postid;
		
		$strTheme = $db->once_fetch_assoc("select * from ".dbprefix."theme where themeid='".$themeid."'");
		
		$likeNum = $db->once_num_rows("select * from ".dbprefix."share_theme_like where userid='$userid' and themeid='$themeid'");

			
			if(intval($likeNum)==0){
			$db->query("insert into ".dbprefix."share_theme_like (`userid`,`themeid`,`addtime`) values ('".$userid."','".$themeid."','".time()."')");
			$db->query("update ".dbprefix."theme set likenum=likenum+1 where themeid='$themeid'");
			
	//feed开始
	$feed_template = '<a href="{link}" title="{title}"><img src="{img}" width="120" alt="{title}" title="{title}"></a></div><div class="pro-info"><h3 class="ofh"><a href="{link}" target="_blank">{title}</a></h3><p class="pro-intro">{content}</p><div class="friend-comment-list">';

	$feed_data = array(
		'link'	=>  tsurl('zhuti'.$themeid),
		'title'	=> $strTheme['title'],
		'ctyle' => '喜欢了主题',
		'themeid' => $themeid,
		'img'	=> $strTheme['simg'],
		'content'	=> getsubstrutf8(t($strTheme['desc']),'0','50'),
	);
	aac('feed')->addFeed($userid,$feed_template,serialize($feed_data),'zhuti',$themeid);
	//feed结束
			}
			
	$json['code'] = $likeNum>0?101:100;
	$json['msg'] = $likeNum>0?"您已经喜欢过了":"喜欢了";
	outputJson($json);
	exit;
}

	$json['code'] = 101;
	$json['msg'] = "未知错误！";
	outputJson($json);
	
	break;
	
	
	
	case "del_themegoods":
	
	if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
	$goodsid	    = intval(trim($_POST['goodsId']));
	$themeid	    = intval(trim($_POST['themeid']));
	$strTheme = $db->once_fetch_assoc("select * from ".dbprefix."theme where themeid='".$themeid."'");
	
	$arrgoods = explode(',',$strTheme['strgoodid']);
	
	foreach($arrgoods as $item){if($item<>$goodsid) $arrgood[] = $item;}
	
	foreach($arrgood as $item){
			$str .=$item.",";
		}
		$slen = strlen($str)-1;
		$strgoodid = substr($str,0,$slen);
	
	$db->query("update ".dbprefix."theme set strgoodid='$strgoodid' where themeid='$themeid'");
	
	$json['code'] = 100;
	$json['msg'] = "";
	outputJson($json);
	
	
	break;
	
	case "UploadtopicImg":
			$uptypes = array( 
			'image/jpg',
			'image/jpeg',
			'image/png',
			'image/pjpeg',
			'image/gif',
			'image/x-png',
		);
		
		if(isset($_FILES['filedata'])){
		
			$f=$_FILES['filedata'];
			
			if(empty($f['name'])){
			
				qiMsg("头像不能为空！");
				
			}elseif ($f['name']){
				if (!in_array($_FILES['filedata']['type'],$uptypes)) {
					qiMsg('你上传的头像图片类型不正确，系统仅支持 jpg,gif,png 格式的图片!');
				}
			} 
			$uptime = time();
			$fold = date('Ymd',$uptime);
			$dest_dir='cache/group/'.$fold;
			createFolders($dest_dir);
			
			//原图
			$fileInfo=pathinfo($f['name']);
			$extension=$fileInfo['extension'];
			$newphotoname = time().'.'.$extension;
			$dest=$dest_dir.'/'.$newphotoname;

			move_uploaded_file($f['tmp_name'],mb_convert_encoding($dest,"gb2312","UTF-8"));
			chmod($dest, 0755);
			$json['code'] = '100';
			$json['imgurl'] = SITE_URL.$dest;
			outputJson($json);
		}else{
			
			$result = '';
		}
	
	echo $result;
	
	
	break;
	
	
	case "UploadImg":
			$uptypes = array( 
			'image/jpg',
			'image/jpeg',
			'image/png',
			'image/pjpeg',
			'image/gif',
			'image/x-png',
		);
		
		$g_f = _get('f')?_get('f'):'uploadShareImg';

		if(isset($_FILES[$g_f])){
		
			$f=$_FILES[$g_f];
			
			if(empty($f['name'])){
			
				qiMsg("头像不能为空！");
				
			}elseif ($f['name']){
				if (!in_array($_FILES[$g_f]['type'],$uptypes)) {
					qiMsg('你上传的头像图片类型不正确，系统仅支持 jpg,gif,png 格式的图片!');
				}
			} 
			$uptime = time();
			$fold = date('Ymd',$uptime);
			$dest_dir='cache/bigpic/'.$fold;
			createFolders($dest_dir);
			
			//原图
			$fileInfo=pathinfo($f['name']);
			$extension=$fileInfo['extension'];
			$newphotoname = time().'.'.$extension;
			$dest=$dest_dir.'/'.$newphotoname;

			move_uploaded_file($f['tmp_name'],mb_convert_encoding($dest,"gb2312","UTF-8"));
			chmod($dest, 0755);
			$result = $dest;
		}else{
			
			$result = '';
		}
	
	echo $result;
	
	
	break;
	
	
		case "UploadTagImg":
			$uptypes = array( 
			'image/jpg',
			'image/jpeg',
			'image/png',
			'image/pjpeg',
			'image/gif',
			'image/x-png',
		);
		
		$g_f = _get('f')?_get('f'):'uploadShareImg';

		if(isset($_FILES[$g_f])){
		
			$f=$_FILES[$g_f];
			
			if(empty($f['name'])){
			
				qiMsg("图片不能为空！");
				
			}elseif ($f['name']){
				if (!in_array($_FILES[$g_f]['type'],$uptypes)) {
					qiMsg('你上传的图片类型不正确，系统仅支持 jpg,gif,png 格式的图片!');
				}
			} 
			$uptime = time();
			$fold = date('Ymd',$uptime);
			$dest_dir='cache/tag/'.$fold;
			createFolders($dest_dir);
			
			//原图
			$fileInfo=pathinfo($f['name']);
			$extension=$fileInfo['extension'];
			$newphotoname = time().'.'.$extension;
			$dest=$dest_dir.'/'.$newphotoname;

			move_uploaded_file($f['tmp_name'],mb_convert_encoding($dest,"gb2312","UTF-8"));
			chmod($dest, 0755);
			$tag_id = explode('_',$g_f);
			$db->query("update ".dbprefix."goods_tags set `img`='".$dest."' where tag_id='".$tag_id[1]."'");
			$result = $dest;
			
		}else{
			
			$result = '';
		}
	
	echo $result;
	
	
	break;
	
	
	break;
	
	case "del_feed":
	
	if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$feedid     		= intval(trim($_POST['feedid']));
	
		$strfeed = $db->once_fetch_assoc("select userid from ".dbprefix."feed where feedid='".$feedid."'");
		//删除动态
		if($userid == $strfeed['userid'] || $userid==1)
	{
		$db->query("DELETE FROM ".dbprefix."feed WHERE feedid = '".$feedid."'");
		$json['code'] = 100;
		
		
	}else{
		$json['code'] = 101;
		$json['msg'] = "您无权删除该动态";
		
	}
	
	outputJson($json);
	
	break;
	
	case "identity":
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$goods_id      		= intval(trim($_POST['productId']));
		$commentType        = intval(trim($_POST['commentType']));
		
		$strShare = $db->once_fetch_assoc("select * from ".dbprefix."share_goods where goods_id='".$goods_id."'");
		
		$identityNum = $db->once_fetch_assoc("select * from ".dbprefix."share_goods_like where  commentType >0 and userid='$userid' and goods_id='$goods_id' ");
		
		
	if($userid == $strShare['uid'])
	{
			$json['code'] = 101;
			$json['msg'] = "你分享的一定值得^_^'";
	}elseif(is_array($identityNum)){
			$json['code'] = 103;
			$json['desirable'] =$identityNum['commentType'];
	}else{
			$json['code'] = 100;
			$db->query("insert into ".dbprefix."share_goods_like (`userid`,`goods_id`,`commentType`,`addtime`) values ('".$userid."','".$goods_id."','".$commentType."','".time()."')");
			if($commentType ==1) $db->query("update ".dbprefix."share_goods set count_worth=count_worth+1 where goods_id='$goods_id'");
			
			//feed开始
	$feed_template = '<a href="{link}" title="{title}"><img src="{img}" width="120" alt="{title}" title="{title}"></a></div><div class="pro-info"><h3 class="ofh"><a href="{link}" target="_blank">{title}</a></h3><p class="pro-intro">{content}</p><div class="friend-comment-list">';

	if($commentType=='0'){
			$ctyle = "喜欢了它"; 
			}elseif($commentType=='1'){
			$ctyle = "鉴定了该宝贝认为：<b>值得</b>"; 
			}elseif($commentType=='2'){
			$ctyle = "鉴定了该宝贝认为：<b>不值得</b>"; 
			}else{
			$ctyle = '';
			}

	$feed_data = array(
				'link'	=>  tsurl('baobei',$goods_id),
				'title'	=> $strShare['name'],
				'ctyle' => $ctyle,
				'goods_id' => $goods_id,
				'img'	=> $strShare['img'],
				'content'	=> getsubstrutf8(t($strShare['comment']),'0','80'),
	);
	aac('feed')->addFeed($userid,$feed_template,serialize($feed_data),'goods',$goods_id);
	//feed结束
			
	}
	outputJson($json);
	break;
	
	
	case "editStyle":
	if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$themeid      		= intval(trim($_POST['topicId']));
		$headerPhoto        = trim($_POST['headerPhoto']);
		$topStyle           = trim($_POST['topStyle']);
		$bgPhoto            = trim($_POST['bgPhoto']);
		$pageStyle          = trim($_POST['pageStyle']);
	
	$db->query("update ".dbprefix."theme set topStyle='$topStyle',pageStyle='$pageStyle',pagePhoto='$bgPhoto',headerPhoto='$headerPhoto' where themeid='$themeid'");
	
		$json['code'] = 100;
		outputJson($json);
	
    break;
	
	
	
		case "upthemefile":
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$userid = intval($TS_USER['user']['userid']);
		
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		
		if(!isset($_FILES['filedata']) || empty($_FILES['filedata'])) qiMsg("请上传选择文件！");
		if($userid == '0') qiMsg("非法操作！");

		$uptypes = array( 
			'image/jpg',
			'image/jpeg',
			'image/png',
			'image/pjpeg',
			'image/gif',
			'image/x-png',
		);
		$pic = $_FILES['filedata'];
		if(isset($pic)){

			$f=$pic;

		if ($f['name']){
				if (!in_array($_FILES['filedata']['type'],$uptypes)) {
					qiMsg("仅支持 jpg,gif,png 格式的图片！");
				}
			}
		}
		$uptime = time();
		$fold = date('Ymd',$uptime);
		$dir = "cache/thumb/theme/".$fold;
		$c = h($_GET['c']);
		!is_dir($dir)?mkdir($dir,0777):'';
		$dest="cache/thumb/theme/".$fold."/".$userid.$c.".jpg";
		move_uploaded_file($f['tmp_name'],mb_convert_encoding($dest,"gb2312","UTF-8"));

		$json['code'] = '100';
		$json['imgurl'] = $dest;
		outputJson($json);
		
		
		break;
		
		
		case "getbaobeidetail":
	
		$goods_id = intval(trim($_POST['goodsid']));
		

			$strgoods = $db->once_fetch_assoc("select goods_id,name,comment,count_comment,count_like,img,price,taoke_url from ".dbprefix."share_goods where goods_id='$goods_id'");
		
		if($strgoods){
		
		$json['code'] = 100;
		
		$json['url'] = SITE_URL.tsurl('baobei',$goods_id);
		
		$json['baobei'] = $strgoods;
		
		$json['baobei']['tags'] = '';
		
		}else{
			
			$json['code'] = 101;
		}
		
		outputJson($json);

   		break;
		
		
		case "feeds_count":
		$nowtime = time();
		$allfeeds = $db->fetch_all_assoc("select * from ".dbprefix."feed where feedtype<>'friend' and $nowtime-addtime<20");
		
		$json['feedsMessageNum'] = count($allfeeds);
		$json['code'] = 100;
		
		outputJson($json);
		
		break;
		
		case "M_count":
		
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$nowtime = time();
		$allfeeds = $db->fetch_all_assoc("select * from ".dbprefix."feed where feedtype<>'friend' and $nowtime-addtime<20");
		
		$allfollows = $db->fetch_all_assoc("select * from ".dbprefix."user_follow where new='1' and userid_follow=$userid");
		
		$allsystems = $db->fetch_all_assoc("select * from ".dbprefix."message where isread='0' and touserid=$userid and userid=0");
		
		//$json['feedsMessageNum'] = count($allfeeds);
		$json['fansMessageNum'] = count($allfollows);
		$json['systemMessageNum'] = count($allsystems);
		$json['fansurl'] = tsurl('user','fans',array('userid'=>$userid));
		$json['systemurl'] = tsurl('message','my');
		$json['code'] = 100;
		
		outputJson($json);
		
		break;
		
		case "cancel_notify":
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$db->query("update ".dbprefix."user_follow set new='0' where userid_follow='$userid'");
		$db->query("update ".dbprefix."message set `isread`='1' where userid='0' and touserid='$userid' and `isread`='0'");

		$json['code'] = 100;
		
		outputJson($json);
		
		break;
		
		case "reset_simg":
		if($userid == 0){
			header("Location: ".SITE_URL.tsurl('user','login'));
			exit;
		}
		$themeid = intval(trim($_POST['themeid']));
		
		$strTheme = $db->once_fetch_assoc("select simg,strgoodid from ".dbprefix."theme where themeid='$themeid'");
	
		unlink($strTheme['simg']);
		
		$arrgoods = explode(',',$strTheme['strgoodid']);
		$arrgoods = array_flip($arrgoods);
		$randgoodid = array_rand($arrgoods,1);
		$simgurl = $randgoodid?aac('zhuti')->themesimg($randgoodid):'';
		$db->query("update ".dbprefix."theme set `simg`='$simgurl' where themeid='".$themeid."'");

		$json['code'] = 100;
		
		outputJson($json);
		
		break;
		
		case "get_goodtag":
		
		$goods_id = intval(trim($_POST['pid']));
		
		$arr_tags = aac('sharetag')->getObjTagByObjid('share','goods_id',$goods_id);
		
		foreach($arr_tags as $key=>$item){
			$arr_tag[]=$item['tag_name'];
		}
		
		$json['tags'] = $arr_tag;
		
		$json['code'] = 100;
		
		outputJson($json);
		
		break;
		
		
	case "get_tag":
		$catename = _get('catename','trim');
		$g_id = _get('g_id');
		$catename =str_replace(' ','',$catename);
		$catename =str_replace('-','',$catename);

		$cateData = $db->once_fetch_assoc("select cate_id from ".dbprefix."goods_cate where cate_name like '%".$catename."%'");
	
		$cate_id = $cateData['cate_id'];
		$alltag = $db->fetch_all_assoc("select tag_id from ".dbprefix."goods_category_tags where cate_id ='".$cate_id."'");
		$subcatetag = $db->fetch_all_assoc("select tag from ".dbprefix."goods_subcate where cate_id ='".$cate_id."'");
		
		foreach($alltag as $key=>$item){
			$tag_str = $db->once_fetch_assoc("select tag_name from ".dbprefix."goods_tags where tag_id= '".$item['tag_id']."'");
			$html.= '<li g_id="'.$g_id.'">'.$tag_str['tag_name'].'</li>';
		}
		
		foreach($subcatetag as $key=>$item){
			$item['tag'] = str_replace('，',',',$item['tag']);
			$tagarr = explode(',',$item['tag']);
			foreach($tagarr as $v){
				$html.= '<li g_id="'.$g_id.'">'.$v.'</li>';
			}
		
		}
		
	echo $html;
			
	break;
	
	
	
	case "get_share":
		$tao_url = _get('tao_url','trim');
		
		if($tao_url){
		$return=aac('share')->get_goodinfo_by_url($tao_url);
		$pic_arr = explode(' ',$return['pic_url']);
		$return['pic_1'] = str_replace('_100x100.jpg','',$pic_arr[0]);
		$return['pic_1'] = str_replace('_60x60.jpg','',$pic_arr[0]);
		$return['pic_2'] = str_replace('_100x100.jpg','',$pic_arr[1]);
		$return['pic_2'] = str_replace('_60x60.jpg','',$pic_arr[1]);
		$return['pic_3'] = str_replace('_100x100.jpg','',$pic_arr[2]);
		$return['pic_3'] = str_replace('_60x60.jpg','',$pic_arr[2]);
		$return['pic_4'] = str_replace('_100x100.jpg','',$pic_arr[3]);
		$return['pic_4'] = str_replace('_60x60.jpg','',$pic_arr[3]);
		outputJson($return);
		}
			
	break;
	
	
	case "getCateBytag":
	
		$tag_id= _post('tag_id','intval');
		$arr_cate = $db->fetch_all_assoc("select * from ".dbprefix."goods_cate where cate_id>1 and parent_id=0");
		foreach($arr_cate as $key=>$item){
						$is_the_cate = $db->once_fetch_assoc("select id from ".dbprefix."goods_category_tags WHERE `cate_id` ='".$item['cate_id']."' and `tag_id` ='$tag_id'");
						$class = $is_the_cate['id']?'class="current"':'';
	
						$html .= '<li id="J_getcate_'.$tag_id.$item['cate_id'].'" '.$class.'><a href="javascript:;" onclick="return J_set_cate('.$tag_id.','.$item['cate_id'].');"class="J_item">'.$item['cate_name'].'</a></li>';
					}	
		
		
		$html .= '<div class="hr"></div>';
		
		echo $html;
			
	break;
	
	
	case "set_cate_tag":
	
		$tag_id= _post('tagid','intval');
		
		$cate_id= _post('cate_id','intval');
		
			$is_the_cate = $db->once_fetch_assoc("select id from ".dbprefix."goods_category_tags WHERE `cate_id` ='".$cate_id."' and `tag_id` ='$tag_id'");
			if($is_the_cate['id']){
				$db->query("DELETE FROM ".dbprefix."goods_category_tags WHERE `cate_id` ='".$cate_id."' and `tag_id` ='$tag_id'");
			}else{
			
				$db->query("insert into ".dbprefix."goods_category_tags (`cate_id`,`tag_id`,`is_index`,`weight`) VALUES ('$cate_id','$tag_id','0','100')");
				
			}
			
		$arr_cate = $db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where tag_id =".$tag_id);
		
		foreach($arr_cate as $key=>$item){
			
						$arr_cate = $db->once_fetch_assoc("select cate_name from ".dbprefix."goods_cate where cate_id ='".$item['cate_id']."' and cate_id<>1 and parent_id<>1");

						$is_index =$item['is_index']?'style="background-color:#F00;" title="该标签为【'.$arr_cate['cate_name'].'】分类的首页标签"':'style="background-color:#006B9F;"';
			if($arr_cate['cate_name']){
						$html .='<a class="n_tag" href="javascript:;" onclick="return set_cate('.$tag_id.');" '.$is_index.'>'.$arr_cate['cate_name'].'</a> ';
			}
					}	
		
		echo $html;
			
	break;
	
	
	case "set_tag_hot":
	
		$tag_id= _post('tag_id','intval');
		
		$is_hot= _post('is_hot','intval');

		$db->query("update ".dbprefix."goods_tags set `is_hot`='$is_hot' where tag_id='$tag_id'");
		
		echo 1;
			
	break;
	
}