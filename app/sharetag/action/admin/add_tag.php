<?php 
defined('IN_TS') or die('Access Denied.');


switch($ts){
	case "":
		$title = '添加标签';
		
		
			$arrcate = $db->fetch_all_assoc("select cate_name from ".dbprefix."goods_cate where cate_id>1 and parent_id=0 order by cate_id asc");
			
		foreach($arrcate as $key=>$item){
			
					$cateData = $db->once_fetch_assoc("select cate_id from ".dbprefix."goods_cate where cate_name like '".$item['cate_name']."'");
					$c	= $db->fetch_all_assoc("select cate_id,cate_name from ".dbprefix."goods_cate where parent_id ='".$cateData['cate_id']."'");

					if(is_array($c)){
					$cate_html .= '<option value="'.$item['cate_id'].'">'.$item['cate_name'].'</option>';
					foreach($c as $k=>$v){
						$cate_html .= '<option value="'.$v['cate_id'].'">&nbsp;&nbsp; - '.$v['cate_name'].'</option>';
					}
				
			}
		}

		$cate_id = intval($_GET['cate_id']);
		$top_cate_id=intval($_GET['top_cate_id']);
		$AlltagNum = $db->once_num_rows("select * from ".dbprefix."goods_tags");
		$strcate = $db->once_fetch_assoc("select * from ".dbprefix."goods_cate  where cate_id='$cate_id'");

		include template("admin/addtag");
		
		break;
	
	case "do":
	
		$strtag = trim($_POST['strtag']);
		
		$cate_id_arr = $_POST['cate_id'];

		$strtag = str_replace(' ',',',$strtag);
		$strtag = str_replace('，',',',$strtag);
		$arrkeywords = explode(",",$strtag);
		ksort($arrkeywords);
		if(empty($cate_id_arr)) qiMsg("请选择一个所属分类！");
		
		foreach($cate_id_arr as $v){
			foreach($arrkeywords as $item){
					
			if($item){
			$tagcount = $db->once_num_rows("select * from ".dbprefix."goods_tags where tag_name='".$item."'");

			if($tagcount){
					$tagid = aac('sharetag')->getTagId($item);
					
					$good_catecount = $db->once_num_rows("select * from ".dbprefix."goods_category_tags where cate_id='".$v."' and tag_id='$tagid'");
					if(!$good_catecount){
						
						$db->query("INSERT INTO ".dbprefix."goods_category_tags (`cate_id`,`tag_id`,`weight`) VALUES ('".$v."','".$tagid."','100')");
					}
						
				}else {
					
					$db->query("INSERT INTO ".dbprefix."goods_tags (`tag_name`,`tag_code`,`sort`,`is_hot`,`count`) VALUES ('".$item."','".$item."','100','0','1')");
						$tagid = $db->insert_id();
						$db->query("INSERT INTO ".dbprefix."goods_category_tags (`cate_id`,`tag_id`,`weight`) VALUES ('".$v."','".$tagid."','100')");
				
					
				}
				}
		}
		}
		
		qiMsg("标签添加成功！",'<a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list">管理标签</a>');
		break;
}