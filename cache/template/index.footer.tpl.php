<?php include pubTemplate("JsConstant");?>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/do.min.js"></script>
<script>
(function(){
var b="?t="+GUANGER.staticVersion,a=function(a){return"<?php echo SITE_URL;?>js/"+a+b};Do.add("guang",{path:a("guang.min.js"),type:"js",requires:["tools","cookie"]});Do.add("tools",{path:a("jquery.tools.min.js"),type:"js"});Do.add("cookie",{path:a("jquery.cookie.min.js"),type:"js"});Do.add("share_guang",{path:a("share_guang.min.js"),type:"js",requires:["guang"]});Do.add("search_suggest",{path:a("search_suggest.min.js"),type:"js",requires:["guang"]});Do.add("localstorage",{path:a("localstorage.min.js"),type:"js"});
Do.add("guang_comment",{path:a("comment.min.js"),type:"js"});Do.add("like_say",{path:a("like_say.min.js"),type:"js"});Do.add("common",{path:a("common.min.js"),type:"js",requires:["share_guang","search_suggest","localstorage"]});Do.global("guang");Do("common");
	Do.add('index', {
		path: a('index.min.js'), 
		type: 'js', 
		requires: ['<?php echo SITE_URL;?>js/feedSlider.min.js','<?php echo SITE_URL;?>js/scrollImg.min.js','<?php echo SITE_URL;?>js/follow.min.js','<?php echo SITE_URL;?>js/lazyload.min.js']
	});	

})();
</script>  </div>
<!--thepage end-->


<script type="text/javascript">
	Do('index');
	Do('ajaxfileupload');
</script>

<?php doAction('body_foot')?>
<?php include pubTemplate("footer");?>