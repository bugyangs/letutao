<?php 


include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$ms  = $c->faxian_timeline(); // done
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息

$arr = $user_message;

//print_r($_SESSION['token']);
//exit;
$title = "新浪微博登录信息完善";

include 'get_user_info.html';