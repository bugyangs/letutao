<?php
defined('IN_TS') or die('Access Denied.');

//板块首页

$groupid = intval($_GET['groupid']);

if($groupid == '0') header("Location: ".SITE_URL."index.php");

$new['group']->isGroup($groupid);

$typeid = intval($_GET['typeid']);

$kw = h($_GET['kw']);

$sortstr = $_GET['sort'];
$sortarr = array('uptime','new','most');
$sortstr = in_array($sortstr,$sortarr)?$sortstr:'';

$typestr = $_GET['type'];
$typearr = array('best','ask');
$typestr = in_array($typestr,$typearr)?$typestr:'';


//板块信息
$strGroup = $new['group']->getOneGroup($groupid);
$strGroup['groupicon'] = $strGroup['groupicon']?$strGroup['groupicon']:'public/images/group.gif';
$strGroup['groupdesc'] = stripslashes($strGroup['groupdesc']);

if($strGroup == '') header("Location: ".SITE_URL."index.php");

$strGroup['recoverynum'] = $db->once_num_rows("select * from ".dbprefix."group_topics where groupid='$groupid' and isshow='1'");

$strGroup['groupdesc'] = editor2html($strGroup['groupdesc']);



$title = $strGroup['groupname'];

//板块话题分类
$arrTopicTypes = $db->fetch_all_assoc("select * from ".dbprefix."group_topics_type where groupid='$groupid'");
if(is_array($arrTopicTypes)){
	foreach($arrTopicTypes as $item){
		$arrTopicType[$item['typeid']] = $item;
	}
}

//组长信息
$leaderId = $strGroup['userid'];

$strLeader = $db->once_fetch_assoc("select * from ".dbprefix."user_info where userid='$leaderId'");
$arrft = $db->fetch_all_assoc("select userid from ".dbprefix."group_topics where userid='$leaderId'");
$strLeader['ft'] = count($arrft);
$arrcmt = $db->fetch_all_assoc("select userid from ".dbprefix."group_topics_comments where userid='$leaderId'");
$strLeader['cmt'] = count($arrcmt);

$strLeader['f'] = $strLeader['face']?SITE_URL.miniimg($strLeader['face'],'user',48,48,$strLeader['path'],1):SITE_URL.'public/images/noavatar.gif';

//判断会员是否加入该板块
$userid = $TS_USER['user']['userid'];

$isGroupUser = $db->once_num_rows("select * from ".dbprefix."group_users where userid='$userid' and groupid='$groupid'");


//板块是否需要审核
if($strGroup['isaudit']=='1'){
	//推荐板块
	$arrRecommendGroup = $new['group']->getRecommendGroup('7');
	include template("group_isaudit");
	
}elseif($strGroup['isopen']=='1' && $isGroupUser=='0'){
	//是否开放访问
	include template("group_isopen");
}else{

	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	
	$lstart = $page*30-30;
	
	
	
	switch($sortstr){
		case 'uptime':
		
		$sort = 'uptime desc';
		
		break;
		
		case 'new':
		
		$sort = 'addtime desc';
		
		break;
		
		case 'most':
		
		$sort = 'count_comment desc';
		
		break;
		
	}
	$sort = $sort?$sort:'uptime desc';
	
	
	switch($typestr){
		case 'best':
		
		$type = 'and isposts =1';
		
		break;
		
		case 'ask':
		
		$type = 'and isask =1';
		
		break;
		
	}
	$type = $type?$type:'';
	
	$kw = $kw?" and title like '%".$kw."%'":'';
	
	if($typeid == '0'){
		$andType = '';
		$url = SITE_URL.tsurl('group','group',array('groupid'=>$groupid,'page'=>''));
	}else{
		$andType = "and typeid='$typeid'";
		$url = SITE_URL.tsurl('group','group',array('groupid'=>$groupid,'typeid'=>$typeid,'page'=>''));
	}
	
	$sql = "select * from ".dbprefix."group_topics where groupid='$groupid' ".$type.$kw." and isshow='0' order by istop desc,".$sort." limit $lstart,30";
	
	$arrTopics = $db->fetch_all_assoc($sql);
	if( is_array($arrTopics)){
		foreach($arrTopics as $key=>$item){
			$arrTopic[] = $item;
			$arrTopic[$key]['typename'] = $arrTopicType[$item['typeid']]['typename'];
			$arrTopic[$key]['user'] = aac('user')->getSimpleUser($item['userid']);
			$arrTopic[$key]['group'] = aac('group')->getSimpleGroup($item['groupid']);
			$arrTopic[$key]['photo'] = $new['group']->getOnePhoto($item['topicid']);
		}
	}
	
	$topic_num = $db->once_fetch_assoc("select count(topicid) from ".dbprefix."group_topics where groupid='$groupid' ".$andType." and isshow='0'");
	
	$pageUrl = pagination($topic_num['count(topicid)'], 30, $page, $url);

	
	
	
	//板块会员
	$groupUser = $db->fetch_all_assoc("select userid from ".dbprefix."group_users where groupid='$groupid' order by addtime DESC limit 8");
	
	if(is_array($groupUser)){
		foreach($groupUser as $key=>$item){
			$arrGroupUser[] = aac('user')->getUserForApp($item['userid']);
			$arrft = $db->fetch_all_assoc("select userid from ".dbprefix."group_topics where userid='".$item['userid']."'");
			$arrGroupUser[$key]['ft'] = count($arrft);
			$arrcmt = $db->fetch_all_assoc("select userid from ".dbprefix."group_topics_comments where userid='".$item['userid']."'");
			$arrGroupUser[$key]['cmt'] = count($arrcmt);
		}
	}
	
	if($page > 1){
		$title = $strGroup['groupname'].' - 第'.$page.'页';
	}
	
	
	
		$likes = intval($_GET['likes']);
	
	
	if($likes=='1'){
		
		
	$page = isset($_GET['page']) ? $_GET['page'] : '1';
	$url = SITE_URL.tsurl('group','group',array('groupid'=>$groupid,'likes'=>'1','page'=>''));
	$lstart = $page*100-100;
	
		
	//喜欢的人
	$arrlikes = $db->fetch_all_assoc("select userid from ".dbprefix."group_users where `groupid`='".$groupid."' order by addtime desc limit $lstart,100");
	foreach($arrlikes as $key=>$item){
		$arrlikeuser[] =  aac('user')->getSimpleUser($item['userid']);
		$arrulikes = $db->fetch_all_assoc("select userid from ".dbprefix."share_goods_like where `userid`='".$item['userid']."'");
		$arrlikeuser[$key]['likenum'] = count($arrulikes);
	}
	
	$grouplikeNum = $db->fetch_all_assoc("select userid from ".dbprefix."group_users where `groupid`='".$groupid."'");
	
	$pageUrl = pagination(count($grouplikeNum), 100, $page, $url);
		
		
		
		
	$title = '喜欢这个主题的人 - '.$strTheme[title];

	include template('group_likes');
	exit;
		
		
		
	}
	
	

	include template("group");

}