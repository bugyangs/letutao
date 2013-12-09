<?php
defined('IN_TS') or die('Access Denied.');

	
	/* 
	 * 所有板块
	 */
	 
	$userid=$TS_USER['user']['userid'];

	$page = isset($_GET['page']) ? $_GET['page'] : '1';
	$url = SITE_URL.tsurl('group','allgroup',array('page'=>''));
	$lstart = $page*32-32;
	$arrGroups = $db->fetch_all_assoc("select groupid from ".dbprefix."group order by isrecommend desc , count_user desc limit $lstart,32");
	foreach($arrGroups as $key=>$item){
		$arrData[] = $new['group']->getOneGroup($item['groupid']);
	}
	foreach($arrData as $key=>$item){
		$arrGroup[] =  $item;
		$arrGroup[$key]['groupdesc'] = getsubstrutf8(t($item['groupdesc']),0,7);
		$arrGroup[$key]['groupicon'] = $arrGroup[$key]['groupicon']?$arrGroup[$key]['groupicon']:'public/images/group.gif';
	}
	$groupNum = $db->once_fetch_assoc("select count(groupid) from ".dbprefix."group");
	$pageUrl = pagination($groupNum['count(groupid)'], 32, $page, $url);

	
	/* 
	 * 我的板块
	 */

	$myGroup = $db->fetch_all_assoc("select * from ".dbprefix."group_users where userid='$userid'");
	
	
	//我加入的板块
	if(is_array($myGroup)){
		foreach($myGroup as $key=>$item){
			$arrMyGroup[] = $new[group]->getOneGroup($item['groupid']);
		}
	}
	
	$myCreateGroup = $db->fetch_all_assoc("select * from ".dbprefix."group where userid='$userid'");
	//我管理的板块
	if(is_array($myCreateGroup)){
		foreach($myCreateGroup as $key=>$item){
			
			$arrMyAdminGroup[] = $new[group]->getOneGroup($item['groupid']);
			
		}
	}
	
	$title = '查看所有板块';
	
	include template("allgroup");