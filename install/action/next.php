<?php 
defined('IN_TS') or die('Access Denied.');

$site_url = getHttpUrl();
$dbname = 'letutao';

if(!function_exists("gd_info")){$gd = '不支持,无法处理图像';}
if(function_exists(gd_info)) {  $gd = @gd_info();  $gd = $gd["GD Version"];  $gd ? '&nbsp; 版本：'.$gd : '';}

function writable($var)
{
	$writeable = FALSE;
	$var = THINKROOT.'/'.$var;
	if(!is_dir($var))
	{
		@mkdir($var, 0777);
	}
	if (is_dir($var))
	{
		$var .= '/temp.txt';
		if (($fp = @fopen($var, 'w')) && (fwrite($fp, 'tapp')))
		{
			fclose($fp);
			@unlink($var);
			$writeable = TRUE;
		}
	}
	return $writeable;
}

function PWriteFile($filename, $content, $mode = 'ab')
{
	$filename = THINKROOT.'/'.$filename;
	
	if(!is_file($filename)){
		return FALSE;	
	}
	
	if (strpos($filename, '..') !== FALSE)
	{
		return FALSE;
	}
	$path = dirname($filename);
	if (!is_dir($path))
	{
		if (!mkdir($path, 0777))
		{
			return FALSE;
		}
	}
	$fp = @ fopen($filename, $mode);
	if ($fp)
	{
		flock($fp, LOCK_EX);
		fwrite($fp, $content);
		fclose($fp);
		@ chmod($filename, 0777);
		return TRUE;
	}
	return FALSE;
}


include 'install/html/next.html';