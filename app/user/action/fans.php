<?php
defined('IN_TS') or die('Access Denied.');
//用户空间
$userid = intval($_GET['userid']);

$page = isset($_GET['page']) ? $_GET['page'] : '1';
$url = SITE_URL.tsurl('user','fans',array('userid'=>$userid,'page'=>''));
$lstart = $page*20-20;
//用户数据统计
require_once 's_count.php';


$pageUrl = pagination($fansNum, 20, $page, $url);

if($userid == 0){
	header("Location: ".SITE_URL);
	exit;
}

$new['user']->isUser($userid);

$strUser = $new['user']->getOneUserByUserid($userid);




$arrFans = $db->fetch_all_assoc("select * from ".dbprefix."user_follow where userid_follow=$userid order by addtime desc limit $lstart,20");

foreach($arrFans as $key=>$item){

	$arrFan[]= array(
	'user' =>aac('user')->getSimpleUser($item['userid']),
	'new' =>$item['new'],
	'isfollow' =>  $new['user']->isfollow($TS_USER['user']['userid'],$item['userid']),
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
	if($userid == $TS_USER['user']['userid']) $db->query("update ".dbprefix."user_follow set `new`='0' where userid_follow='".$TS_USER['user']['userid']."'");
	
	}else{
		
	$Per = 0;	
		
	}



$title = $strUser['username'].'的粉丝';

//用户空间关键词和描述设置，可以根据情况自己进行修改！0416

$TS_SITE['base']['site_key']=$title.','.$TS_SITE['base']['site_key'];

$TS_SITE['base']['site_desc']='这里是'.$title.'。这里有最棒的潮流搭配和购物心得，一起来逛逛吧。我们一起发现喜欢！';


include template("fans");
