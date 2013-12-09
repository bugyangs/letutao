<?php 
defined('IN_TS') or die('Access Denied.');


switch($ts){
	case "":
		$title = '分类标签设置';
		
		$cate_id = intval($_GET['cate_id']);
		$tag_id = intval($_GET['tag_id']);
		$top_cate_id = intval($_GET['top_cate_id']);
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$lstart = $page*20-20;
		$url = 'index.php?app=system&ac=AllCateTag&cate_id='.$cate_id.'&page=';
		
		
		
		//获取分类标签
		if($tag_id){
		$arrnavtag = $db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where cate_id='$cate_id' and tag_id='$tag_id' order by id asc");}else{
				$arrnavtag = $db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where cate_id='$cate_id' order by id asc limit $lstart,20");
			
		}
		$strcate = $db->once_fetch_assoc("select * from ".dbprefix."goods_cate  where cate_id='$cate_id'");
		foreach($arrnavtag as $key=>$item){
			if($tag_id){
				if($tag_id==$item['tag_id']){
					$arr_tagname = aac('sharetag')->getOneTag($item['tag_id']);
					$arrnavtag[$key]['tagname'] = $arr_tagname['tag_name'];
				}
			}else{
				$arr_tagname = aac('sharetag')->getOneTag($item['tag_id']);
				$arrnavtag[$key]['tagname'] = $arr_tagname['tag_name'];
			}
		}
		
		$tagNum = $db->once_num_rows("select * from ".dbprefix."goods_category_tags where cate_id='$cate_id'");
		$tagNum=$tag_id?1:$tagNum;
		$pageUrl = pagination($tagNum, 20, $page, $url);
		
		include template("AllCateTag");
		break;
		
	case "set_is_index":
		
		$tag_id = intval($_POST['tag_id']);
		$cate_id = intval($_POST['cate_id']);
		$is_index = intval($_POST['is_index']);
		$db->query("update ".dbprefix."goods_category_tags set `is_index`='$is_index' where tag_id='$tag_id' and cate_id='$cate_id'");
		echo 1;
		break;
		
	case "setweight":
		
		$tag_id = intval($_POST['tag_id']);
		$cate_id = intval($_POST['cate_id']);
		$weight = intval($_POST['weight']);
		$db->query("update ".dbprefix."goods_category_tags set `weight`='$weight' where tag_id='$tag_id' and cate_id='$cate_id'");
		echo 1;
		break;

	case "del_tag":
		
		$id = intval($_POST['id']);
		$db->query("DELETE FROM ".dbprefix."goods_category_tags where tag_id='$id'");
		echo 1;
		break;
	
	
	case "do":
	
		$strtag = trim($_POST['strtag']);
		
		$cate_id = trim($_POST['cate_id']);
		$strtag = str_replace(' ',',',$strtag);
		$strtag = str_replace('，',',',$strtag);
		$arrkeywords = explode(",",$strtag);
		ksort($arrkeywords);
		
		$db->query("DELETE FROM ".dbprefix."goods_category_tags WHERE cate_id = '".$cate_id."'");
		
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
		qiMsg("标签设置成功！","<a href=\"index.php?app=system&ac=navtag&cate_id=$cate_id\">返回</a>");
		break;
}