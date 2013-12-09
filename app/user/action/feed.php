<?php
defined('IN_TS') or die('Access Denied.');
//用户空间
$userid = intval($_GET['userid']);

$page = isset($_GET['p']) ? $_GET['p'] : '1';
$url = SITE_URL.tsurl('user','feed',array('userid'=>$userid,'p'=>''));
$lstart = $page*10-10;

//用户数据统计
require_once 's_count.php';

$pageUrl = pagination($feedNum, 10, $page, $url);

if($userid == 0){
	header("Location: ".SITE_URL);
	exit;
}

$new['user']->isUser($userid);

$strUser = $new['user']->getOneUserByUserid($userid);




$arrFeeds = $db->fetch_all_assoc("select * from ".dbprefix."feed where userid=$userid and feedtype='goods' order by addtime desc limit $lstart,10");



$arrFeed = aac('feed')->getGoodsFeed($arrFeeds);


//print_r($arrFeed);

//好友动态
$arrfollowfeed = array();
$arrfollows = $db->fetch_all_assoc("select userid_follow from ".dbprefix."user_follow where userid=".$userid."");
if(is_array($arrfollows)){
	foreach($arrfollows as $item){
				$str .="'".$item['userid_follow']."',";
			}
			$slen = strlen($str)-1;
			$strtagid = substr($str,0,$slen);

			$arrfollowfeeds = $db->fetch_all_assoc("select * from ".dbprefix."feed where userid in (".$strtagid.")  and feedtype = 'goods' order by addtime desc limit 10");
		//print_r($arrfollowfeed);

$arrfollowfeed = aac('feed')->getGoodsFeed($arrfollowfeeds);

}

$title = $strUser['username'].'的最新动态';

//用户空间关键词和描述设置，可以根据情况自己进行修改！0416

$TS_SITE['base']['site_key']=$title.','.$TS_SITE['base']['site_key'];

$TS_SITE['base']['site_desc']='这里是'.$title.'。这里有最棒的潮流搭配和购物心得，一起来逛逛吧。我们一起发现喜欢！';


include template("feed");
