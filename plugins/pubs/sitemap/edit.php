<?php
defined('IN_TS') or die('Access Denied.');
//插件编辑
switch($ts){
	case "set":

		include 'edit_set.html';
		break;
		
	case "do":
		$_POST['file_dir'] = trim($_POST['file_dir']);
		$_POST['xml_txt']  = trim($_POST['xml_txt']);
		$_POST['scope']    =$_POST['scope'];
		$_POST['search']    =$_POST['search'];
		$file_dir = THINKROOT.str_replace('*',$_POST['xml_txt'],$_POST['file_dir']);
		if(!in_array($_POST['xml_txt'],array('xml','txt'))) qiMsg("文件类型有误！");
		if($_POST['xml_txt']=='xml'){
			$sitemap='<?xml version="1.0" encoding="UTF-8"?>
			';
			$sitemap.=($_POST['search']=='google')?'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">':'<sitemapindex>
			';
			$sitemap.='<url><loc>'.SITE_URL.'</loc><priority>1.0</priority><lastmod>'.date('Y-m-d').'</lastmod><changefreq>Always</changefreq></url>
			';
			//商品
			if(in_array('goods',$_POST['scope'])){
			//分类
			foreach($LE_APPone as $key=>$item){
				$url =tsurl($key);
					$sitemap.='
					<url>
		<loc>'.SITE_URL.str_replace('&','&amp;',$url).'</loc>
		<lastmod>'.date('Y-m-d').'</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.8</priority>
		</url>
					';
			}
			
			$arrgoods_id = $db->fetch_all_assoc("select goods_id from ".dbprefix."share_goods");
			foreach ($arrgoods_id as $key=>$item){
				$url =tsurl('baobei',$item['goods_id']);
			$str='
			<url>
<loc>'.SITE_URL.str_replace('&','&amp;',$url).'</loc>
<lastmod>'.date('Y-m-d').'</lastmod>
<changefreq>daily</changefreq>
<priority>0.6</priority>
</url>
			';
			$sitemap.=$str;
			}
			}
			
			if(in_array('zhuti',$_POST['scope'])){
			//主题
			$sitemap.='<url><loc>'.SITE_URL.tsurl('zhuti').'</loc><priority>0.8</priority><lastmod>'.date('Y-m-d').'</lastmod><changefreq>Always</changefreq></url>
			';
			$arrthemeid = $db->fetch_all_assoc("select themeid from ".dbprefix."theme");
			foreach ($arrthemeid as $key=>$item){
				$url =tsurl('zhuti'.$item['themeid']);
			$str='
			<url>
<loc>'.SITE_URL.str_replace('&','&amp;',$url).'</loc>
<lastmod>'.date('Y-m-d').'</lastmod>
<changefreq>daily</changefreq>
<priority>0.6</priority>
</url>
			';
			$sitemap.=$str;
			}
			}
			
			if(in_array('topic',$_POST['scope'])){
			//讨论
			$sitemap.='<url><loc>'.SITE_URL.tsurl('group').'</loc><priority>0.8</priority><lastmod>'.date('Y-m-d').'</lastmod><changefreq>Always</changefreq></url>
			';
			$arrtopicid = $db->fetch_all_assoc("select topicid from ".dbprefix."group_topics where isshow=0");
			foreach ($arrtopicid as $key=>$item){
				$url =tsurl('topicid',$item['topicid']);
			$str='
			<url>
<loc>'.SITE_URL.str_replace('&','&amp;',$url).'</loc>
<lastmod>'.date('Y-m-d').'</lastmod>
<changefreq>daily</changefreq>
<priority>0.6</priority>
</url>
			';
			$sitemap.=$str;
			}
			}
			
		$sitemap.='</sitemapindex>';	
		
		}else{
			
			
			$sitemap.=SITE_URL
			;
			//商品
			if(in_array('goods',$_POST['scope'])){
			//分类
			foreach($LE_APPone as $key=>$item){
					$url =tsurl($key);
					$sitemap.=SITE_URL.str_replace('&','&amp;',$url)."\r\n";
			}
			
			$arrgoods_id = $db->fetch_all_assoc("select goods_id from ".dbprefix."share_goods");
			foreach ($arrgoods_id as $key=>$item){
				$url =tsurl('baobei',$item['goods_id']);
				$str=SITE_URL.str_replace('&','&amp;',$url)."\r\n";
				$sitemap.=$str;
				}
			}
			
			if(in_array('zhuti',$_POST['scope'])){
			//主题
			$sitemap.=SITE_URL.tsurl('zhuti')
			;
			$arrthemeid = $db->fetch_all_assoc("select themeid from ".dbprefix."theme");
			foreach ($arrthemeid as $key=>$item){
				$url =tsurl('zhuti'.$item['themeid']);
			$str=SITE_URL.str_replace('&','&amp;',$url)."\r\n";
			$sitemap.=$str;
			}
			}
			
			if(in_array('topic',$_POST['scope'])){
			//讨论
			$sitemap.=SITE_URL.tsurl('group')
			;
			$arrtopicid = $db->fetch_all_assoc("select topicid from ".dbprefix."group_topics where isshow=0");
			foreach ($arrtopicid as $key=>$item){
				$url =tsurl('topicid',$item['topicid']);
				$str=SITE_URL.str_replace('&','&amp;',$url)."\r\n";
				$sitemap.=$str;
				}
			}
			
			
			
			
		}
		$incFile = fopen($file_dir,"w+") or qiMsg("请设置".str_replace('*',$_POST['xml_txt'],$_POST['file_dir'])."的权限为777");
    	if(fwrite($incFile, $sitemap)){
        	qiMsg("sitemap生成成功<br>保存路径：".SITE_URL.str_replace('*',$_POST['xml_txt'],$_POST['file_dir']));
    	}else{
       		qiMsg("Error！");
   		 }
		
		
		break;
}