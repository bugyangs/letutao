<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
	case "":
		$arrSlides = $db->fetch_all_assoc("select * from ".dbprefix."indexslide");

		$title = '首页幻灯设置';
		include template("IndexSlide");
		break;
		
	case "do":
	
		$ids= $_POST['id'];
		$slidetitles= $_POST['slidetitle'];
		$slidedescs = $_POST['slidedesc'];
		$slideurls = $_POST['slideurl'];
		$slideimgs = $_POST['slideimg'];
	    $sorts=$_POST['sort'];
		
		foreach($ids as $key=>$item){
			
			$id= intval($item);
			$slidetitle= trim($slidetitles[$key])?trim($slidetitles[$key]):' ';
			$slidedesc = trim($slidedescs[$key]);
			$slideurl  = trim($slideurls[$key]);
			$slideimg  = trim($slideimgs[$key]);
			
			$sortid=trim($sorts[$key]);

			if(empty($slideimg)) qiMsg("必须选择幻灯图片","<a href=\"index.php?app=system&ac=IndexSlide\">点击返回</a>");
			if(empty($slideurl)) qiMsg("必须填写幻灯链接，空连接请填#号","<a href=\"index.php?app=system&ac=IndexSlide\">点击返回</a>");
			
			if($slidetitle){
				$db->query("update ".dbprefix."indexslide set `title`= '".$slidetitle."',`desc`='".$slidedesc."',`url`='".$slideurl."',`img`='".$slideimg."',`sort`='$sortid',`addtime`='".time()."' where id='$id'");
			}
		}
		
		qiMsg("首页幻灯设置成功^_^","<a href=\"index.php?app=system&ac=IndexSlide\">点击返回</a>");

		
	
		break;
}