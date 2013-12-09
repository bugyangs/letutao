<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
	case "":

		$title = '发送系统通知';
		include template("system_note");
		break;
		
	case "do":
	
		$msg_userid = '0';
		$msg_content = _post('content');
		if(empty($msg_content)) qiMsg('系统通知不能为空...^_^');
		$arruser = $db->fetch_all_assoc("select userid from ".dbprefix."user");
		foreach($arruser as $item){
				aac('message')->sendmsg($msg_userid,$item['userid'],$msg_content);
		}
			qiMsg('系统通知全部发送成功...^_^');
		break;
}