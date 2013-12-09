<?php
defined('IN_TS') or die('Access Denied.'); 
/*
 *Letutao 安装程序
 * @copyright (c) 2010-3000 Letutao All Rights Reserved
 * @code by QiuJun
 * @Email:qiniao@vip.qq.com
 */

//安装文件的IMG，CSS文件
$skins	= 'data/install/skins/';

//进入正题
$title = 'Letutao安装程序';

require_once 'action/'.$install.'.php';