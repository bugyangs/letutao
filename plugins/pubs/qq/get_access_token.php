<?php

/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */
 
require_once("qqConnectAPI.php");
$qc = new QC();
$qc->qq_callback();

//将access token，openid保存起来！！！
//在demo演示中，直接保存在全局变量中.
//为避免网站存在多个子域名或同一个主域名不同服务器造成的session无法共享问题
//请开发者按照本SDK中comm/session.php中的注释对session.php进行必要的修改，以解决上述2个问题，
$_SESSION["token"]   = $qc->get_access_token();
$_SESSION["secret"]  = '';
$_SESSION["openid"]  = $qc->get_openid();

$isopenid = $db->once_num_rows("select * from ".dbprefix."user_info where `qq_openid`='".$_SESSION['openid']."'");

if($isopenid > 0){
	$userData = $db->once_fetch_assoc("select * from ".dbprefix."user_info where `qq_openid`='".$_SESSION['openid']."'");
	$_SESSION['tsuser']	= $userData;
	echo '<script>
	if(window.opener){
		window.opener.followGuang(100,"","","false",true);
	}
	window.close();	
</script>';
exit;
}else{
	header("Location: ".SITE_URL."index.php?app=pubs&ac=plugin&plugin=qq&in=get_user_info");
}

/*
echo "<p>现在您已经获取到了用户的关键数据</p>";
echo "<p>openid:".$result['openid']."用户唯一标识</p>";
echo "<p>token:".$result['oauth_token']."具有访问权限的token</p>";
echo "<p>secret:".$result['oauth_token_secret']."密钥</p>";
echo "<p>以上三个参数您应该保存下来，用于访问QQ互联的其他接口,比如:</p>";
echo "<p>点击<a href=\"../user/get_user_info.php\"    target=\"_blank\">获取用户信息</a></p>";
echo "<p>接下来您需要处理自己网站的登录逻辑，祝您使用QQ登录愉快</p>";
*/
//第三方处理用户绑定逻辑
//将openid与第三方的帐号做关联
//bind_to_openid();
?>