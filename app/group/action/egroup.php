<?php

//创建板块

defined('IN_TS') or die('Access Denied.');

$groupid = intval($_GET['groupid']);

$arrOne = $db->once_fetch_assoc("select * from ".dbprefix."group where groupid='$groupid'");

$title = '编辑板块';
include template("egroup");