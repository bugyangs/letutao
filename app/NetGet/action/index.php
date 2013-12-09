<?php 
defined('IN_TS') or die('Access Denied.');

		$LETUTAOkey	 = trim($_POST['LETUTAOkey']);

		$Gtype       = trim($_POST['Gtype']);
		$contentid	 = trim($_POST['content']);
		$litpic	     = trim($_POST['litpic']);
		$title	     = trim($_POST['title']);
		$userid      = trim($_POST['userid']);
		$arruserid   = explode(",",$userid);
		$i=rand(0,(count($arruserid)-1));
		$userid = $arruserid[$i];
		$json = array();
		$YOURkey     = '112266';//这里填写您的采集密钥,与ET软件内一致，请勿使用默认值，详见http://bbs.tuntron.com，防止被坏蛋利用...
         
		//采集密钥判断
		  if($LETUTAOkey!==$YOURkey){
			echo('[no]');
			echo('[err]密钥验证失败[/err]');
			exit;
		}
		
		if($Gtype=='mogujie'){
		
		//分析蘑菇街链接
		preg_match('/http:\/\/www.taobao.com\/webww\/ww.php\?ver=3\&gid=[0-9]*/',$contentid, $matches);
		$taobaoid =  str_replace('http://www.taobao.com/webww/ww.php?ver=3&gid=','',$matches[0]);
		}
	  
	  if($Gtype=='guang'){
		//分析逛链接
		$taobaoid =  $contentid;
		}
	
	if($Gtype=='alimama'){
		//分析逛链接
		$taobaoid =  $title;
		}
		
	  if($taobaoid){
		$url = 'http://item.taobao.com/item.htm?id='.$taobaoid;
		
		$return=aac('share')->get_goodinfo_by_url($url);
		$tag = explode(' ',$return['defaulttags']);
		$imgs = str_replace(' ',',',$return['pic_url']);
		
		$post=array(
			'title'=>$return['name'],
			'comment'=>$return['name'],
			'catename'=>$return['cate_name'],
			'info'=>$return['info'],
			'cate_id'=>$return['cate_id'],
			'defaulttags'=>$return['defaulttags'],
			'tags'=>$tag,
			'imgs'=>$imgs,
		);
		if($goodsid=aac('share')->add_good($post,$userid)){
			echo('[ok]');
		}
		else{
				echo('[no]');
				echo('[err]发布失败...[/err]');
				exit();
		}
	  }else{
		  
		  		echo('[no]');
				echo('[err]发布失败,无商品ID...[/err]');
				exit();
		  
		  
	  }