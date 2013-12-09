<?php
/* 
狗扑站长狗扑源码社区子 bbs.gope.cn 
*/
 
//定义网站根目录,APP目录,DATA目录，乐兔淘程序核心目录

define('IN_TS',true);

define('THINKROOT', dirname(__FILE__));
define('THINKAPP', THINKROOT.'/app');
define('THINKDATA',THINKROOT.'/data');
define('LETUTAO', THINKROOT.'/letutao');
define('THINKINSTALL',THINKDATA.'/install');
define('THINKPLUGIN',THINKDATA.'/plugins');

//装载Letutao核心
include 'letutao/letutao.php';
$TS_SOFT['info']['version'] ='v2.4';
//除去加载内核运行时间统计开始
$time_start = getmicrotime();
if(is_file(THINKROOT.'/data/config.inc.php')){
	//装载APP应用
	include 'app/index.php';
}else{
	//装载安装程序
	include 'install/index.php';
}
unset($GLOBALS);