<?php 
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */
defined('IN_TS') or die('Access Denied.');

require_once("taobao.class.php");

$TaobaoLogin = new TaobaoLogin();
$is_valid = $TaobaoLogin->CheckTaoBaoSign(trim($_GET['top_parameters']),trim($_GET['top_sign']));
if($is_valid){
$info_arr = $TaobaoLogin->GetTaoBaoParameters(trim($_GET['top_parameters']));
$info_arr['taobao_access_token']=base64_encode(md5($info_arr['nick'].$info_arr['user_id'],true));
}else{
	
	echo '验证失败';
	exit;
	
}

//接口调用示例：

$title = "淘宝网帐号登录信息完善";

include 'get_user_info.html';