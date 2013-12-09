<?php
defined('IN_TS') or die('Access Denied.');

	//讨论首页
	
	//推荐的板块
	$arrRecommendGroups = $new['group']->getRecommendGroup(12);
	
	foreach($arrRecommendGroups as $key=>$item){
		$arrRecommendGroup[]=$item;
		
		$arrRecommendGroup[$key]['groupdesc'] = getsubstrutf8($item['groupdesc'],0,68);
		
	}


	//收藏的话题 
$arrMyCollect = aac('user')->getCollectTopic($userid,15);
	
	//今日热门话题

	$arrhotTopics = $db->fetch_all_assoc("select * from ".dbprefix."group_topics where typeid=0 order by count_comment desc,uptime desc,count_view desc limit 20");
	
	foreach($arrhotTopics as $key=>$item){
		$arrhotTopic[]=$item;
		
		$arrhotTopic[$key]['user'] = aac('user')->getSimpleUser($item['userid']);
		
	}
	
	
	//最新话题
	$arrnewTopics = $db->fetch_all_assoc("select * from ".dbprefix."group_topics where typeid=0 order by addtime desc limit 20");
	
	foreach($arrnewTopics as $key=>$item){
		
		$arrnewTopic[]=$item;
		
		$arrnewTopic[$key]['user'] = aac('user')->getSimpleUser($item['userid']);
		
	}
	
	
	//随机达人
	$arrdarens = $db->fetch_all_assoc("select * from ".dbprefix."user_info where darenid>0 order by rand() limit 5");
	
	foreach($arrdarens as $key=>$item){
		
		$arrdaren[] = $item;
		$u =aac('user')->getOneUserByUserid($item['userid']);
		$arrdaren[$key]['face']=$u['bigface'];
		$d= $db->once_fetch_assoc("select darenname from ".dbprefix."daren where darenid='".$item['darenid']."'");
		$arrdaren[$key]['darenname']=$d['darenname'];
		$arrdaren[$key]['isfollow'] =  aac('user')->isfollow($TS_USER['user']['userid'],$item['userid']);
	}
	//我创建的话题
	
	if($TS_USER['user']['userid']){
	$arrtopics = $db->fetch_all_assoc("select * from ".dbprefix."group_topics where typeid=0 and userid=".$TS_USER['user']['userid']." order by addtime desc limit 5");
	}
	
	//最热门10个板块
	$arrHotGroup = $new['group']->getHotGroup('10');
	
	
	//自己创建的10个板块
	if($TS_USER['user']['userid']){
	$myarrgroup = $db->fetch_all_assoc("select * from ".dbprefix."group where isshow=0 and userid=".$TS_USER['user']['userid']." order by addtime desc limit 10");
	}
	
	
	//板块分类
	$arrCate = $new['group']->getCates();
	
	$title = '讨论板块 - '.$TS_SITE['base']['site_title'];

	include template("index");