<?php
defined('IN_TS') or die('Access Denied.');  
class zhuti{

	var $db;

	function zhuti($dbhandle){
		$this->db = $dbhandle;
	}
	
	function themesimg($goodid)
	{
	
			if($goodid){
				$Onegood = $this->db->once_fetch_assoc("select oldimg from ".dbprefix."share_goods where goods_id in (".$goodid.")");
				$arrimg = explode('|',$Onegood['oldimg']);
				$simgurl= fileiimg($arrimg[0],'theme',270,180,'',1);
				if(!is_file($simgurl)){$simgurl= fileiimg($Onegood['oldimg'],'theme',270,180,'',1);}
				
				return $simgurl;
			}else{
				
				return '';
				
			}
			
			
		}
	

}
