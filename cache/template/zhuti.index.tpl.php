<?php include template('header'); ?>
	<!--header-->
<div id="wrap">
<div id="container980">
   <div class="main-recommend clearfix">
					<div class="left">
						<div id="J_Slide">
							<div class="items">
								<div class="item">
									<a href="<?php echo SITE_URL;?><?php echo tsurl('zhuti'.$arrrecomthemes['themeid'])?>" title="<?php echo $arrrecomthemes['title'];?>" target="_blank">
										<img src="<?php echo SITE_URL;?><?php if($arrrecomthemes['headerPhoto']) { ?><?php echo $arrrecomthemes['headerPhoto'];?><?php } else { ?>images/3HeaderPic_4.jpg<?php } ?>" alt="<?php echo $arrrecomthemes['title'];?>">
									</a>
									<a style="position:absolute;bottom:26px;right:20px;height: 32px;width:100px;text-align:center;background:#f25106;color: #fff;line-height:32px;overflow:hidden;display:block;border-radius:5px;opacity:0.9" href="<?php echo SITE_URL;?><?php echo tsurl('zhuti'.$arrrecomthemes['themeid'])?>" title="去看看" target="_blank">去看看 》</a>
								</div>
							</div>
						</div>
						
					</div>
					<div class="right">
						<div class="topic-tips">
						</div>
                       <a href="<?php echo SITE_URL;?><?php echo tsurl('user','createzt')?>"  class="create-topic-btn"></a>
												<p class="link">
							<a href="<?php echo SITE_URL;?><?php echo tsurl('group','topic',array('topicid'=>'1'))?>" target="_blank">（ˇ_ˇ）做主题，须知道&gt;&gt;</a>
						</p>
						
					</div>
				</div>
                <div id="dashai" class="clearfix">
                    <div class="topic-nav" style="margin-top:15px;">
                        <ul class="nav-main">
                            <?php foreach((array)$LE_APPone as $key=>$item) {?>
			               <li  class="nav-19" >
                                <a href="#<?php echo $key;?>" title="<?php echo $item;?>"><?php echo $item;?></a>
                           </li>
			                <?php }?>
                        </ul>
						 </div>

						<div class="pb15 pt10">
                           <?php doAction('adcode',null,'5')?>
                           
                        </div>
                <?php foreach((array)$zhutimessage as $ztmkey=>$ztmitem) {?>
                <?php if($ztmitem['zt'] ) { ?>
						<div class="topic-item clearfix" id="<?php echo $ztmkey;?>">
                        
	<div class="topic-cate-name">
		<h3>推荐<?php echo $ztmitem['cate'];?></h3>
		<a class="more" href="<?php echo SITE_URL;?><?php echo tsurl('zhuti',$ztmitem['cate'])?>#zhutiid" title="<?php echo $ztmitem['cate'];?>">查看更多&gt;</a>
	</div>
	
	<div class="topic-list">
		<div class="clearfix">
    
        <?php foreach((array)$ztmitem['zt'] as $zkey=>$zitem) {?>
			<div class="nineGrid" >
			<div class="hd">
				<h4><a  href="<?php echo SITE_URL;?><?php echo tsurl('zhuti')?><?php echo $zitem['themeid'];?>" title="<?php echo $zitem['title'];?>" target="_blank"><?php echo $zitem['title'];?><span>(<?php echo $zitem['goodsnum'];?>)</span></a>
									</h4>
			</div>
              <?php if($zitem['goods']) { ?>
			<div class="bd clearfix">
				<a href="<?php echo SITE_URL;?><?php echo tsurl('zhuti')?><?php echo $zitem['themeid'];?>" title="<?php echo $zitem['title'];?>" target="_blank">
                
                 <?php $zti=1?>
               
                <?php foreach((array)$zitem['goods'] as $zgkey=>$zgitem) {?>
				<img  pindex="1" <?php if($zti%3==0) { ?>class="last"<?php } ?>alt="" title="" src="<?php echo SITE_URL;?><?php echo $zgitem['simg'];?>"/>
                   <?php $zti=$zti+1?>
				<?php }?>	
               
                											
       			</a>
			</div>
             <?php } else { ?>
                <img  pindex="1" <?php if($zti%3==0) { ?>class="last"<?php } ?>alt="" title="" src="<?php echo SITE_URL;?>images/nogoods.gif"/>
                <?php } ?>
			<div class="ft clearfix">
				<div class="user-info">
										<a rel="usercard" href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$zitem['user'][userid]))?>" title="<?php echo $zitem['user']['username'];?>" class="user-img" target="_blank">
													<img src="<?php echo $zitem['user']['face'];?>" alt="<?php echo $zitem['user']['username'];?>"/>
											</a>
					<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$zitem['user'][userid]))?>" title="<?php echo $zitem['user']['username'];?>" class="user-name" target="_blank"><?php echo $zitem['user']['username'];?></a>
                                         <i class="inlineblock i-daren"></i>
                    				</div>
									 <?php if($zitem['user'][isfollow]==3&&$userid == $TS_USER['user'][userid]) { ?>
                    <div href="#" class="followed-btn">互相关注<span class="mr5 ml5">|</span><a rel="removefollow" href="javascript:;" data-followtype="5" data-userid="<?php echo $item['userid'];?>" data-usernick="<?php echo $item['username'];?>">取消</a></div>
                     <?php } elseif ($zitem['user'][isfollow]==3) { ?>
                     <div href="#" class="followed-btn">互相关注</div>
                     
                      <?php } elseif ($zitem['user'][userid]== $TS_USER['user'][userid]) { ?>
                      
                       <div href="#" class="followed-btn">互相关注</div>
                       
                      <?php } elseif ($zitem['user'][isfollow]==1) { ?>
                     <div href="#" class="followed-btn">已关注</div>
                     
                      <?php } else { ?>
                     <a rel="follow" href="javascript:;" class="follow-btn" data-followtype="<?php if($zitem['user'][isfollow]==2&&$userid == $TS_USER['user'][userid]) { ?>1<?php } elseif ($zitem['user'][isfollow]==2) { ?>3<?php } elseif ($item['isfollow']==4&&$userid == $TS_USER['user'][userid]) { ?>5<?php } elseif ($zitem['user'][isfollow]==4) { ?>4<?php } ?>" data-userid="<?php echo $zitem['user'][userid];?>" data-usernick="<?php echo $zitem['user'][username];?>">加关注</a><br />
                     <?php } ?>
							</div>
		</div>
			<?php }?></div>
				<div class="topic-aside">
			<div class="bar-list top">
				<h3>本周热榜</h3>
				<em>TOP</em>
				<ul>
                <?php foreach((array)$ztmitem['zttop'] as $zttopkey=>$zttopitem) {?>
				<li>
						<a href="<?php echo SITE_URL;?><?php echo tsurl('zhuti')?><?php echo $zttopitem['themeid'];?>" title="<?php echo $zttopitem['title'];?>" class="clearfix" target="_blank"><?php echo $zttopitem['title'];?><span class="num"><?php echo $zttopitem['goodsnum'];?></span></a>
					</li>	
									
              <?php }?>		
									</ul>
			</div>
		</div><!--topic-aside end-->
			</div>
</div>
<?php } ?>
<?php }?>
</div><!--topic-main end-->
        </div>
    </div>
<?php include pubTemplate("JsConstant");?>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/do.min.js"></script>
<script>
(function(){
var b="?t="+GUANGER.staticVersion,a=function(a){return"<?php echo SITE_URL;?>js/"+a+b};Do.add("guang",{path:a("guang.min.js"),type:"js",requires:["tools","cookie"]});Do.add("tools",{path:a("jquery.tools.min.js"),type:"js"});Do.add("cookie",{path:a("jquery.cookie.min.js"),type:"js"});Do.add("share_guang",{path:a("share_guang.min.js"),type:"js",requires:["guang"]});Do.add("search_suggest",{path:a("search_suggest.min.js"),type:"js",requires:["guang"]});Do.add("localstorage",{path:a("localstorage.min.js"),type:"js"});
Do.add("guang_comment",{path:a("comment.min.js"),type:"js"});Do.add("like_say",{path:a("like_say.min.js"),type:"js"});Do.add("common",{path:a("common.min.js"),type:"js",requires:["share_guang","search_suggest","localstorage"]});Do.global("guang");Do("common");
})();
Do('ajaxfileupload');
</script> 
<?php include template('footer'); ?>
