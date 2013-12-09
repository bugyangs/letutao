<?php include template('header'); ?>
<link href="<?php echo SITE_URL;?>css/setting.css" rel="stylesheet" type="text/css" />
<div id="wrap">
		<div id="container">
			<div class="content clearfix">
				<?php include template('set_menu'); ?>				
             <div class="main-content">
					
					<div class="set-pic" style="float:left; margin-left:100px;">
                     <form method="POST" action="<?php echo SITE_URL;?>index.php?app=user&ac=do&ts=setface" enctype="multipart/form-data" >
					 <img alt="<?php echo $TS_USER['uname'];?>" valign="middle" src="<?php echo $strUser['face'];?>" class="pil" />
					<div class="mt5">
					<div class="m">从你的电脑上选择图像文件：(仅支持jpg，gif，png格式的图片)</div><br>
                
                <input type="file" name="picfile" />
                <input class="submit" type="submit" value="修改头像" />
               
						</div>
                 </form>
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