<?php

/**
 *      &文件上传类&
 */
defined('IN_TS') or die('Access Denied.');
define('DS', '/');
class t_upload_file {

    var $folder;
    var $max_size;
    var $root_dir = 'uploadfile';
    var $limit_ext;
    var $lock_name = '';
	var $thisext;

    // only read
    var $size;
    var $filename;
    var $path;
    var $src;

    //private
    var $_file;

    function __construct($name,$exts='') { //PHP 5
    	if(empty($_FILES[$name])) {
    	    qiMsg('没有文件被上传。');
    	}
		
        $this->_file =& $_FILES[$name];
		
		$error = array(
		'1' => '上传的文件过大，超过了文件最大上传限度。',
		'2' => '上传的文件过大，超过了表单提交的上传限度。',
		'3' => '文件上传不完整。',
		'4' => '没有文件被上传。',
		'6' => '找不到临时文件夹。',
		'7' => '文件写入失败。',
		);
		
        if($this->_file['error'] > 0) {
            qiMsg($error[$this->_file['error']]);
        }
		
        $this->size = $this->_file['size'];
        
        $this->max_size = size_bytes(ini_get('upload_max_filesize'));
        if(!$exts) $exts = 'rar zip 7z txt jpg doc png pdf';//待调整
		
        $this->set_ext($exts);
		
    }

    function t_upload_file($name,$etxs='') { //PHP 4
        $this->__construct($name,$etxs);
    }

    function set_max_size($size) {
        $this->max_size = min($this->max_size, size_bytes($size . 'k'));
    }

    function set_ext($exts) {
        if(!$exts) return '';
        $exts = explode(' ', $exts);
        foreach($exts as $k => $v) {
            if(!$v) {
                unset($exts[$k]);
            } else {
                $exts[$k] = strtolower($v);
            }
        }
        if($exts) $this->limit_ext = $exts;
    }

    function _check() {
        if(!is_uploaded_file($this->_file['tmp_name'])) {
            qiMsg('global_upload_unkown');
        } elseif(!$this->is_upfile($this->_file['name'])) {
            @unlink($this->_file['tmp_name']);
            qiMsg('文件格式不正确，只允许上传以 %s 为后缀的文件。');
//        } if(filesize($this->_file['tmp_name']) != $this->_file['size']) {
//          @unlink($this->_file['tmp_name']);
//        	qiMsg('global_upload_size_invalid');
        } elseif($this->_file['size'] > $this->max_size) {
            @unlink($this->_file['tmp_name']);
            qiMsg(sprintf(lang('global_upload_szie_thraw'), floor($this->max_size/1024) ,'KB'));
        }
        return TRUE;
    }

    function upload($folder, $subdir = 'MONTH') {
        
        $this->_check();
        
        $this->folder = $folder;
        $path = THINKROOT.'/' . $this->root_dir ."/". $this->folder;
        if(!@is_dir($path)){
            if(!@mkdir($path, 0777)) {
               qiMsg('global_mkdir_no_access');
            }
        }

        if($subdir == 'MONTH') {
            $subdir = date('Y-m', time());
        } elseif($subdir == 'DAY') {
            $subdir = date('Y-m-d', time());
        }
        if($subdir) {
            $dirs = explode(DS, $subdir);
            //vp($dirs);
            foreach ($dirs as $val) {
                $path .= DS . $val;
                if(!@is_dir($path)) {
                    if(!@mkdir($path, 0777)) {
                       qiMsg('global_mkdir_no_access');
                    }
                }
            }
        }

        $fileinfo = pathinfo($this->_file['name']);
        $ext = strtolower($fileinfo["extension"]); 

        if(!$this->lock_name) {
            PHP_VERSION < '4.2.0' && srand();
            $rand = rand(1, 100);
            $name = $rand . '_' . time() . '.' . $ext;
            unset($rand);
        } else {
            $name = $this->lock_name . '.' . $ext;
        }
        $sorcuefile = $path . DS . $name;

        if (@move_uploaded_file($this->_file['tmp_name'], $sorcuefile)) {
            $this->filename = $name;
            $this->path = str_replace(THINKROOT, '', $path);
            $this->src = str_replace(DS, '/', $this->loacl_path);
            $this->delete_tmpfile();
            return TRUE;
        } else {
            qiMsg('global_upload_lost');
        }
    }

    function delete_tmpfile() {
        @unlink(str_replace("\\\\", "\\", $this->_file['tmp_name']));
    }

    function delete_file() {
        @unlink($this->path.'/'.$this->filename);
    }

    function is_upfile($filename) {
        $ext =$this->thisext= strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if(!$ext) return FALSE;
        return in_array($ext, $this->limit_ext);
    }

}