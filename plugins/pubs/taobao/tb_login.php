<?php
/**
 * jsSDK for 淘宝登录
 * @version 1.0.0
 * @author 70020765@qq.com
 */

defined('IN_TS') or die('Access Denied.');
require_once("taobao.class.php");

function LoginUrl($top_appkey,$redirect_uri)
{
	$redirect_uri = urlencode($redirect_uri);
	return "https://oauth.taobao.com/authorize?response_type=code&state=".rand(1000,10000)."&client_id=".$top_appkey."&redirect_uri=".$redirect_uri;
}

$TaobaoLogin = new TaobaoLogin();

$lu = $TaobaoLogin->GetTaoBaoLoginUrl();

header("Location: ".$lu);

?>
