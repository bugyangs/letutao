<?php
defined('IN_TS') or die('Access Denied.');
//用户空间

$sort = isset($_GET['sort']) ? h($_GET['sort']) : '';
$userid = intval($_GET['userid']);
//$page = isset($_GET['p']) ? intval($_GET['p']) : '1';

$page = isset($_GET['p']) ? $_GET['p'] : '1';
$url = SITE_URL.tsurl('user','space',array('userid'=>$userid,'sort'=>$sort,'p'=>''));
$lstart = $page*25-25;
$sGoods = $db->fetch_all_assoc("select uid from ".dbprefix."share_goods where uid='$userid'");
$sGoodsNum = count($sGoods);
$afeedNum = $db->fetch_all_assoc("select * from ".dbprefix."feed where userid=$userid and feedtype = 'goods'");
$feedNum =count($afeedNum);
$lGoods = $db->fetch_all_assoc("select goods_id from ".dbprefix."share_goods_like where userid='$userid' and commentType ='0'");
$lGoodsNum = count($lGoods);
$Gnum = $lGoodsNum+$sGoodsNum;

$sthemes = $db->fetch_all_assoc("select themeid from ".dbprefix."theme where userid='$userid'");
$sthemesNum = count($sthemes);


$afansNum = $db->fetch_all_assoc("select * from ".dbprefix."user_follow where userid_follow=$userid");

$fansNum =count($afansNum);

$afollowNum = $db->fetch_all_assoc("select * from ".dbprefix."user_follow where userid=$userid");

$sfollowNum =count($afollowNum);

if($sort=='share'){
$pageUrl = pagination($sGoodsNum, 25, $page, $url);
}else{
$pageUrl = pagination($lGoodsNum, 25, $page, $url);
}
if($userid == 0){
	header("Location: ".SITE_URL);
	exit;
}

$new['user']->isUser($userid);

$strUser = $new['user']->getOneUserByUserid($userid);




if($sort){
		switch ($sort) {
			case "share":
			
					$Goods = $db->fetch_all_assoc("select goods_id,uid,img,name from ".dbprefix."share_goods where uid='$userid' limit $lstart,25");
					$letype = 'good';
					$letypewz = '删除宝贝';
			break;
			
			case "worth":
				$arrlike = $db->fetch_all_assoc("select goods_id from ".dbprefix."share_goods_like where userid='$userid' and commentType ='1' order by addtime desc");
				
				//筛选数组
		foreach($arrlike as $item){
			$str .="'".$item['goods_id']."',";
		}
		$slen = strlen($str)-1;
		$strtagid = substr($str,0,$slen);
		if($strtagid){
		$Goods = $db->fetch_all_assoc("select goods_id,uid,img,name from ".dbprefix."share_goods where goods_id in (".$strtagid.")");
		}
			break;
		
		}
	
	}else{
		$arrlike = $db->fetch_all_assoc("select goods_id from ".dbprefix."share_goods_like where userid='$userid' and commentType ='0'  order by addtime desc limit $lstart,25");
		$letype = 'ilike';
		$letypewz = '取消喜欢';
				//筛选数组
		foreach($arrlike as $item){
			$str .="'".$item['goods_id']."',";
		}
		$slen = strlen($str)-1;
		$strtagid = substr($str,0,$slen);
		if($strtagid){
		$Goods = $db->fetch_all_assoc("select goods_id,uid,img,name from ".dbprefix."share_goods where goods_id in (".$strtagid.") ");
		}
	}
	$arrtags = $arrtagss = array();
	foreach($Goods as $key=>$item){
		$Good[] = $item;
		$arrLike = $db->fetch_all_assoc("select userid from ".dbprefix."share_goods_like where `goods_id`='".$item['goods_id']."'");
		$Good[$key]['LikeNum'] = count($arrLike);
		$Good[$key]['user'] = aac('user')->getSimpleUser($item['userid']);
		$arrtag = aac('sharetag')->getObjTagByObjid('share','goods_id',$item['goods_id']);
		$arrtags = array_merge($arrtags,$arrtag);
		
	}
	
	$arrtags =unique_arr($arrtags);
	
	$arrnum = count($arrtags)>40?'40':count($arrtags);
	
	 $tempArr = array_rand($arrtags,$arrnum);//随机取出二维数组的键
     
     foreach($tempArr as $value){
   				$arrtagss[] = $arrtags[$value];
                }
				
	//print_r($arrtagss);




//是否跟随
if($TS_USER['user']['userid'] != '' && $TS_USER['user']['userid'] != $strUser['userid']){
	$followNum = $db->once_num_rows("select * from ".dbprefix."user_follow where userid='".$TS_USER['user']['userid']."' and userid_follow='$userid'");
	if($followNum > '0'){
		$strUser['isfollow'] = true;
	}else{
		$strUser['isfollow'] = false;
	}
}else{
	$strUser['isfollow'] = false;
}

//他跟随的用户
$followUsers = $db->fetch_all_assoc("select userid_follow from ".dbprefix."user_follow where userid='$userid' order by addtime limit 12");

if(is_array($followUsers)){
	foreach($followUsers as $item){
		$arrFollowUser[] =  $new['user']->getOneUserByUserid($item['userid_follow']);
	}
}

//加入的板块
$arrGroups = $db->fetch_all_assoc("select * from ".dbprefix."group_users where userid='$userid' limit 12");

if(is_array($arrGroups)){
	foreach($arrGroups as $key=>$item){
		$arrGroup[] = aac('group')->getOneGroup($item['groupid']);
	}
}

//自己的话题 
$arrMyTopic = $db->fetch_all_assoc("select * from ".dbprefix."group_topics where userid='$userid' order by addtime desc limit 15");

//回复的话题 
$arrComments = $db->fetch_all_assoc("select topicid from ".dbprefix."group_topics_comments where userid='$userid' group by topicid order by addtime desc limit 15");
if(is_array($arrComments)){
	foreach($arrComments as $item){
		$oneTopic = $db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid='".$item['topicid']."'");
		if($oncTopic['userid'] != $userid){
			$arrMyComment[] = $oneTopic;
		}
		
	}

}

//print_r($strUser);
//收藏的话题 
$arrMyCollect = $new['user']->getCollectTopic($userid,15);

if($sort=='share') $title = $strUser['username'].'分享的宝贝';

if($sort=='worth') $title = $strUser['username'].'认为值得的宝贝';

if(!$sort) $title = $strUser['username'].'喜欢的宝贝';

//用户空间关键词和描述设置，可以根据情况自己进行修改！0416

$TS_SITE['base']['site_key']=$title.','.$TS_SITE['base']['site_key'];

$TS_SITE['base']['site_desc']='这里是'.$title.'。这里有最棒的潮流搭配和购物心得，一起来逛逛吧。我们一起发现喜欢！';


include template("index");
