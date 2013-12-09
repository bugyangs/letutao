<?php
defined('IN_TS') or die('Access Denied.');

//瀑布流&画板
$_SESSION["style"] = in_array($_GET['style'],array('pin','boards')) ? $_GET['style'] :$_SESSION["style"];
$is_pin=$_SESSION["style"]?$_SESSION["style"]:$TS_SITE['base']['liststyle'];

//首页排序
$arrOptions = fileRead('options.php','data','index');

//设置标签
$arrtagOptions = fileRead('tags.php','data','index');
$arrOptions['sort'] = $arrOptions['sort']?$arrOptions['sort']:'';
//提取GET参数
$sort = _get('sort','h',$arrOptions['sort']);
if(!in_array($sort, array('count_like', 'count_worth', 'count_view', 'count_comment', '0~100', '100~200', '200~500', '500~9999999'))) {
	$sort = '';//防SQL注入
	}
$kw = isset($_GET['k']) ? h($_GET['k']) : '';
$tag = _get('tag','h','');
$tag = urldecode($tag);
$kw = urldecode($kw);
if(!IsUTF8($tag)){
	$tag = mb_convert_encoding($tag,'utf-8','gbk');
}

$page = isset($_GET['p']) ? intval($_GET['p']) : '1';

$arrtagid =  $db->once_fetch_assoc("select tag_id from ".dbprefix."goods_tags where tag_name='".$tag."'");
$catetags = aac('sharetag')->getObjTagByCateid_new(1);
if(empty($arrtagid) && $tag)
{
	$arrData = array(
				
				'tag_name'			=> $tag,
				'tag_code'			=> $tag,
				'sort'			    => '100',
				'is_hot'	        => '0',
				'count'				=> '0',
				
				
			);
	$tagid = $db->insertArr($arrData,dbprefix.'goods_tags');
}else{

$tagid = $arrtagid['tag_id'];
}
$userid = intval($TS_USER['user']['userid']);
$tagid = $tagid?$tagid:'';
	$sumGoodsNum =0;
    $where = $cateId ? "where cate_id = '$cateId'" : "";
	if($sort && strstr($sort,'0')&&empty($kw)){
	$arrsort = explode('~',$sort);//3.19伪静态
	list($a,$b) = $arrsort;
	$order =  'price';
	$where = $where?$where.' and price >'.$a.'and price < '.$b:' where price >'.$a.' and price < '.$b;
	}elseif($sort && !strstr($sort,'0')&&empty($kw)){
	$order = $sort;
	}elseif($kw){
		
	if($sort && strstr($sort,'0')&&!empty($kw)){
	$arrsort = explode('~',$sort);//3.19伪静态
	list($a,$b) = $arrsort;
	$order =  'price';
	$where = $where?$where.' and price >'.$a.'and price < '.$b:' where price >'.$a.' and price < '.$b;
	}elseif($sort && !strstr($sort,'0')&&!empty($kw)){
	$order = $sort;
	}else{
	$order = 'goods_id';	
	}
	
	//多关键词搜索 2013.2.20
	$kw_Array = explode(' ',$kw);
	
	for ($i=0;$i<count($kw_Array);$i++){
		$wv1 =  " name like '%".$kw_Array[$i]."%' ";
		$wv2 =  $wv1.' or '.$wv2;
	}
	
	$wv2 =  rtrim($wv2, " or");
	$where = $where?$where." and".$wv2:"where".$wv2;
	
		
	}else{
	$order = 'goods_id';
	}
	$adesc = strstr($sort,'0')?' asc':' desc';
