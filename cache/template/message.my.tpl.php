<?php include template('header'); ?>
<link href="<?php echo SITE_URL;?>css/profile08.css" rel="stylesheet" type="text/css" />

<div id="wrap">
		<div id="container">
			<div class="content clearfix">
				<div class="side-nav">
	<h2>我的通知</h2>
	<ul class="nav_r">		 
		<li>
			<a class="on" href="javascript:;">系统通知</a>(<?php echo $systemNum;?>)
		</li>
        
        <!--<li><a href="javascript:'';">好友消息</a></li>-->
		
	</ul>
</div>				<div class="main-content">
					<div class="my_comment" id="msgbox"></div>
					<!--分页-->
				<div class="tar mt30">
					<div class="pagin inlineblock clearfix" id="J_Pagination">
                    	 <?php echo $pageUrl;?>
					</div>
				</div>
				</div>
		</div><!--container end-->
	</div>
    </div>
    
<?php include pubTemplate("JsConstant");?>


<script src="<?php echo SITE_URL;?>js/jquery-1.6.4.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo SITE_URL;?>js/jquery.tools.min.js"></script>

<script type="text/javascript" src='<?php echo SITE_URL;?>js/guang-min.js?t=20120106230000.js'></script>

<script src="<?php echo SITE_URL;?>js/goods.js" type="text/javascript"></script>
    
    
    
    
<script type="text/javascript">

function systembox(userid){
	$("#sendbox").html("");
	$("#msgbox").html("加载系统消息中......")
	$.ajax({
		type: "GET",
		url:  "<?php echo SITE_URL;?>index.php?app=message&ac=systembox&lstart="+ <?php echo $lstart;?> +"&userid="+userid,
		success: function(msg){
			$('#msgbox').html(msg);
			var msgbox=document.getElementById('msgbox');
			if(msgbox.scrollHeight>msgbox.offsetHeight) msgbox.scrollTop=msgbox.scrollHeight-msgbox.offsetHeight+20;
			
		}
	});
}
systembox('<?php echo $TS_USER['user'][userid];?>');
</script>



<?php include template('footer'); ?>