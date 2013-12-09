<?php
defined('IN_TS') or die('Access Denied.');  
class cate{

	var $db;

	function getuser($dbhandle){
		$this->db = $dbhandle;
	}

}
