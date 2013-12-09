<?php
defined('IN_TS') or die('Access Denied.');
//用户空间
$userid = intval($_GET['userid']);

$page = isset($_GET['page']) ? $_GET['page'] : '1';
$url = SITE_URL.tsurl('user','follow',array('userid'=>$userid,'page'=>''));
$lstart = $page*20-20;

//用户数据统计
require_once 's_count.php';


$pageUrl = pagination($followNum, 20, $page, $url);

if($userid == 0){
	header("Location: ".SITE_URL);
	exit;
}

$new['user']->isUser($userid);

$strUser = $new['user']->getOneUserByUserid($userid);



	
$arrfollows = $db->fetch_all_assoc("select * from ".dbprefix."user_follow where userid=$userid order by addtime desc limit $lstart,20");

foreach($arrfollows as $key=>$item){
	
	$arrfollow[]= array(
	'user' =>aac('user')->getSimpleUser($item['userid_follow']),
	'isfollow' =>  $new['user']->isfollow($TS_USER['user']['userid'],$item['userid_follow']),
		);
	
}

//可能感兴趣的人
	if($TS_USER['user']['userid']){
		
		$Per = 1;
		
		$arrfos = $db->fetch_all_assoc("select * from ".dbprefix."user_follow where userid=".$TS_USER['user']['userid']." order by addtime desc");

foreach($arrfos as $key=>$item){
		
		$str.= $item['userid_follow'].',';
	
}

		
	$arrusers = $db->fetch_all_assoc("select userid from ".dbprefix."user_info where userid<>".$TS_USER['user']['userid']." order by uptime desc limit 100");
	
	$randnum = count($arrusers)<7?count($arrusers):7;
	
	$randuser = array_rand($arrusers,$randnum);
	
	foreach ($randuser as $v) { 
 	 $randusers[]=$arrusers[$v]; 
	}
	
	$arrfs = explode(',',$str);

	foreach($randusers as $key=>$item){
		
		if(!in_array($item['userid'],$arrfs)){
			
			$isft =$new['user']->isfollow($TS_USER['user']['userid'],$item['userid']);
			$ft = $isft==2?'1':'5';
			$arrPer[] =array(
			'user' => aac('user')->getSimpleUser($item['userid']),
			'ft' => $ft,
			);
		}
		
	}
	
	}else{
		
	$Per = 0;	
		
	}


	$title = $strUser['username'].'关注的人';
	include template("follow");