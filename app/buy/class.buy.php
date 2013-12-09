<?php

defined('IN_TS') or die('Access Denied.');  

class buy{


	function getOneShare($goods_id){
		
		global $db;
		
		$isShare = $db->once_num_rows("select * from ".dbprefix."share_goods where goods_id='$goods_id'");
		
		if($isShare == '0'){
			header("Location: ".SITE_URL."index.php");
		}else{
			$strShare = $db->once_fetch_assoc("select * from ".dbprefix."share_goods where goods_id='$goods_id'");
			return $strShare;
		}
	}

}
