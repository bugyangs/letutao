<?php
defined('IN_TS') or die('Access Denied.');
//插件编辑
switch($ts){
	case "set":
		require_once(THINKROOT."/plugins/pubs/taobao/Recorder.class.php");
		$Recorder = new Recorder();
		include 'edit_set.html';
		break;
		
	case "do":
		$_POST['appkey'] = trim($_POST['appkey']);
		$_POST['appsecret'] = trim($_POST['appsecret']);
		$_POST['redirect_uri']=$_POST['siteurl'].'index.php?app=pubs&ac=plugin&plugin=taobao&in=get_access_token';

		$setting = json_encode($_POST);
    	$setting = str_replace("\/", "/",$setting);
		
		$incFile = fopen(THINKROOT."/plugins/pubs/taobao/inc.php","w+") or qiMsg("请设置API\comm\inc.php的权限为777");
    	if(fwrite($incFile, $setting)){
        	qiMsg("修改成功！");
    	}else{
       		qiMsg("Error！");
   		 }
		
		
		break;
}