<?php
defined('IN_TS') or die('Access Denied.');
switch($ts){
	case "options":
		
		$arrData = array(
			'site_title' => trim($_POST['site_title']),
			'site_subtitle' => trim($_POST['site_subtitle']),
			'site_key' => trim($_POST['site_key']),
			'site_desc' => trim($_POST['site_desc']),
			
			'is_open' => intval($_POST['is_open']),
			'close_tip' => trim($_POST['close_tip']),
			
			'PID' => trim($_POST['PID']),
			'tdj_PID' => trim($_POST['tdj_PID']),
			'AppKey' => trim($_POST['AppKey']),
			'AppSecret' => trim($_POST['AppSecret']),
			'site_checkcode'	=> htmlspecialchars($_POST['site_checkcode']),
			
			'site_url' => trim($_POST['site_url']),
			'site_email' => trim($_POST['site_email']),
			'site_icp' => trim($_POST['site_icp']),
			'isface'	=> $_POST['isface'],
			'isgzip'	=> $_POST['isgzip'],
			'timezone'	=> $_POST['timezone'],
			'lang'	=> $_POST['lang'],
			'site_indexcut'	=> $_POST['indexcut'],
			'liststyle'	=> $_POST['liststyle'],
			'bigpic'	=> $_POST['bigpic'],
			'isucenter'	=> $_POST['isucenter'],
			'goodlink'	=> $_POST['goodlink'],
		);


		foreach ($arrData as $key => $val){
			$db->query("UPDATE ".dbprefix."system_options SET optionvalue='$val' where optionname='$key'");
		}
		
		$arrOptions = $db->fetch_all_assoc("select optionname,optionvalue from ".dbprefix."system_options");
		foreach($arrOptions as $item){
				$arrOption[$item['optionname']] = $item['optionvalue'];
		}
		
		fileWrite('system_options.php','data',$arrOption);
		
		qiMsg("系统选项更新成功，并重置了缓存文件^_^");
		
		break;
		
		case "diskyun":
		
		$arrData = array(
			'isopen' => _post('isopen','trim','0'),
			'YunCom' => _post('YunCom','trim','baidu'),
			'AK' => _post('AK','trim'),
			'SK' => _post('SK','trim'),
			'Bucket' => _post('Bucket','trim'),
			'loadUrl' => _post('loadUrl','trim'),
			'isdel' => _post('isdel','trim'),
		);
	
		foreach ($arrData as $key => $val){
			$db->query("UPDATE ".dbprefix."diskyun_options SET optionvalue='$val' where optionname='$key'");
		}
		
		$arrOptions = $db->fetch_all_assoc("select optionname,optionvalue from ".dbprefix."diskyun_options");
		foreach($arrOptions as $item){
				$arrOption[$item['optionname']] = $item['optionvalue'];
		}
		
		fileWrite('diskyun_options.php','data',$arrOption);
		
		qiMsg("云储存设置成功，并重置了缓存文件^_^");
		
		break;
		
		case "weibo":
			
		$arrOptions = fileRead('options.php','data','system');
		$arrOptions['site_sinaweibo'] = $_POST['site_sinaweibo'];
		$arrOptions['site_qqweibo'] = $_POST['site_qqweibo'];
		
		fileWrite('system_options.php','data',$arrOptions);
		
		qiMsg("微博地址设置成功，并重置了缓存文件^_^");
		
		break;
		
		
}