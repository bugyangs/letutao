<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?> - <?php echo $TS_APP['options'][appname];?> - <?php echo $TS_SITE['base'][site_title];?></title>

<style>
body{margin:0;padding:0;font-family:Arial,Helvetica,sans-serif;background:#3a81c0;}
.login{width:500px;margin:0 auto;background:#3a81c0 no-repeat url(app/<?php echo $app;?>/skins/<?php echo $skin;?>/loginbg.gif); overflow: hidden;margin-top:100px; }
.login .logo{float:left;margin-top: 100px;font-size:14px;color:#FFFFFF;width:230px;text-align:center;}

.login .logo a{color:#FFFFFF;border:none;text-decoration: none;}

.login .logo img{border:none;}

.login .info{float:left;margin:50px 0;}

.login .info a{color:#FFFFFF;text-decoration: none;font-size:12px;}

.login .info h1{font-size:16px;color:#FFFFFF;}

.login .info p{font-size:14px;color:#FFFFFF;}

.input-text, .measure-input, textarea, input.date, input.endDate, .input-focus {
/*border: 1px solid #A7A6AA;*/
height: 18px;
padding: 2px 0 2px 5px;
border: 1px solid #D0D0D0;
background: white url(app/system/skins/default/input.png) repeat-x;
font-family: Verdana, Geneva, sans-serif,"宋体";
font-size: 12px;
margin-top:2px;
}

/*按钮*/
.btn{color:#333;background:#f1f0f0;border:1px solid #c4c4c4;border-radius:2px;padding:4px 15px;display:inline-block;
cursor:pointer;text-decoration:none;overflow:visible;text-align:center;zoom:1;white-space:nowrap;margin-right:10px;font-family:inherit;position:relative;}
.btn:hover{background:#e9e7e7;}

.btn_submit{color:#FFFFFF; background:#318dd0; font-size:12px;  border-color:#106BAB #106BAB #0D68A9;}
.btn_submit:hover{background:#3486c1;}

</style>

</head>
<body>

<div class="login">

<div class="logo">
<a href="http://bbs.gope.cn/" target="_blank">
<img src="app/<?php echo $app;?>/skins/<?php echo $skin;?>/logo_login.png" alt="乐兔淘购物分享系统" />
<br />
www.tuntron.com
</a>
</div>

<div class="info">
<h1 style="height:24px;"></h1>
<div>
<form method="post" action="index.php?app=system&ac=login&ts=do">

<p>管理员Email<br />
<input class="input-text" style="width:200px;" name="email" /></p>
<p>密码<br /><input class="input-text" style="width:200px;" type="password" name="pwd" /></p>

<input  type="hidden" name="cktime" value="2592000">
<input class="btn btn_submit" type="submit" value="登录后台" /> <a href="index.php">返回首页</a>

</form>
</div>
</div>

</div>


</body>
</html>