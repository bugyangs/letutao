<?php

define('IN_DISCUZ', true);

define('UC_CLIENT_VERSION', '1.6.0'); //note UCenter 版本标识
define('UC_CLIENT_RELEASE', '20081031');

define('API_DELETEUSER', 1); //note 用户删除 API 接口开关
define('API_RENAMEUSER', 1); //note 用户改名 API 接口开关
define('API_GETTAG', 1); //note 获取标签 API 接口开关
define('API_SYNLOGIN', 1); //note 同步登录 API 接口开关
define('API_SYNLOGOUT', 1); //note 同步登出 API 接口开关
define('API_UPDATEPW', 1); //note 更改用户密码 开关
define('API_UPDATEBADWORDS', 1); //note 更新关键字列表 开关
define('API_UPDATEHOSTS', 1); //note 更新域名解析缓存 开关
define('API_UPDATEAPPS', 1); //note 更新应用列表 开关
define('API_UPDATECLIENT', 1); //note 更新客户端缓存 开关
define('API_UPDATECREDIT', 1); //note 更新用户积分 开关
define('API_GETCREDITSETTINGS', 1); //note 向 UCenter 提供积分设置 开关
define('API_GETCREDIT', 1); //note 获取用户的某项积分 开关
define('API_UPDATECREDITSETTINGS', 1); //note 更新应用积分设置 开关

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '1');

define('UC_ROOT', '../');
// note 普通的 http 通知方式
if (!defined('IN_UC')) {
	error_reporting(0);
	set_magic_quotes_runtime(0);

	defined('MAGIC_QUOTES_GPC') || define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	require_once UC_ROOT . './data/config.inc.php';
	require_once UC_ROOT . './api/uc_config.php';
	require_once UC_ROOT . './uc_client/client.php';
	$_DCACHE = $get = $post = array();

	$code = @$_GET['code'];
	parse_str(_authcode($code, 'DECODE', UC_KEY), $get);
	if (MAGIC_QUOTES_GPC) {
		$get = _stripslashes($get);
	} 

	$timestamp = time();
	if ($timestamp - $get['time'] > 3600) {
		exit('Authracation has expiried');
	} 
	if (empty($get)) {
		exit('Invalid Request');
	} 
	$action = $get['action'];

	require_once UC_ROOT . './uc_client/lib/xml.class.php';
	$post = xml_unserialize(file_get_contents('php://input'));

	if (in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcreditsettings', 'updatecreditsettings'))) {
		$uc_note = new uc_note();
		exit($uc_note -> $get['action']($get, $post));
	} else {
		exit(API_RETURN_FAILED);
	} 
	// note include 通知方式
} else {
	require_once UC_ROOT . './data/config.inc.php';
	require_once UC_ROOT . './api/uc_db_mysql.class.php';
	$GLOBALS['db'] = new dbstuff;
	$db_c = 'utf-8';
	$GLOBALS['db'] -> connect($TS_DB['host'], $TS_DB['user'], $TS_DB['pwd'], $TS_DB['name'], $pconnect, true, $db_c);
	$GLOBALS['tablepre'] = $TS_DB['pre'];
	unset($TS_DB['host'], $TS_DB['user'], $TS_DB['pwd'], $TS_DB['name'], $pconnect);
} 

class uc_note {
	var $dbconfig = '';
	var $db = '';
	var $tablepre = '';
	var $appdir = '';

	function _serialize($arr, $htmlon = 0) {
		if (!function_exists('xml_serialize')) {
			include_once UC_ROOT . './uc_client/lib/xml.class.php';
		} 
		return xml_serialize($arr, $htmlon);
	} 

	function uc_note() {
		$this -> appdir = substr(dirname(__FILE__), 0, -3);
		$this -> dbconfig = $this -> appdir . './config.inc.php';
		$this -> db = $GLOBALS['db'];
		$this -> tablepre = $GLOBALS['tablepre'];
	} 

	function test($get, $post) {
		return API_RETURN_SUCCEED;
	} 

	function deleteuser($get, $post) {
		$uids = $get['ids'];
		!API_DELETEUSER && exit(API_RETURN_FORBIDDEN);

		return API_RETURN_SUCCEED;
	} 

	function renameuser($get, $post) {
		$uid = $get['uid'];
		$usernameold = $get['oldusername'];
		$usernamenew = $get['newusername'];
		if (!API_RENAMEUSER) {
			return API_RETURN_FORBIDDEN;
		} 

		return API_RETURN_SUCCEED;
	} 

	function gettag($get, $post) {
		$name = $get['id'];
		if (!API_GETTAG) {
			return API_RETURN_FORBIDDEN;
		} 

		$return = array();
		return $this -> _serialize($return, 1);
	} 

