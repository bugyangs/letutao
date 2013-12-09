<?php include template('header'); ?>

<link href="<?php echo SITE_URL;?>css/forum.css" rel="stylesheet" type="text/css" />
<div class="square clearfix">

    <!-- 讨论吧 -->

	<div class="main clearfix">

        <div class="sort-news mb10 clearfix">
        
        <?php foreach((array)$arrRecommendGroup as $key=>$item) {?>

          <div class="sprt-piece  <?php if(($key+1)%2==0) { ?>bg-fa<?php } else { ?>bg-f3<?php } ?>">

                <div class="sprt-img">

                    <a href="<?php echo SITE_URL;?><?php echo tsurl('group','group',array(groupid=>$item['groupid']))?>" title="<?php echo $item['groupname'];?>" target="_blank">

                        <img src="<?php echo SITE_URL;?><?php if($item['groupicon']) { ?><?php echo $item['groupicon'];?><?php } else { ?>public/images/event_dft.jpg<?php } ?>" alt="<?php echo $item['groupname'];?>" width="80" height="80" />

                    </a>

                </div>

                <div class="sprt-text">

                    <h3>

                        <a href="<?php echo SITE_URL;?><?php echo tsurl('group','group',array(groupid=>$item['groupid']))?>" title="<?php echo $item['groupname'];?>" target="_blank"><?php echo $item['groupname'];?></a>

                    </h3>

                    <ul>

					<?php echo $item['groupdesc'];?>

                                            </ul>

                </div>

            </div>
            
		<?php }?>

        </div>

	</div>

    <div class="forum-con square-bar-con vertical-box fl">

		<div class="title">

			<ul class="tab-title clearfix" id="J_ForumPostTabTitle">

				<li class="first current"><a href="#" title="">热门话题Top20</a><i></i></li>

				<li class="last"><a href="javascript:;" title="">新话题？抢沙发</a><i></i></li>
			</ul>
            
            <div class="fr" style="margin-top:-35px;">

					<a class="bbl-btn ml10" href="<?php echo SITE_URL;?><?php echo tsurl('group','create')?>">+ 创建板块</a>
                    
                    <a class="bbl-btn ml10" href="<?php echo SITE_URL;?><?php echo tsurl('group','allgroup')?>">查看所有板块</a>

					</div>
            
            

		</div>

		<div class="panels" id="J_ForumPostTabPanels">

			<!-- 热帖 -->

			<div class="panels-con">

    			<table>

                   <tr> 

    					<th class="top-icon"></th> 

    					<th class="topic">话题</th>

    					<th class="anthor">作者</th>

    					<th class="statistics">回帖/查看</th>

    					<th class="latest">最新回帖</th>

    				</tr>
	 <?php if($arrhotTopic) { ?>
 <?php foreach((array)$arrhotTopic as $key=>$item) {?>
    				<tr>

    					<td class="top-icon" align="left">												
							<?php if($item['istop']==1) { ?>
    					 	<div class="icon i-forum i-status-top i-d" title="置顶帖">置顶帖</div>
                            <?php } elseif ($item['isask']==1) { ?>
                            <div class="icon i-forum i-status-ask i-d" title="问答帖">问答帖</div>
                             <?php } elseif ($item['isposts']==1) { ?>
                            <div class="icon i-forum i-status-best i-d" title="精华帖">精华帖</div>
                             <?php } else { ?>
                            <div class="icon i-forum i-status-general i-d" title="普通帖">普通帖</div>
							<?php } ?>
    						    					</td>

    					<td align="left" class="topic">

    						<a class="status-top ofh wordbreak" href="<?php echo SITE_URL;?><?php echo tsurl('group','topic',array('topicid'=>$item['topicid']))?>" title="<?php echo $item['title'];?>">

    							<?php echo $item['title'];?>

    						</a>

    					</td>

    					<td align="left" class="anthor">

							    						<a class="g-daren" href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('userid'=>$item['user']['userid']))?>" title="<?php echo $item['user']['username'];?>" target="_blank"><em class="ofh"><?php echo $item['user']['username'];?></em><?php if($item['user']['darenid']>0) { ?><i class="i-daren">达人</i><?php } ?></a>

							    					</td>

    					<td align="left"><?php echo $item['count_comment'];?>/<?php echo $item['count_view'];?></td>

    					<td align="right"><?php echo date('m-d h:i',$item['addtime'])?></td>

    				</tr>
                    
                    
                    <?php }?>
                    
                                        <?php } else { ?>
<tr>
<td class="top-icon" align="left"></td>
<td align="left" class="topic">暂无任何话题！</td>
<td align="left" class="anthor"></td>
<td align="left"></td>
<td align="right"></td>
</tr>

<?php } ?> 


    				    				    			</table>

			</div>

			<!-- 新帖 -->

			<div class="panels-con" style="display:none">

				<table>

                   <tr> 

    					<th class="top-icon"></th> 

    					<th class="topic">话题</th>

    					<th class="anthor">作者</th>

    					<th class="statistics">回帖/查看</th>

    					<th class="latest">最新回帖</th>

    				</tr>
			 <?php if($arrnewTopic) { ?>
			 <?php foreach((array)$arrnewTopic as $key=>$item) {?>
    				<tr>

    					<td class="top-icon" align="left">												
							<?php if($item['istop']==1) { ?>
    					 	<div class="icon i-forum i-status-top i-d" title="置顶帖">置顶帖</div>
                            <?php } elseif ($item['isask']==1) { ?>
                            <div class="icon i-forum i-status-ask i-d" title="问答帖">问答帖</div>
                             <?php } elseif ($item['isknowlege']==1) { ?>
                            <div class="icon i-forum i-status-knowlege i-d" title="知识帖">知识帖</div>
                             <?php } elseif ($item['isposts']==1) { ?>
                            <div class="icon i-forum i-status-best i-d" title="精华帖">精华帖</div>
                             <?php } else { ?>
                            <div class="icon i-forum i-status-general i-d" title="普通帖">普通帖</div>
							<?php } ?>
    						    					</td>

    					<td align="left" class="topic">

    						<a class="status-top ofh wordbreak" href="<?php echo SITE_URL;?><?php echo tsurl('group','topic',array('topicid'=>$item['topicid']))?>" title="<?php echo $item['title'];?>">

    							<?php echo $item['title'];?>

    						</a>

    					</td>

    					<td align="left" class="anthor">

							    						<a class="g-daren" href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('userid'=>$item['user']['userid']))?>" title="<?php echo $item['user']['username'];?>" target="_blank"><em class="ofh"><?php echo $item['user']['username'];?></em>
                                                        <?php if($item['user']['darenid']>0) { ?><i class="i-daren">达人</i><?php } ?></a>

							    					</td>

    					<td align="left"><?php echo $item['count_comment'];?>/<?php echo $item['count_view'];?></td>

    					<td align="right"><?php echo date('m-d h:i',$item['addtime'])?></td>

    				</tr>
                    
                    
                    <?php }?>
                    
                    <?php } else { ?>
<tr>
<td class="top-icon" align="left"></td>
<td align="left" class="topic">暂无任何话题！</td>
<td align="left" class="anthor"></td>
<td align="left"></td>
<td align="right"></td>
</tr>

<?php } ?> 


    				    				    			</table>

			</div>

		</div>

    </div>

    <div class="square-sidebar fr">

    	<!-- 达人 -->

		

    	<div class="daren vertical-box">

    		<div class="title">

    			<h3>达人们~</h3>

    			<ul class="dot-tab-title clearfix" id="J_DarenTabTitle">
					<?php if($arrdaren) { ?>
					<?php foreach((array)$arrdaren as $key=>$item) {?>
                    <li <?php if($key=0) { ?>class="current"<?php } ?>><a title="<?php echo $item['username'];?> / <?php echo $item['darenname'];?>"><?php echo $key;?></a></li>
					<?php }?>
                    <?php } else { ?>
                     <li></li>
					<?php } ?>
                   
    			</ul>

    		</div>

			

    		<ul class="daren-panels" id="J_DarenTabPanels">

					<?php if($arrdaren) { ?>
					<?php foreach((array)$arrdaren as $key=>$item) {?>
    				   <li class="clearfix"  <?php if($key>0) { ?>style="display:none"<?php } ?>>

        				<a class="user-img" href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['userid']))?>" title="<?php echo $item['username'];?>">

    						    							<img src="<?php echo $item['face'];?>" width="80" height="80" alt="<?php echo $item['username'];?>" />

    						    					</a>

        				<a class="user-name g-daren" href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['userid']))?>" title="<?php echo $item['username'];?> / <?php echo $item['darenname'];?>"><em class="ofh"><?php echo $item['username'];?></em><i class="i-daren">达人</i> / <?php echo $item['darenname'];?></a>

						

						<span class="user-desc"><?php echo $item['signed'];?></span>

													<?php if($item['isfollow']==3&&$userid == $TS_USER['user'][userid]) { ?>
                    <div href="#" class="followed-btn">互相关注<span class="mr5 ml5">|</span><a rel="removefollow" href="javascript:;" data-followtype="5" data-userid="<?php echo $item['userid'];?>" data-usernick="<?php echo $item['username'];?>">取消</a></div>
                     <?php } elseif ($item['isfollow']==3) { ?>
                     <div href="#" class="followed-btn">互相关注</div>
                     
                      <?php } elseif ($item['userid']== $TS_USER['user'][userid]) { ?>
                      
                       <div href="#" class="followed-btn">互相关注</div>
                       
                      <?php } elseif ($item['isfollow']==1) { ?>
                     <div href="#" class="followed-btn">已关注</div>
                     
                      <?php } else { ?>
                     <a rel="follow" href="javascript:;" class="follow-btn" data-followtype="<?php if($item['isfollow']==2&&$userid == $TS_USER['user'][userid]) { ?>1<?php } elseif ($item['isfollow']==2) { ?>3<?php } elseif ($item['isfollow']==4&&$userid == $TS_USER['user'][userid]) { ?>5<?php } elseif ($item['isfollow']==4) { ?>4<?php } ?>" data-userid="<?php echo $item['userid'];?>" data-usernick="<?php echo $item['username'];?>">加关注</a><br />
                     <?php } ?>

											</li>
         
                    <?php }?>
					<?php } ?>	
    								    		</ul>

    	</div>

    	

    	<!-- 我创建的 -->
 <?php if($arrtopics) { ?>
		    	<div class="my-joined vertical-box clearfix">

    		    		    		<div class="title">

				<ul class="tab-title clearfix" id="J_MyJoinedTabTitle">

					<li class="first current"><a>我创建的话题</a><i></i></li>

					<!--<li class="last"><a id="J_MyForumBtn">我参与的讨论</a><i></i></li>-->

				</ul>

    		</div>

			<div class="panels" id="J_MyJoinedTabPanels">

				<!-- 我创建的话题 -->

				<div class="panels-con"  id="J_MyTopicPanels">

            		    					<ul>
                                            
					<?php foreach((array)$arrtopics as $key=>$item) {?>    

        				                			<li>

                				<a class="ofh" href="<?php echo SITE_URL;?><?php echo tsurl('group','topic',array('topicid'=>$item['topicid']))?>" title=""><?php echo $item['title'];?></a>

                				<span><?php echo $item['count_comment'];?>条评论，最后回复：<?php echo date('Y-m-d H:i',$item['uptime'])?></span>

                			</li>
                            
                              <?php }?>
					


        				                		</ul>

    					                		<div class="my-pagin" style="height:25px;">

                			
                		</div>

										

				</div><!-- panels-con end -->

			</div><!-- panels end -->



    	</div>
<?php } ?>	
		        <div class="my-joined vertical-box">

            <div class="forum-hot">

                <div class="tab-hot clearfix" id="J_ForumTabNav">

                    <a href="javascript:;" class="on" data-tab="hot">热闹的板块</a><span class="vline5 fl">|</span>

                    <a href="javascript:;" data-tab="my">我创建的板块</a>

                </div>

                

                <div class="tab-con tab-con-hot">

                                        <ul class="clearfix">

