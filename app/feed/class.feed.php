<?php
defined('IN_TS') or die('Access Denied.');
class feed{

	var $db;

	function feed($dbhandle){
		$this->db = $dbhandle;
	}
	
		//处理文字
	function getcontent($content)
	{
		$content = str_replace('[br]','<br>',$content);
		if(strpos($content,'[/font]')){
		$pattern = "/\[font([a-z][A-Z][0-9]*)\]/is";  
		$replacement = "";  
		preg_replace($pattern, $replacement, $content);
		
		
		}
		return $content;
		
	}
	
	
	//添加feed
	function addFeed($userid,$template,$data,$feedtype,$connectid=0){
		$userid = intval($userid);
		$data = addslashes($data);
		$this->db->query("insert into ".dbprefix."feed (`userid`,`feedtype`,`connectid`,`template`,`data`,`addtime`) values ('$userid','$feedtype','$connectid','$template','$data','".time()."')");
	}
	
	//获取Goods—feed
	function getGoodsFeed($arrFeeds){
		if(is_array($arrFeeds)){
		foreach($arrFeeds as $key=>$item){
	$data = mb_unserialize($item['data']);
	//print_r($data);
	
	if(is_array($data)){
		foreach($data as $key=>$itemTmp){
			$tmpkey = '{'.$key.'}';
			if($key=='link'||$key=='img'){
			$tmpdata[$tmpkey] = SITE_URL.$itemTmp;
			}else{
				
			$tmpdata[$tmpkey] = $itemTmp;
				
			}
		}
	}
	
	$goods_id = $data['goods_id'];
	
	
	
	$strShare =  $this->db->once_fetch_assoc("select count_comment,count_like from ".dbprefix."share_goods where goods_id='$goods_id'");

	$arrFeed[] = array(
	
		'feedid' => $item['feedid'],
		
		'user'	=> aac('user')->getSimpleUser($item['userid']),
		
		'content' => strtr($item['template'],$tmpdata),

		'data' => $data,
		
		'cmt'  => $strShare['count_comment'],
		
		'cle'  => $strShare['count_like'],
		
		'feedtype' => $item['feedtype'],
		
		'addtime' => $item['addtime'],
	);
	
}

return $arrFeed;
		}else{
			
			return '';
		}
	}
	
}