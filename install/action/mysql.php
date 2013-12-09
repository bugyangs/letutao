<?php 
defined('IN_TS') or die('Access Denied.');

$site_url = getHttpUrl();
$dbname = 'letutao';

/*从环境变量里取出数据库连接需要的参数*/
$host = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');
$port = getenv('HTTP_BAE_ENV_ADDR_SQL_PORT');
$user = getenv('HTTP_BAE_ENV_AK')?getenv('HTTP_BAE_ENV_AK'):'root';
$pwd = getenv('HTTP_BAE_ENV_SK');

include 'install/html/mysql.html';