<?php
	/* 
	 * 商品管理
	 */
	
	switch($ts){
	
		//商品列表
		case "list":
			//商品分类函数
			function get_c_html($cate_name){
			global $db;
			$arrcate = $db->fetch_all_assoc("select cate_name from ".dbprefix."goods_cate where cate_id>1 and parent_id=0 order by cate_id asc");
			
		foreach($arrcate as $key=>$item){
			
					$cateData = $db->once_fetch_assoc("select cate_id from ".dbprefix."goods_cate where cate_name like '".$item['cate_name']."'");
					$c	= $db->fetch_all_assoc("select cate_name from ".dbprefix."goods_cate where parent_id ='".$cateData['cate_id']."'");

					if(is_array($c)){
						$cate_html .= $cate_name==$item['cate_name']?'<option value="'.$item['cate_name'].'" selected="selected">'.$item['cate_name'].'</option>':'<option value="'.$item['cate_name'].'">'.$item['cate_name'].'</option>';
					foreach($c as $k=>$v){
						$cate_html .= $cate_name==$v['cate_name']?'<option value="'.$v['cate_name'].'" selected="selected">&nbsp;&nbsp; - '.$v['cate_name'].'</option>':'<option value="'.$v['cate_name'].'">&nbsp;&nbsp; - '.$v['cate_name'].'</option>';
					}
				
			}
		}
			return $cate_html;
		
			}
		
		
		
		    $selecttype=$_REQUEST['selecttype'];
			$selectvalue=$_REQUEST['selectvalue'];
			$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$lstart = $page*15-15;
			if($selecttype){
				$url = 'index.php?app=share&ac=admin&mg=goods&ts=list&selecttype='.$selecttype.'&selectvalue='.$selectvalue.'&page=';
			}else{
				$url = 'index.php?app=share&ac=admin&mg=goods&ts=list&page=';
			}
			$wherestr="";
			
			
			if($selecttype&&$selectvalue){
			  if($selecttype=='goods_id'||$selecttype=='name'){
				$wherestr="where ".$selecttype." like '%".$selectvalue."%'";  
				
			  }
			  if($selecttype=='uid'){
				 $wherestr="where ".$selecttype." in (select userid from ".dbprefix."user_info where username like '%".$selectvalue."%')";
				  
			  }
			 if($selecttype=='cate_id'){
				 $wherestr="where ".$selecttype." in (select cate_id from ".dbprefix."goods_cate where cate_name like '%".$selectvalue."%')";
				  
			  }
			   $url = 'index.php?app=share&ac=admin&mg=goods&ts=list&selecttype='.$selecttype.'&selectvalue='.$selectvalue.'&page='; 
			}
			$arrgood = $db->fetch_all_assoc("select * from ".dbprefix."share_goods ".$wherestr." order by goods_id desc limit $lstart,15");
			
			foreach($arrgood as $key=>$item){
				$arrgoods[] = $item;
				$strcate = $db->once_fetch_assoc("select cate_name,appname from ".dbprefix."goods_cate where cate_id = '".$item['cate_id']."'");
				$arrgoods[$key]['cate_name'] = $strcate['cate_name'];
				$arrgoods[$key]['user'] = aac('user')->getUserForApp($item['uid']);
				
			}
			
			
			
			$goodsNum = $db->once_num_rows("select * from ".dbprefix."share_goods ".$wherestr);
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
			$goods_id = $_GET['goods_id'];
			
			if($goods_id){
			
			$strgoods       = $db->once_fetch_assoc("select themeid,uid,img,bigpic FROM ".dbprefix."share_goods WHERE goods_id	=".$goods_id);
		
		$isdel = $db->query("DELETE FROM ".dbprefix."share_goods WHERE goods_id	=".$goods_id);
		
		//删除评论回复
		$db->query("DELETE FROM ".dbprefix."share_goods_comments WHERE shareid = '".$goods_id."'");
		
		//删除动态
		$db->query("DELETE FROM ".dbprefix."feed WHERE feedtype='goods' and connectid=".$goods_id);
		
		//删除喜欢
		$db->query("DELETE FROM ".dbprefix."share_goods_like WHERE goods_id = '".$goods_id."'");
		
		//删除tag索引
		//$db->query("DELETE FROM ".dbprefix."tag_topic_index WHERE topicid = '".$topicid."'");
		
		//统计 
		if($strgoods['themeid']){
		$db->query("update ".dbprefix."theme set `goodsnum`=goodsnum-1 where themeid='".$strgoods['themeid']."'");
		}
		
	unlink($strgoods['img']);//删除缩略图
	
	if(strlen($strgoods['bigpic'])>10){
		
		unlink($strgoods['bigpic']); //删除本地化大图
	}
			

			qiMsg("商品删除成功！");
			}else{
				
			qiMsg("请选择要删除的商品！");
				
			}
			
			break;
		

			
			//设置分类
		case "delmore":
		 $delgoodsid=$_REQUEST['goods_iid'];
		 if($delgoodsid){
			 
		 foreach($delgoodsid as $dkey=>$ditem){
			 $goods_id = $ditem;
			
			
			$strgoods       = $db->once_fetch_assoc("select themeid,uid,img,bigpic FROM ".dbprefix."share_goods WHERE goods_id	=".$goods_id);
		
		$isdel = $db->query("DELETE FROM ".dbprefix."share_goods WHERE goods_id	=".$goods_id);
		
		//删除评论回复
		$db->query("DELETE FROM ".dbprefix."share_goods_comments WHERE shareid = '".$goods_id."'");
		
		//删除动态
		$db->query("DELETE FROM ".dbprefix."feed WHERE feedtype='goods' and connectid=".$goods_id);
		
		//删除喜欢
		$db->query("DELETE FROM ".dbprefix."share_goods_like WHERE goods_id = '".$goods_id."'");
		
		//删除tag索引
		//$db->query("DELETE FROM ".dbprefix."tag_topic_index WHERE topicid = '".$topicid."'");
		
		//统计 
		if($strgoods['themeid']){
		$db->query("update ".dbprefix."theme set `goodsnum`=goodsnum-1 where themeid='".$strgoods['themeid']."'");
		}
		
	   unlink($strgoods['img']);//删除缩略图
	
	  if(strlen($strgoods['bigpic'])>10){
		
		unlink($strgoods['bigpic']); //删除本地化大图
           	}  
		  }
		qiMsg("商品删除成功！");
		 }else{
		qiMsg("请选择要删除的商品！");
			 
		 }
		break;		
		case "setcate":
		
			$goods_id = $_POST['goods_id'];
			$cate_name  = $_POST['cate_name'];
			$strcate = $db->once_fetch_assoc("select * from ".dbprefix."goods_cate where cate_name = '".$cate_name."'");
		
			$db->query("UPDATE ".dbprefix."share_goods SET  cate_id='".$strcate['cate_id']."' where goods_id = '".$goods_id."'");
			
			echo 1;
			

			break;
			
			//修改标题
		case "setname":
		
			$goods_id = $_POST['goods_id'];
			$name  = $_POST['name'];
		
			$db->query("UPDATE ".dbprefix."share_goods SET  name='".$name."' where goods_id = '".$goods_id."'");
			
			echo 1;
			

			break;
	}