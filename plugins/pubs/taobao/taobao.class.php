<?php
/**
 * jsSDK for 淘宝登录
 * @version 1.0.0
 * @author 70020765@qq.com
 */


/*
 * @taobao封装类，将常用的taobao登录请求操作封装在一起
 * */
require_once("Recorder.class.php");
class TaobaoLogin{
	
	function __construct(){
        $this->recorder = new Recorder();
    }

    public function GetTaoBaoLoginUrl()
	{
		
		$top_appkey = $this->recorder->readInc("appkey");
		$redirect_uri = $this->recorder->readInc("redirect_uri");
		$redirect_uri = urlencode($redirect_uri);
		return "https://oauth.taobao.com/authorize?response_type=user&client_id=".$top_appkey."&encode=utf-8&redirect_uri=".$redirect_uri;
	}

	public function CheckTaoBaoSign($top_parameters,$top_sign)
	
	{
		$top_appkey= $this->recorder->readInc("appkey");
		$top_secret= $this->recorder->readInc("appsecret");
		$sign = base64_encode(md5($top_parameters.$top_secret,true));
		return $sign == $top_sign;
	}

	public function GetTaoBaoParameters($top_parameters)
	{
		$parameters = array();
		parse_str(base64_decode(urldecode($top_parameters)),$parameters);
		return $parameters;
	}

	public function GetTaoBaoRefreshTokenUrl($sessionkey,$refreshToken)
	{
		$signs = array();
		$signs['appkey'] = $this->recorder->readInc("appkey");
		$signs['refresh_token'] = $refreshToken;
		$signs['sessionkey'] = $sessionkey;
		$sign = '';
		foreach($signs as $key=>$val)
		{
			$sign .= $key.$val;
		}
		$sign .= $this->recorder->readInc("appsecret");
		$signs['sign'] = strtoupper(md5($sign));
		return "http://container.open.taobao.com/container/refresh?".http_build_query($signs);
	}

	public function GetContents($url){
			if (ini_get("allow_url_fopen") == "1") {
				$response = file_get_contents($url);
			}else{
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_URL, $url);
				$response =  curl_exec($ch);
				curl_close($ch);
			}
	
			//-------请求为空
			if(empty($response)){
				$this->error->showError("50001");
			}
	
			return $response;
		}
}
