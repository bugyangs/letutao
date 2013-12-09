<?php include template('header'); ?>
<link href="<?php echo SITE_URL;?>css/feeds.css" rel="stylesheet" type="text/css" />

<div id="wrap">
	<div id="container" class="clearfix">
		<div class="main box-shadow">
			<div class="nav">
				<ul class="clearfix">
					<li <?php if($news=='index'||$news=='goods'||$news=='zhuti'||$news=='pinpai'||$news=='topic') { ?>class="cur"<?php } ?>>
                    <?php if($userid>0) { ?>
                    <a href="<?php echo SITE_URL;?><?php echo tsurl('feed')?>">好友动态</a>
                    <?php } else { ?>
                    <a href="javascript:;" date-href="<?php echo SITE_URL;?><?php echo tsurl('feed')?>" class="create-btn">好友动态</a>
                    <?php } ?>
                    </li>
					<li <?php if($news=='news') { ?>class="cur"<?php } ?>><a href="<?php echo SITE_URL;?><?php echo tsurl('feed','news')?>">全站动态</a></li>
				</ul>
			</div>
						<div class="feeds-list">
								<div class="feeds-menu">
		
		<div class="fl feeds-cate">
		<label>分类：</label>
        <?php if($news=='index'||$news=='goods'||$news=='zhuti'||$news=='pinpai'||$news=='topic') { ?>
		<a href="<?php echo SITE_URL;?><?php echo tsurl('feed')?>"  <?php if($news=='index') { ?>class="cur"<?php } ?> >全部</a>
		<span>|</span>
		<a href="<?php echo SITE_URL;?><?php echo tsurl('feed','goods')?>" <?php if($news=='goods') { ?>class="cur"<?php } ?>>宝贝</a>
		<span>|</span>
		<a href="<?php echo SITE_URL;?><?php echo tsurl('feed','zhuti')?>" <?php if($news=='zhuti') { ?>class="cur"<?php } ?>>主题</a>
        <span>|</span>
        <a href="<?php echo SITE_URL;?><?php echo tsurl('feed','topic')?>" <?php if($news=='topic') { ?>class="cur"<?php } ?>>讨论</a>
        
        <?php } elseif ($news=='news') { ?>
        
        <a href="<?php echo SITE_URL;?><?php echo tsurl('feed','news')?>"  <?php if($type=='') { ?>class="cur"<?php } ?> >全部</a>
		<span>|</span>
		<a href="<?php echo SITE_URL;?><?php echo tsurl('feed','news',array('type'=>'goods'))?>" <?php if($type=='goods') { ?>class="cur"<?php } ?>>宝贝</a>
		<span>|</span>
		<a href="<?php echo SITE_URL;?><?php echo tsurl('feed','news',array('type'=>'zhuti'))?>" <?php if($type=='zhuti') { ?>class="cur"<?php } ?>>主题</a>
        <span>|</span>
        <a href="<?php echo SITE_URL;?><?php echo tsurl('feed','news',array('type'=>'topic'))?>" <?php if($type=='topic') { ?>class="cur"<?php } ?>>讨论</a>
        
        <?php } ?>

	</div>
	</div>
    <?php if($arrfollowfeed) { ?>
    <?php foreach((array)$arrfollowfeed as $key=>$item) {?>
    <?php if($item['feedtype']=='goods') { ?>
	<div class="section clearfix">
		<div class="byUser-pic">
			<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('userid'=>$item['user'][userid]))?>" title="<?php echo $item['user'][username];?>" target="_blank">
			<img src="<?php echo $item['user'][face];?>" width="60" height="60" alt="<?php echo $item['user'][username];?>" title="<?php echo $item['user'][username];?>"/>
			</a>
		</div>
		<div class="byUser-feeds">
									<h3 class="ofh"><a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('userid'=>$item['user'][userid]))?>" target="_blank"><?php echo $item['user'][username];?></a><span class="content mr10">：<?php echo $item['data'][ctyle];?> <a href="<?php echo SITE_URL;?><?php echo tsurl('baobei',$item['data'][goods_id])?>" target="_blank"><?php echo $item['data'][title];?></a></span></h3>
									<div class="feeds-info">
							<div class="baobei-feeds clearfix">
					<div class="baobei-pic" rel="small" data-proid="<?php echo $item['data'][goods_id];?>">
						<img src="<?php if($DISK_YUN['isopen']) { ?><?php echo BCS_URL;?><?php echo $item['data'][img];?><?php } else { ?><?php echo SITE_URL;?><?php echo $item['data'][img];?><?php } ?>" alt="<?php echo $item['data'][title];?>" width="120"/>					
						<span>￥<?php echo $item['price'];?></span>
					</div>
				</div>
				<div class="comment-time">
						<?php if($item['user'][userid] == $TS_USER['user'][userid] ||$TS_USER['user'][userid] == 1) { ?><a class="fr btn" rel="del_feed" href="javascript:;" data-feedid="<?php echo $item['feedid'];?>" title="删除该动态">删除动态</a>
                        <span class="mr5 ml5 gcc fr">|</span>
                    <?php } ?>
										
                                        
					<a href="<?php echo SITE_URL;?><?php echo tsurl('baobei',$item['data'][goods_id])?>" class="fr btn">查看详情</a>
										<span class="gc"><?php echo date('m-d H:i',$item['addtime'])?></span>
				</div>
						</div>
		</div>
	</div>
    <?php } elseif ($item['feedtype']=='zhuti') { ?>
     <?php if($item['data'][topicid]) { ?>
   		<div class="section clearfix">
		<div class="byUser-pic">
			<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('userid'=>$item['user'][userid]))?>" title="<?php echo $item['user'][username];?>" target="_blank">
			<img src="<?php echo $item['user'][face];?>" width="60" height="60" alt="<?php echo $item['user'][username];?>" title="<?php echo $item['user'][username];?>"/>
			</a>
		</div>
		<div class="byUser-feeds">
									<h3 class="ofh"><a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('userid'=>$item['user'][userid]))?>" target="_blank"><?php echo $item['user'][username];?></a>:<?php echo $item['content'];?></h3>
                                    
                                    <p class="byUser-comment wbbw"><?php echo $item['data'][content];?></p>
									<div class="feeds-info">
				<div class="comment-time">
					
					<?php if($item['user'][userid] == $TS_USER['user'][userid] ||$TS_USER['user'][userid] == 1) { ?><a class="fr btn" rel="del_feed" href="javascript:;" data-feedid="<?php echo $item['feedid'];?>" title="删除该动态">删除动态</a>
                    <?php } ?>
										<span class="gc"><?php echo date('m-d H:i',$item['addtime'])?></span>
				</div>
						</div>
		</div>
	</div>
     <?php } ?>
      <?php if($item['data'][themeid]) { ?>
    	<div class="section clearfix">
		<div class="byUser-pic">
			<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('userid'=>$item['user'][userid]))?>" title="<?php echo $item['user'][username];?>" target="_blank">
			<img src="<?php echo $item['user'][face];?>" width="60" height="60" alt="<?php echo $item['user'][username];?>" title="<?php echo $item['user'][username];?>"/>
			</a>
		</div>
		<div class="byUser-feeds">
									<h3 class="ofh"><a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('userid'=>$item['user'][userid]))?>" target="_blank"><?php echo $item['user'][username];?></a><span class="content mr10">：<?php echo $item['data'][ctyle];?> <a href="<?php echo SITE_URL;?><?php echo tsurl('zhuti'.$item['data'][themeid])?>" target="_blank"><?php echo $item['data'][title];?></a></span></h3>
									<div class="feeds-info">
							<div class="topic-feeds clearfix">
					<div class="topic-pic viewlike">
						<a class="pic" target="_blank" href="<?php echo SITE_URL;?><?php echo tsurl('zhuti'.$item['data'][themeid])?>">
						<span class="b-img"><img src="<?php echo SITE_URL;?><?php echo $item['data'][img];?>" alt="<?php echo $item['data'][title];?>"></span></a>
					</div>
				</div>
				<div class="comment-time">
				<?php if($item['user'][userid] == $TS_USER['user'][userid] ||$TS_USER['user'][userid] == 1) { ?><a class="fr btn" rel="del_feed" href="javascript:;" data-feedid="<?php echo $item['feedid'];?>" title="删除该动态">删除动态</a>
                    <?php } ?>
										<span class="gc"><?php echo date('m-d H:i',$item['addtime'])?></span>
				</div>
						</div>
		</div>
	</div>
     <?php } ?>
    
	<?php } elseif ($item['feedtype']=='topic'||$item['feedtype']=='zhuti') { ?>
    
    
    
    <div class="section clearfix">
		<div class="byUser-pic">
			<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('userid'=>$item['user'][userid]))?>" title="<?php echo $item['user'][username];?>" target="_blank">
			<img src="<?php echo $item['user'][face];?>" width="60" height="60" alt="<?php echo $item['user'][username];?>" title="<?php echo $item['user'][username];?>"/>
			</a>
		</div>
		<div class="byUser-feeds">
									<h3 class="ofh"><a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('userid'=>$item['user'][userid]))?>" target="_blank"><?php echo $item['user'][username];?></a>:<?php echo $item['content'];?></h3>
                                    
                                    <p class="byUser-comment wbbw"><?php echo $item['data'][content];?></p>
									<div class="feeds-info">
				<div class="comment-time">
					
					<?php if($item['user'][userid] == $TS_USER['user'][userid] ||$TS_USER['user'][userid] == 1) { ?><a class="fr btn" rel="del_feed" href="javascript:;" data-feedid="<?php echo $item['feedid'];?>" title="删除该动态">删除动态</a>
                    <?php } ?>
										<span class="gc"><?php echo date('m-d H:i',$item['addtime'])?></span>
				</div>
						</div>
		</div>
	</div>
    
    
    <?php } ?>
    <?php }?>
     <?php } else { ?>
     <p style="line-height:34px;">
     
     暂无任何动态...
     
     </p>
    <?php } ?>
	  								<div class="clearfix pt20 pb20">

					<div class="pagin fr pagination" id="J_Pagination">
                    
                     <?php echo $pageUrl;?>
                    
                    </div>
                   
				</div>
			</div>
					</div><!--main end-->
		<div class="side">
		
	<!--小道消息-->	
		<div class="news box-shadow plr15 ss">
		<div class="title">小道消息，嘘...</div>
		<ul id="J_FeedsNews">
            <?php if($arrfriendfeed) { ?>
    <?php foreach((array)$arrfriendfeed as $key=>$item) {?>
        
        <li>
				<div class="user-pic">
					<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('userid'=>$item['user'][userid]))?>" target="_blank">
					<img src="<?php echo $item['user'][face];?>" width="30" height="30" alt="alezebet_5045" title="alezebet_5045"/>
					</a>
				</div>
				<div class="user-news">
					<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array('userid'=>$item['user'][userid]))?>" target="_blank"><?php echo $item['user'][username];?></a>&nbsp;刚刚关注了
																								<a href="<?php echo $item['data'][link];?>" target="_blank"><?php echo $item['data'][username];?></a>																																															   					<br/>
									</div>
			</li>
                <?php }?>
    <?php } ?>
        
					</ul>
	</div>
		
	<!--登录状态-->
    <?php if($userid>0) { ?>
			<div class="interest box-shadow plr15 ss">
		<div class="title">你可能感兴趣的人</div>
		<ul class="interPer" id="J_InterPer">
											   <?php if($arrPer) { ?>
                            <?php foreach((array)$arrPer as $key=>$item) {?>
                            
						<li>
				<div class="user-pic">
					<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['user'][userid]))?>" title="<?php echo $item['user'][username];?>">
        			        				<img src="<?php echo $item['user'][face];?>" width="50" height="50" alt="<?php echo $item['user'][username];?>" title="<?php echo $item['user'][username];?>">
        								</a>
				</div>
				<div class="user-info">
										<a class="username ofh" href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['user'][userid]))?>" title="<?php echo $item['user'][username];?>"><?php echo $item['user'][username];?></a>
									<p>关注 <?php echo $item['user'][count_follow];?><span class="mr5 ml5">|</span>粉丝 <?php echo $item['user'][count_followed];?> </p>
					<a rel="follow" href="javascript:;" class="follow-btn" data-followtype="<?php echo $item['ft'];?>" data-userid="<?php echo $item['user'][userid];?>">加关注</a>
				</div>
			</li>
            <?php }?>
            
            <?php } else { ?>
            <li><p>木有了，你好厉害，系统自愧不如。</p></li>
                            <?php } ?>
								</ul>
	</div>
    
    <?php } ?>
			
		<div class="friend-comment box-shadow plr15 ss">
		<div class="title">
			他们正在讨论...
		</div>
		<ul style="overflow:hidden">
        											   <?php if($arrnowtopic) { ?>
                            <?php foreach((array)$arrnowtopic as $key=>$item) {?>
        <li>
				<div class="comment-pic">
				<a class="username ofh" href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['user'][userid]))?>" title="<?php echo $item['user'][username];?>" target="_blank">
					<img src="<?php echo $item['user'][face];?>" width="30" height="30" alt="<?php echo $item['user'][username];?>" title="<?php echo $item['user'][username];?>"/>
					</a>
				</div>
				<div class="comment-con">
					<p class="top">
						<a href="<?php echo SITE_URL;?><?php echo tsurl('group','topic',array('topicid'=>$item['topicid']))?>" target="_blank"><?php echo $item['title'];?></a>
					</p>
					<p class="btm">
                    <?php if($item['typeid']==1) { ?>
						<a href="<?php echo SITE_URL;?><?php echo tsurl('zhuti',$item['catetheme'])?>" target="_blank"><?php echo $item['catetheme'];?></a><?php } elseif ($item['typeid']==0) { ?><a href="<?php echo SITE_URL;?><?php echo tsurl('group','group',array(groupid=>$item['groupid']))?>" target="_blank"><?php echo $item['groupname'];?></a><?php } ?><span class="mr5 ml5">/</span><a href="<?php echo SITE_URL;?><?php echo tsurl('group','topic',array('topicid'=>$item['topicid']))?>" target="_blank"><?php echo $item['count_comment'];?>条回复</a>
					</p>
				</div>
			</li>
            <?php }?>
            <?php } ?>
					</ul>
	</div>

		
	<!--登录状态-->
