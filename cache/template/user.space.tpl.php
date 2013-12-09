<?php include template('header'); ?>

<!--
<div class="ad clearfix">
 <?php doAction('adcode',null,'8')?>
</div>
-->
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

		<li ><a href="<?php echo SITE_URL;?><?php echo tsurl('user','feed',array(userid=>$strUser['userid']))?>"><?php echo $feedNum;?><br>动态</a></li>

		<li class="cur trait"><a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$strUser['userid']))?>"><?php echo $Gnum;?><br>宝贝</a></li>


		 <li ><a href="<?php echo SITE_URL;?><?php echo tsurl('user','zhuti',array(userid=>$strUser['userid']))?>"><?php echo $Tnum;?><br>主题</a></li>

			<li><a href="<?php echo SITE_URL;?><?php echo tsurl('user','fans',array(userid=>$strUser['userid']))?>"><?php echo $fansNum;?><br>粉丝</a></li>
            
            
            	<li class="last"><a href="<?php echo SITE_URL;?><?php echo tsurl('user','follow',array(userid=>$strUser['userid']))?>"><?php echo $followNum;?><br>关注</a></li>

			<i></i>	

	</ul>

</div>

		<div class="page-bd clearfix">

		<div class="main">   

			<div class="baobei box-shadow plr15">

				<div class="main-title clearfix">

					<h2>
					<?php if($sort=='') { ?>
						最近喜欢的宝贝(<?php echo $lGoodsNum;?>)

						<span class="ml5 mr5">|</span>

						<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$strUser['userid'],sort=>'share'))?>">发布的宝贝(<?php echo $sGoodsNum;?>)</a>
                        
					<?php } ?>
                    
                    <?php if($sort=='share') { ?>
						<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$strUser['userid']))?>">最近喜欢的宝贝(<?php echo $lGoodsNum;?>) </a>

						<span class="ml5 mr5">|</span>

						发布的宝贝(<?php echo $sGoodsNum;?>)
                        
					<?php } ?>
                    
					</h2>
<?php if($userid == $TS_USER['user'][userid]) { ?>
										<span class="fr">

					<a rel="shareGoods" class="bbl-btn ml10" href="javascript:;">+ 发布宝贝</a>

					</span>
<?php } ?>
									</div>

								<ul class="clearfix">
                                
                                
                     <?php if($Good) { ?>
					<?php foreach((array)$Good as $key=>$item) {?>
						<li <?php if(($key+1)%5==0) { ?>class="last"<?php } ?>>

						<div class="baobei-wrap">

							<div class="baobei-pic">

								<a target="_blank" title="<?php echo $item['name'];?>" href="<?php echo SITE_URL;?><?php echo tsurl('baobei',$item['goods_id'])?>">

								<img src="<?php if($DISK_YUN['isopen']) { ?><?php echo BCS_URL;?><?php echo $item['img'];?><?php } else { ?><?php echo SITE_URL;?><?php echo $item['img'];?><?php } ?>" width="120" alt="<?php echo $item['name'];?>" title="<?php echo $item['name'];?>"/>

								</a>

<?php if($userid == $TS_USER['user'][userid] ||$TS_USER['user'][userid] == 1) { ?>
			<a class="ilike-del" href="javascript:void(0);" data-type="4" data-proid="<?php echo $item['goods_id'];?>" data-le="del_<?php echo $letype;?>" style="display: none; " title="<?php echo $letypewz;?>">喜欢-1</a>
            <?php } ?>

									</div>

														<p><?php echo $item['name'];?></p>

							                            						</div>

					</li>
                    
                    <?php }?>
<?php } ?>
                    

														</ul>

								<div class="clearfix pt20 pb20">

					<div class="pagin fr pagination">
