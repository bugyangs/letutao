<?php

defined('IN_TS') or die('Access Denied.');
	$spage  = intval($_POST['spage']);
	$bpage  = intval($_POST['bpage']);
	$sort   = h(trim($_POST['sort']));
	$kw     = h(trim($_POST['kw']));
	$subcate= h(trim($_POST['subcate']));
	$tag= h(trim($_POST['tag']));
	if($bpage){
		$bpage  = ($bpage-1)*50;
		$spage  = $bpage+$spage*10;
	}else{
		$spage  = $spage*10;
	}
	if($spage<0) {
		header("Location: ".SITE_URL);
		exit;
	}

	$cateId = intval($_POST['cateId']);
if($cateId){
	$catetags = aac('sharetag')->getObjTagByCateid_new($cateId);

	//筛选下级分类数组
	foreach($catetags as $key=>$item){
			$str_s .="'".$item['cate_id']."',";
		}
		$str = $str_s."'".$cateId."'";
		
	if($subcate){
		$subgoodsid= aac('sharetag')->getidbysubcate($cateId,$subcate);
	}else{
		$where = $cateId ? "where cate_id in ($str)" : "";
	}
	if($tag){
	$where = $where?$where."and name like '%".$tag."%'":"where name like '%".$tag."%'";	
	}
	if($sort && strstr($sort,'0') ){
	$arrsort = explode('~',$sort);//3.19伪静态
	list($a,$b) = $arrsort;
	$order =  'price';
	$where = $where?$where.' and price > '.$a.' and price < '.$b:' where price > '.$a.' and price < '.$b;
	}elseif($sort && !strstr($sort,'0') ){
	$order = $sort;
	}elseif($kw){//3.24搜索
	$order =  'goods_id';
	$where = $where?$where." and name like '%".$kw."%'":"where name like '%".$kw."%'";
	}else{
	$order = 'goods_id';
	}
	$adesc = strstr($sort,'0')?' asc':' desc';
	$tagid = isset($_POST['tagId']) ? $_POST['tagId'] : '100000';
	


		$arrdefaulttag = $db->fetch_all_assoc("select goods_id from ".dbprefix."tag_default_goods where tagid='$tagid'");
		
		$arrgoodstag = $db->fetch_all_assoc("select goods_id from ".dbprefix."tag_share_goods where tagid='$tagid'");
		//修复标签只显示10个
		
		
		//筛选数组
		
		foreach($arrgoodstag as $item){
			$str1 .="'".$item['goods_id']."',";
		}
		
		foreach($arrdefaulttag as $item){
			$str2 .="'".$item['goods_id']."',";
		}
		if($subgoodsid){
		foreach($subgoodsid as $item){
			$str3 .="'".$item['goods_id']."',";
		}
		
		$str = $str1.$str2.$str3;
		}else{
			
		$str = $str1.$str2;	
		}
		
		
		
		$slen = strlen($str)-1;
		$strtagid = substr($str,0,$slen);
		
		
	
		if($strtagid){
		$where = $where?$where.' and':'where';
		$Goods = $db->fetch_all_assoc("select * from ".dbprefix."share_goods ".$where." goods_id in (".$strtagid.") order by istop desc , ".$order.$adesc." limit $spage,10");
	
	    }else{
		
		$Goods = $db->fetch_all_assoc("select * from ".dbprefix."share_goods ".$where." order by istop desc , ".$order.$adesc." limit $spage,10");
	
	}
	$goodsh = count($Goods)<10?'true':'false';
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
//发现	
}else{
	  if($subcate){
		$subgoodsid= aac('sharetag')->getidbysubcate(0,$subcate);
		foreach($subgoodsid as $item){
			$str3 .="'".$item['goods_id']."',";
		}
		$where = 'where  goods_id in ('.$str3.')';
	  }
	if($tag){
	$where = $where?$where."and name like '%".$tag."%'":"where name like '%".$tag."%'";	
	}
	if($sort && strstr($sort,'0') ){
	$arrsort = explode('~',$sort);//3.19伪静态
	list($a,$b) = $arrsort;
	$order =  'price';
	$where = $where?$where.' and price > '.$a.' and price < '.$b:' where price > '.$a.' and price < '.$b;
	}elseif($sort && !strstr($sort,'0') ){
	$order = $sort;
	}elseif($kw){//3.24搜索
	$order =  'goods_id';
	$where = $where?$where." and name like '%".$kw."%'":"where name like '%".$kw."%'";
	}else{
	$order = 'goods_id';
	}
	$adesc = strstr($sort,'0')?' asc':' desc';
    
	$Goods = $db->fetch_all_assoc("select * from ".dbprefix."share_goods ".$where." order by istop desc , ".$order.$adesc." limit $spage,10");
	

	$goodsh = count($Goods)<10?'true':'false';
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
		
	}
	include template("index");