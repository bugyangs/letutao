<?php

/**
 * jsSDK for 淘宝登录
 * @version 1.0.0
 * @author 70020765@qq.com
 */
defined('IN_TS') or die('Access Denied.');

require_once("taobao.class.php");

$TaobaoLogin = new TaobaoLogin();
$is_valid = $TaobaoLogin->CheckTaoBaoSign(trim($_GET['top_parameters']),trim($_GET['top_sign']));
if($is_valid){
$info = $TaobaoLogin->GetTaoBaoParameters(trim($_GET['top_parameters']));
$info['taobao_access_token']=base64_encode(md5($info['nick'].$info['user_id'],true));
$istaobaouid = $db->once_num_rows("select * from ".dbprefix."user_info where `taobao_access_token`='".$info['taobao_access_token']."'");
if($istaobaouid > 0){
	$userData = $db->once_fetch_assoc("select * from ".dbprefix."user_info where `taobao_access_token`='".$info['taobao_access_token']."'");
	$_SESSION['tsuser']	= $userData;
		echo '<script>
			if(window.opener){
				window.opener.followGuang(100,"","","false",true);
			}
			window.close();	
		</script>';
		exit;
}else{
	header("Location: ".SITE_URL."index.php?app=pubs&ac=plugin&plugin=taobao&in=get_user_info&top_parameters=".trim($_GET['top_parameters'])."&top_sign=".trim($_GET['top_sign']));
}
	
};

?>