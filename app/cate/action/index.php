<?php
	defined('IN_TS') or die('Access Denied.');
	
	//瀑布流&画板模式判断
	$_SESSION["style"] = in_array($_GET['style'],array('pin','boards')) ? $_GET['style'] :$_SESSION["style"];
	$is_pin=$_SESSION["style"]?$_SESSION["style"]:$TS_SITE['base']['liststyle'];
	
	//通过appname获取当前分类，不存在则404错误
	$strcate = $db->once_fetch_assoc("select * from ".dbprefix."goods_cate where appname = '".$cate_appname."' and parent_id=0");
	$cateid = intval($strcate['cate_id']);
	if($cateid==''||$ac!=='index'){
		@header("http/1.1 404 not found"); 
		@header("status: 404 not found");
		include template("404");
		exit();
	}
	
	//初始化商品排序&初始化商品数目
	$arrOptions['sort'] = $arrOptions['sort']?$arrOptions['sort']:'';
	$sumGoodsNum = 0;
	
	//get获取排序并过滤
	$sort = _get('sort','h',$arrOptions['sort']);
	if(!in_array($sort, array('count_like', 'count_worth', 'count_view', 'count_comment', '0~100', '100~200', '200~500', '500~9999999'))) {$sort = '';//防SQL注入
	}

	//get获取标签并设置编码
	$tag = _get('tag','h','');
	if(!IsUTF8($tag)) $tag=mb_convert_encoding($tag,'utf-8','gbk');
	if(IsUrlencode($tag)) $tag=urldecode($tag);//判断是否urlencode

	$catetagid = aac('sharetag')->getTagId($tag);//标签存在则通过标签名获取ID
	
	//初始化翻页字段P
	$page = isset($_GET['p']) ? intval($_GET['p']) : '1';
	
	//最新_通过cateid获取分类下的标签
	$catetags = aac('sharetag')->getObjTagByCateid_new($cateid);

	if($subcate){
		
		$subgoodsid= aac('sharetag')->getidbysubcate($cateid,$subcate);
	   
	  }else{
		  
		$where = $cateid ? "where cate_id = ".$cateid."" : "";
	}
	
	
	//SQL判断条件
	if($sort && strstr($sort,'0') ){
		$arrsort = explode('~',$sort);
		list($a,$b) = $arrsort;
		$order =  'price';
		$where = $where?$where.' and price > '.$a.' and price < '.$b:' where price >'.$a.' and price < '.$b;
	}elseif($sort && !strstr($sort,'0') ){
		$order = $sort;
	}else{
		$order = 'goods_id';
	}
	$adesc = strstr($sort,'0')?' asc':' desc';
	


	//翻页设置
	$url = SITE_URL.tsurl($cate_appname,'',url_array('p',''));
	$nexturl =SITE_URL.tsurl($cate_appname,'',url_array('p',$page+1));
	$lstart = $page*36-36;
	
	if($tag)
		{
			//如果当前分类下标签存在
			//默认标签并筛选数组
			$arrdefaulttag = $db->fetch_all_assoc("select goods_id from ".dbprefix."tag_default_goods where tagid='$catetagid'");
			foreach($arrgoodstag as $item){$str1 .="'".$item['goods_id']."',";}
			
			//用户选择标签并筛选数组，因有用户自定义了标签
			$arrgoodstag = $db->fetch_all_assoc("select goods_id from ".dbprefix."tag_share_goods where tagid='$catetagid'");
			foreach($arrdefaulttag as $item){$str2 .="'".$item['goods_id']."',";}
					

			//标题中包含标签名的商品并筛选数组
			$arr_likegoodstag = $db->fetch_all_assoc("select goods_id from ".dbprefix."share_goods where name like '%$tag%'");
			foreach($arr_likegoodstag as $item){$str3 .="'".$item['goods_id']."',";}
			
			//合并筛选结果并去除最后一个’,‘字符，得到sql的IN条件，IN查询效率不高有待改善。
			$str = $str1.$str2.$str3;
			$strtagid = substr($str,0,-1);
			
			$strtagid_arr = explode(',',$strtagid);
			$strtagid_arr = array_unique($strtagid_arr);
			$strtagid = implode(',',$strtagid_arr);
			
			if($strtagid){
				$where = $where?$where.' and':'where';
				$Goods = $db->fetch_all_assoc("select * from ".dbprefix."share_goods ".$where." goods_id in (".$strtagid.") order by istop desc , ".$order.$adesc." limit $lstart,36");
				$sumGoodsNum = $db->once_num_rows("select * from ".dbprefix."share_goods ".$where." goods_id in (".$strtagid.") order by istop desc , ".$order.$adesc);
			}
		
		
		}elseif($subcate){
			//如果标签组分类存在
				
				foreach($subgoodsid as $item){
						$str_sub .="'".$item['goods_id']."',";
					}
					$strtagid = substr($str_sub,0,-1);
					
					if($strtagid){
					$where = $where?$where.' and':'where';
					$Goods = $db->fetch_all_assoc("select * from ".dbprefix."share_goods ".$where." goods_id in (".$strtagid.") order by istop desc , ".$order.$adesc." limit $lstart,36");
					$sumGoodsNum = $db->once_num_rows("select * from ".dbprefix."share_goods ".$where."  goods_id in (".$strtagid.")  order by istop desc , ".$order.$adesc);
					}
					
					
		}else{
			$Goods = $db->fetch_all_assoc("select * from ".dbprefix."share_goods ".$where." order by istop desc , ".$order.$adesc." limit $lstart,36");
			$sumGoodsNum = $db->once_num_rows("select * from ".dbprefix."share_goods ".$where." order by istop desc , ".$order.$adesc);	
	
		}

	//无条件下显示当前分类下所有商品，url_array()函数为当前页面get参数数量判断。



	//最后对筛选出的商品数据进行调整
	$pageUrl = nopin_pagination($sumGoodsNum, 36, $page, $url);
	foreach($Goods as $key=>$item){
			$Good[] = $item;
			if($DISK_YUN['isopen']) {
				 aac('system')->DiskYun_baidu_upload($item['img']);
			}
			$Good[$key]['user'] = aac('user')->getSimpleUser($item['userid']);
			$Good[$key]['oldimg']=rtrim($Good[$key]['oldimg'], "|");
			$Good[$key]['OneComment'] = aac('share')->GetOneComment($item['goods_id']);
			}
			//判断显示类型，瀑布流或画板
			if($is_pin=='boards'){$Good =splitArrayc($Good,9);
		}
		
	
	//可根据SEO需求进行优化，如需帮助请到论坛讨论：bbs.tuntron.com
	$title =$tag?$tag." - ".$strcate['cate_name'].' - '.$TS_SITE['base']['site_title']:$strcate['cate_name'].' - '.$TS_SITE['base']['site_title'];
	
	
	//4.26伪静态修复
	
	
	$TS_SITE['base']['site_key']   = !empty($tag)?$tag.",".$strcate['seo_keywords']:$strcate['seo_keywords'];
	$TS_SITE['base']['site_desc']  = $strcate['seo_desc'];
	
	$is_pin=='pin'?include template("pin_index"):include template("index");