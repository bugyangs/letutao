<?php
defined('IN_TS') or die('Access Denied.');

//首页幻灯

$indexslides = $db->fetch_all_assoc("select * from ".dbprefix."indexslide order by sort asc , addtime desc limit 7");
$i = 0;
foreach($indexslides as $key=>$item){
		$indexslide[] = $item;
		$indexslide[$key]['i'] = $i;
		$i++;
	}
	
	
//精华话题6个
$arrpTopics = $db->fetch_all_assoc("select * from ".dbprefix."group_topics where isposts=1 order by uptime desc limit 8");
	
	foreach($arrpTopics as $key=>$item){
		$arrpTopic[]=$item;
		
		$arrpTopic[$key]['user'] = aac('user')->getSimpleUser($item['userid']);
		
	}
	
//热门标签
$HotTag = $db->fetch_all_assoc("select * from ".dbprefix."goods_tags where is_hot=1 limit 45");

foreach($HotTag as $key=>$item){
		$cate_id_str = $db->once_fetch_assoc("select cate_id from ".dbprefix."goods_category_tags where tag_id ='".$item['tag_id']."'");
		$appname = $db->once_fetch_assoc("select appname from ".dbprefix."goods_cate where cate_id = '".$cate_id_str['cate_id']."'");
		 
		$HotTag[$key]['appname'] = $appname['appname']?$appname['appname']:'faxian';
		
}	





//最新主题
$arrthemes = $db->fetch_all_assoc("select * from ".dbprefix."theme  order by istop desc, goodsnum desc,addtime desc limit 4");
$i = 0;
foreach($arrthemes as $key=>$item){
		$arrtheme[] = $item;
		if($item['background']){
		$arrtheme[$key]['simg']= fileiimg($item['background'],'theme',235,120,'',1);
		}
		$arrtheme[$key]['left'] = $i;
		$i=$i+242;
	}

//大家刚刚喜欢了
//达人推荐

$arrDarens = $db->fetch_all_assoc("select a.userid,a.goods_id,a.commentType,a.addtime from ".dbprefix."share_goods_like AS a LEFT JOIN ".dbprefix."user_info AS b ON a.userid = b.userid where a.commentType=0 and b.darenid>0 order by a.addtime desc limit 4");

$arrDaren = array();
foreach($arrDarens as $key=>$item){
	$arrDaren[]=$item;
	$isgoods = $db->once_fetch_assoc("select img,simg_170,name,count_like,price from ".dbprefix."share_goods where goods_id='".$item['goods_id']."'");
	if(is_array($isgoods)){
	$arrDaren[$key]['strgoods'] = $isgoods;
	$imgstr = aac('index')->cut_Img($isgoods['name'],'170','170');
	$arrDaren[$key]['simg_170']=$imgstr;
	$arrDaren[$key]['liketime']= getTime($item['addtime'],time());
	}
	
}




//推荐板块

$arrGroups = $db->fetch_all_assoc("select groupid from ".dbprefix."group order by isrecommend desc ,count_user desc limit 7");
	foreach($arrGroups as $key=>$item){
		$arrData[] = aac('group')->getOneGroup($item['groupid']);
	}
	foreach($arrData as $key=>$item){
		$arrRecommendGroup[] =  $item;
		$arrRecommendGroup[$key]['user'] = aac('user')->getSimpleUser($item['userid']);
		$arrRecommendGroup[$key]['groupdesc'] = getsubstrutf8(t($item['groupdesc']),0,35);
		$arrRecommendGroup[$key]['groupicon'] = $arrRecommendGroup[$key]['groupicon']?$arrRecommendGroup[$key]['groupicon']:'public/images/group.gif';
	}



//分类商品
$category = array();
foreach($TS_SITE['appnav'] as $key=>$item){
	
	$strcate = $db->once_fetch_assoc("select * from ".dbprefix."goods_cate where appname LIKE '%".$key."%' and parent_id=0");
	$cateid = intval($strcate['cate_id']);
	
	//悬浮导航
	$F_nav[$key] =aac('sharetag')->getObjTagByCateid_new($cateid,true);
	
	$arrThemes = $db->fetch_all_assoc("select themeid,userid,title,simg from ".dbprefix."theme where cate='".$item."' order by themeid desc limit 7");
	
	foreach($arrThemes as $kkey=>$iitem){
		$arrThemes[$kkey]['user'] = aac('user')->getSimpleUser($iitem['userid']);;
		}
	
	$catetags_1 = aac('sharetag')->getObjTagByCateid($cateid,'0,3','1');
	
		foreach($catetags_1 as $kkey=>$iitem){
			$imgstr = aac('index')->cut_Img($iitem['tag_name'],'270','140',$cateid);
			$catetags_1[$kkey]['imgstr'] = $imgstr;
		}

	$catetags_2 = aac('sharetag')->getObjTagByCateid($cateid,'3,6','1');
	foreach($catetags_2 as $kkey=>$iitem){
			if($kkey==0){
				$imgstr = aac('index')->cut_Img($iitem['tag_name'],'290','290',$cateid);
			}else{
				$imgstr = aac('index')->cut_Img($iitem['tag_name'],'140','140',$cateid);
			}
			$catetags_2[$kkey]['imgstr'] = $imgstr;
		}

	$category[]    = array(
	'appname'=>$key,
	'catename'=>$item,
	'arrThemes'=>$arrThemes,
	'cateid'=>$cateid,
	'catetags_1'=>$catetags_1,
	'catetags_2'=>$catetags_2,
	);

}

//可根据SEO需求进行优化，如需帮助请到论坛讨论：bbs.tuntron.com
$title = $TS_SITE['base']['site_title'].' - '.$TS_SITE['base']['site_subtitle'];

	include template("index");