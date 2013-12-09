<?php
defined('IN_TS') or die('Access Denied.');
//用户空间

$sort = isset($_GET['sort']) ? h($_GET['sort']) : '';
$userid = intval($_GET['userid']);

$page = isset($_GET['page']) ? $_GET['page'] : '1';
$url = SITE_URL.tsurl('user','zhuti',array('userid'=>$userid,'sort'=>$sort,'page'=>''));
$lstart = $page*6-6;

//用户数据统计
require_once 's_count.php';


if($sort=='create'){
$pageUrl = pagination($sthemesNum, 6, $page, $url);
}else{
$pageUrl = pagination($lthemesNum, 6, $page, $url);
}
if($userid == 0){
	header("Location: ".SITE_URL);
	exit;
}

$new['user']->isUser($userid);

$strUser = $new['user']->getOneUserByUserid($userid);

$strdaren = $new['user']->getDaren($strUser['darenid']);




switch ($sort) {
		case "":
		$arrthemes = $db->fetch_all_assoc("select themeid from ".dbprefix."share_theme_like where userid='$userid'  order by addtime desc limit $lstart,6");
	
		$letype = 'ilike';
		$letypewz = '取消喜欢';
	
		break;
		
		case "create":
		$arrthemes = $db->fetch_all_assoc("select themeid from ".dbprefix."theme where userid='$userid'  order by addtime desc limit $lstart,6");
		$letype = 'ilike';
		$letypewz = '删除主题';
		
		break;
	}
	
	
	
	foreach($arrthemes as $key=>$item){
		$arrtheme[] = $item;
		$strtheme = $db->once_fetch_assoc("select title,likenum,topicid,strgoodid from ".dbprefix."theme where `themeid`='".$item['themeid']."'");
		$arrtheme[$key]['themename'] = $strtheme['title'];
		$arrtheme[$key]['likenum'] = $strtheme['likenum'];
		$arrtheme[$key]['topicid'] = $strtheme['topicid'];
		$strcmt= $db->once_fetch_assoc("select count_comment from ".dbprefix."group_topics where topicid='".$strtheme['topicid']."'");
		$arrtheme[$key]['count_cmt']=$strcmt['count_comment']?$strcmt['count_comment']:'0';
		if(substr($strtheme['strgoodid'], -1)==','){
		$slen = strlen($strtheme['strgoodid'])-1;
		$strtheme['strgoodid'] = substr($strtheme['strgoodid'],0,$slen);
		$db->query("update ".dbprefix."theme set `strgoodid`='".$strtheme['strgoodid']."' where themeid='$Themeid'");
		}
		$strtheme['strgoodid'] = str_replace(',,',',',$strtheme['strgoodid']);
		if($strtheme['strgoodid']) $arrgoods = $db->fetch_all_assoc("select name,img from ".dbprefix."share_goods where goods_id in (".$strtheme['strgoodid'].") order by uptime desc limit 7");
		$arrtheme[$key]['goods']=$arrgoods;
		
	}
	
//精彩主题推荐

$bestthemes = $db->fetch_all_assoc("select themeid,title,simg,userid,uptime from ".dbprefix."theme where recom='1' order by addtime desc limit 6");

foreach($bestthemes as $key=>$item){
	$besttheme[]=$item;
	
	$besttheme[$key]['user'] = $new['user']->getOneUserByUserid($item['userid']);
	
	
}

	
	//print_r($arrtheme);

if($sort=='create') $title = $strUser['username'].'创建的主题';

if(!$sort) $title = $strUser['username'].'喜欢的主题';

//用户空间关键词和描述设置，可以根据情况自己进行修改！0416

$TS_SITE['base']['site_key']=$title.','.$TS_SITE['base']['site_key'];

$TS_SITE['base']['site_desc']='这里是'.$title.'。这里有最棒的潮流搭配和购物心得，一起来逛逛吧。我们一起发现喜欢！';

	include template("zhuti");