<?php echo $pageUrl;?>
									</div>

				</div>

			</div>

			

		</div><!--main end-->

		<div class="side">

		<div class="profile-box box-shadow ss">

		<div class="u">

			<div class="u-face">

				<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$strUser['userid']))?>">

													<img src="<?php echo $strUser['bigface'];?>" alt="<?php echo $strUser['username'];?>"  width="180px" height="180px"/>

								</a>

			</div>

			<div class="u-info clearfix">

								<h2 class="ofh"><?php echo $strUser['username'];?></h2>

																				

				
				<ul class="ul-daren clearfix">
                <?php if($strdaren) { ?>
                <li class="bg-daren" style=" background:url(<?php echo SITE_URL;?><?php echo $strdaren['background'];?>) no-repeat"><h5><?php echo $strdaren['darenname'];?></h5><i>本站认证</i></li>
                <?php } ?>

									</ul>

                                    <?php if($strUser['userid'] == $TS_USER['user'][userid]) { ?>
                                    <a href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>base))?>">修改资料</a>
                                    <?php } ?>
                                     <?php if($strUser['userid'] <> $TS_USER['user'][userid]) { ?>
                                     <?php if($strUser['isfollow']) { ?>
                                        <div class="followed-btn-big">已关注<span class="mr5 ml5">|</span><a rel="removefollow" data-followtype="0" data-usernick="<?php echo $strUser['username'];?>" data-userid="<?php echo $strUser['userid'];?>" href="javascript:;">取消</a></div>
                                     <?php } else { ?>
                                     
                                      <a rel="follow" href="javascript:;" class="follow-btn-big" data-followtype="0" data-userid="<?php echo $strUser['userid'];?>" data-usernick="<?php echo $strUser['username'];?>">加关注</a>
                                    
                                     <?php } ?>
									
                                    <?php } ?>
                                    &nbsp;&nbsp;&nbsp;
                                   <span style="color: #BCBCBC"><?php if($strArea) { ?>
<?php echo $strArea['one'][areaname];?> 
<?php echo $strArea['two'][areaname];?> 
<?php echo $strArea['three'][areaname];?> 
<?php } else { ?>
火星
<?php } ?></span>
                                   <?php if($strUser['signed']) { ?>
                                   <p style="line-height:24px; margin-top:10px; padding:5px; background-color: #F8FEFD; border:#E4FCF7 1px solid"><?php echo $strUser['signed'];?></p><?php } ?>
                                                                                    </div>

		</div>

	</div>

		

		<div class="friend-tags box-shadow plr15 ss">

				<div class="title">跟<?php if($userid == $TS_USER['user'][userid]) { ?>我<?php } else { ?> Ta <?php } ?>相关的标签</div>

				<ul class="clearfix">
				<?php foreach((array)$arrtagss as $key=>$item) {?>
								    			<li <?php if($item['is_hot']) { ?>class="focus"<?php } ?>><a class="ofh" href="<?php echo SITE_URL;?><?php echo tsurl('faxian','',array(tag=>$item['tag_name']))?>"><?php echo $item['tag_name'];?></a></li>

<?php }?>

							</ul>

	</div>

		<!--side end-->		</div>

		<!--page-bd end-->

	</div>

</div>
<?php include pubTemplate("JsConstant");?>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/do.min.js"></script>
<script>
(function(){
var b="?t="+GUANGER.staticVersion,a=function(a){return"<?php echo SITE_URL;?>js/"+a+b};Do.add("guang",{path:a("guang.min.js"),type:"js",requires:["tools","cookie"]});Do.add("tools",{path:a("jquery.tools.min.js"),type:"js"});Do.add("cookie",{path:a("jquery.cookie.min.js"),type:"js"});Do.add("share_guang",{path:a("share_guang.min.js"),type:"js",requires:["guang"]});Do.add("search_suggest",{path:a("search_suggest.min.js"),type:"js",requires:["guang"]});Do.add("localstorage",{path:a("localstorage.min.js"),type:"js"});
Do.add("guang_comment",{path:a("comment.min.js"),type:"js"});Do.add("like_say",{path:a("like_say.min.js"),type:"js"});Do.add("common",{path:a("common.min.js"),type:"js",requires:["share_guang","search_suggest","localstorage"]});Do.global("guang");Do("common");
})();
</script> 
<script type="text/javascript">
Do('profile');
Do('follow');
Do('ajaxfileupload');
</script>

<?php include template('footer'); ?>