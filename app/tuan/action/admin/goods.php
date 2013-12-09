<?php
	/* 
	 * 商品管理
	 */
	
	switch($ts){
	
		//商品列表
		case "list":
			$tuancate = $db->fetch_all_assoc("select * from ".dbprefix."tuan_cate order by cate_id");
			$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$lstart = $page*15-15;
			$url = 'index.php?app=share&ac=tuan&mg=goods&ts=list&page=';
			$arrgood = $db->fetch_all_assoc("select * from ".dbprefix."tuan order by tuanid desc limit $lstart,15");
			
			foreach($arrgood as $key=>$item){
				$arrgoods[] = $item;
				$strcate = $db->once_fetch_assoc("select cate_name from ".dbprefix."tuan_cate where cate_id = '".$item['cateid']."'");
				$arrgoods[$key]['catename'] = $strcate['cate_name'];
			}
			
			
			
			$goodsNum = $db->once_num_rows("select * from ".dbprefix."tuan");
			$pageUrl = pagination($goodsNum, 15, $page, $url);

			include template("admin/goods_list");
			break;
		
		//编辑商品
		case "edit":
			$userid = $_GET['userid'];
			$strUser = $new['user']->getOneUserByUserid($userid);
			
			include template("admin/good_edit");
			break;
		
		//查看商品 
		case "view":
			$userid = $_GET['userid'];
			
			$strUser = $new['user']->getOneUserByUserid($userid);
			
			include template("admin/good_view");
			break;
			
			
		//删除商品
		case "del":
			$tuanid = $_GET['tuanid'];

		
			$isdel = $db->query("DELETE FROM ".dbprefix."tuan WHERE tuanid	=".$tuanid);


			qiMsg("团购删除成功！");
			
			break;
		

			
			//设置分类
		case "setcate":
		
			$tuanid = $_POST['tuanid'];
			$cateid  = $_POST['appname'];
			$db->query("UPDATE ".dbprefix."tuan SET  cateid='".$cateid."' where tuanid = '".$tuanid."'");
			
			echo 1;
			

			break;
			
			//修改标题
		case "setname":
		
			$tuanid = $_POST['tuanid'];
			$title  = $_POST['name'];
		
			$db->query("UPDATE ".dbprefix."tuan SET  title='".$title."' where tuanid = '".$tuanid."'");
			
			echo 1;
			

			break;
	}