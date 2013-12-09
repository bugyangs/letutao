<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */

/*
 * @brief ErrorCase类，封闭异常
 * */
class ErrorCase{
    private $errorMsg;

    public function __construct(){
        $this->errorMsg = array(
            "20001" => "配置文件损坏或无法读取，请重新设置",
			"40001" => "配置文件不存在或为空，请到后台重新配置",
            "30001" => "状态不匹配。可能被CSRF攻击.",
            "50001" => "可能是服务器无法请求https协议可能未开启curl支持,请尝试开启curl支持，重启web服务器，如果问题仍未解决，请联系我们"
            );
    }

    /**
     * showError
     * 显示错误信息
     * @param int $code    错误代码
     * @param string $description 描述信息（可选）
     */
    public function showError($code, $description = '$'){
     


        echo "<meta charset=\"UTF-8\">";
        if($description == "$"){
            qiMsg($this->errorMsg[$code]);
        }else{
			echo "<h3>error:</h3>$code";
            echo "<h3>msg  :</h3>$description";
            exit();
        }
    }
    public function showTips($code, $description = '$'){
    }
}
