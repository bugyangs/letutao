<?php include template('header'); ?>
<link href="<?php echo SITE_URL;?>css/setting.css" rel="stylesheet" type="text/css" />
<div id="wrap">
		<div id="container">
			<div class="content clearfix">
				<?php include template('set_menu'); ?>				
             <div class="main-content">
					<div class="set-info">
						<form class="set-form" id="J_SetBasic" method="post" action="<?php echo SITE_URL;?>index.php?app=user&ac=do&ts=setbase">
							<div class="error-row"><p></p></div>
							<div class="form-row">
								<label><span class="rc">*</span>昵称：</label>
								<input type="text" class="base-input" name="username" id="nickname" value="<?php echo $strUser['username'];?>">
							</div>
							<div class="form-row">
								<label>邮箱：</label>
								<span class="theemail yc"><?php echo $strUser['email'];?></span>
							</div>
							<div class="form-row clearfix">
								<label>性别：</label>
								<div class="sex">
									<input type="radio" class="ml5 mr5" <?php if($strUser['sex']=='1') { ?>checked="select"<?php } ?> name="sex" type="radio" value="1"><span class="radio-txt">男</span>
									<input type="radio" class="ml20 mr5"<?php if($strUser['sex']=='2') { ?>checked="select"<?php } ?> name="sex" type="radio" value="2"><span class="radio-txt">女</span>
									<input type="radio" class="ml20 mr5" <?php if($strUser['sex']=='0') { ?>checked="select"<?php } ?> name="sex" type="radio" value="0"><span class="radio-txt">保密</span>
								</div>
							</div>
							<div class="form-row">
								<label>自我介绍：</label>
								<textarea class="base-txa intro-txa" name="signed" placeholder="介绍一下自己吧~"><?php echo $strUser['signed'];?></textarea>
							</div>
							<div class="form-row pt10">
								<label>&nbsp;</label>
								<input type="submit" class="bbl-btn submit" value="保存">
							</div>
						</form>
										</div>
					<div class="set-pic">
					<img align="left" alt="<?php echo $TS_USER['uname'];?>" valign="middle" src="<?php echo $strUser['face'];?>"  />
												<div class="mt5">
							<a href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>face))?>">修改头像</a>
						</div>
					</div>
				</div>
			</div>
		</div><!--container end-->
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