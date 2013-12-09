<?php

	defined('IN_TS') or die('Access Denied.');
	
	
	$tuancate = $db->fetch_all_assoc("select * from ".dbprefix."tuan_cate order by cate_id");
	$cateid = _get('cateid')?_get('cateid'):0;
	
	$where_cate = $cateid>0?' and cateid = '.$cateid.'':'';
	$sort = _get('sort')?_get('sort'):'default';
	$sortArr=array('price','zk','sold');
	if(!in_array($sort, $sortArr)) {$sort = 'default';}//防SQL注入
	$order = 'istop desc,tuanid desc';
	if($sort=='price'){
		
		$order = 'istop desc,price_tuan asc';
		
	}
	
	if($sort=='zk'){
		
		$order = 'istop desc,price_tuan/price_market asc';
		
	}
	
	if($sort=='sold'){
		
		$order = 'istop desc,count_sold desc';
		
	}
	
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$lstart = $page*15-15;
	$urlcateid = $cateid?'&cateid='.$cateid.'':'';
	$urlsort = $sort?'&sort='.$sort.'':'';
	
	$url = 'index.php?app=tuan'.$urlcateid.$urlsort.'&page=';
	
	$Arr_tuan = $db->fetch_all_assoc("select * from ".dbprefix."tuan where isshow=0".$where_cate." order by ".$order." limit $lstart,15");
	foreach($Arr_tuan as $key=>$item){
		
		$Arr_tuan[$key]['zk'] = sprintf("%01.1f",($item['price_tuan']/$item['price_market'])*10);
		
	}
	
	$tuanNum = $db->once_num_rows("select * from ".dbprefix."tuan where isshow=0".$where_cate);
	$pageUrl = tuan_pagination($tuanNum, 15, $page, $url);
	
	$keywords = !empty($strword)?$strword:$TS_SITE['base']['site_key'];
	$TS_SITE['base']['site_desc']  = '团购，为您省钱，值得信任';
	$title = '团购 - '.$TS_SITE['base']['site_title'];
	include template("index");