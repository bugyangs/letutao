<?php
defined('IN_TS') or die('Access Denied.');


$page = isset($_GET['page']) ? $_GET['page'] : '1';
$url = SITE_URL.tsurl('message','my',array('page'=>''));
$lstart = $page*10-10;


//我的消息盒子

if($TS_USER['user']['userid']=='') header("Location: ".SITE_URL."index.php");

$userid = $TS_USER['user']['userid'];

$arrToUsers = $db->fetch_all_assoc("select userid from ".dbprefix."message where userid > '0' and touserid='$userid' group by userid");

if(is_array($arrToUsers)){
	foreach($arrToUsers as $key=>$item){
		$arrToUser[] = $item;
		$arrToUser[$key]['user'] = aac('user')->getUserForApp($item['userid']);
		$arrToUser[$key]['count'] = $db->once_num_rows("select * from ".dbprefix."message where touserid='$userid' and userid='".$item['userid']."' and isread='0'");
	}
}

//统计系统消息
$systemNum = $db->once_num_rows("select * from ".dbprefix."message where userid='0' and touserid='$userid'");

$pageUrl = pagination($systemNum, 10, $page, $url);

$title = '我的消息';

include template("my");