if($is_pin=='pin'){
	
	//瀑布流模式
	if($tagid)
	{

		$arrdefaulttag = $db->fetch_all_assoc("select goods_id from ".dbprefix."tag_default_goods where tagid='$tagid'");
		$arrgoodstag = $db->fetch_all_assoc("select goods_id from ".dbprefix."tag_share_goods where tagid='$tagid'");
		$arr_likegoodstag = $db->fetch_all_assoc("select goods_id from ".dbprefix."share_goods where name like '%$tag%'");
		//筛选数组
		foreach($arrgoodstag as $item){
			$str1 .="'".$item['goods_id']."',";
		}
		
		foreach($arrdefaulttag as $item){
			$str2 .="'".$item['goods_id']."',";
		}
			//筛选数组
		foreach($arr_likegoodstag as $item){
			$str3 .="'".$item['goods_id']."',";
		}
		$str = $str1.$str2.$str3;
		$slen = strlen($str)-1;
		$strtagid = substr($str,0,$slen);
		
	
		$where = $where?$where.' and':'where';
		if($strtagid){
		$Goods = $db->fetch_all_assoc("select * from ".dbprefix."share_goods ".$where." goods_id in (".$strtagid.") order by istop desc , ".$order.$adesc." limit 10");
		$sumGoodsNum = $db->once_num_rows("select * from ".dbprefix."share_goods ".$where." goods_id in (".$strtagid.") order by istop desc , ".$order.$adesc);
		}
	}else{
	
		$Goods = $db->fetch_all_assoc("select * from ".dbprefix."share_goods ".$where." order by istop desc , ".$order.$adesc." limit 10");
		$sumGoodsNum = $db->once_num_rows("select * from ".dbprefix."share_goods ".$where." order by istop desc , ".$order.$adesc);
	}
	
	foreach($Goods as $key=>$item){
		$Good[] = $item;
		if($DISK_YUN['isopen']) {
			aac('system')->DiskYun_baidu_upload($item['img']);
			if($item['img_h']) {
				$Good[$key]['imgheigt'] = $item['img_h'];
			}else{
			    $img_info = getimagesize($DISK_YUN['loadUrl'].$item['img']);
				$Good[$key]['imgheigt'] =  $img_info[1];
				$db->query("update ".dbprefix."share_goods set `img_h`='".$img_info[1]."' where goods_id='".$item['goods_id']."'");
			}
			
		}else{
			
			if($item['img_h']) {
				$Good[$key]['imgheigt'] = $item['img_h'];
			}else{
			    $img_info = getimagesize($item['img']);	
				$Good[$key]['imgheigt'] =  $img_info[1];
				$db->query("update ".dbprefix."share_goods set `img_h`='".$img_info[1]."' where goods_id='".$item['goods_id']."'");
			}
		}
		
		$Good[$key]['user'] = aac('user')->getSimpleUser($item['userid']);
		$Good[$key]['OneComment'] = aac('share')->GetOneComment($item['goods_id']);
	}
	
}else{
	
	//画板模式
	
	$url = SITE_URL.tsurl('faxian','',array('tag'=>$tag,'p'=>''));
	$nexturl =SITE_URL.tsurl('faxian','',array('tag'=>$tag,'p'=>$page+1));
	$lstart = $page*36-36;
	
	if($tagid)
	{

		$arrdefaulttag = $db->fetch_all_assoc("select goods_id from ".dbprefix."tag_default_goods where tagid='$tagid'");
		$arrgoodstag = $db->fetch_all_assoc("select goods_id from ".dbprefix."tag_share_goods where tagid='$tagid'");
		$arr_likegoodstag = $db->fetch_all_assoc("select goods_id from ".dbprefix."share_goods where name like '%$tag%'");
		//筛选数组
		foreach($arrgoodstag as $item){
			$str1 .="'".$item['goods_id']."',";
		}
		
		foreach($arrdefaulttag as $item){
			$str2 .="'".$item['goods_id']."',";
		}
		
		//筛选数组
		foreach($arr_likegoodstag as $item){
			$str3 .="'".$item['goods_id']."',";
		}
		$str = $str1.$str2.$str3;
		$slen = strlen($str)-1;
		$strtagid = substr($str,0,$slen);
		
	
		$where = $where?$where.' and':'where';
		if($strtagid){
		$Goods = $db->fetch_all_assoc("select * from ".dbprefix."share_goods ".$where." goods_id in (".$strtagid.") order by istop desc , ".$order.$adesc." limit $lstart,36");
		$sumGoodsNum = $db->once_num_rows("select * from ".dbprefix."share_goods ".$where." goods_id in (".$strtagid.") order by istop desc , ".$order.$adesc);
		}
	}else{
	
		$Goods = $db->fetch_all_assoc("select * from ".dbprefix."share_goods ".$where." order by istop desc , ".$order.$adesc." limit $lstart,36");
		$sumGoodsNum = $db->once_num_rows("select * from ".dbprefix."share_goods ".$where." order by istop desc , ".$order.$adesc);
	}
	$pageUrl = nopin_pagination($sumGoodsNum, 36, $page, $url);
	
	foreach($Goods as $key=>$item){
		
		$Good[] = $item;
		if($DISK_YUN['isopen']) {
			aac('system')->DiskYun_baidu_upload($item['img']);
		}
		$Good[$key]['imgheigt'] =  $img_info[1];
		$Good[$key]['user'] = aac('user')->getSimpleUser($item['userid']);
		$Good[$key]['oldimg']=rtrim($Good[$key]['oldimg'], "|");
		$Good[$key]['OneComment'] = aac('share')->GetOneComment($item['goods_id']);
	}
	
	//重组数组，每9个为一组
	$Good =splitArrayc($Good,9);
	
}
	
	
	
	//热门标签
	$arrhottag = $db->fetch_all_assoc("select tag_name from ".dbprefix."goods_tags order by count desc limit 23");

	$arrTag = aac('tag')->getObjTagByObjid('user','userid',$userid);
	
	//推荐主题
	
	$arrzhuti = $db->fetch_all_assoc("select themeid,title from ".dbprefix."theme order by likenum desc,recom desc limit 8");
	
	
	//可根据SEO需求进行优化，如需帮助请到论坛讨论：bbs.tuntron.com
	$title = $tag?$tag.' - '.$TS_SITE['base']['site_title']:$TS_SITE['base']['site_title'].' - '.$TS_SITE['base']['site_subtitle'];
	$title = $kw?'搜索含有"'.$kw.'"的宝贝 - '.$TS_SITE['base']['site_title']:$title;
	$TS_SITE['base']['site_key'] = $kw?$kw.','.$TS_SITE['base']['site_key']:$TS_SITE['base']['site_key'];

	$is_pin=='pin'?include template("pin_index"):include template("index");