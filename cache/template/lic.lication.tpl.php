<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>letutao 提示</title>

<style type="text/css">

<!--

body {

background-color:#F9F9EF;

font-family: Arial;

font-size: 12px;

line-height:150%;

text-align:center;

}

a{color:#F39; text-decoration:none; font-weight:bold}

.main {

width:500px;

background-color:#FFFFFF;

font-size: 12px;

color: #666666;

margin:50px auto 0;

list-style:none;

padding:20px;
border:#CCC 2px solid;

}

.main p {

line-height: 18px;

margin: 5px 20px;

font-size:12px;

}
td { font-size:12px}
.button {
    -moz-box-sizing: content-box;
    border: 1px solid #BBBBBB;
    border-radius: 5px 5px 5px 5px;
    color: #464646;
    cursor: pointer;
    font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
    font-size: 12px !important;
    line-height: 12px;
    padding: 6px 12px;
    text-decoration: none;
}
.button:hover{
    border-color: #666666;
    color: #000000;
}
.button{
    background:#F2F2F2;
}
.button:active{
    background: #EEEEEE;
}
.note {border:#F3F3F3 1px solid; padding:5px; background-color:#F5F5F5; margin-top:10px;}

.input-text, .measure-input, textarea, input.date, input.endDate, .input-focus {
/*border: 1px solid #A7A6AA;*/
height: 24px;
line-height:24px;
padding: 2px 0 2px 5px;
border: 1px solid #D0D0D0;
background: white url(<?php echo SITE_URL;?>app/system/skins/default/input.png) repeat-x;
font-family: Verdana, Geneva, sans-serif,"瀹嬩綋";
font-size: 12px;
}

-->

</style>
<script src="<?php echo SITE_URL;?>public/js/jquery.js" type="text/javascript"></script>
<script>
function check_auname(){ 
	if($("#auname").attr("value")==""){ 
		alert("授权名不能为空"); 
		$("#auname").focus(); 
		return false; 
	} 
	
} 

function check(){ 
	if($("#letutaocode").attr("value")==""){ 
		alert("授权码不能为空"); 
		$("#letutaocode").focus(); 
		return false; 
	} 
	
	if($("#lic_username").attr("value")==""){ 
		alert("请确认您的授权名"); 
		$("#lic_username").focus(); 
		return false; 
	} 
	$("#is_lod").show();
} 


</script>

</head>

<body>

<div class="main">
<?php if($options_lic['site_lication']) { ?>
<?php if($isurlcode>0) { ?>
<p>感谢您使用本系统！如有问题请到<a href="http://bbs.tuntron.com" target="_blank">橙创论坛</a>提问！</p>
<?php } elseif ($le==re_lic) { ?>
<form method="POST" action="<?php echo SITE_URL;?>index.php?app=lic&ac=lication&le=re_lic">
<input type="hidden" name="submit" value="1" />
<table width="500" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="126" height="37" align="right">管理员密码：</td>
    <td width="219"><input style="width:200px;"  type="password" class="input-text" name="adminpwd" value="" /></td>
    <td width="155"></td>
  </tr>
  
  <tr>
    <td height="35">&nbsp;</td>
 
    <td><input type="submit" class="button" value="重新授权" /></td>
    <td></td>
  </tr>
  
   </form>
<?php } else { ?>
<p>您的系统已存在授权码，或与当前域名不匹配！</p>
<a href="<?php echo SITE_URL;?>index.php?app=lic&ac=lication&le=re_lic">点击重新授权</a></p>
<?php } ?>
<?php } else { ?>
<p style="margin-bottom:20px;">您的软件没有授权,请输入授权码！<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=70020765&amp;site=qq&amp;menu=yes"><img style="padding-top:6px;" border="0" src="http://wpa.qq.com/pa?p=2:70020765:42" alt="点击这里给我发消息" title="点击这里给我发消息"></a></p>
<form method="GET" action="http://au.letushuo.com/index.php" target="_blank">
<input type="hidden" name="app" value="admindo" />
<input type="hidden" name="ac" value="lication" />
<input type="hidden" name="lic_type" value="letutao" />
<input type="hidden" name="loch_url" value="<?php echo $loch_url;?>" />
<table width="500" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="126" height="37" align="right">授权名：</td>
    <td width="219"><input style="width:200px;" id="auname" class="input-text" name="ucusername" value="" /></td>
    <td width="155"><input type="submit" class="button"  onclick="return check_auname()" value="获取授权码" /></td>
  </tr>
  
   </form>
   <form method="POST" action="<?php echo SITE_URL;?>index.php?app=lic&ac=lication&le=do">
  <tr>
    <td height="32"  align="right">授权码：</td>
    <td><input style="width:200px;" id="letutaocode" class="input-text" name="letutaocode" value="" /></td>
    <td>输入授权码</td>
  </tr>
  <tr>
    <td width="126" height="37" align="right">确认会员名：</td>
    <td width="219"><input style="width:200px;" id="lic_username" class="input-text" name="lic_username" value="" /></td>
    <td width="155"></td>
  </tr>
  
  <tr>
    <td width="126" height="37" align="right">即将授权的网址：</td>
    <td width="219"><input style="width:200px;" class="input-text" readonly="readonly" value="<?php echo $_SERVER['HTTP_HOST'];?>" /></td>
    <td width="155"></td>
  </tr>
 
  <tr>
    <td height="35">&nbsp;</td>
 
    <td><input type="submit" class="button" onClick="return check()" value="授权" />&nbsp;&nbsp;&nbsp;<span id="is_lod" style="display:none">正在授权，请稍等...</span></td>
    <td></td>
  </tr>
</table>
<div class="note">
<p align="left">1、输入您在授权中心的用户名,如果用QQ登陆的话，那么就是您的QQ网名。</p>
<p align="left">2、直接点击获取授权码</p>
<p align="left">3、将获取的授权码填写到授权码栏</p>
<p align="left">4、再次确认您的授权名</p>
<p align="left">5、提交授权</p>
<p align="left">6、本地授权不影响上线授权.本地授权域名必须为：127.0.0.1或localhost</p>
<p align="left">注：如果您还没有搞清楚如何授权的话，<a href="http://bbs.tuntron.com/forum.php?mod=viewthread&tid=12" target="_blank">点击这里</a></p>
</div>
</form>
<?php } ?>
</div>

</body>

</html>