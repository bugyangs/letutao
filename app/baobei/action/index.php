<?php
/* 
狗扑站长狗扑源码社区子 bbs.gope.cn 
 */
	defined('IN_TS') or die('Access Denied.');
	
	$goods_id = intval($goods_id);
	
	//试试手气
	$lucker = $db->fetch_all_assoc("select goods_id from ".dbprefix."share_goods order by rand() limit 1");
	
	$strShare = $new['baobei']->getOneShare($goods_id);
	
	if($goods_id == 0 || empty($strShare))
	{
		@header("http/1.1 404 not found"); 
		@header("status: 404 not found");
		include template("404");
		exit(); 
	}
	
	$arroldimg = explode('|',$strShare['oldimg']);
	
	$strShare['oldimg']=$arroldimg[0];
	//print_r($arroldimg);
	
	$arrshop_info = mb_unserialize($strShare['shop_info']);
	
	//兼容老版本，无数据则获取，打开2.0版本之前发布的商品可能会稍慢
	if(empty($strShare['shop_info'])){
		$url = $strShare['url'];
		include_once THINKROOT."/app/share/class.share.php";
		$share_module = new share($url);
		$result = $share_module->fetch();
		if($result['item']['seller_credit_score']&&$result['shop']){
		$db->query("update ".dbprefix."share_goods set `seller_credit_score`='".$result['item']['seller_credit_score']."',`shop_info`='".serialize($result['shop'])."' where goods_id='".$goods_id."'");
		}
	}
	
	
	//处理图片宽度
	if($strShare['oldimg_w']){
		$imgheigt =  $strShare['oldimg_h'];
		$imgwith =  $strShare['oldimg_w'];
	}else{
		$oldimg_info = getimagesize($strShare['oldimg']);
		$imgheigt =  $oldimg_info[1];
		$imgwith =   $oldimg_info[0];
		$db->query("update ".dbprefix."share_goods set `oldimg_w`='".$imgwith."',`oldimg_h`='".$imgheigt."' where goods_id='".$goods_id."'");
	}
	if($imgwith>470){
	$bl=$imgheigt/$imgwith;
	$w=470;
	$h=intval(470*$bl);
	}
	
	$strShare['tags'] = aac('sharetag')->getObjTagByObjid('share','goods_id',$goods_id);
	
	//相关商品
	$gi=1;
	foreach($strShare['tags'] as $gtkey=>$gtitem){
		if($gi<=5){
		 $xggoodsarray=$db->fetch_all_assoc("select goods_id from ".dbprefix."tag_share_goods where tagid=".$gtitem['tag_id']." and goods_id <>".$goods_id." limit 0,3");


		 foreach($xggoodsarray as $xggkey=>$xggitem){
			if(aac("baobei")->getOneShare($xggitem['goods_id']))
		  $strShare['tags'][$gtkey]['good'][$xggkey]=aac("baobei")->getOneShare($xggitem['goods_id']);
		 }
		 
		}
	 }
	 
	 
	

	//相关主题
	$zhuti=array();
	$zhutiarray = $db->fetch_all_assoc("select themeid,title,userid from ".dbprefix."theme where strgoodid like '%".$goods_id."%' limit 0,10");
	
    foreach($zhutiarray as $ztkey=>$zhuitem){
    $zhuti[$ztkey]=$zhuitem;
	$zhutiuser=$db->once_fetch_assoc("select username from ".dbprefix."user_info where userid =".$zhuitem['userid']);
	$zhuti[$ztkey]['user']=$zhutiuser['username'];
	}
    //喜欢的人
	$userlike=array();
	$likeuserarray = $db->fetch_all_assoc("select userid from ".dbprefix."share_goods_like where goods_id=".$goods_id." group by userid limit 0,10");//查询喜欢这件商品的前十位的ID

	foreach($likeuserarray as $ulkey=>$ulitem){
	$userlike[$ulkey]=$ulitem;
	$userlike[$ulkey]['user']=aac('user')->getSimpleUser($ulitem['userid']);//查询每个用户的用户名
	$userliketop3=$db->fetch_all_assoc("select goods_id from ".dbprefix."share_goods_like where goods_id!=".$goods_id." and userid=".$ulitem['userid']." order by addtime desc limit 0,3");//查询出每个每个用户喜欢的其他三件商品
	foreach($userliketop3 as $ultkey=>$ultitem){
	 $userlike[$ulkey]['top3'][$ultkey]=$ultitem;
	 $top3goods=$db->once_fetch_assoc("select name,img from ".dbprefix."share_goods where goods_id =".$ultitem['goods_id']);
	  $userlike[$ulkey]['top3'][$ultkey]['name']=$top3goods['name'];
	  
	  $userlike[$ulkey]['top3'][$ultkey]['img']=$top3goods['img'];
	}
	}


	//分享者开始
	$shareuserid = $strShare['uid'];
	
	$strshareUser = $db->once_fetch_assoc("select * from ".dbprefix."user_info where userid='$shareuserid'");
	
	//头像
		if($strshareUser['face'] != ''){
			$strshareUser['face'] = SITE_URL.miniimg($strshareUser['face'],'user',48,48,$strshareUser['path'],1);
			
		}else{
			$strshareUser['face']	= SITE_URL.'public/images/noavatar.gif';
		}
	
	//分享者结束
	

	
	//喜欢的人 4-23
	
	$arrLiker = $db->fetch_all_assoc("select * from ".dbprefix."share_goods_like where `goods_id`='$goods_id' and commentType = 0 order by addtime desc limit 16");
	
	foreach($arrLiker as $key=>$item){
		$arrLikers[] = $item;
		$arrLikers[$key]['user'] = aac('user')->getUserForApp($item['userid']);
	}
	
	//猜你喜欢
    $yourarray= $db->fetch_all_assoc("select * from ".dbprefix."share_goods order by goods_id desc limit 12");
	foreach($yourarray as $key=>$item){
		$your[$key] = $item;
	}


	//大图伪本地 6-22
	if($TS_SITE['base']['bigpic']==2){
	$imgbase64 = base64_encode($strShare['oldimg']);
	$strShare['oldimg'] = SITE_URL.'pic/'.$imgbase64.'.jpg';
	}

	//大图本地化 4-15
	
	
	if($strShare['bigpic'] && is_file($strShare['bigpic'])){
			$strShare['oldimg'] = SITE_URL.$strShare['bigpic'];
		}
	
	

	$title = $strShare['name'].' - '.$TS_SITE['base']['site_title'];
	
	
	$buyurl = ($strShare['taoke_url']!=='null')?$strShare['taoke_url']:$strShare['url'];
	
	//评论列表开始
	$sc = isset($_GET['sc']) ? $_GET['sc'] : 'desc';
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$url = SITE_URL.tsurl('baobei',$goods_id,array('page'=>''));
	$lstart = $page*10-10;
	
	$arrComment = $db->fetch_all_assoc("select * from ".dbprefix."share_goods_comments where `shareid`='$goods_id' order by addtime $sc limit $lstart,10");
	$CommentNum = $db->once_num_rows("select * from ".dbprefix."share_goods_comments where `shareid`='$goods_id'");
	foreach($arrComment as $key=>$item){
		$arrShareComment[] = $item;
		$arrShareComment[$key]['user'] = aac('user')->getUserForApp($item['userid']);
		$arrShareComment[$key]['content'] = t($item['content']);
		if($item['referid']){
		$arrShareComment[$key]['recomment'] = $new['baobei']->recomment($item['referid']);
		}
	}

	$pageUrl = pagination($CommentNum, 10, $page, $url,'#gocomment');
	
	$userid = intval($TS_USER['user']['userid']);
	$strUser = $db->once_fetch_assoc("select * from ".dbprefix."user_info where userid='$userid'");
		
		//头像
		if($strUser['face'] != ''){
			$strUser['face'] = SITE_URL.miniimg($strUser['face'],'user',48,48,$strUser['path'],1);
			
		}else{
			$strUser['face']	= SITE_URL.'public/images/noavatar.gif';
		}
	
	$arrbcount = $db->fetch_all_assoc("select * from ".dbprefix."share_goods_comments where `shareid`='$goods_id'");
	
	$commentNum = count($arrbcount);
	$LikeNum   = $strShare['count_like'];//喜欢人数
	$scountNum = $strShare['count_worth']+1;//认为值得
	$bcountNum = count($arrbcount)+1;//总鉴定
	
	$arrtag = aac('sharetag')->getObjTagByObjid('default','goods_id',$goods_id);
	if(is_array($arrtag)){
	foreach($arrtag as $item){
			$str .="'".$item['tag_id']."',";
		}
	$slen = strlen($str)-1;
	$strtagid = substr($str,0,$slen);
	$arrdefaulttag = $db->fetch_all_assoc("select goods_id from ".dbprefix."tag_default_goods where tagid in (".$strtagid.")");
		//筛选数组
		foreach($arrdefaulttag as $item){
			$str .="'".$item['goods_id']."',";
		}
		$slen = strlen($str)-1;
		$strtagid = substr($str,0,$slen);
	$arrfinds = $db->fetch_all_assoc("select * from ".dbprefix."share_goods where goods_id <>".$goods_id." and goods_id in (".$strtagid.") order by goods_id desc limit 10");
	}
	if(!is_array($arrfinds)){
	
	$arrfinds = $db->fetch_all_assoc("select * from ".dbprefix."share_goods where goods_id <>".$goods_id." order by goods_id desc limit 20");
	
	}
	$strcate = $db->once_fetch_assoc("select appname from ".dbprefix."goods_cate where cate_id='".$strShare['cate_id']."'");
	
	$cateappname = $strcate['appname'];//获取分类appname
	$db->query("update ".dbprefix."share_goods set `count_view`=count_view+1 where goods_id='".$goods_id."'");
	$istaobao = strstr($strShare['url'],'taobao');
	
	//SEO 增加商品页关键词和描述 0416
	foreach($strShare['tags'] as $item){
			$strwords .=$item['tag_name'].",";
		}
	$len=strlen($strwords);
	$strword = substr($strwords,0,$len-1);
	$keywords = !empty($strword)?$strword:$TS_SITE['base']['site_key'];
	$TS_SITE['base']['site_desc']  = $strShare['comment'];
	
	//通过淘点金转化链接
	$iitemid = aac('share')->getID($strShare['url']);
	$json = file_get_contents('http://g.click.taobao.com/display?pid='.$TS_SITE['base']['tdj_PID'].'&wt=0&rd=1&ct=itemid%3D'.$iitemid.'&st=1&rf='.urlencode(SITE_URL.'index.php?app=goodid&ac='.$goods_id).'&et=72267379&pgid=1');
	
	$taobao_info_m = json_decode(substr(str_replace('null_data(','',$json),0,-1),true);
	$taobao_info = $taobao_info_m['data']['items']['0'];
	
	
	include template("index");
	
	//大图本地化 4-17优化
	if($TS_SITE['base']['bigpic']==1){
		if($strShare['bigpic']&& is_file($strShare['bigpic'])){
			$strShare['oldimg'] = SITE_URL.$strShare['bigpic'];
		}else{
			$uptime = time();
			$fold = date('Ymd',$uptime);
			$CUTPIC = fileiimg($strShare['oldimg'],'bigpic/'.$fold,470,$h,'',0);
			$strShare['oldimg'] =SITE_URL.$CUTPIC;
			$db->query("update ".dbprefix."share_goods set `bigpic`='".$CUTPIC."' where goods_id='".$strShare['goods_id']."'");		}
	}