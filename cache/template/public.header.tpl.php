<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php if($ac=='index') { ?><?php echo $title;?><?php } else { ?><?php echo $title;?><?php if($TS_APP['options'][appname]) { ?>- <?php echo $TS_APP['options'][appname];?><?php } ?> - <?php echo $TS_SITE['base'][site_title];?><?php } ?></title>
<?php if($app=='faxian' || $app=='index'||$app=='cate') { ?>
<meta name="keywords" content="<?php echo $TS_SITE['base'][site_key];?>" /> 
<meta name="description" content="<?php echo $TS_SITE['base'][site_desc];?>" /> 
<?php } ?>
<?php if($app=='user'&&$ac=='space') { ?>
<meta name="keywords" content="<?php echo $TS_SITE['base'][site_key];?>" /> 
<meta name="description" content="<?php echo $TS_SITE['base'][site_desc];?>" /> 
<?php } ?>
<?php if($app=='baobei') { ?>
<meta name="keywords" content="<?php echo $keywords;?>" /> 
<meta name="description" content="<?php echo $TS_SITE['base'][site_desc];?>" /> 
<?php } ?>
<?php echo htmlspecialchars_decode($TS_SITE['base'][site_checkcode])?>

<link rel="icon" href="<?php echo SITE_URL;?>public/images/favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo SITE_URL;?>public/images/favicon.png" type="image/x-icon" />
<link href="<?php echo SITE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_URL;?>css/global.css" rel="stylesheet" type="text/css" />
<?php if($app=='index') { ?>
<link href="<?php echo SITE_URL;?>css/index.css" rel="stylesheet" type="text/css" />
<?php } ?>
<!--[if ie 6]>
<style type="text/css">
.header .g-logo a { display:block;width:135px;height:53px;background:url(<?php echo SITE_URL;?>images/logo.png) no-repeat;_background:none;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="<?php echo SITE_URL;?>images/logo.png",sizingMethod="crop");text-indent:-999px;overflow:hidden; } 
.header .g-slogan { float:right;height:22px;line-height:22px;margin-top:35px;padding:6px 5px 6px 15px;background:url(<?php echo SITE_URL;?>images/bg-slogan.png) no-repeat;_background:none;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="<?php echo SITE_URL;?>images/bg-slogan.png",sizingMethod="crop"); } 
.price_box {_background:none;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="<?php echo SITE_URL;?>images/pr_bg.png",sizingMethod="crop");}
</style>
<![endif]-->
</head>
<body id="J_Page">
<!--[if IE 6]>
<style>
.ie6_warning{width:100%;height:50px;background:#f7efb1;}
.ie6_warning_w{width:990px;margin:0px auto;text-align:center;}
.ie6_warning p{color:#4a3e04;line-height:32px;padding:9px 0px;height:32px;}
.ie6_warning p span{display:inline;zoom:1;line-height:32px;height:32px;vertical-align:top;padding-right:10px;}
.ie6_warning p a{display:inline;zoom:1;height:32px;width:50px;vertical-align:top;}
.ie6_warning p a img{display:inline;*zoom:1;height:32px;width:50px;}
</style>
<div class="ie6_warning"><div class="ie6_warning_w">
<p><span>您使用的浏览器内核为IE6，落后于全球76.2%的用户！推荐您直接升级到</span><a target="_blank" href="http://windows.microsoft.com/zh-cn/windows/upgrade-your-browser"><img src="http://www.letushuo.com/images/download_ie8.gif"></a></p>
</div></div>
<![endif]-->
<div class="thepage" style="width:100%;">
    <!--header-->
	<div class="header" id="header">
		<div class="m-head">
			<div class="layout980 clearfix">
				<h1 class="g-logo">
					<a href="<?php echo SITE_URL;?>"><?php echo $TS_SITE['base'][site_title];?><span class="goup"></span></a>
				</h1>
                <form method="get" action="<?php echo SITE_URL;?>index.php?app=faxian&ac=index">
	<div class="g-slogan">
     <input type="hidden" name="app" value="faxian">
											<input id="J_SearchKeyword" type="text" class="fl search-input-keyword" maxlength ="50" name="k" value="懒得逛了，我搜～" autocomplete="off"/>
			<a id="J_SearchBarSubmit" class="header-search-button fl" title="搜索"></a>
	</div>
</form>
		</div>
		</div>
		<div class="m-nav">
	<div class="layout980 clearfix pos-r">
		<ul class="channel clearfix">
        <?php if($TS_SITE['sysnav']['index']['is_show']) { ?>
			<li>
            <a <?php if($app==index) { ?>class=" on "<?php } ?> href="<?php echo SITE_URL;?><?php if($TS_SITE['base'][site_indexcut]!==index) { ?><?php echo tsurl(index)?> <?php } ?>"><?php echo $TS_SITE['sysnav']['index']['name'];?></a>
            <span>-</span>
            </li>
        <?php } ?>
      
			<li>
				<dl class="clearfix">
                  <?php if($TS_SITE['sysnav']['faxian']['is_show']) { ?>
					<dt><a <?php if($app==faxian) { ?>class=" on "<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl(faxian)?>"><?php echo $TS_SITE['sysnav']['faxian']['name'];?></a>
                     <span>-</span>
                  <?php } ?>
                    <?php if(is_array($TS_SITE['appnav'])) { ?>
                    <?php foreach((array)$TS_SITE['appnav'] as $key=>$item) {?>
                    <dd ><a <?php if($cate_appname==$key) { ?>class="on"<?php } ?>  href="<?php echo SITE_URL;?><?php echo tsurl($key)?>"><?php echo $item;?></a></dd>
                    <?php }?>
                    <?php } ?>
				</dl>
			</li>
    
			<li>
				<dl class="clearfix">
                  <?php if($TS_SITE['sysnav']['group']['is_show']) { ?>
					<dt>
                    <span>-</span>
                        <a  <?php if($app==group) { ?>class="on"<?php } ?>  href="<?php echo SITE_URL;?><?php echo tsurl(group)?>"><?php echo $TS_SITE['sysnav']['group']['name'];?></a>
                     
                    </dt>
					<?php } ?>
                    <?php if($TS_SITE['sysnav']['feed']['is_show']) { ?>
                   
					<dt class="pos-ie" id="feeds-xiaoxi">
                     <span>-</span>
                        <a <?php if($app==feed) { ?>class="on"<?php } ?>  href="<?php echo SITE_URL;?><?php echo tsurl(feed)?>"><?php echo $TS_SITE['sysnav']['feed']['name'];?></a>
                    </dt>
                    <?php } ?>
				</dl>
			</li>
              <?php if($TS_SITE['sysnav']['zhuti']['is_show']) { ?>
            <li class="first">
            <span>-</span>
				<a <?php if($app==zhuti) { ?>class=" on "<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl(zhuti)?>"><?php echo $TS_SITE['sysnav']['zhuti']['name'];?></a>
			</li>
            <?php } ?>
             <?php if($TS_SITE['sysnav']['tuan']['is_show']) { ?>
			<li class="first">
            <span>-</span>
				<a <?php if($app==tuan) { ?>class=" on "<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl(tuan)?>"><?php echo $TS_SITE['sysnav']['tuan']['name'];?></a>
			</li>
            <?php } ?>
		</ul>
		<a class="header-nav-search fr" title="搜索"></a>
		<!--<a class="btn-signIn fr" href="javascript:;" rel="signIn" >签到</a>-->
		<div class="shareIt fr">
			<a class="btn-sg" href="javascript:;">分享好东西<span class="arrow-dn"></span></a>
			<ul class="dropdown shareit-dropdown">
				<li class="sg-li"><a rel="shareGoods" href="javascript:;" class="hd-share-goods">发布宝贝</a></li>
				<li><a href="<?php echo SITE_URL;?><?php echo tsurl('user','createzt')?>" rel="nofollow" class="hd-create-topic">创作主题</a></li>
                <li><a href="javascript:void(0);" class="hd-create-pic add_pic" rel="shareimages">分享图片</a></li>
			</ul>
		</div>
        
        
         <?php if($TS_USER['user'] == '') { ?>
				<div class="regLogin fr clearfix">
			<a href="<?php echo SITE_URL;?><?php echo tsurl('user','login')?>">登录</a><span class="vline5">|</span><a href="<?php echo SITE_URL;?><?php echo tsurl('user','register')?>">注册</a>
			<span class="arrow-dn-r"></span>
            <?php if(in_array('qq',$isL_Open)||in_array('sina',$isL_Open)||in_array('taobao',$isL_Open)) { ?>
                <ul class="share-link login-dropdown">
                <?php if(in_array('qq',$isL_Open)) { ?>
                    <li><a class="s-qq" href="<?php echo SITE_URL;?>index.php?app=pubs&ac=plugin&plugin=qq&in=qq_login">QQ登录</a></li>
                <?php } ?>
                <?php if(in_array('sina',$isL_Open)) { ?>
                    <li><a class="s-tao" href="<?php echo SITE_URL;?>index.php?app=pubs&ac=plugin&plugin=taobao&in=tb_login">淘宝登录</a></li>
                <?php } ?>
                <?php if(in_array('taobao',$isL_Open)) { ?>
                    <li><a class="s-sina" href="<?php echo SITE_URL;?>index.php?app=pubs&ac=plugin&plugin=sina&in=sina_login">新浪微博登录</a></li>
                <?php } ?>
				</ul>
            <?php } ?>
		</div>
		<a class="unlogin-like fr clearfix" href="#">
			<div class="unlogin-like-png">
			</div>
			<span class="unlogin-like-text">喜欢(<span class="count"></span>)</span>
		</a>
        
        <?php } else { ?>
        
        <div class="xiaoxi-box fr clearfix">
			<a rel="xiaoxi" class="xiaoxi fl" href="javascript:;">消息<span class="messge-count" id="J_MessageTotalNum">N</span><span class="arrow-dn"></span></a>
			<ul class="dropdown xiaoxi-dropdown" style="display: none; width:85px;">
                <li><a href="<?php echo SITE_URL;?><?php echo tsurl('message','my')?>">系统消息<span class="messge-count" id="J_SystemMessageNum"></span></a></li>
                <li><a href="<?php echo SITE_URL;?><?php echo tsurl('user','fans',array(userid=>$TS_USER['user'][userid]))?>">粉丝<span class="messge-count" id="J_FanMessageNum"></span></a></li>
                <li><a href="javascript:;" id="J_CancelMessageAll">清除提示</a></li>
			</ul>
		</div>
        <div class="person fr clearfix">
			<a class="gohome" href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$TS_USER['user'][userid]))?>">
			<span class="userPhoto">
				<img src="<?php echo $hface;?>" alt="<?php echo $TS_USER['user'][username];?>">
			</span><?php echo $TS_USER['user'][username];?><span class="arrow-dn"></span></a>
			<ul class="dropdown set-dropdown" style="display: none; width:85px;">
				<li><a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$TS_USER['user'][userid]))?>">我的主页</a></li>
				<li><a href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>base))?>">帐号设置</a></li>
				<li class="last"><a href="<?php echo SITE_URL;?><?php echo tsurl('user','login',array(ts=>out))?>">退出</a></li>
			</ul>
		</div>
        <div id="J_MessageTipBox"></div>
        <?php } ?>
        
			</div>
</div>
</div>