<?php
defined('IN_TS') or die('Access Denied.');
//插件编辑
switch($ts){
	case "set":
		require_once(THINKROOT."/plugins/pubs/qq/Recorder.class.php");
		$Recorder = new Recorder();
		$arrData['scope'] = explode(',',$Recorder->readInc('scope'));
		include 'edit_set.html';
		break;
		
	case "do":
		$_POST['appid'] = trim($_POST['appid']);
		$_POST['appkey'] = trim($_POST['appkey']);
		$_POST['callback']=$_POST['siteurl'].'index.php?app=pubs&ac=plugin&plugin=qq&in=get_access_token';
		$_POST['scope'] = implode(",",$_POST['scope']);
      
		$setting = json_encode($_POST);
		
    	$setting = str_replace("\/", "/",$setting);

		$incFile = fopen(THINKROOT."/plugins/pubs/qq/inc.php","w+") or qiMsg("请设置API\comm\inc.php的权限为777");
    	if(fwrite($incFile, $setting)){
        	qiMsg("修改成功！");
    	}else{
       		qiMsg("Error！");
   		 }
		
		
		break;
}