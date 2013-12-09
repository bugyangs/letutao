<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */
defined('IN_TS') or die('Access Denied.');
define("QQDEBUG", false);
if (defined("QQDEBUG") && QQDEBUG)
{
    @ini_set("error_reporting", E_ALL);
    @ini_set("display_errors", TRUE);
}

//include_once("session.php");

//$arrQQ = include_once("data.php");

//$_SESSION["appid"]    = $arrQQ['appid']; 

//$_SESSION["appkey"]   = $arrQQ['appkey']; 

//$_SESSION["callback"] = $arrQQ['siteurl']."index.php?app=pubs&ac=plugin&plugin=qq2&in=get_access_token"; 
