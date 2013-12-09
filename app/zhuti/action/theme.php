<?php

	defined('IN_TS') or die('Access Denied.');
	
	$Themeid=substr($themeid,-(strlen($themeid)-5));
	$strTheme = $db->once_fetch_assoc("select * from ".dbprefix."theme where themeid='$Themeid'");
	
	if(!is_array($strTheme)) header("Location: ".SITE_URL.tsurl('zhuti'));
	
	
	$strThemeUser = aac('user')->getSimpleUser($strTheme['userid']);
	$sGoods = $db->fetch_all_assoc("select uid from ".dbprefix."share_goods where uid='".$strTheme['userid']."'");
	$sGoodsNum = count($sGoods);
	$lGoods = $db->fetch_all_assoc("select goods_id from ".dbprefix."share_goods_like where userid='".$strTheme['userid']."' and commentType ='0'");
	$lGoodsNum = count($lGoods);
	$Gnum = $lGoodsNum+$sGoodsNum;
	$sthemes = $db->fetch_all_assoc("select themeid from ".dbprefix."theme where userid='".$strTheme['userid']."'");
	$sthemesNum = count($sthemes);
	$strTheme['desc'] = nl2br($strTheme['desc']);
	
	//美化主题-属性值
	$obtopStyle = json_decode($strTheme['topStyle']);
	$obpageStyle = json_decode($strTheme['pageStyle']);
	$arrtopStyle = (array)$obtopStyle;
	$arrpageStyle = (array)$obpageStyle;
	$headerBgImage =SITE_URL.$strTheme['headerPhoto'];
	$pageBgImage =SITE_URL.$strTheme['pagePhoto'];
	$arrpageStyle['backgroundPosition']=$arrpageStyle['backgroundPosition']?$arrpageStyle['backgroundPosition']:'left top';
	$arrtopStyle['backgroundPosition']=$arrtopStyle['backgroundPosition']?$arrtopStyle['backgroundPosition']:'left top';
	$arrtopStyle['height']=$arrtopStyle['height']?$arrtopStyle['height']:'auto';
	$trepeat=$arrtopStyle['backgroundRepeat']=='repeat'?'0':'1';
	
	$prepeat=$arrpageStyle['backgroundRepeat']=='repeat'?'0':'1';
	$pfixed=$arrpageStyle['[backgroundAttachment']=='scroll'?'0':'1';
	
	
	//print_r($arrpageStyle);
	
	
	
	//兼容2.0之前版本，新安装可以删除↓
	$strshares1 = $db->fetch_all_assoc("select goods_id,img,name,price,count_comment,count_like from ".dbprefix."share_goods where themeid='$Themeid' order by goods_id desc limit 100");
	foreach($strshares1 as $key=>$item){
		$strshare1[] = $item;
		$img_info = getimagesize($item['img']);
		$strshare1[$key]['imgheigt'] =  $img_info[1];
		$strshare1[$key]['OneComment'] = aac('share')->GetOneComment($item['goods_id']);
	}
	//兼容v2.0之前版本，大于v2.0可以删除↑
	
	if(substr($strTheme['strgoodid'], -1)==','){
		$slen = strlen($strTheme['strgoodid'])-1;
		$strTheme['strgoodid'] = substr($strTheme['strgoodid'],0,$slen);
		$db->query("update ".dbprefix."theme set `strgoodid`='".$strTheme['strgoodid']."' where themeid='$Themeid'");
		}
		
	$strTheme['strgoodid'] = str_replace(',,',',',$strTheme['strgoodid']);

	$sqlin = $strTheme['strgoodid']?' where goods_id in ('. $strTheme['strgoodid'] .')':'';
	if($sqlin){
	$strsharesy = $db->fetch_all_assoc("select goods_id,img,name,price,count_comment,count_like from ".dbprefix."share_goods ".$sqlin." limit 100");
	foreach($strsharesy as $key=>$item){
		$strsharey1[] = $item;
		$img_info = getimagesize($item['img']);
		$strsharey1[$key]['imgheigt'] =  $img_info[1];
		$strsharey1[$key]['OneComment'] = aac('share')->GetOneComment($item['goods_id']);
	}
	}
	
	//倒排
	$c= count($strsharey1);
	$strsharey = array();
	for($i = 1;$i<=count($strsharey1);$i++){
		$strsharey[] = $strsharey1[$c-$i];
	}
	
	//print_r($strshare);
	
	$strtag = $strTheme['strtag'];
	$tags = str_replace ( '，', ',', $strtag);
	$tags = str_replace ( ' ', ',', $tags);
	$arrTag = explode(',',$tags);
	
	if($strTheme['topicid']){
	
	//评论开始
	$arrComment = $db->fetch_all_assoc("select * from ".dbprefix."group_topics_comments where `topicid`='".$strTheme['topicid']."' order by addtime desc limit 10");
	foreach($arrComment as $key=>$item){
		$arrTopicComment[] = $item;
		$arrTopicComment[$key]['user'] = aac('user')->getUserForApp($item['userid']);
		$arrTopicComment[$key]['content'] = getsubstrutf8(editor2html($item['content']),0,100);
		$arrTopicComment[$key]['recomment'] = aac('group')->recomment($item['referid']);
	}
	
	$conum = $db->once_fetch_assoc("select count(*) from ".dbprefix."group_topics_comments where `topicid`='".$strTheme['topicid']."'");
	}
	
	$commentNum=intval($conum['count(*)']);
	
	//上一个主题
	
	$pre_theme = $db->once_fetch_assoc("select * from ".dbprefix."theme where themeid >'$Themeid' order by themeid asc limit 0,1");
	
	
	//下一个主题
	$next_theme = $db->once_fetch_assoc("select * from ".dbprefix."theme where themeid <'$Themeid' order by themeid desc limit 0,1");
	$TS_APP['options']['appname'] = '主题街';

	if($likes=='likes'){
		
	$page = isset($_GET['page']) ? $_GET['page'] : '1';
	$url = SITE_URL.tsurl('zhuti'.$strTheme['themeid'],'likes',array('page'=>''));
	$lstart = $page*100-100;
	
		
		//喜欢的人
	$arrlikes = $db->fetch_all_assoc("select userid from ".dbprefix."share_theme_like where `themeid`='".$strTheme['themeid']."' order by addtime desc limit $lstart,100");
	foreach($arrlikes as $key=>$item){
		$arrlikeuser[] =  aac('user')->getSimpleUser($item['userid']);
		$arrulikes = $db->fetch_all_assoc("select userid from ".dbprefix."share_goods_like where `userid`='".$item['userid']."'");
		$arrlikeuser[$key]['likenum'] = count($arrulikes);
	}
	
	$themelikeNum = $db->fetch_all_assoc("select userid from ".dbprefix."share_theme_like where `themeid`='".$strTheme['themeid']."'");
	$pageUrl = pagination(count($themelikeNum), 100, $page, $url);
		
		
		
		
	$title = '喜欢这个主题的人 - '.$strTheme[title];

	include template('likes');
		
		
		}else{
	
	
	$title = $strTheme[title];
	
	include template('theme');

		}