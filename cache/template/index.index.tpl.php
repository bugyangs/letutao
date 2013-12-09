<?php include template('header'); ?>
<style>
.bulletin .label{width:210px;height:280px;}
.bulletin .label .dotted{padding-top:0;   }
.bulletin .label ul{padding-top:4px; }
.bulletin .label li.first{padding:4px 0 6px;}
.bulletin .label li{width:230px;overflow:hidden;height:20px;line-height:20px;padding:7px 0;   }
.bulletin .label li a{display:inline-block;zoom:1;padding:3px 4px;color:#666;height:16px;line-height:16px;}
.bulletin .label li a.em{color:#ee2266;}
.bulletin .label li a.tag{background:#fff5f5;padding:0 6px;margin-right:3px;height:22px;line-height:22px;color:#f86b82;border-radius:2px;-webkit-border-radius:2px;text-decoration:none;   }

</style>
    <!-- main-box begin -->
    <div class="main-box clearfix">
        <div class="flash fl">
			<div class="scrollable">
				<!-- 解决图片加载顺序问题  style="left: -2880px;"-->
				<div class="items">
 <?php if($indexslide) { ?>
<?php foreach((array)$indexslide as $key=>$item) {?>
							<div class="item">
							<a class="topic-bg" href="<?php echo $item['url'];?>" target="_blank" style="background-image:url(<?php echo $item['img'];?>)" title="<?php echo $item['title'];?>">
							</a>
							<div class="itemText">
							<h3 class="topicTitle bigfs"><a href="<?php echo $item['url'];?>" target="_blank"><?php echo $item['title'];?></a></h3>
								
							<a class="byOne" href="<?php echo $item['url'];?>" target="_blank">
									<?php echo nl2br($item['desc'])?>
							</a>
							</div>
                            <?php if($item['title']) { ?>
							<a href="<?php echo $item['url'];?>" target="_blank" class="itmeGuang"  title="<?php echo $item['title'];?>">去看看&gt;</a>
                            <?php } ?>
							<a href="<?php echo $item['url'];?>" class="a-mask" target="_blank" title="<?php echo $item['title'];?>" <?php if(empty($item['title'])) { ?>
 style="background:none"<?php } ?>></a>
						</div>
<?php }?>
<?php } ?>

																
					</div>
			</div>
	        <ul class="navi clearfix"> 
            
              <?php if($indexslide) { ?>
<?php foreach((array)$indexslide as $key=>$item) {?>

		<li <?php if($item[i]==0) { ?>class="first active"<?php } ?>>
					<span></span>
					<a href="<?php echo $item['url'];?>" title="<?php echo $item['title'];?>" target="_blank">
					<div class="thumb">
						<img src="<?php echo $item['img'];?>" alt="<?php echo $item['title'];?>" width="130" height="45">
					</div>
					<h3 class="topicTitle ofh"></h3>
					</a>
				</li>
	<?php }?>
<?php } ?>

	                    	                	                
			</ul>
        </div>
        <!-- flash end -->
        			<div class="bulletin fr clearfix" id="J_Bulletin">
				<h3>最近热门标签~</h3>
				<div class="label clearfix"> <ul class="dotted clearfix"> 
                
                <?php foreach((array)$HotTag as $key=>$item) {?>
                <?php if($key%5==0) { ?>
                <li <?php if($key==0) { ?>class="first"<?php } ?>> 
                <?php } ?>
				 <a<?php if($item['count']>100) { ?> class="tag"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl($item['appname'],'',array('tag'=>$item['tag_name']))?>" target="_blank" title="<?php echo $item['tag_name'];?>"><?php echo $item['tag_name'];?></a>
                   <?php if($key%5==5&&$key>0) { ?>
                </li>
                <?php } ?>
                <?php }?>
        
                
             </ul> </div>
                
			</div><!-- cms end 最近热门的玩意儿 end -->
    </div>
     <div class="ad clearfix" style="margin:-15px auto 10px auto; width:980px;"><!-- 首页广告1 -->
 <?php doAction('adcode',null,'1')?>
</div>
    <!-- main-box end -->
	<!-- latestLike end-->
    <?php if($category) { ?>					
<?php foreach((array)$category as $key=>$item) {?>
    	<div class="category-main clearfix">
		
        <div class="category">
            <div class="hd clearfix">
                <h2><a href="<?php echo SITE_URL;?><?php echo tsurl($item['appname'])?>" title="<?php echo $item['catename'];?>" target="_blank"><?php echo $item['catename'];?></a></h2>
            </div>
            <div class="group clearfix">
                <dl class="clearfix">
					 <dt>
                       <ul class="J_Prompt">
                       			
                                
                        <?php if(is_array($item['catetags_1'])) { ?>					
            <?php foreach((array)$item['catetags_1'] as $key=>$iitem) {?>
    					    	<li>
                                    <a href="<?php echo SITE_URL;?><?php echo tsurl($item['appname'],'',array(tag=>$iitem['tag_name']))?>" title="<?php echo $iitem['tag_name'];?>" target="_blank">
                                        <img src="<?php echo $iitem['imgstr'];?>" width="270px" height="140px" alt="<?php echo $iitem['tag_name'];?>">
                                    </a>
                                    <div class="title bigfs"><a href="<?php echo SITE_URL;?><?php echo tsurl($item['appname'],'',array(tag=>$iitem['tag_name']))?>" target="_blank" title="<?php echo $iitem['tag_name'];?>"><?php echo $iitem['tag_name'];?></a></div>
                                </li>
    								
            <?php }?>
                                                
            <?php } ?>				    						    						                                
    						    							</ul>
                            </dt>
							<dd>
                            <ul class="J_Prompt">			    					
            <?php if(is_array($item['catetags_2'])) { ?>					
            <?php foreach((array)$item['catetags_2'] as $kkey=>$iitem) {?> 
    				    		<li>
                                     <a href="<?php echo SITE_URL;?><?php echo tsurl($item['appname'],'',array(tag=>$iitem['tag_name']))?>" title="<?php echo $iitem['tag_name'];?>" target="_blank">
                                        <img src="<?php echo $iitem['imgstr'];?>" <?php if($kkey==0) { ?>width="290px" height="290px"<?php } else { ?>width="140px" height="140px"<?php } ?> alt="<?php echo $iitem['tag_name'];?>">
                                    </a>
                                    <div class="title bigfs"><a href="<?php echo SITE_URL;?><?php echo tsurl($item['appname'],'',array(tag=>$iitem['tag_name']))?>" target="_blank" title="<?php echo $iitem['tag_name'];?>"><?php echo $iitem['tag_name'];?></a></div>
                                </li>
                <?php }?>
                                                
            <?php } ?>	

    												                        </ul>
                    </dd>
                </dl>
            </div>
        </div>
        
        <div class="tab fr">
                    <div class="nav">
                        <ul class="J_Theme-tab">
                        <li class="on">主题</li>
                                                <li>达人</li>
                        </ul>
                    </div>
                    <div class="theme clearfix">
                        <ul class="J_Theme">
                        <?php if(is_array($item['arrThemes'])) { ?>					
            <?php foreach((array)$item['arrThemes'] as $kkey=>$iitem) {?> 
							   <li  <?php if($kkey==0) { ?>class="on"<?php } ?>>
                                                        
                                <a  class="list-a" href="<?php echo SITE_URL;?><?php echo tsurl('zhuti'.$iitem['themeid'])?>" target="_blank" title="<?php echo $iitem['title'];?>"><?php echo $iitem['title'];?></a>
                                <a class="theme-pic" target="_blank" href="<?php echo SITE_URL;?><?php echo tsurl('zhuti'.$iitem['themeid'])?>" >
                                    <img src="<?php if($iitem['simg']) { ?><?php echo $iitem['simg'];?><?php } else { ?>images/none-z-b.gif<?php } ?>" alt="<?php echo $iitem['title'];?>" width="210" height="140">
                                    <span><?php echo $iitem['title'];?></span>
                                </a>
                            </li>
                                           <?php }?>
                                                
            <?php } ?>	 
			
						</ul>
                        <div class="more-2">
                             <a  class="more-a" href="<?php echo SITE_URL;?><?php echo tsurl('zhuti',$item['catename'])?>" target="_blank" title="更多<?php echo $item['catename'];?>主题">&gt;&gt;</a>
                        </div>
                    </div>
                    <div class="theme clearfix dr">
                    	 <?php if(is_array($item['arrThemes'])) { ?>					
            <?php foreach((array)$item['arrThemes'] as $kkey=>$iitem) {?>
						 <dl>
                            <dt>
                                <a class="user-img" href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$iitem['user']['userid']))?>" title="<?php echo $iitem['user']['username'];?>" target="_blank">
                                                							<img src="<?php echo $iitem['user']['face'];?>" width="60" height="60" alt="<?php echo $iitem['user']['username'];?>" />
            						                                </a>
                            </dt>
                            <dd>
                                <a class="name g-daren" href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$iitem['user']['userid']))?>" target="_blank">
                                <em class="ofh"><?php echo $iitem['user']['username'];?></em></a>
                                <p class="intro"><?php if($iitem['user']['signed']) { ?><?php echo $iitem['user']['signed'];?><?php } else { ?>这家伙很懒，什么话都没留下！<?php } ?></p>
                            	<a rel="follow" href="javascript:;" class="follow-btn" data-followtype="5" data-userid="<?php echo $iitem['user']['userid'];?>" title="<?php echo $iitem['user']['username'];?>" data-usernick="<?php echo $iitem['user']['username'];?>">加关注</a>
                                                        </dd>
                        </dl>
			<?php }?>
                                                
            <?php } ?>	 		
						                      
                    </div>
        </div>
		
    </div>
		<?php }?>
									
<?php } ?>

	<div class="justGuang clearfix pos-r">
		<fieldset>
    		<h3 id="J_legend">
    			现在加入我们，开始发现喜欢，改变生活...
    		</h3>
    		<div class="field-box" id="J_welcome">
            <?php if(in_array('qq',$isL_Open)||in_array('sina',$isL_Open)||in_array('taobao',$isL_Open)) { ?>
    			<div class="clearfix thirdLogin">
                 <?php if(in_array('qq',$isL_Open)) { ?>
					<a class="l-qq" href="<?php echo SITE_URL;?>index.php?app=pubs&ac=plugin&plugin=qq&in=qq_login" target="_blank">QQ帐号登录</a>
                 <?php } ?>
                     <?php if(in_array('taobao',$isL_Open)) { ?>
                    <a class="l-tao" href="<?php echo SITE_URL;?>index.php?app=pubs&ac=plugin&plugin=taobao&in=tb_login" target="_blank">淘宝账户登录</a><?php } ?>
                    <?php if(in_array('sina',$isL_Open)) { ?>
					<a class="l-sina" href="<?php echo SITE_URL;?>index.php?app=pubs&ac=plugin&plugin=sina&in=sina_login" target="_blank">新浪微博登录</a><?php } ?>
    			</div>
			<?php } ?>
<div class="clearfix gc login">	
    				<a id="J_login" href="<?php echo SITE_URL;?><?php echo tsurl('user','login')?>">帐号登录</a>&nbsp;|&nbsp;<a href="<?php echo SITE_URL;?><?php echo tsurl('user','register')?>">免费注册</a>
    			</div>
    		</div>
    	</fieldset>
	</div>
<?php include template('footer'); ?>