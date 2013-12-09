<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	$_SESSION['token'] = $token;
	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );

$isuid = $db->once_num_rows("select * from ".dbprefix."user_info where `sina_access_token`='".$_SESSION['token']['access_token']."'");
if($isuid > 0){
	$userData = $db->once_fetch_assoc("select * from ".dbprefix."user_info where `sina_access_token`='".$_SESSION['token']['access_token']."'");
	$_SESSION['tsuser']	= $userData;
	echo '<script>
			if(window.opener){
				window.opener.followGuang(100,"","","false",true);
			}
			window.close();	
		</script>';
		exit;
}else{
	header("Location: ".SITE_URL."index.php?app=pubs&ac=plugin&plugin=sina&in=get_user_info");
}


} else {
	  qiMsg("可能由于appkey有误！");
      exit;
}
?>
