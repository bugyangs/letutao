<?php

//创建板块

defined('IN_TS') or die('Access Denied.');

$arrOne = $db->fetch_all_assoc("select * from ".dbprefix."group_cates where catereferid='0'");

$title = '创建板块';
include template("create");