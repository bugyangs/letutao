<?php include template('header'); ?>
<link href="<?php echo SITE_URL;?>css/topicEdit.css" rel="stylesheet" type="text/css" />

<div id="wrap">
	<div id="container">
		<div class="nav box-shadow">

	<ul class="clearfix">

		<li class=" user bigfs">

			<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$strUser['userid']))?>">

													<img src="<?php echo $strUser['face'];?>" alt="<?php echo $strUser['username'];?>" />

							<?php echo $strUser['username'];?>

			</a>

		</li>	

		<li><a href="<?php echo SITE_URL;?><?php echo tsurl('user','feed',array(userid=>$strUser['userid']))?>"><?php echo $feedNum;?><br>动态</a></li>

		<li><a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$strUser['userid']))?>"><?php echo $Gnum;?><br>宝贝</a></li>


		 <li class="cur trait"><a href="<?php echo SITE_URL;?><?php echo tsurl('user','zhuti',array(userid=>$strUser['userid']))?>"><?php echo $Tnum;?><br>主题</a></li>

			<li><a href="<?php echo SITE_URL;?><?php echo tsurl('user','fans',array(userid=>$strUser['userid']))?>"><?php echo $fansNum;?><br>粉丝</a></li>
            
            
            	<li class="last"><a href="<?php echo SITE_URL;?><?php echo tsurl('user','follow',array(userid=>$strUser['userid']))?>"><?php echo $followNum;?><br>关注</a></li>

			<i></i>	

	</ul>

</div>
		<div class="content">
			<h2>创作主题</h2>
			<div class="topic-edit" data-source="">
				<form id="J_TopicEditFm" class="edit-form" method="post" action="<?php echo SITE_URL;?>index.php?app=share&ac=do&le=add_zhuti">
							<div class="form-row clearfix">
								<label><span class="rc">*</span>标题：</label>
								<div class="fm-item">
									<input id="J_TopicTitle" name="title" class="b-input" type="text" value="" />
									
								</div>
							</div>
							<div class="form-row clearfix">
								<label>介绍：</label>
								<div class="fm-item">
									<textarea id="J_TopicIntro" class="b-textarea intro-txa" name="desc"></textarea>
									
								</div>
							</div>
							<div class="form-row clearfix">
								<label>分类：</label>
								<div class="fm-item">
									<select id="J_SelCag" name="cate">
										<option value="">选择分类</option>
                                           <?php foreach((array)$LE_APPone as $key=>$item) {?>
										<option value="<?php echo $item;?>" <?php if($item==$cate) { ?> selected="selected"<?php } ?>><?php echo $item;?></option>
         								   <?php }?>
                                        <option value="其他" >其它</option>
									</select>
									
									<p>选择相应的分类，让大家更容易找到你的主题</p>
								</div>
							</div>
							<div class="form-row clearfix">
								<label>标签：</label>
								<div class="fm-item">
									<input type="text" class="b-input" name="keywords" id="J_TopicTags" value="" />
									<p>多个标签用逗号隔开</p>
								</div>
							</div>
							<div class="error-row"><p class="error"></p></div>
							<div class="form-row">
								<label>&nbsp;</label>
																<input type="submit" class="bbl-btn submit" value="创建主题" />
															</div>
				</form>
			</div>
		</div>
		<!--content end-->
	</div>
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