<?php
defined('IN_TS') or die('Access Denied.');
$userid = intval($TS_USER['user']['userid']);
if($userid==0) $news='news';
$page = isset($_GET['page']) ? $_GET['page'] : '1';
$url = SITE_URL.tsurl('feed',$news,array('page'=>''));
$lstart = $page*10-10;


//小道消息，嘘...

$arrfriendfeeds = $db->fetch_all_assoc("select * from ".dbprefix."feed where feedtype = 'friend' order by addtime desc limit 20");
$arrfriendfeed= aac('feed')->getGoodsFeed($arrfriendfeeds);

//你可能感兴趣的人

if($userid>0){
		
		$Per = 1;
		
		$arrfos = $db->fetch_all_assoc("select * from ".dbprefix."user_follow where userid=".$userid." order by addtime desc");

foreach($arrfos as $key=>$item){
		
		$str.= $item['userid_follow'].',';
	
}
	
	$arrusers = $db->fetch_all_assoc("select userid from ".dbprefix."user_info where userid<>".$userid." order by uptime desc limit 100");
	
	$randnum = count($arrusers)<7?count($arrusers):7;
	
	$randuser = array_rand($arrusers,$randnum);
	
	foreach ($randuser as $v) { 
 	 $randusers[]=$arrusers[$v]; 
	}
	
	$arrfs = explode(',',$str);

	foreach($randusers as $key=>$item){
		
		if(!in_array($item['userid'],$arrfs)){
			$isft =aac('user')->isfollow($userid,$item['userid']);
			$ft = $isft==2?'1':'5';
			$arrPer[] =array(
			'user' => aac('user')->getSimpleUser($item['userid']),
			'ft' => $ft,
			);
		}
		
	}
	if($userid == $userid) $db->query("update ".dbprefix."user_follow set `new`='0' where userid_follow='".$userid."'");
	
	}else{
		
	$Per = 0;	
		
	}
	
//他们正在讨论

$arrnowtopics = $db->fetch_all_assoc("select topicid,typeid,groupid,themeid,userid,title,count_comment from ".dbprefix."group_topics where isshow=0 order by count_comment desc limit 10");



foreach($arrnowtopics as $key=>$item){
	
	$arrnowtopic[]=$item;
	if($item['typeid']==0) $strgname = $db->once_fetch_assoc("select groupname from ".dbprefix."group where groupid='".$item['groupid']."'");
	if($item['typeid']==1) $strtname = $db->once_fetch_assoc("select cate from ".dbprefix."theme where topicid='".$item['topicid']."'");
	$arrnowtopic[$key]['groupname']=$strgname['groupname'];
	
	$arrnowtopic[$key]['catetheme']=$strtname['cate'];
	
	$arrnowtopic[$key]['user']=aac('user')->getSimpleUser($item['userid']);
	
}

//

if($news=='index'||$news=='goods'||$news=='zhuti'||$news=='pinpai'||$news=='topic'){
	//好友动态
	
	switch ($news) {
		
		case 'index':
		
		$feedtype = "and feedtype <> 'friend'";
		
		break;
		
		case 'goods':
		
		$feedtype = "and feedtype = 'goods'";
		
		break;
		
		case 'zhuti':
		
		$feedtype = "and feedtype = 'zhuti'";
		
		break;
		
		case 'pinpai':
		
		$feedtype = "and feedtype = 'pinpai'";
		
		break;
		
		case 'topic':
		
		$feedtype = "and feedtype = 'topic'";
		
		break;
		
		
		
	}
	
	
	
	$arrfollowfeed = array();
	
	$arrfollows = $db->fetch_all_assoc("select userid_follow from ".dbprefix."user_follow where userid=$userid");
	
	if(is_array($arrfollows)){
		foreach($arrfollows as $item){
					$str .="'".$item['userid_follow']."',";
				}
				$slen = strlen($str)-1;
				$strtagid = substr($str,0,$slen);
	
				$arrfollowfeeds = $db->fetch_all_assoc("select * from ".dbprefix."feed where userid in (".$strtagid.") ".$feedtype." order by addtime desc limit $lstart,10");
				
				$allfollowfeeds = $db->fetch_all_assoc("select * from ".dbprefix."feed where userid in (".$strtagid.") ".$feedtype." ");
				
	
	$arrfollowfeed = aac('feed')->getGoodsFeed($arrfollowfeeds);
	
	}

	
	$pageUrl = pagination(count($allfollowfeeds), 10, $page, $url);
	
				foreach($arrfollowfeed as $key=>$item){
					
					$strShare = $db->once_fetch_assoc("select price from ".dbprefix."share_goods where goods_id='".$item['data']['goods_id']."'");
					$arrfollowfeed[$key]['price']=$strShare['price'];
					
						if($item['data']['themeid']){
					$strTheme = $db->once_fetch_assoc("select simg from ".dbprefix."theme where themeid='".$item['data']['themeid']."'");
					$arrfollowfeed[$key]['data']['img']=$strTheme['simg']?$strTheme['simg']:'images/none-z-b.gif';
				}
					
				}
	
	
	//print_r($arrFeed);
	if($page > 1){
		$title = '好友动态 - 第'.$page.'页 - '.$TS_SITE['base']['site_title'];
	}else{
		$title = '好友动态 - '.$TS_SITE['base']['site_title'];
	}
	


}elseif($news=='news'){
	
	$type = trim($_GET['type']);
	$feedtype = "where feedtype <> 'friend'";
	
	switch ($type) {
		
		case 'goods':
		
		$feedtype = "where feedtype = 'goods'";
		
		break;
		
		case 'zhuti':
		
		$feedtype = "where feedtype = 'zhuti'";
		
		break;
		
		case 'pinpai':
		
		$feedtype = "where feedtype = 'pinpai'";
		
		break;
		
		case 'topic':
		
		$feedtype = "where feedtype = 'topic'";
		
		break;
		
		
		
	}
	
	
				$url = SITE_URL.tsurl('feed',$news,array('type'=>$type,'page'=>''));
	
				$arrfollowfeeds = $db->fetch_all_assoc("select * from ".dbprefix."feed ".$feedtype." order by addtime desc limit $lstart,10");
				
				$allfollowfeeds = $db->fetch_all_assoc("select * from ".dbprefix."feed ".$feedtype." ");
				
	
	$arrfollowfeed = aac('feed')->getGoodsFeed($arrfollowfeeds);


	
	$pageUrl = pagination(count($allfollowfeeds), 10, $page, $url);
	
				foreach($arrfollowfeed as $key=>$item){
					
					$strShare = $db->once_fetch_assoc("select * from ".dbprefix."share_goods where goods_id='".$item['data']['goods_id']."'");
					$arrfollowfeed[$key]['price']=$strShare['price'];
						if($item['data']['themeid']){
					$strTheme = $db->once_fetch_assoc("select simg from ".dbprefix."theme where themeid='".$item['data']['themeid']."'");
					$arrfollowfeed[$key]['data']['img']=$strTheme['simg']?$strTheme['simg']:'images/none-z-b.gif';
				}
					
				}
	
	
	
	
	
		if($page > 1){
		$title = '全站动态 - 第'.$page.'页 - '.$TS_SITE['base']['site_title'];
	}else{
		$title = '全站动态 - '.$TS_SITE['base']['site_title'];
	}


}

	include template('index');
