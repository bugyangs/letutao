<?php
defined('IN_TS') or die('Access Denied.');  
class pinpai{

	var $db;

	function pinpai($dbhandle){
		$this->db = $dbhandle;
	}

}
