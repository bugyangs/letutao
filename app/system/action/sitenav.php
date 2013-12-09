<?php 
defined('IN_TS') or die('Access Denied.');

		
switch($ts){
	case "":
		$title = '导航设置';
		$strsitenav = $db->fetch_all_assoc("select * from ".dbprefix."goods_cate where parent_id=0 and appname<>'' order by sort asc");
		foreach($strsitenav as $key=>$item){
			$sitenav[] = $item;
			$sitenav[$key]['tagNum'] = $db->once_num_rows("select * from ".dbprefix."goods_category_tags where cate_id='".$item['cate_id']."'");
		}
		include template("sitenav");
		break;
		
	case "do":

		
		qiMsg("未知操作！","<a href=\"index.php?app=system&ac=sitenav\">返回</a>");
		
		break;
		
		
		case "do_nav":
		
		
		$arrcate_id = $_POST['cate_id'];
		$arrcate_name = $_POST['cate_name'];
		$arrseo_keywords = $_POST['seo_keywords'];
		$arrseo_desc = $_POST['seo_desc'];
		$arris_nav = $_POST['is_nav'];
		$arrappname = $_POST['appname'];
		$arrtag_num = $_POST['tag_num'];
		$arrsort = $_POST['sort'];
		
		//首页、讨论吧、动态 、主题 -、团购系统导航数组
		$arr_sys_nav = array(
			'index'=>array(
				'name'=>$_POST['indexname'],
				'seo_keywords'=>$_POST['index_seo_keywords'],
				'seo_desc'=>$_POST['index_seo_desc'],
				'is_show'=>1,
				),
			'faxian'=>array(
				'name'=>$_POST['faxianname'],
				'seo_keywords'=>$_POST['faxian_seo_keywords'],
				'seo_desc'=>$_POST['faxian_seo_desc'],
				'is_show'=>1,
				),
			'group'=>array(
				'name'=>$_POST['groupname'],
				'seo_keywords'=>$_POST['group_seo_keywords'],
				'seo_desc'=>$_POST['group_seo_desc'],
				'is_show'=>1,
				),
				
			'feed'=>array(
				'name'=>$_POST['feedname'],
				'seo_keywords'=>$_POST['feed_seo_keywords'],
				'seo_desc'=>$_POST['feed_seo_desc'],
				'is_show'=>1,
				),
				
			'zhuti'=>array(
				'name'=>$_POST['zhutiname'],
				'seo_keywords'=>$_POST['zhuti_seo_keywords'],
				'seo_desc'=>$_POST['zhuti_seo_desc'],
				'is_show'=>1,
				),
			'tuan'=>array(
				'name'=>$_POST['tuanname'],
				'seo_keywords'=>$_POST['tuan_seo_keywords'],
				'seo_desc'=>$_POST['tuan_seo_desc'],
				'is_show'=>1,
				),
		);
		
		fileWrite('sys_appnav.php','data',$arr_sys_nav);
	
		foreach($arrcate_name as $key=>$item){
			$cate_name = trim($item);
			$cate_id = trim($arrcate_id[$key]);
			$seo_keywords = trim($arrseo_keywords[$key]);
			$seo_desc = trim($arrseo_desc[$key]);
			$is_nav = trim($arris_nav[$key]);
			$appname = trim($arrappname[$key]);
			$tag_num = trim($arrtag_num[$key]);
			$sort = trim($arrsort[$key]);
			if(!$tag_num){
				$tag_num='20';
			}
			if(!$sort){
				$sort='0';
			}
			if($cate_name&& $appname){
					$arrNav = array(
					$appname	=> $cate_name,
					);
				$iscateid = $db ->once_num_rows("select cate_id from ".dbprefix."goods_cate where cate_id='".$cate_id."'");
				if($iscateid&&$cate_id<>1){
				$updatenav = $db->query("UPDATE ".dbprefix."goods_cate SET  cate_name='".$cate_name."',seo_keywords='".$seo_keywords."',seo_desc='".$seo_desc."',appname='".$appname."',tag_num='".$tag_num."',sort='".$sort."',is_nav='".$is_nav."' where cate_id = '".$cate_id."'");
				}elseif($cate_id<>1){
				$insertnav = $db->query("insert into ".dbprefix."goods_cate SET  cate_name='".$cate_name."',seo_keywords='".$seo_keywords."',seo_desc='".$seo_desc."',appname='".$appname."',tag_num='".$tag_num."',sort='".$sort."',parent_id='0'");
				}

			}
			
			
		}
		
		$sitenav = $db->fetch_all_assoc("select cate_name,appname from ".dbprefix."goods_cate where is_nav=1 and parent_id=0 and appname<>'' order by sort asc");
		$arrNavdo = array();
		foreach($sitenav as $key=>$item){
				$arrNav = array(
					$item['appname']	=> 	$item['cate_name'],
					);
				$arrNavdo = $arrNavdo+$arrNav;
		}
		
		fileWrite('top_appnav.php','data',$arrNavdo);
		
		fileWrite('sys_appnav.php','data',$arr_sys_nav);
	
		
		qiMsg("导航修改成功！","<a href=\"index.php?app=system&ac=sitenav\">返回</a>");
		
		break;
		
		case "del":
		
		$cate_id = intval($_GET['cate_id']);
		$arrNavdo = array();
		if($cate_id){
		
		$iscateid = $db ->once_num_rows("select cate_id from ".dbprefix."goods_cate where parent_id='".$cate_id."'");
		
		if($iscateid){
			qiMsg("存在下级分类，无法删除！","<a href=\"index.php?app=system&ac=navtag&cate_id=$cate_id\">管理下级分类</a>");
		}else{
			
			$db->query("DELETE FROM ".dbprefix."goods_cate WHERE  cate_id='$cate_id'");
			$db->query("DELETE FROM ".dbprefix."goods_category_tags WHERE  cate_id='$cate_id'");
		}
		
		qiMsg("导航删除成功！","<a href=\"index.php?app=system&ac=sitenav\">返回</a>");
		}
		
		break;
		
		case "isnav":
		$arrNavdo = array();
		$cate_id = $_POST['cate_id'];
		
		if(intval($cate_id)>0){
		$updateisnav = $db->query("UPDATE ".dbprefix."goods_cate SET  is_nav='1' where cate_id = '$cate_id'");
		$sitenav = $db->fetch_all_assoc("select cate_name,appname from ".dbprefix."goods_cate where is_nav=1 and parent_id=0 and appname<>''");
		foreach($sitenav as $key=>$item){
				$arrNav = array(
					$item['appname']	=> 	$item['cate_name'],
					);
				$arrNavdo = $arrNavdo+$arrNav;
		}
		fileWrite('top_appnav.php','data',$arrNavdo);
		}elseif(!empty($cate_id)){
			
		$sys_nav_arrs = fileRead('appnav.php','data','sys');
		
		foreach($sys_nav_arrs as $key=>$item){
			if($key==$cate_id){
				
				$sys_nav_arr[$key] =  array (
										'name' => $item['name'],
										'seo_keywords' =>  $item['seo_keywords'],
										'seo_desc' =>  $item['seo_desc'],
										'is_show' => 1,
									  );
									  
			}else{
				$sys_nav_arr[$key] = $item;
			}
		}
			
		fileWrite('sys_appnav.php','data',$sys_nav_arr);
			
		}
		
		
		echo '1';
		
		break;
		
		case "unnav":
		$arrNavdo = array();
		$cate_id = $_POST['cate_id'];
		if(intval($cate_id)>0){
		$updateisnav = $db->query("UPDATE ".dbprefix."goods_cate SET  is_nav='0' where cate_id = '$cate_id'");
		$sitenav = $db->fetch_all_assoc("select cate_name,appname from ".dbprefix."goods_cate where is_nav=1 and parent_id=0 and appname<>''");
		foreach($sitenav as $key=>$item){
				$arrNav = array(
					$item['appname']	=> 	$item['cate_name'],
					);
				$arrNavdo = $arrNavdo+$arrNav;
		}
		fileWrite('top_appnav.php','data',$arrNavdo);
		
		}elseif(!empty($cate_id)){
			
			$sys_nav_arrs = fileRead('appnav.php','data','sys');
		
		foreach($sys_nav_arrs as $key=>$item){
			if($key==$cate_id){
				
				$sys_nav_arr[$key] =  array (
										'name' => $item['name'],
										'seo_keywords' =>  $item['seo_keywords'],
										'seo_desc' =>  $item['seo_desc'],
										'is_show' => 0,
									  );
									  
			}else{
				$sys_nav_arr[$key] = $item;
			}
		}
			
		fileWrite('sys_appnav.php','data',$sys_nav_arr);
			
			
		}
		echo '1';
		
		break;
}