<?php
/* 
狗扑站长狗扑源码社区子 bbs.gope.cn 
 */
defined('IN_TS') or die('Access Denied.');
require_once THINKROOT.'/plugins/bcs/bcs.class.php';
require_once THINKROOT.'/letutao/license.Oauth.class.php';
class system{
	var $db;
	var $license;
	function system($dbhandle){
		$this->db = $dbhandle;
		$this->license = new LetushuoOauth();
	}
	
	function DiskYun_baidu_upload($imgurl){
			
			global $DISK_YUN;
			if($this->is_object_exist($imgurl)==0&&is_file($imgurl)){
				
				$host = 'bcs.duapp.com';
				$ak = $DISK_YUN['AK'];
				$sk = $DISK_YUN['SK'];
				$bucket = $DISK_YUN['Bucket'];
				$object = '/'.$imgurl;
				$fileUpload = './'.$imgurl;
				
				$baiduBCS = new BaiduBCS ( $ak, $sk, $host );
				$p = array('acl'=>'public-read');
				$response = $baiduBCS->create_object ($bucket,$object,$fileUpload,$p);
				if (!$response->isOK ()) {
					return false;
				}else{
					if($DISK_YUN['isdel']) unlink($fileUpload);
					return true;
				}	
				
			}else{
				
				return true;
				
			}
	}
	
	function DiskYun_baidu_delete($imgurl){
			
			global $DISK_YUN;
			if(Bcs_exists($DISK_YUN['loadUrl'].$imgurl)==1){
				
				$host = 'bcs.duapp.com';
				$ak = $DISK_YUN['AK'];
				$sk = $DISK_YUN['SK'];
				$bucket = $DISK_YUN['Bucket'];
				$object = '/'.$imgurl;
				
				$baiduBCS = new BaiduBCS ( $ak, $sk, $host );
				 $response = $baiduBCS->delete_object ( $bucket, $object);
				if (!$response->isOK ()) {
					return false;
				}else{
					return true;
				}	
				
			}else{
				
				return true;
				
			}
	}
	
	function is_object_exist($imgurl) {
				global $DISK_YUN;
				$host = 'bcs.duapp.com';
				$ak = $DISK_YUN['AK'];
				$sk = $DISK_YUN['SK'];
				$bucket = $DISK_YUN['Bucket'];
				$object = '/'.$imgurl;
				
				$baiduBCS = new BaiduBCS ( $ak, $sk, $host );
				$bolRes = $baiduBCS->is_object_exist ( $bucket, $object );
		        return $bolRes == true ? 1 : 0;
		}

}