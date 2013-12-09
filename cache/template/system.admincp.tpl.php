<!-- Put IE into quirks mode -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="70020765@qq.com" />
<meta name="Copyright" content="<?php echo $TS_SOFT['info'][copyright];?>" />
<title><?php echo $title;?> - <?php echo $TS_APP['options'][appname];?> - <?php echo $TS_SITE['base'][site_title];?></title>
<style type="text/css">

html {height:100%;max-height:100%;padding:0;margin:0;border:0;background:#fff;font-size:12px;font-family:Arial;
/* hide overflow:hidden from IE5/Mac */
/* \*/
overflow: hidden;
/* */
}

body{height:100%;max-height:100%;overflow:hidden;padding:0;margin:0; border:0;}

.midder{overflow:hidden; position:absolute; z-index:3; top:70px; width:100%;bottom:60px;}

*html .midder {top:0; height:100%; max-height:100%; width:100%; overflow:auto;position:absolute; z-index:3;border-bottom:60px solid #fff;padding-top:60px;}

.header{position:absolute;margin:0;top:0;display:block;width:100%;height:60px;background:#3A81C0;background-position:0 0; background-repeat:no-repeat;z-index:5;overflow:hidden;}
.header .logo{float:left;padding-top:10px;}

.header .right{margin-left:200px;overflow:hidden;}
.header .menu{overflow:hidden;padding-right:20px; position:absolute; top:35px; left:230px;}
.header .menu ul{margin:0;padding:0;overflow:hidden;}
.header .menu ul li{list-style:none;float:left;padding:6px 3px;color:#FFFFFF;font-size:12px;text-align:center;font-weight: bold;}
.header .menu ul li a{color:#FFFFFF;padding:15px 10px;}
.header .menu ul .select{background:#FFFFFF;border-radius: 4px 4px 0px 0px;}
.header .menu ul .select a{color:#555555;}

.header .user{padding:5px;font-size:12px;text-align:right;color:#FFFFFF;margin:0px 20px 0 0;}
.header .user a{color:#FFFFFF;margin-left:20px;}

.footer{position:absolute; margin:0;bottom:0;display:block;width:100%;height:50px;line-height:50px;font-size:1em;z-index:5;overflow:hidden;text-align:center;background:#F0F0F0;color:#999999;}
.lic_note{ color:#FFF; background-color:#F00; position:absolute; z-index:10000px; top:10px; left:450px;padding:3px 5px; }
.lic_note a { color:#FFF; font-weight:bold;}
a {color:#336699;text-decoration:none;}
img{border:none;}
</style>
<script src="public/js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script>
$(function(){
	   $(".menu li").click(function(){
			var index = $(this).index();
		   $(this).addClass("select").siblings().removeClass("select");
		})
	})
</script>
</head>
<body>

<div class="header">
<?php if($lic_r==10001) { ?>

<?php } elseif ($lic_r==10002) { ?>
<div class="lic_note"\>您当前使用的是测试授权码，如果正式上线请<a href="<?php echo SITE_URL;?>index.php?app=lic&ac=lication&le=re_lic">点击重新授权</a></div>
<?php } elseif ($lic_r==10003) { ?>
<div class="lic_note"\>您的授权信息存在问题，将影响部分功能，请<a href="http://bbs.gope.cn" target="_blank">联系客服</a>或<a href="<?php echo SITE_URL;?>index.php?app=lic&ac=lication&le=re_lic">重新授权</a></div>
<?php } elseif ($lic_r==10004) { ?>

<?php } ?>


<div class="logo"><a href="index.php?app=system"><img src="app/<?php echo $app;?>/skins/<?php echo $skin;?>/logo.gif" alt="乐兔淘管理中心" /></a></div>

<div class="user">
欢迎您，<?php echo $TS_USER['admin'][username];?> 
<a href="index.php" target="_blank">返回前台</a> 
<a href="index.php?app=system&ac=login&ts=out">[退出]</a>
</div>
<div class="menu">
<ul>
<li class="select"><a href="index.php?app=system&ac=main"  target="main">首页</a></li>
<li><a href="index.php?app=system&ac=options"  target="main">系统</a></li>
<li><a href="index.php?app=user&ac=admin&mg=options"  target="main">会员</a></li>
<li><a href="index.php?app=share&ac=admin&mg=goods&ts=list"  target="main">商品</a></li>
<li><a href="index.php?app=cate&ac=admin&mg=setcate"  target="main">分类</a></li>
<li><a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list"  target="main">标签</a></li>
<li><a href="index.php?app=group&ac=admin&mg=options"  target="main">板块</a></li>
<li><a href="index.php?app=system&ac=plugin&ts=list&apps=pubs"  target="main">登陆设置</a></li>
<li><a href="index.php?app=mail&ac=admin&mg=options"  target="main">邮件设置</a></li>
<li><a href="index.php?app=pubs&ac=plugin&plugin=counter&in=edit&ts=set"  target="main">统计</a></li>
<li><a href="index.php?app=common&ac=admin&mg=info&ts=about"  target="main">关于</a></li>
<li><a href="index.php?app=pubs&ac=plugin&plugin=gobad&in=edit&ts=set"  target="main">广告</a></li>
<li><a href="index.php?app=pubs&ac=plugin&plugin=sitemap&in=edit&ts=set"  target="main">sitemap</a></li>
<?php if($isupdate ==1) { ?>
<li><a href="index.php?app=update"  target="main">升级</a></li>
<?php } ?>
<li><a href="index.php?app=faxian&ac=plugin&plugin=links&in=edit&ts=set"  target="main">友情链接</a></li>
</ul>
</div>
</div>

<div class="footer">
<p>Copyright (C) <?php echo $TS_SOFT['info'][year];?> <a href="<?php echo $TS_SOFT['info'][url];?>"><?php echo $TS_SOFT['info'][name];?></a> <?php echo $TS_SOFT['info'][version];?>   <script language=javascript>
<!--
window["\x64\x6f\x63\x75\x6d\x65\x6e\x74"]["\x77\x72\x69\x74\x65\x6c\x6e"]("\u8d44\u6e90\u63d0\u4f9b\x3a\x3c\x61 \x68\x72\x65\x66\x3d\"\x68\x74\x74\x70\x3a\/\/\x62\x62\x73\x2e\x67\x6f\x70\x65\x2e\x63\x6e\/\" \x74\x61\x72\x67\x65\x74\x3d\"\x5f\x62\x6c\x61\x6e\x6b\" \x73\x74\x79\x6c\x65\x3d\"\x63\x6f\x6c\x6f\x72\x3a\x23\x33\x33\x36\x36\x30\x30\x3b\" \x3e\x3c\x62\x3e\u72d7\u6251\u6e90\u7801\u793e\u533a\x3c\/\x62\x3e\x3c\/\x61\x3e");
//-->
</script></p>
</div>

<div class="midder">
<iframe src="index.php?app=system&ac=main" id="main" name="main" width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow: visible;margin:0;padding:0;"></iframe>
</div>
</body>
</html>