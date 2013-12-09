<?php
defined('IN_TS') or die('Access Denied.');

/* 
 * 板块话题内容页
 */

$topicid = intval($_GET['topicid']);

if($topicid == 0){
		@header("http/1.1 404 not found"); 
		@header("status: 404 not found");
		include template("404");
		exit(); 
}

$new['group']->isTopic($topicid);

$strTopic = $new['group']->getOneTopic($topicid);

//话题分类
if($strTopic['typeid'] != '0'){
	$strTopic['type'] = $db->once_fetch_assoc("select * from ".dbprefix."group_topics_type where typeid='".$strTopic['typeid']."'");
}

//板块
$strGroup = $db->once_fetch_assoc("select * from ".dbprefix."group where groupid='".$strTopic['groupid']."'");

//判断会员是否加入该板块
$groupid = intval($strGroup['groupid']);
$userid = intval($TS_USER['user']['userid']);

$isGroupUser = $db->once_num_rows("select * from ".dbprefix."group_users where userid='$userid' and groupid='$groupid'");

//浏览方式
if($strGroup['isopen']=='1' && $isGroupUser=='0'){
	
	$title = $strTopic['title'];
	include template("topic_isopen");
	
}else{
	
	
	//话题标签
	$strTopic['tags'] = aac('tag')->getObjTagByObjid('topic','topicid',$topicid);
	$strTopic['content'] = editor2html($strTopic['content']);
	$strTopic['user']	= aac('user')->getUserForApp($strTopic['userid']);
	$strTopic['user']['signed'] = hview($strTopic['user']['signed']);
	$title = $strTopic['title'];
	
	//判断是否是主题帖
	if($strTopic['typeid']==1){
		
		$strtheme = $db->once_fetch_assoc("select * from ".dbprefix."theme where `topicid`='$topicid'");
	}
	
	//评论列表开始
	$sc = isset($_GET['sc']) ? $_GET['sc'] : 'asc';
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	
	//倒序asc
	if($sc=='asc'){
		$url = SITE_URL.tsurl('group','topic',array('topicid'=>$topicid,'page'=>''));
	}else{
		$url = SITE_URL.tsurl('group','topic',array('topicid'=>$topicid,'sc'=>$sc,'page'=>''));
	}
	
	
	$lstart = $page*15-15;
	
	$arrComment = $db->fetch_all_assoc("select * from ".dbprefix."group_topics_comments where `topicid`='$topicid' order by addtime $sc limit $lstart,15");
	foreach($arrComment as $key=>$item){
		$arrTopicComment[] = $item;
		$arrTopicComment[$key]['user'] = aac('user')->getUserForApp($item['userid']);
		$arrTopicComment[$key]['content'] = editor2html($item['content']);
		$arrTopicComment[$key]['recomment'] = $new['group']->recomment($item['referid']);
		$allcomment.=$arrTopicComment[$key]['content'].$arrTopicComment[$key]['recomment'];
	}

	$mediaImgList = $new['group']->get_mediaImgList($strTopic['content'].$allcomment);
	
	$mediaVideoList = $new['group']->get_mediaVideoList($strTopic['content'].$allcomment);
	
	$commentNum= $db->once_num_rows("select * from ".dbprefix."group_topics_comments where `topicid`='$topicid'");
	
	$pageUrl = pagination($commentNum, 15, $page, $url);
	//评论列表结束
	
	
	
	//判断会员是否加入该板块
	$userid = intval($TS_USER['user']['userid']);
	$isGroupUser = $db->once_num_rows("select * from ".dbprefix."group_users where userid='$userid' and groupid='".$strTopic['groupid']."'");

	
	$groupid = $strTopic['groupid'];
	
	//板块成员
	$strGroupUser = $db->once_fetch_assoc("select * from ".dbprefix."group_users where userid='$userid' and groupid='".$strTopic['groupid']."'");
	
	//最新话题
	$newTopics = $db->fetch_all_assoc("select topicid,userid,title,count_comment from ".dbprefix."group_topics where groupid='$groupid' and isshow='0' order by addtime desc limit 10");
	
	foreach($newTopics as $key=>$item){
		$newTopic[] = $item;
		$newTopic[$key]['user'] = aac('user')->getSimpleUser($item['userid']);
	}
	
	($page > 1) ? $titlepage = " - 第".$page."页" : $titlepage='';
	$strGroup['groupname']=$strTopic['typeid']==1?'主题街':$strGroup['groupname'];
	$title = $title.$titlepage.' - '.$strGroup['groupname'];
	include template('topic');
	
	$db->query("update ".dbprefix."group_topics set `count_view`=count_view+1 where topicid='".$topicid."'");
	
}