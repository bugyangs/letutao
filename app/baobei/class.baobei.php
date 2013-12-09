<?php
/* 
狗扑站长狗扑源码社区子 bbs.gope.cn 
 */
defined('IN_TS') or die('Access Denied.');  

class baobei{


	function getOneShare($goods_id){
		
		global $db;
		
		$isShare = $db->once_num_rows("select * from ".dbprefix."share_goods where goods_id='$goods_id'");
		
		if($isShare == '0'){
			return '';
		}else{
			$strShare = $db->once_fetch_assoc("select * from ".dbprefix."share_goods where goods_id='$goods_id'");
			return $strShare;
		}
	}
	
		//Refer二级循环，三级循环暂时免谈
	function recomment($referid){
		global $db;
		$strComment = $db->once_fetch_assoc("select * from ".dbprefix."share_goods_comments where commentid='$referid'");
		$strComment['user'] = aac('user')->getUserForApp($strComment['userid']);
		$strComment['content'] = editor2html($strComment['content']);
		return $strComment;
	}

}
