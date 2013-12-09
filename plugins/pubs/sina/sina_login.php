<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
$isuser_info = $db->once_fetch_assoc("select * from ".dbprefix."user_info");
if(!isset($isuser_info['sina_access_token'])) $db->query("ALTER TABLE   ".dbprefix."user_info ADD `sina_access_token` char(64) NOT NULL default '' AFTER  `isqqt`");

header("Location:$code_url");
?>
