<?php 
defined('IN_TS') or die('Access Denied.');


switch($ts){
	case "":
		$title = '添加标签';

		$cate_id = intval($_GET['cate_id']);
		$top_cate_id=intval($_GET['top_cate_id']);
		
		$strcate = $db->once_fetch_assoc("select * from ".dbprefix."goods_cate  where cate_id='$cate_id'");

		include template("addtag");
		
		break;
	
	case "do":
	
		$strtag = trim($_POST['strtag']);
		
		$cate_id = trim($_POST['cate_id']);
		$top_cate_id = trim($_POST['top_cate_id']);
		$strtag = str_replace(' ',',',$strtag);
		$strtag = str_replace('，',',',$strtag);
		$arrkeywords = explode(",",$strtag);
		ksort($arrkeywords);
		foreach($arrkeywords as $item){
			if($item){
			$tagcount = $db->once_num_rows("select * from ".dbprefix."goods_tags where tag_name='".$item."'");
			if($tagcount == '0'){
						$db->query("INSERT INTO ".dbprefix."goods_tags (`tag_id`,`tag_name`,`tag_code`,`sort`,`is_hot`,`count`) VALUES (NULL,'".$item."','".$item."','100','0','1')");
						$tagid = $db->insert_id();
						$db->query("INSERT INTO ".dbprefix."goods_category_tags (`id`,`cate_id`,`tag_id`,`weight`) VALUES (NULL,'".$cate_id."','".$tagid."','100')");
				}else {
				
					$tagid = aac('sharetag')->getTagId($item);
					$good_catecount = $db->once_num_rows("select * from ".dbprefix."goods_category_tags where cate_id='$cate_id' and tag_id='$tagid'");
					if($good_catecount == '0'){
						$db->query("INSERT INTO ".dbprefix."goods_category_tags (`id`,`cate_id`,`tag_id`,`weight`) VALUES (NULL,'".$cate_id."','".$tagid."','100')");
					}
				}
				}
		}
		qiMsg("标签添加成功！","<a href=\"index.php?app=system&ac=AllCateTag&cate_id=$cate_id&top_cate_id=$top_cate_id\">返回</a>");
		break;
}