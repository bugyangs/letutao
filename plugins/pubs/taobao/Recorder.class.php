<?php
/**
 * jsSDK for 淘宝登录
 * @version 1.0.0
 * @author 70020765@qq.com
 */
class Recorder{
    private static $data;
    private $inc;

    public function __construct(){

        //-------读取配置文件
        $incFileContents = file_get_contents(THINKROOT."/plugins/pubs/taobao/inc.php");
        $this->inc = json_decode($incFileContents);
		
        if(empty($this->inc)){
             echo '配置文件不存在！';
        }

        if(empty($_SESSION['QC_userData'])){
            self::$data = array();
        }else{
            self::$data = $_SESSION['QC_userData'];
        }
    }

   public function write($name,$value){
        self::$data[$name] = $value;
    }

    public function read($name){
        if(empty(self::$data[$name])){
            return null;
        }else{
            return self::$data[$name];
        }
    }

    public function readInc($name){
        if(empty($this->inc->$name)){
            return null;
        }else{
            return $this->inc->$name;
        }
    }

    public function delete($name){
        unset(self::$data[$name]);
    }

    function __destruct(){
        $_SESSION['QC_userData'] = self::$data;
    }
}
