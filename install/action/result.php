<?php 
defined('IN_TS') or die('Access Denied.');

$host = trim($_POST['host']);
$user = trim($_POST['user']);
$pwd = trim($_POST['pwd']);
$name = trim($_POST['name']);
$pre = trim($_POST['pre']);
$select_sql = trim($_POST['sql']);

$arrdb = array(
	'host'	=> $host,
	'user'	=> $user,
	'pwd'	=> $pwd,
	'name'	=> $name,
	'pre'	=> $pre,
);

//网站信息
$site_title = trim($_POST['site_title']);
$site_subtitle = trim($_POST['site_subtitle']);
$site_url = trim($_POST['site_url']);

//用户信息
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$username = trim($_POST['username']);

if(!preg_match("/^[\w_]+_$/",$pre)) qiMsg("数据表前缀不符合(例如：le_)");

if($site_title == '' || $site_subtitle=='' || $site_url=='') qiMsg("网站信息不能为空！");

if($email == '' || $password=='' || $username=='') qiMsg("用户信息不能为空！");

if(valid_email($email)==false) qiMsg("Email输入有误！");

include 'letutao/mysql.php';

$db = new MySql($arrdb);

if($db){
	
	$sql = file_get_contents('install/install.sql');
	$sql = str_replace('ts_',$pre,$sql);
	$array_sql = preg_split("/;[\r\n]/", $sql);
	
	foreach($array_sql as $sql){
		$sql = trim($sql);
		if ($sql){
			if (strstr($sql, 'CREATE TABLE')){
				preg_match('/CREATE TABLE ([^ ]*)/', $sql, $matches);
				$ret = $db->query($sql);
			} else {
				$ret = $db->query($sql);
			}
		}
	}
	
	//存入管理员数据
	$userid = $db->query("insert into ".$pre."user (`pwd`,`email`) values ('".md5($password)."','".$email."')");
	$db->query("insert into ".$pre."user_info (`userid`,`username`,`email`,`isadmin`,`addtime`,`uptime`) values ('$userid','$username','$email','1','".time()."','".time()."')");
	
	//更改网站信息
	$db->query("update ".$pre."system_options set `optionvalue`='$site_title' where `optionname`='site_title'");
	$db->query("update ".$pre."system_options set `optionvalue`='$site_subtitle' where `optionname`='site_subtitle'");
	$db->query("update ".$pre."system_options set `optionvalue`='$site_url' where `optionname`='site_url'");
	
	$arrOptions = $db->fetch_all_assoc("select * from ".$pre."system_options");
	foreach($arrOptions as $item){
		$arrOption[$item['optionname']] = $item['optionvalue'];
	}

	fileWrite('system_options.php','data',$arrOption);
	
	//生成配置文件
	$fp =  fopen(THINKDATA.'/config.inc.php','w');
	
	if(!is_writable(THINKDATA.'/config.inc.php')) qiMsg("配置文件(data/config.inc.php)不可写。如果您使用的是Unix/Linux主机，请修改该文件的权限为777。如果您使用的是Windows主机，请联系管理员，将此文件设为everyone可写");
	$config = "<?php\n"
					."	/*\n"
					."	 *数据库配置\n"
					."	 */\n"
					."	\n"
					."	\$TS_DB['sql']='".$select_sql."';\n"
					."	\$TS_DB['host']='".$host."';\n"
					."	\$TS_DB['user']='".$user."';\n"
					."	\$TS_DB['pwd']='".$pwd."';\n"
					."	\$TS_DB['name']='".$name."';\n"
					."	\$TS_DB['pre']='".$pre."';\n"
					."	define('dbprefix','".$pre."');\n";
	
	$fw =  fwrite($fp,$config);
	
	$strUser['email'] = $email;
	$strUser['password']	= $password;
	
	include 'install/html/result.html';
}else{
	include 'install/html/error.html';
}