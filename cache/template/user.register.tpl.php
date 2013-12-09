<?php include template('header'); ?>
<div id="container">

	<div class="content">

		<h2>注册<span class="fr">已有帐号？<a href="<?php echo SITE_URL;?><?php echo tsurl('user','login')?>">直接登录</a></span></h2>

<?php if($TS_APP['options'][isregister]=='2') { ?>
<p align="center">本站暂时关闭注册！</p>
<p align="center"><a href="<?php echo SITE_URL;?>">[返回首页]</a></p>
<?php } else { ?>

		<div class="form">        	

    		<div class="error-row-l" ><p class="error"></p></div>

			<fieldset class="out-login">

        		<legend>

        			1.无需注册，直接使用这些帐号登录：

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

        			2.上面的帐号都没有？免费注册一个<?php echo $TS_SITE['base'][site_title];?>帐号吧~

        		</legend>

        		<div class="field-box pt25 pl20">

        		<form  id="regForm" method="POST" action="<?php echo SITE_URL;?>index.php?app=user&ac=register&ts=do">

					<div class="form-row">

						<label>Email：</label>

						<input type="text" class="base-input" name="email" id="email" value="" placeholder="用于登录和找回密码" />

					</div>
					
					<div class="form-row">

						<label>密码：</label>

						<input class="base-input" type="password" id="pwd" name="pwd"  />

					</div>
					
					<div class="form-row">

						<label>重复：</label>

						<input class="base-input" type="password" id="repwd" name="repwd"  />

					</div>
					
					<div class="form-row">

						<label><?php echo $TS_HL['app'][1040];?></label>

						<input class="base-input" type="text" id="username" name="username" />

					</div>
					<input type="hidden" name="fuserid" value="<?php echo $fuserid;?>" />
					<div class="form-row pt10 clearfix">

						<label>&nbsp;</label>

						<input type="submit" class="bbl-btn submit" value="<?php echo $TS_HL['app'][1049];?>" style="cursor:pointer" />

					</div>

					<div class="form-row">

						<label>&nbsp;</label>

						<input type="checkbox" class="check" name="remember" value="1" checked="checked" />

						<span class="agreement gc6">我已阅读并同意<a href="<?php echo SITE_URL;?><?php echo tsurl('faxian','agreement')?>" target="_blank">《使用协议》</a></span>

					</div>

				</form>

				</div>

			</fieldset>

			

		</div>	
        
<?php } ?>	

	</div><!--content end-->

</div>

<?php include pubTemplate("JsConstant");?>

<script src="<?php echo SITE_URL;?>js/jquery-1.6.4.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo SITE_URL;?>js/jquery.tools.min.js"></script>

<script type="text/javascript" src='<?php echo SITE_URL;?>js/guang-min.js?t=20120106230000.js'></script>

<script type="text/javascript" src="<?php echo SITE_URL;?>js/jquery.pagination.js"></script>

<script type="text/javascript">

$(function() {	

	$("#regForm").validator();

	

	/*$(".out-login a").click(function(){

		var snsurl = $(this).attr("href");

		jQuery.guang.util.openWin(snsurl);

		return false;

	});*/

});
</script>
<?php include template('footer'); ?>