<?php foreach((array)$arrHotGroup as $key=>$item) {?>    
                                                        <li>

                                <div class="item">

                                    <h3><a href="<?php echo SITE_URL;?><?php echo tsurl('group','group',array(groupid=>$item['groupid']))?>" target="_blank"><?php echo $item['groupname'];?></a></h3>

                                    <p><?php echo $item['count_topic'];?>个新话题，<?php echo $item['count_user'];?>人参与讨论</p>

                                </div>

                            </li>
<?php }?>
                                                </ul>

                                    </div>

                <div class="tab-con tab-con-my">

                                        <ul class="clearfix">


<?php foreach((array)$myarrgroup as $key=>$item) {?>   
                            <li>

                                <div class="item">

                                    <h3><a href="<?php echo SITE_URL;?><?php echo tsurl('group','group',array(groupid=>$item['groupid']))?>" target="_blank"><?php echo $item['groupname'];?></a></h3>

                                    <p><?php echo $item['count_topic'];?>个新话题，<?php echo $item['count_user'];?>人参与讨论</p>

                                </div>

                            </li>

<?php }?>
                                            </ul>

                                    </div>

            </div>



        </div>



    </div>

</div>

<?php include pubTemplate("JsConstant");?>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/do.min.js"></script>
<script>
(function(){
var b="?t="+GUANGER.staticVersion,a=function(a){return"<?php echo SITE_URL;?>js/"+a+b};Do.add("guang",{path:a("guang.min.js"),type:"js",requires:["tools","cookie"]});Do.add("tools",{path:a("jquery.tools.min.js"),type:"js"});Do.add("cookie",{path:a("jquery.cookie.min.js"),type:"js"});Do.add("share_guang",{path:a("share_guang.min.js"),type:"js",requires:["guang"]});Do.add("search_suggest",{path:a("search_suggest.min.js"),type:"js",requires:["guang"]});Do.add("localstorage",{path:a("localstorage.min.js"),type:"js"});
Do.add("guang_comment",{path:a("comment.min.js"),type:"js"});Do.add("like_say",{path:a("like_say.min.js"),type:"js"});Do.add("common",{path:a("common.min.js"),type:"js",requires:["share_guang","search_suggest","localstorage"]});Do.global("guang");Do("common");
 Do('ajaxfileupload');
})();
</script> 
<script type="text/javascript">
Do('squareBar');
Do('follow');
Do(function(){
	if(window.location.search!=""){
		var discussPosY = $(".discuss-page").offset().top-40;
		$("html, body").animate({
			scrollTop: discussPosY
		}, 120);
	}
});
</script>
<?php include template('footer'); ?>