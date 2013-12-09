<?php
defined('IN_TS') or die('Access Denied.');
//统计用户数据

$sGoods = $db->fetch_all_assoc("select uid from ".dbprefix."share_goods where uid='$userid'");
$sGoodsNum = count($sGoods);

$lGoods = $db->fetch_all_assoc("select goods_id from ".dbprefix."share_goods_like where userid='$userid' and commentType ='0'");
$lGoodsNum = count($lGoods);
$Gnum = $lGoodsNum+$sGoodsNum;

$sthemes = $db->fetch_all_assoc("select themeid from ".dbprefix."theme where userid='$userid'");
$sthemesNum = count($sthemes);
$lthemes = $db->fetch_all_assoc("select themeid from ".dbprefix."share_theme_like where userid='$userid'");
$lthemesNum = count($lthemes);

$Tnum = $lthemesNum+$sthemesNum;

$afeedNum = $db->fetch_all_assoc("select * from ".dbprefix."feed where userid=$userid and feedtype = 'goods'");

$feedNum =count($afeedNum);


$ffnumuser = aac('user')->getSimpleUser($userid);

$fansNum =$ffnumuser['count_followed'];

$followNum =$ffnumuser['count_follow'];
