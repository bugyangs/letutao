<?php 
defined('IN_TS') or die('Access Denied.');

$AlltagNum = $db->once_num_rows("select * from ".dbprefix."goods_tags");
switch($ts){
	case "":
		$title = '自动分类调试';
		include template("admin/TestGetCate");
		
		break;
	
	case "do":
	
		$submit = trim($_POST['submit']);
		$url = _post('url');
	
		
		if($url){
			
			$arrcate = $db->fetch_all_assoc("select cate_name,cate_id from ".dbprefix."goods_cate where cate_id>1 and parent_id=0 order by cate_id asc");
			
			
			$w = (count($arrcate)+4)*60;
			$return=aac('share')->get_goodinfo_by_url($url);
			$tag_arr =$return['status']=='1'?explode(' ',$return['defaulttags']):$return['tags'];
			
			$tag_arr = array_unique($tag_arr);
			
			
			$weight =array();
			foreach($arrcate as $key=>$item){
				
				$All_weight =0;
				foreach($tag_arr as $tag){
			
					$arrttg = $db->once_fetch_assoc("select tag_id,tag_name from ".dbprefix."goods_tags where tag_name ='".$tag."'");
					$arrweight = $db->once_fetch_assoc("select cate_id,weight from ".dbprefix."goods_category_tags where cate_id='".$item['cate_id']."' and tag_id = '".$arrttg['tag_id']."'");
					$All_weight += $arrweight['weight'];
					
				}
				$weight[$item['cate_id']] =$All_weight;
				
			}
			
			$is_cateid = array_search(max($weight),$weight);
			$return_cate = $db->once_fetch_assoc("select cate_name from ".dbprefix."goods_cate where cate_id='".$is_cateid."'");

			foreach($tag_arr as $k=>$v){
				if($v){
					$arrttg = $db->once_fetch_assoc("select tag_id,tag_name from ".dbprefix."goods_tags where tag_name ='".$v."'");
					$tag_weight[$k]['tagname'] =$v;
					foreach($arrcate as $key=>$item){
							$arrweight = $db->once_fetch_assoc("select cate_id,weight from ".dbprefix."goods_category_tags where cate_id='".$item['cate_id']."' and tag_id = '".$arrttg['tag_id']."'");
							$o_w[$item['cate_id']]= $arrweight['weight']?$arrweight['weight']:0;
						
					}
					$tag_weight[$k]['weight']  = $o_w;
				}
					
				}
			
			
		}else{
			qiMsg('请粘贴目标商品链接！');
		}

		
		
		
		
		
		
		
		
		include template("admin/TestGetCate");
		break;
}