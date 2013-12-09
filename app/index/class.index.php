<?php
defined('IN_TS') or die('Access Denied.');  
class index{

	var $db;

	function index($dbhandle){
		$this->db = $dbhandle;
	}
	
	function cut_Img($tag_name,$w,$h,$cateid=''){
		
		$strtag = $this->db->once_fetch_assoc("select img from ".dbprefix."goods_tags where tag_name = '".$tag_name."'");
		
				
		
		if($strtag['img']){
			
			/*
				$uptime = time();
				$fold = date('Ymd',$uptime);
				$smimg= fileiimg($strtag['img'],'index/'.$fold,$w,$h,'',1);
			*/
				return $strtag['img'];
			
			}else{
				return 'images/none-z-b.gif';
			}
	}
	
	
}
