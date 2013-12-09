<?php 
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */
require_once("qqConnectAPI.php");
$qc = new QC();
$arr = $qc->get_user_info();

$str_info = base64_encode(getJson($arr));

//接口调用示例：

$title = "QQ帐号登录信息完善";

include 'get_user_info.html';