<input id="J_ForumPostCon" type="hidden" />
<style>.guang-editor-wrap { display:none}</style>
			<!--未登录状态-->
	</div><!--side end-->
	</div>
</div>

<?php include pubTemplate("JsConstant");?>

<script type="text/javascript" src="<?php echo SITE_URL;?>js/do.min.js"></script>
<script>
(function(){
var b="?t="+GUANGER.staticVersion,a=function(a){return"<?php echo SITE_URL;?>js/"+a+b};Do.add("guang",{path:a("guang.min.js"),type:"js",requires:["tools","cookie"]});Do.add("tools",{path:a("jquery.tools.min.js"),type:"js"});Do.add("cookie",{path:a("jquery.cookie.min.js"),type:"js"});Do.add("share_guang",{path:a("share_guang.min.js"),type:"js",requires:["guang"]});Do.add("search_suggest",{path:a("search_suggest.min.js"),type:"js",requires:["guang"]});Do.add("localstorage",{path:a("localstorage.min.js"),type:"js"});Do.add("track_info",{path:a("track_info.min.js"),type:"js"});
    Do.add("guang_comment",{path:a("comment.min.js"),type:"js"});Do.add("add_topic_say",{path:a("add_topic_say.min.js"),type:"js"});Do.add("like_say",{path:a("like_say.min.js"),type:"js"});Do.add("common",{path:a("common.min.js"),type:"js",requires:["share_guang","search_suggest","localstorage"]});Do.global("guang");Do("common");Do("track_info");
})();
</script>
<script type="text/javascript">
Do('follow');
Do('feedfile');
Do('ajaxfileupload');
</script>


<?php include template('footer'); ?>