<?php

/*
	狗扑站长狗扑源码社区子bbs.gope.cn

	$Id: domain.php 1059 2011-03-01 07:25:09Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

class domaincontrol extends base {

	function __construct() {
		$this->domaincontrol();
	}

	function domaincontrol() {
		parent::__construct();
		$this->init_input();
		$this->load('domain');
	}

	function onls() {
		return $_ENV['domain']->get_list(1, 9999, 9999);
	}
}

?>