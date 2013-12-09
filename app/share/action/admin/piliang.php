<?php
	/* 
	 * 商品管理
	 */
	
	switch($ts){
	
		//商品列表
		case "list":
		
			$arrcate = $db->fetch_all_assoc("select cate_name from ".dbprefix."goods_cate where cate_id>1 and parent_id=0 order by cate_id asc");
			
		foreach($arrcate as $key=>$item){
			
					$cateData = $db->once_fetch_assoc("select cate_id from ".dbprefix."goods_cate where cate_name like '".$item['cate_name']."'");
					$c	= $db->fetch_all_assoc("select cate_name from ".dbprefix."goods_cate where parent_id ='".$cateData['cate_id']."'");

					if(is_array($c)){
					$cate_html .= '<option value="'.$item['cate_name'].'">'.$item['cate_name'].'</option>';
					foreach($c as $k=>$v){
						$cate_html .= '<option value="'.$v['cate_name'].'">&nbsp;&nbsp; - '.$v['cate_name'].'</option>';
					}
				
			}
		}
		    $selecttype=$_REQUEST['selecttype'];
			$selectvalue=$_REQUEST['selectvalue'];
			$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$lstart = $page*15-15;
			$url = 'index.php?app=share&ac=admin&mg=goods&ts=list&page=';
			$wherestr="";
			if($selecttype&&$selectvalue){
			  if($selecttype=='goods_id'||$selecttype=='name'){
				$wherestr="where ".$selecttype." like '%".$selectvalue."%'";  
				
			  }
			  if($selecttype=='uid'){
				 $wherestr="where ".$selecttype." in (select userid from ".dbprefix."user_info where username like '%".$selectvalue."%')";
				  
			  }
			 if($selecttype=='cate_id'){
				 $wherestr="where ".$selecttype." in (select cate_id from ".dbprefix."goods_cate where appname like '%".$selectvalue."%')";
				  
			  }
			   $url = 'index.php?app=share&ac=admin&mg=goods&ts=list&selecttype='.$selecttype.'&selectvalue='.$selectvalue.'&page='; 
			}
			$arrgood = $db->fetch_all_assoc("select * from ".dbprefix."share_goods ".$wherestr." order by goods_id desc limit $lstart,15");
			
			foreach($arrgood as $key=>$item){
				$arrgoods[] = $item;
				$strcate = $db->once_fetch_assoc("select cate_name,appname from ".dbprefix."goods_cate where cate_id = '".$item['cate_id']."'");
				$arrgoods[$key]['appname'] = $strcate['appname'];
				$arrgoods[$key]['user'] = aac('user')->getUserForApp($item['uid']);
				
			}
			
			
			
			$goodsNum = $db->once_num_rows("select * from ".dbprefix."share_goods ".$wherestr);
			$pageUrl = pagination($goodsNum, 15, $page, $url);

			include template("admin/piliang");
			break;
			
		
		//查看商品 
		case "add":

			global $db,$DISK_YUN;
			
			$i =0;
			foreach($_POST['name'] as $key=>$item){
				$i =$i+1;
				$url = $_POST['url'][$key];
				$uid = $_POST['uid'][$key];
				$catename = $_POST['catename'][$key];
				$cateData = $db->once_fetch_assoc("select cate_id from ".dbprefix."goods_cate where cate_name like '".$catename."'");
				$cate_id = $cateData['cate_id'];
				$tag = $_POST['tag'][$key];
				$op = $_POST['op'][$key];
				
				$img_url_1 = $_POST['img_url_1'.$key];
				$img_url_2 = $_POST['img_url_2'.$key];
				$img_url_3 = $_POST['img_url_3'.$key];
				$img_url_4 = $_POST['img_url_4'.$key];
				if(empty($img_url_1)){qiMsg("至少要选择一张主图");}
				
				$uptime = time();
				$fold = date('Ymd',$uptime);
			
				$random = random(14);
				$dir = "cache/thumb/index/".$fold;
				!is_dir($dir)?mkdir($dir,0777):'';
				$imgurl="cache/thumb/index/".$fold."/".$random."w210.jpg";
				$pic_url = $img_url_1;
				require_once 'letutao/class.image.php';
				$resizeimage = new tsImg("$pic_url", "210", "", "0", "$imgurl" );
				if(!is_file($imgurl)) $resizeimage = new tsImg("$pic_url", "210", "", "0", "$imgurl" );
				$img_info = getimagesize($imgurl);	
				$img_h= $img_info[1];
				
				$img = $imgurl;
			
				$arrData = array(
					'uid'				 => intval($uid),
					'img'				 => $img,
					'img_h'				 => $img_h,
					'oldimg'			 => $img_url_1.'|'.$img_url_2.'|'.$img_url_3.'|'.$img_url_4,
					'name'	             => $item,
					'price'				 => intval(10),
					'taoke_url'		     => $url,
					'url'		         => $url,
					'seller_credit_score'=> 0,
					'shop_info'		     => '0',
					//折扣价
					'cate_id'		     => intval($cate_id),
					'comment'		     => $item,
					'uptime'		     => time(),
				);
		
			$goodsid = $db->insertArr($arrData,dbprefix.'share_goods');
			aac('sharetag')->addTag('share','goods_id',$goodsid,$tags);
			aac('sharetag')->addTag('default','goods_id',$goodsid,$defaulttags);
		
			}
			
			qiMsg("共成功上传了".$i."个商品！");
			break;
		
		//编辑商品
		case "edit":
			$userid = $_GET['userid'];
			$strUser = $new['user']->getOneUserByUserid($userid);
			
			include template("admin/piliang");
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
			
			break;
		

			
			//设置分类
		case "delmore":
		 $delgoodsid=$_REQUEST['goods_iid'];
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
		break;		
		case "setcate":
		
			$goods_id = $_POST['goods_id'];
			$appname  = $_POST['appname'];
			$strcate = $db->once_fetch_assoc("select * from ".dbprefix."goods_cate where appname LIKE '%".$appname."%'");
		
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