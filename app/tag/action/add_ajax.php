<?php 
defined('IN_TS') or die('Access Denied.');
switch($ts){
	case "":
		
		$objname = $_GET['objname'];
		$idname = $_GET['idname'];
		$objid = $_GET['objid'];
		
		include template("add_ajax");
		break;
		
	case "do":
	
		$objname = $_POST['objname'];
		$idname = $_POST['idname'];
		$objid = $_POST['objid'];
		$tags = $_POST['tags'];
		
		$tagsid = $new['tag']->addTag($objname,$idname,$objid,$tags);
		
	$json['status'] = 1;
	outputJson($json);
	
		break;
}