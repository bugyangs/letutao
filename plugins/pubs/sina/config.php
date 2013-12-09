<?php
defined('IN_TS') or die('Access Denied.');

$arrSINA = include_once("data.php");
define( "WB_AKEY" , $arrSINA['appid'] );
define( "WB_SKEY" , $arrSINA['appkey'] );
define( "WB_CALLBACK_URL" , $arrSINA['siteurl'].'index.php?app=pubs&ac=plugin&plugin=sina&in=callback' );
