<?php include template('header'); ?>
<div id="container">	

	<div class="content">

		<h2>登录<span class="fr">没有帐号？<a href="<?php echo SITE_URL;?><?php echo tsurl('user','register')?>">免费注册</a></span></h2>

		<div class="form">

			<fieldset class="out-login">

        		<legend>

        			1.使用这些帐号登录：

        		</legend>

        		<div class="field-box">

        			<div class="pt20 clearfix">	

<?php if(in_array('qq',$isL_Open)||in_array('sina',$isL_Open)||in_array('taobao',$isL_Open)) { ?>
<?php if(in_array('sina',$isL_Open)) { ?>
        				<a class="l-sina" href="<?php echo SITE_URL;?>index.php?app=pubs&ac=plugin&plugin=sina&in=sina_login" target="_blank">新浪微博登录</a>
                         <?php } ?>
 <?php if(in_array('qq',$isL_Open)) { ?>
        				<a class="l-qq" href="<?php echo SITE_URL;?>index.php?app=pubs&ac=plugin&plugin=qq&in=qq_login" target="_blank">QQ帐号登录</a>
                        <?php } ?>
<?php if(in_array('taobao',$isL_Open)) { ?>
                        <a class="l-tao" href="<?php echo SITE_URL;?>index.php?app=pubs&ac=plugin&plugin=taobao&in=tb_login" target="_blank">淘宝帐号登录</a>
<?php } ?>
 <?php } else { ?>
 <p style="padding-left:20px;">未启用第三方登陆方式...</p>
 <?php } ?>
        			</div>
<!--
        			<div class="share-link pt20 clearfix">	

        				<a class="s-alipay" href="#" target="_blank">支付宝</a>

        				<a class="s-tencent" href="#" target="_blank">腾讯微博</a>

        				<a class="s-douban" href="#" target="_blank">豆瓣</a>

        				<a class="s-renren" href="#" target="_blank">人人网</a>

        			</div>	
-->
        		</div>

    		</fieldset>

    		<fieldset class="reg">

        		<legend>

        			2.使用已注册的<?php echo $TS_SITE['base'][site_title];?>帐号登录：

        		</legend>

        		<div class="field-box pt25">

        		<form id="J_LoginForm" method="POST" action="<?php echo SITE_URL;?>index.php?app=user&ac=login&ts=do">

        			<div class="error-row" ><p class="error"></p></div>

					<div class="form-row">

						<label>Email：</label>

						<input type="text" class="base-input" name="email" id="email" value="" placeholder="" />

					</div>

					<div class="form-row">

						<label>密码：</label>

						<input type="password" class="base-input" name="pwd" id="password" value="" />

					</div>

					<div class="form-row">

						<label>&nbsp;</label>

						<input type="checkbox" class="check" name="cktime" value="1209600" checked="checked" />
						
						<span>两周内自动登录</span>

					</div>
					<input type="hidden" name="jump" value="<?php echo $jump;?>" />
					<div class="form-row">

						<label>&nbsp;</label>

						<input type="submit" class="bbl-btn submit" value="登录" />

						<a class="forgotlink" href="<?php echo SITE_URL;?><?php echo tsurl('user','forgetpwd')?>">忘记密码？</a>

					</div>

				</form>

				</div>

			</fieldset>

		</div>		

	</div><!--content end-->
	</div>
<?php include pubTemplate("JsConstant");?>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/do.min.js"></script>
<script>
(function(){
var b="?t="+GUANGER.staticVersion,a=function(a){return"<?php echo SITE_URL;?>js/"+a+b};Do.add("guang",{path:a("guang.min.js"),type:"js",requires:["tools","cookie"]});Do.add("tools",{path:a("jquery.tools.min.js"),type:"js"});Do.add("cookie",{path:a("jquery.cookie.min.js"),type:"js"});Do.add("share_guang",{path:a("share_guang.min.js"),type:"js",requires:["guang"]});Do.add("search_suggest",{path:a("search_suggest.min.js"),type:"js",requires:["guang"]});Do.add("localstorage",{path:a("localstorage.min.js"),type:"js"});Do.add("track_info",{path:a("track_info.min.js"),type:"js"});
    Do.add("guang_comment",{path:a("comment.min.js"),type:"js"});Do.add("add_topic_say",{path:a("add_topic_say.min.js"),type:"js"});Do.add("like_say",{path:a("like_say.min.js"),type:"js"});Do.add("common",{path:a("common.min.js"),type:"js",requires:["share_guang","search_suggest","localstorage"]});Do.global("guang");Do("common");Do("track_info");
})();
Do('ajaxfileupload');
</script>
<?php include template('footer'); ?>