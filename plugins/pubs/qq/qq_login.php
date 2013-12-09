<?php
/**
 * PHP SDK for QQ登录 OpenAPI
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */

require_once("qqConnectAPI.php");
$qc = new QC();
$qc->qq_login();
//qq_login($_SESSION["appid"], $_SESSION["appkey"], $_SESSION["callback"]);
?>
