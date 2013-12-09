<?php

	defined('IN_TS') or die('Access Denied.');
	$sort = _get('sort','trim','');
	$cate = urldecode($leac)=='index'?'':urldecode($leac);
	$page = _get('page','intval','1');
	$url = SITE_URL.tsurl('zhuti',$cate,array('sort'=>$sort,'page'=>''));
	
	$lstart = $page*18-18;

	$sortarr = array('hf','hc');
	$sort = in_array($sort,$sortarr)?$sort:'';
	
	
		switch($sort){
		
		case 'hf':
		
		$orderby = 'likenum desc';
		
		break;
		
		case 'hc':
		
		$orderby = 'length(strgoodid) desc';
		
		break;
		
	}
	$orderby = $orderby?$orderby:'addtime desc';
	
	
	if($cate) $where =" where cate='".$cate."' ";
	
	$arrthemes = $db->fetch_all_assoc("select * from ".dbprefix."theme ".$where." order by istop desc,".$orderby." limit $lstart,18");
	
	$arrrecomthemes = $db->once_fetch_assoc("select * from ".dbprefix."theme where recom='1' order by istop desc, addtime desc limit 1");
	$arrrecomthemes['user']= aac('user')->getSimpleUser($arrrecomthemes['userid']);
	$arrrecomthemes['desc']= nl2br($arrrecomthemes['desc']);
	$obtopStyle = json_decode($arrrecomthemes['topStyle']);
	$arrtopStyle = (array)$obtopStyle;
	$arrtopStyle['backgroundColor']=$arrtopStyle['backgroundColor']?$arrtopStyle['backgroundColor']:'#FEDFD8';
	
	$themeNum = $db->once_fetch_assoc("select count(themeid) from ".dbprefix."theme".$where);
	$pageUrl = pagination($themeNum['count(themeid)'], 18, $page, $url);

	foreach($arrthemes as $key=>$item){
		$arrtheme[] = $item;
		$arrtheme[$key]['user']  = aac('user')->getSimpleUser($item['userid']);
		$strcmt= $db->once_fetch_assoc("select count_comment from ".dbprefix."group_topics where topicid='".$item['topicid']."'");
		$arrtheme[$key]['count_cmt']=$strcmt['count_comment']?$strcmt['count_comment']:'0';
		if($item['strgoodid']){
			if(empty($item['simg'])){
			$simgurl = aac('zhuti')->themesimg($item['strgoodid']);
			$db->query("update ".dbprefix."theme set `simg`='$simgurl' where themeid='".$item['themeid']."'");
			}
		
		}else{
		$arrtheme[$key]['simg']='images/none-z-b.gif';	
		}
	}
	
	//主题达人
	$arrdarens = $db->fetch_all_assoc("select * from ".dbprefix."user_info where darenid>0 order by rand() limit 5");
	
	foreach($arrdarens as $key=>$item){
		
		$arrdaren[] = $item;
		$u =aac('user')->getOneUserByUserid($item['userid']);
		$arrdaren[$key]['face']=$u['bigface'];
		$t= $db->once_fetch_assoc("select themeid,title from ".dbprefix."theme where userid='".$item['userid']."'");
		$arrdaren[$key]['theme']=$t['title'];
		$arrdaren[$key]['themeid']=$t['themeid'];
		$arrdaren[$key]['isfollow'] =  aac('user')->isfollow($TS_USER['user']['userid'],$item['userid']);
	}
	
	
	//最近在讨论
	$arrnewtopics = $db->fetch_all_assoc("select topicid,title from ".dbprefix."group_topics where typeid=1 and count_comment>0 order by uptime desc limit 10");


	foreach($arrnewtopics as $key=>$item){
		
	$arrnewtopic[] = $item;
	$arrComment = $db->once_fetch_assoc("select * from ".dbprefix."group_topics_comments where `topicid`='".$item['topicid']."' order by addtime desc");
	$athemeid = $db->once_fetch_assoc("select themeid from ".dbprefix."theme where `topicid`='".$item['topicid']."'");
	$arrnewtopic[$key]['themeid'] = $athemeid['themeid'];
	$arrnewtopic[$key]['user'] = aac('user')->getUserForApp($arrComment['userid']);
	$arrnewtopic[$key]['content'] = editor2html($arrComment['content']);
	
	}
	
	
	$arruser =  aac('user')->getNewUser(16);
	
	$arrTag =aac('sharetag')->getmoreTag(8);
	
	$title = '主题街 - 创建我喜欢的主题';
	if($cate){
	$title = $cate.' - 主题街 - 创建我喜欢的主题';
	}
	$zhutimessage=array();
	foreach($LE_APPone as $cakey => $caitem){
			//根据cate获取该cate下前三个主题
			$zhutimessage[$cakey]['cate']=$caitem;
			$zhutiarray = $db->fetch_all_assoc("select * from ".dbprefix."theme where cate = '".$caitem."' order by istop desc,recom desc,uptime desc limit 0,3 ");
			//本周热榜
			$zhutitoparray = $db->fetch_all_assoc("select * from ".dbprefix."theme where cate = '".$caitem."' order by likenum desc,istop desc,uptime desc limit 0,6 ");
			//获取用户信息
			foreach($zhutitoparray as $ztopkey=>$ztopitem){
				$zhutimessage[$cakey]['zttop'][$ztopkey]=$ztopitem;
				if($ztopitem['strgoodid']!=NULL){
				$goodsnumarray=explode(",",$ztopitem['strgoodid']);
				$zhutimessage[$cakey]['zttop'][$ztopkey]['goodsnum']=count($goodsnumarray);
				}else{
				$zhutimessage[$cakey]['zttop'][$ztopkey]['goodsnum']=0;	
				}
			}
			//查询每个主题下面的前9个商品
			foreach($zhutiarray as $ztakey=>$ztaitem){
				$zhutimessage[$cakey]['zt'][$ztakey]=$ztaitem;
				if($ztaitem['strgoodid']!=NULL){
				$goodsidarray=explode(",",$ztaitem['strgoodid']);
		        $zhutimessage[$cakey]['zt'][$ztakey]['goodsnum']=count($goodsidarray);
				$goodsidarray=array_slice($goodsidarray,-9,9);
					foreach($goodsidarray as $gikey=>$giitem){
			 
				$goodsmessage=$db->once_fetch_assoc("select goods_id,name,img from ".dbprefix."share_goods where goods_id = ".$giitem);
	  
				$zhutimessage[$cakey]['zt'][$ztakey]['goods'][$gikey]['goods_id']=$goodsmessage['goods_id'];
				$zhutimessage[$cakey]['zt'][$ztakey]['goods'][$gikey]['name']=$goodsmessage['name'];
				$zhutimessage[$cakey]['zt'][$ztakey]['goods'][$gikey]['simg']=$goodsmessage['img'];
				
				}
				}else{
				$zhutimessage[$cakey]['zt'][$ztakey]['goodsnum']=0;	
				}
			
				$zhutimessage[$cakey]['zt'][$ztakey]['user']=aac('user')->getOneUserByUserid($ztaitem['userid']);
			}
	}

	include template("index");