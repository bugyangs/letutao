<?php
defined('IN_TS') or die('Access Denied.');

$curlimg = new pic;

$gurl = str_replace(".jpg",'',$_GET["ac"]);

$url=$curlimg->url_base64_decode($gurl);

$strimg = $curlimg->get_file($url);
$img_file = $strimg; 
$fp = fopen($img_file, 'rb');
$content = fread($fp, filesize($img_file)); //二进制数据 
fclose($fp);
header('Content-Type: image/jpeg');
echo $content;

unlink($img_file); //清除缓存图片  