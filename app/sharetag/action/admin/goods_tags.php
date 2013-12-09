<?php 
defined('IN_TS') or die('Access Denied.');


switch($ts){
	case "list":
		$title = '分类标签设置';
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$lstart = $page*50-50;
		$selecttype=_get('selecttype','trim');
		$sort=_get('sort','trim')?_get('sort','trim'):'tag_id';
		$orderby =' order by '.$sort.' desc';
		$selectvalue=_get('selectvalue','trim');
		if($selecttype){
				$url = 'index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list&sort='.$sort.'&selecttype='.$selecttype.'&selectvalue='.$selectvalue.'&page=';
			}else{
				$url = 'index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list&sort='.$sort.'&page=';
			}
		
		$AlltagNum = $db->once_num_rows("select * from ".dbprefix."goods_tags");
		
		if($selecttype=='tag_id'){
			
			
			//根据标签ID获取分类标签
			$arrtag = $db->fetch_all_assoc("select * from ".dbprefix."goods_tags where tag_id=".$selectvalue.$orderby."  limit $lstart,50");
			
			foreach($arrtag as $key=>$item){
			$arrnavtag[] = $item;
				$arr_cate = $db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where tag_id =".$item['tag_id']);
				foreach($arr_cate as $k=>$v){
						$arr_c = $db->once_fetch_assoc("select cate_name from ".dbprefix."goods_cate where cate_id ='".$v['cate_id']."' and cate_id<>1 and parent_id<>1");
						$arr_cate[$k]['cate_name'] = $arr_c['cate_name'];
					}	
			
			$arrnavtag[$key]['cate'] = $arr_cate;
			}
			$tagNum = $db->once_num_rows("select * from ".dbprefix."goods_tags where tag_id=".$selectvalue."");
		}elseif($selecttype=='name'){
			
			
			//根据标签名称获取分类标签
			$tagstr_arr = explode(' ',$selectvalue);
			
			if(count($tagstr_arr)>1){ //多标签名搜索，多个请用空格分开
				
				foreach($tagstr_arr as $key=>$item){
					if($key+1==count($tagstr_arr)){
						$or .="tag_name like '%".$item."%'";
					}else{
						$or .="tag_name like '%".$item."%' or ";
					}
					
				}	
				
				$arrtag = $db->fetch_all_assoc("select * from ".dbprefix."goods_tags where ".$or." ".$orderby." limit $lstart,50");
				
				foreach($arrtag as $key=>$item){
				$arrnavtag[] = $item;
					$arr_cate = $db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where tag_id =".$item['tag_id']);
					foreach($arr_cate as $k=>$v){
							$arr_c = $db->once_fetch_assoc("select cate_name from ".dbprefix."goods_cate where cate_id ='".$v['cate_id']."' and cate_id<>1 and parent_id<>1");
							$arr_cate[$k]['cate_name'] = $arr_c['cate_name'];
						}	
				
				$arrnavtag[$key]['cate'] = $arr_cate;
				}
				$tagNum = $db->once_num_rows("select * from ".dbprefix."goods_tags where  ".$or."");
			
			}else{
				$arrtag = $db->fetch_all_assoc("select * from ".dbprefix."goods_tags where tag_name like '%".$selectvalue."%' ".$orderby." limit $lstart,50");
				
				foreach($arrtag as $key=>$item){
				$arrnavtag[] = $item;
					$arr_cate = $db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where tag_id =".$item['tag_id']);
					foreach($arr_cate as $k=>$v){
							$arr_c = $db->once_fetch_assoc("select cate_name from ".dbprefix."goods_cate where cate_id ='".$v['cate_id']."' and cate_id<>1 and parent_id<>1");
							$arr_cate[$k]['cate_name'] = $arr_c['cate_name'];
						}	
				
				$arrnavtag[$key]['cate'] = $arr_cate;
				}
				$tagNum = $db->once_num_rows("select * from ".dbprefix."goods_tags where tag_name like '%".$selectvalue."%'");
				
				
			}
			
		}elseif($selecttype=='cate_name'){


		$strcate = $db->once_fetch_assoc("select * from ".dbprefix."goods_cate  where cate_name='$selectvalue' and parent_id=0");
			//根据分类名获取标签
			$arrnavtags = $db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where cate_id='".$strcate['cate_id']."' ".$orderby." limit $lstart,20");
		foreach($arrnavtags as $key=>$item){
			$arrnavtag[] = $item;
			$arr_cate = $db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where tag_id =".$item['tag_id']);
			$arr_tagname = aac('sharetag')->getOneTag($item['tag_id']);
			$arrnavtag[$key]['tag_id'] = $arr_tagname['tag_id'];
			$arrnavtag[$key]['tag_name'] = $arr_tagname['tag_name'];
			$arrnavtag[$key]['is_hot'] = $arr_tagname['is_hot'];
			$arrnavtag[$key]['count'] = $arr_tagname['count'];
			$arrnavtag[$key]['img'] = $arr_tagname['img'];
			
			foreach($arr_cate as $k=>$v){
						$arr_c = $db->once_fetch_assoc("select cate_name from ".dbprefix."goods_cate where cate_id ='".$v['cate_id']."' and cate_id<>1 and parent_id<>1");
						$arr_cate[$k]['cate_name'] = $arr_c['cate_name'];
					}	
			$arrnavtag[$key]['cate'] = $arr_cate;
		}
		$tagNum = $db->once_num_rows("select * from ".dbprefix."goods_category_tags where cate_id='".$strcate['cate_id']."'");

		}else{
			
			
			//获取全部标签
			$arrtag = $db->fetch_all_assoc("select * from ".dbprefix."goods_tags ".$orderby." limit $lstart,50");
			
			foreach($arrtag as $key=>$item){
			$arrnavtag[] = $item;
				$arr_cate = $db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where tag_id =".$item['tag_id']);
				foreach($arr_cate as $k=>$v){
						$arr_c = $db->once_fetch_assoc("select cate_name from ".dbprefix."goods_cate where cate_id ='".$v['cate_id']."' and cate_id<>1 and parent_id<>1");
						$arr_cate[$k]['cate_name'] = $arr_c['cate_name'];

					}	
			
			$arrnavtag[$key]['cate'] = $arr_cate;
			}
			$tagNum = $db->once_num_rows("select * from ".dbprefix."goods_tags");
			
			
			
			
		}
		$pageUrl = pagination($tagNum, 50, $page, $url);

		include template("admin/AllTag");
		break;
		
	case "set_is_index":
		$title = '设置首页标签';
		
		$tag_id = intval($_POST['tag_id']);
		$cate_id = intval($_POST['cate_id']);
		$is_index = intval($_POST['is_index']);
		$db->query("update ".dbprefix."goods_category_tags set `is_index`='$is_index' where tag_id='$tag_id' and cate_id='$cate_id'");
		echo 1;
		break;
		
	case "setweight":
		$title = '设置首页标签';
		
		$tag_id = intval($_POST['tag_id']);
		$cate_id = intval($_POST['cate_id']);
		$weight = intval($_POST['weight']);
		$db->query("update ".dbprefix."goods_category_tags set `weight`='$weight' where tag_id='$tag_id' and cate_id='$cate_id'");
		echo 1;
		break;

	case "del_tag":
		
		$id = intval($_POST['id']);
		$db->query("DELETE FROM ".dbprefix."goods_tags where tag_id='$id'");
		$db->query("DELETE FROM ".dbprefix."goods_category_tags where tag_id='$id'");
		$db->query("DELETE FROM ".dbprefix."tag_default_goods where tagid='".$id."'");
		$db->query("DELETE FROM ".dbprefix."tag_share_goods where tagid='".$id."'");
		echo 1;
		break;
	case "del_tag_by":
		
		$selecttype=_get('selecttype','trim');
		$selectvalue=_get('selectvalue','trim');
		if($selecttype=='name'){
			$arrtag = $db->fetch_all_assoc("select * from ".dbprefix."goods_tags where tag_name like '%".$selectvalue."%'");
			foreach($arrtag as $key=>$item){
				
				$db->query("DELETE FROM ".dbprefix."goods_tags where tag_id='".$item['tag_id']."'");
				$db->query("DELETE FROM ".dbprefix."goods_category_tags where tag_id='".$item['tag_id']."'");
				$db->query("DELETE FROM ".dbprefix."tag_default_goods where tagid='".$item['tag_id']."'");
				$db->query("DELETE FROM ".dbprefix."tag_share_goods where tagid='".$item['tag_id']."'");
			}	
			
		}elseif($selecttype=='cate_name'){
			
			$strcate = $db->once_fetch_assoc("select * from ".dbprefix."goods_cate  where cate_name='$selectvalue'");
			//根据分类名获取标签
			$arrnavtags = $db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where cate_id='".$strcate['cate_id']."'");
		foreach($arrnavtags as $key=>$item){
			
				$db->query("DELETE FROM ".dbprefix."goods_tags where tag_id='".$item['tag_id']."'");
				$db->query("DELETE FROM ".dbprefix."goods_category_tags where id='".$item['id']."'");
				$db->query("DELETE FROM ".dbprefix."tag_default_goods where tagid='".$item['tag_id']."'");
				$db->query("DELETE FROM ".dbprefix."tag_share_goods where tagid='".$item['tag_id']."'");
			
		}

		}elseif($selecttype=='all'){
			
				$db->query("DELETE FROM ".dbprefix."goods_tags");
				$db->query("DELETE FROM ".dbprefix."goods_category_tags");
				$db->query("DELETE FROM ".dbprefix."tag_default_goods");
				$db->query("DELETE FROM ".dbprefix."tag_share_goods");

			
		}
		qiMsg("标签全部删除成功！");
		break;
}