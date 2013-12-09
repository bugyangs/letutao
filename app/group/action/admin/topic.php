<?php
defined('IN_TS') or die('Access Denied.');
/* 
 * 板块内所有话题
 */

switch($ts){

	//话题列表
	case "list":
		$groupid = $_GET['groupid'];
		
		$strGroup = $db->once_fetch_assoc("select * from ".dbprefix."group where groupid='$groupid'");
		 
		//获取板块全部内容列表
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

		$url = 'index.php?app=group&ac=admin&mg=topic&ts=list&groupid='.$groupid.'&page=';
		
		$arrGroupContent = $new['group']->getGroupContent($page,20,$groupid);
		
		$groupContentNum = $new['group']->getGroupContentNum('groupid',$groupid);
		
		$pageUrl = pagination($groupContentNum, 20, $page, $url);
		
		include template("admin/topic_list");
		
		break;
		
	//话题编辑
	case "edit":
		$topicid = $_GET['topicid'];
		$strTopic = $db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid='$topicid'");

		include template("admin/topic_edit");
		
		break;
		
	//话题编辑执行 
	case "edit_do":
		$topicid = $_POST['topicid'];
		$arrData = array(
			'title' => $_POST['title'],
			'content' => $_POST['content'],
			'istop'	=> $_POST['istop'],
			'isshow' => $_POST['isshow'],
		);
		
		$db->updateArr($arrData,dbprefix.'group_topics','where topicid='.$topicid.'');
		
		header("Location: ".SITE_URL."index.php?app=group&ac=admin&mg=topic&ts=edit&topicid=".$topicid."");
		break;
	
	//话题是否显示 
	case "isshow":
		$topicid = $_POST['topicid'];
		$isshow	= $_POST['isshow'];
		$db->query("update ".dbprefix."group_topics set isshow='$isshow' where topicid = '$topicid'");
		echo '0';
		break;
		
	//删除话题
	case "del":
		$topicid = $_REQUEST['topicid'];
		$new['group']->deltopic($topicid);
		break;
}