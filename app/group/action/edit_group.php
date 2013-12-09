<?php
	/* 
	 * 编辑板块信息
	 */
	defined('IN_TS') or die('Access Denied.');
	
	$groupid = intval($_GET['groupid']);
	
	$strGroup = $new['group']->getOneGroup($groupid);
	
	$strGroup['groupdesc'] = stripslashes($strGroup['groupdesc']);
	
	if($TS_USER['user']['userid'] != $strGroup['userid']) header("Location: ".SITE_URL."index.php");
	
	switch($ts){
		
		//编辑板块基本信息
		case "base":
			
			$title = '编辑板块基本信息';
			include template("edit_base");
			
			break;
		
		//编辑板块头像
		case "icon":

			$title = '修改板块头像';
			include template("edit_icon");
			
			break;
		
		//修改访问权限
		case "privacy":
	
			$title = '编辑板块权限';
			include template("edit_privacy");
			
			break;
		
		//友情板块
		case "friends":

			$title = '编辑友情板块';
			include template("edit_friends");
			
			break;
		
		//板块分类
		case "cate":
			
			$arrCate = array();
			
			$groupcateindexnum = $db->once_num_rows("select * from ".dbprefix."group_cates_index where groupid='$groupid'");
			
			if($groupcateindexnum > 0){
				$arrGroupCateIndex = $db->fetch_all_assoc("select * from ".dbprefix."group_cates_index where groupid='$groupid'");
				
				
				foreach($arrGroupCateIndex as $key=>$item){
					$strCate = $db->once_fetch_assoc("select * from ".dbprefix."group_cates where cateid='".$item['cateid']."'");
					$arrCate[] = $strCate;
				}
			}
			
			$title = '编辑板块分类';
			include template("edit_cate");
			
			break;
			
		//话题分类
		case "type":
			//调出类型
			$arrGroupType = $db->fetch_all_assoc("select * from ".dbprefix."group_topics_type where groupid='".$strGroup['groupid']."'");
			
			$title = '编辑话题分类';
			include template("edit_type");
			
			break;
		
	}