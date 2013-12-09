<?php
	/*
	 * API
	 */
	
	$userid = $_POST['userid'];
	$touserid = $_POST['touserid'];
	$content = $_POST['content'];
	
	if(empty($touserid) || empty($content)){
	
		echo '0';
		
	}else{
	
		$arrData = array(
			'userid'		=> $userid,
			'touserid'		=> $touserid,
			'content'		=> $content,
			'addtime'			=> time(),
		);
	
		$messageid = $db->insertArr($arrData,dbprefix.'message');
		
		echo '1';
		
	}