	function synlogin($get, $post) {
		$uid = $get['uid'];
		$username = $get['username'];
		if (!API_SYNLOGIN) {
			return API_RETURN_FORBIDDEN;
		} 

		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		define('IN_TS', true);

		define('IN_TS', true);
		define('THINKROOT', UC_ROOT);
		define('THINKAPP', THINKROOT . '/app');
		define('THINKDATA', THINKROOT . '/data');
		define('THINKSAAS', THINKROOT . '/tuntron');
		define('THINKINSTALL', THINKROOT . '/install');
		define('THINKPLUGIN', THINKROOT . '/plugins');
		include THINKROOT . './data/config.inc.php';
		include THINKROOT . './tuntron/tuntron.php';
		include THINKROOT . './tuntron/sql/mysql.php';
		include THINKROOT . './tuntron/tsApp.php';
		$app = 'user';

		$db = new MySql($TS_DB);
		include_once THINKROOT . './app/' . $app . '/class.' . $app . '.php';
		$new[$app] = new $app($db);
		$data=uc_get_user($uid,1);
		
		// 更新登录时间，用作自动登录
		$new['user'] -> update('user_info', array('email' => $data[2],
				), array('uptime' => time(),
				)); 
		// 用户信息
		$userData = $new['user'] -> find('user_info', array('email' => $data[2],
				)); 
		// 记住登录Cookie，根据用户Email和最后登录时间
		if ($cktime != '') {
			setcookie("ts_email", authcode($userData['email'], 'ENCODE'), time() + $cktime, '/');
			setcookie("ts_uptime", authcode($userData['uptime'], 'ENCODE'), time() + $cktime, '/');
		} 
		// 用户session信息
		$sessionData = array('userid' => $userData['userid'],
			'username' => $userData['username'],
			'areaid' => $userData['areaid'],
			'path' => $userData['path'],
			'face' => $userData['face'],
			'count_score' => $userData['count_score'],
			'isadmin' => $userData['isadmin'],
			'uptime' => $userData['uptime'],
			);

		$_SESSION['tsuser'] = $sessionData; 
		// 用户userid
		$userid = $userData['userid']; 
		// 积分记录
		$new['user'] -> create('user_scores', array('userid' => $userid,
				'scorename' => '登录',
				'score' => '10',
				'addtime' => time(),
				));

		$strScore = $new['user'] -> find('user_scores', array('userid' => $userid,
				), 'sum(score) score'); 
		// 更新积分
		$new['user'] -> update('user_info', array('userid' => $userid,
				), array('count_score' => $strScore['score'],
				));
	} 

	function synlogout($get, $post) {
		if (!API_SYNLOGOUT) {
			return API_RETURN_FORBIDDEN;
		} 
		// note 同步登出 API 接口
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		_setcookie('Example_auth', '', -86400 * 365);
	} 

	function updatepw($get, $post) {
		if (!API_UPDATEPW) {
			return API_RETURN_FORBIDDEN;
		} 
		$username = $get['username'];
		$password = $get['password'];
		return API_RETURN_SUCCEED;
	} 

	function updatebadwords($get, $post) {
		if (!API_UPDATEBADWORDS) {
			return API_RETURN_FORBIDDEN;
		} 
		$cachefile = $this -> appdir . './uc_client/data/cache/badwords.php';
		$fp = fopen($cachefile, 'w');
		$data = array();
		if (is_array($post)) {
			foreach($post as $k => $v) {
				$data['findpattern'][$k] = $v['findpattern'];
				$data['replace'][$k] = $v['replacement'];
			} 
		} 
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'badwords\'] = ' . var_export($data, true) . ";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	} 

	function updatehosts($get, $post) {
		if (!API_UPDATEHOSTS) {
			return API_RETURN_FORBIDDEN;
		} 
		$cachefile = $this -> appdir . './uc_client/data/cache/hosts.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'hosts\'] = ' . var_export($post, true) . ";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	} 

	function updateapps($get, $post) {
		if (!API_UPDATEAPPS) {
			return API_RETURN_FORBIDDEN;
		} 
		$UC_API = $post['UC_API']; 
		// note 写 app 缓存文件
		$cachefile = $this -> appdir . './uc_client/data/cache/apps.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'apps\'] = ' . var_export($post, true) . ";\r\n";
		fwrite($fp, $s);
		fclose($fp); 
		// note 写配置文件
		if (is_writeable($this -> appdir . './config.inc.php')) {
			$configfile = trim(file_get_contents($this -> appdir . './config.inc.php'));
			$configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
			$configfile = preg_replace("/define\('UC_API',\s*'.*?'\);/i", "define('UC_API', '$UC_API');", $configfile);
			if ($fp = @fopen($this -> appdir . './config.inc.php', 'w')) {
				@fwrite($fp, trim($configfile));
				@fclose($fp);
			} 
		} 

		return API_RETURN_SUCCEED;
	} 

	function updateclient($get, $post) {
		if (!API_UPDATECLIENT) {
			return API_RETURN_FORBIDDEN;
		} 
		$cachefile = $this -> appdir . './uc_client/data/cache/settings.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'settings\'] = ' . var_export($post, true) . ";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	} 

	function updatecredit($get, $post) {
		if (!API_UPDATECREDIT) {
			return API_RETURN_FORBIDDEN;
		} 
		$credit = $get['credit'];
		$amount = $get['amount'];
		$uid = $get['uid'];
		return API_RETURN_SUCCEED;
	} 

	function getcredit($get, $post) {
		if (!API_GETCREDIT) {
			return API_RETURN_FORBIDDEN;
		} 
	} 

	function getcreditsettings($get, $post) {
		if (!API_GETCREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		} 
		$credits = array();
		return $this -> _serialize($credits);
	} 

	function updatecreditsettings($get, $post) {
		if (!API_UPDATECREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		} 
		return API_RETURN_SUCCEED;
	} 
} 
// note 使用该函数前需要 require_once $this->appdir.'./config.inc.php';
function _setcookie($var, $value, $life = 0, $prefix = 1) {
	global $cookiepre, $cookiedomain, $cookiepath, $timestamp, $_SERVER;
	setcookie(($prefix ? $cookiepre : '') . $var, $value,
		$life ? $timestamp + $life : 0, $cookiepath,
		$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
} 

function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), - $ckey_length)) : '';

	$cryptkey = $keya . md5($keya . $keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	} 

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	} 

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	} 

	if ($operation == 'DECODE') {
		if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		} 
	} else {
		return $keyc . str_replace('=', '', base64_encode($result));
	} 
} 

function _stripslashes($string) {
	if (is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = _stripslashes($val);
		} 
	} else {
		$string = stripslashes($string);
	} 
	return $string;
} 
