<?php

	defined('IN_TS') or die('Access Denied.');
	
	$goods_id = intval($goods_id);
	
	
	$strShare = $new['buy']->getOneShare($goods_id);

	$strShare['taoke_url'] = preg_replace('/mm_(.+)_0_0/','mm_'.$TS_SITE['base']['PID'].'_0_0',$strShare['taoke_url']);
	$buyurl = ($strShare['taoke_url'] =='null')||empty($strShare['taoke_url'])?$strShare['url']:$strShare['taoke_url'];
	
	$iitemid = aac('share')->getID($strShare['url']);
	
	include template("index");
	
	
	