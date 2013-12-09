<?php
	/* 
	 * 采集商品
	 */
	 
	 function combineURL($baseURL,$keysArr){
        $combined = $baseURL."&";
        $valueArr = array();

        foreach($keysArr as $key => $val){
            $valueArr[] = "$key=$val";
        }

        $keyStr = implode("&",$valueArr);
        $combined .= ($keyStr);
        
        return $combined;
    }
	
	switch($ts){
	
		//采集配置
		case "":
		
			$item_cate = $new['share']->Taobaocats();
			
			include template("admin/spider");
			break;
			
		//ajax获取分类
		case "ajax_get_tb_cate":
		
			$cid = $_GET['cid'];
			$item_cate = $new['share']->Taobaocats($cid);
			$json['data'] = $item_cate;
			$item_cate?$json['status']=1:$json['status']=0;
			outputJson($json);
			
			break;
			
		
		case  "search":
        	//搜索结果
			$taobaoke_item_list = array();
				$map['keyword'] = _get('keyword', 'trim'); //关键词
				$map['cid'] = _get('cid', 'intval'); //分类ID
				$p = _get('p', 'intval', 1);
				//淘宝只提供400数据
				if ($p > 10) {
					//redirect('collect_alimama/search', array('keyword' => $map['keyword'], 'cid' => $map['cid'], 'search' => 1));
				}
				if (!$map['keyword'] && !$map['cid']) {
					qiMsg("分类和关键词至少设置一个！");
				}
				
				$map['start_price']                = _get('start_price', 'trim'); //价格下限
				$map['end_price']                  = _get('end_price', 'trim'); //价格上限
				$map['start_commissionRate']       = _get('start_commissionRate', 'trim'); //佣金比率下限
				$map['end_commissionRate']         = _get('end_commissionRate', 'trim'); //佣金比率上限
				$map['start_commissionNum']        = _get('start_commissionNum', 'intval'); //30天推广量下限
				$map['end_commissionNum']          = _get('end_commissionNum', 'intval'); //30天推广量上限
				$map['start_totalnum']             = _get('start_totalnum', 'intval'); //总销量下限
				$map['end_totalnum']               = _get('end_totalnum', 'intval'); //总销量上限
				$map['start_credit']               = _get('start_credit', 'trim'); //卖家信用下限
				$map['end_credit']                 = _get('end_credit', 'trim'); //卖家信用上限
				$map['mall_item']                  = _get('mall_item', 'intval'); //是否天猫商品
				$map['guarantee']                  = _get('guarantee', 'intval'); //是否消保卖家
				$map['sevendays_return']           = _get('sevendays_return', 'intval'); //是否支持7天退换
				$map['real_describe']              = _get('real_describe', 'intval'); //是否先行赔付
				$map['cash_coupon']                = _get('cash_coupon', 'intval'); //是否支持抵价券
				$map['sort']                       = _get('sort', 'trim'); //排序方法
				$map['like_init']                  = _get('like_init', 'trim');
				$map['p']                  		   = '';
				
				$url = combineURL('index.php?app=share&ac=admin&mg=spider&ts=search',$map);
				
				$result = $new['share']->_get_list($map, $p);
				
				//分页

				//列表内容
				
				$taobaoke_item_list = $result['item_list'];
				$taobaoke_item_list && F('taobaoke_item_list', $taobaoke_item_list);
			$pageUrl = pagination($result['count']>200?200:$result['count'], 20, $p, $url);
			include template("admin/search");
   		 break;
		 
		case  "publish":
        	//发布已选商品
			
				$url = _post('url');
				$ids = implode(',',_post('num_iid'));
			    $users  = $db->fetch_all_assoc("select userid,username FROM ".dbprefix."user_info");
				$userarray=array();
				foreach($users as $key=>$item){
					$userarray[]=$item;
				}
				include template("admin/publish");	
			
			
		break;
		
		case  "redirect":
		
			$url = _post('url')?urlencode(_post('url', 'trim')):urlencode(_get('url', 'trim'));
			$ids = _post('ids', 'trim')?_post('ids', 'trim'):_get('ids', 'trim');
			$catename = _post('catename', 'trim')?_post('catename', 'trim'):_get('catename', 'trim');
			$i=_get('step', 'trim',0);
			$i=$i+1;
			
			$stop = false;//采集完毕
			$isExists=false;//商品存在
			$Cantresizeimage=false;//无法生成缩略图
			
			//从缓存中获取本页商品数据
			$ids_arr = explode(',', $ids);
			
			$taobaoke_item_list = F('taobaoke_item_list');
			$uid=$_REQUEST['auid'];
			
			$users  = $db->fetch_all_assoc("select userid FROM ".dbprefix."user");
			$users = arr2_arr1($users,'userid');
			if(!$uid){
			$users_key = array_rand($users);
			}else{
			$users_key = $uid;	
			}
			if ($ids_arr[$i-2]) {
				
				$result =$new['share']->publish_good($taobaoke_item_list[$ids_arr[$i-2]], $catename, $users[$users_key]);
				$result=='isExists' && $isExists = true;
				$result=='Cantresizeimage' && $Cantresizeimage = true;
			}
			
			if($i>=count($ids_arr)+1) $stop = true;
			
			include template("admin/redirect");	
			
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