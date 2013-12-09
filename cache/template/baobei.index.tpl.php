<?php include template('header'); ?>
<link href="<?php echo SITE_URL;?>css/detail.min.css" rel="stylesheet" type="text/css" />
<div id="wrap">

		<div class="clearfix" id="container">

			<div id="main" style="width:640px;">

				<div class="main-top" >
				
					<h2><?php echo $strShare['name'];?> <?php if($strShare['price']<>'0') { ?><div class="price_box"><span class="pc">￥</span><?php echo $strShare['price'];?></div><?php } ?></h2>	

					
                    
                    
                    <div class="gallery">

						<div class="pic-box">

						 <?php if($istaobao) { ?>
                            	 <a data-type="0" data-itemid="<?php echo $iitemid;?>" data-tmpl="290x380" data-templid="5" data-rd="1" data-style="1" href="http://item.taobao.com/item.htm?id=<?php echo $iitemid;?>" target="_blank" title="<?php echo $strShare['name'];?>"><img id="J_PicCover" src="<?php echo $strShare['oldimg'];?>" alt="<?php echo $strShare['name'];?>" <?php if($w>0) { ?>width="<?php echo $w;?>" height="<?php echo $h;?>"<?php } ?>/></a>
                            <?php } else { ?>
                            	 <a href="<?php echo $strShare['url'];?>" target="_blank" title="<?php echo $strShare['name'];?>"><img id="J_PicCover" src="<?php echo $strShare['oldimg'];?>" alt="<?php echo $strShare['name'];?>" <?php if($w>0) { ?>width="<?php echo $w;?>" height="<?php echo $h;?>"<?php } ?>/></a>
                            <?php } ?>

						</div>

						<div class="thumb">

							<a class="bgr-btn thumb-nav-prev prev" title="">&lt;</a>

							<div class="thumb-list scrollable">

								<ul class="clearfix items">

																		

										<li  class="cur">

											<a href="javascript:void(0)"><img data-src="<?php echo $strShare['oldimg'];?>" src="<?php echo $strShare['oldimg'];?>" alt="" width="56px" height="56px"/></a>

										</li>
                                        <?php if(count($arroldimg)>1) { ?>
                                        <script type="text/javascript">
										//禁止抓取，不影响SEO
										<?php foreach((array)$arroldimg as $key=>$item) {?>
										 <?php if($item&&$key>0) { ?>
                                        document.writeln("<li ><a href=\"javascript:void(0)\"><img data-src=\"<?php echo $item;?>\" src=\"<?php echo $item;?>\" alt=\"\" width=\"56px\" height=\"56px\"\/><\/a><\/li>");
										<?php } ?>
										<?php }?>
										
										</script>
                                        
                                         <?php } ?>

																	</ul>

							</div>

						</div>

					</div>

					<div class="tags clearfix">

						<span class="fl l2 gc">宝贝标签：</span>
							<?php foreach((array)$strShare['tags'] as $key=>$item) {?>
                            <?php if($cateappname) { ?>
							<a data-tagid="!tag.id" href="<?php echo SITE_URL;?><?php echo tsurl($cateappname,'',array(tag=>$item['tag_name']))?>"><?php echo $item['tag_name'];?></a>
                            <?php } else { ?>
                            <a data-tagid="!tag.id" href="<?php echo SITE_URL;?>index.php?app=home&ac=index&tag=<?php echo $item['tag_name'];?>"><?php echo $item['tag_name'];?></a>
                            <?php } ?>
													<?php }?>
											</div>

					<div class="recommend clearfix">
<div class="cmt clearfix  cmt-love " id="gocomment">

										<div class="user-pic">

																																						<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$strshareUser['userid']))?>"><img title="<?php echo $strshareUser['username'];?>" alt="<?php echo $strshareUser['username'];?>" src="<?php if($strshareUser['face']) { ?><?php echo $strshareUser['face'];?><?php } else { ?><?php echo SITE_URL;?>public/images/noavatar.gif<?php } ?>">
</a>
																			</div>

										<div class="cmt-doc bg-red">

											<div class="cmt-info clearfix">

																									<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$strshareUser['userid']))?>" class="fl"><?php echo $strshareUser['username'];?></a>

											<span class="fl rc">（分享）</span> 

												<span class="fr gc mr10">发布时间：<?php echo date('Y-m-d H:i:s',$strShare['uptime'])?></span>

											</div>

											<p><?php echo $strShare['comment'];?></p>

										</div>

									</div>

					</div>

					<div class="mt10 clearfix">

					<div class="share fr">						

						<span class="fl l20 gc">分享给好友：</span>	
						<a class="s-sina" href="javascript:;" alt="分享到新浪微博"></a>
						<a class="s-qzone" href="javascript:;" alt="分享到QQ空间"></a>	
						<a class="s-tencent" href="javascript:;" alt="分享到腾讯微博"></a>	
						<a class="s-douban" href="javascript:;" alt="分享到豆瓣"></a>		
						<a class="s-renren" href="javascript:;" alt="分享到人人网"></a>
						<a class="s-163" href="javascript:;" alt="分享到网易微博"></a>	
                        				
                    </div>

					</div>

					<div class="act clearfix">

						<div class="like-box">

							<a class="ilike" href="javascript:;" data-type="0" data-loved="0">喜欢+1</a>

						</div>

						<div class="appraisal J_IdentityWorth">

							<span class="fl l30">鉴定：</span>

							<a class="bbl-btn mr10" href="javascript:;" data-type="1">值得</a>

							<a class="bgr-btn" href="javascript:;" data-type="2">不值得</a>
<?php if($strshareUser['userid'] == $TS_USER['user'][userid] || $TS_USER['user'][isadmin] == 1) { ?>
							<a class="fr ml10 baobeidel"  data-type="4" data-proid="<?php echo $strShare['goods_id'];?>" href="javascript:;">删除</a>
<?php } ?>
<?php if($TS_USER['user'][isadmin] == 1) { ?>
<?php if($strShare['istop']==1) { ?>
                            <a class="fr ml10 baobeitop" data-type="0" data-proid="<?php echo $strShare['goods_id'];?>" href="javascript:;">取消置顶</a>
                            <?php } elseif ($strShare['istop']==0 ) { ?>
                             <a class="fr ml10 baobeitop" data-type="1" data-proid="<?php echo $strShare['goods_id'];?>" href="javascript:;">置顶</a>
                            <?php } ?>
                            <?php } ?>
						</div>

					</div>

					<div class="comment">
                    
                    <div class="comment-publish clearfix">
								<div class="pub-box clearfix">
								<div class="user-pic">	
								<img src="<?php if($hface) { ?><?php echo $hface;?><?php } else { ?><?php echo SITE_URL;?>public/images/noavatar.gif<?php } ?>" alt="" width="48" height="48">
								</div>
								<div class="cmt-doc">
									<div class="fm clearfix">
                                    <textarea class="b-textarea atsug cmt-txa"  name="commentContent" placeholder="你觉得这个宝贝怎么样？"  style="height:35px;" id="J_CommentTxa"></textarea>
									</div>
								</div>
								</div>
								<div id="J_CmtHiddenForm" style="display: none;">

									<div class="select clearfix">
										<h4>鉴定：</h4>
										<div class="appraisal fl">
										<a href="javascript:;" class="jd-radio worth-radioclick-on mr10" name="worth" data-type="1"><span>值得</span></a>
											<a href="javascript:;" class="jd-radio worth-radioclick-off mr10" name="worth" data-type="2"><span>不值得</span></a>
																					</div>
										
									</div>
									<div class="submit-row">
										<input type="submit" class="bbl-btn pub" id="J_LkCommentSubmit"  style="cursor:pointer" value="发布"><span class="ml10"><a id="J_HiddenForm" href="javascript:;" class="gc">取消</a></span>
										
									</div>
								</div>
							</div>

						<h3>大家说…</h3>

						<ul class="comment-nav clearfix" id="J_CmtNav">

							<li><a class="current" id="J_CmtAllBtn">全部</a></li>
<!--
							<li><a  id="J_CmtLoveBtn">喜欢的人说</a><i class="vline">|</i></li>

							<li><a  id="J_CmtWorthBtn">认为值得的人说</a><i class="vline">|</i></li>

							<li><a  id="J_CmtNoWorthBtn">认为不值得的人说</a></li>
-->
						</ul>				

						<div class="comment-list">
							<div id="J_ShowResult">

																								

							</div>

							<div id="J_HiddenResult">

									
											<?php if(is_array($arrShareComment)) { ?>
											<?php foreach((array)$arrShareComment as $key=>$item) {?>
																							
											<?php if($item['user'][userid]) { ?>
									<div class="cmt clearfix <?php if($item['commentType']==0) { ?> cmt-love <?php } elseif ($item['commentType']==1 ) { ?> cmt-worth <?php } elseif ($item['commentType']==2 ) { ?> cmt-noworth <?php } ?>">

										<div class="user-pic">

																																						<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['user'][userid]))?>"><img title="<?php echo $item['user'][username];?>" alt="<?php echo $item['user'][username];?>" src="<?php echo $item['user'][face];?>" />
</a>
																			</div>

										<div class="cmt-doc <?php if($item['commentType']==0) { ?>bg-red<?php } elseif ($item['commentType']==1 ) { ?>bg-blue<?php } elseif ($item['commentType']==2 ) { ?>bg-gray<?php } ?>">

											<div class="cmt-info clearfix">

																									<a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['user'][userid]))?>" class="fl"><?php echo $item['user'][username];?></a>

											<?php if($item['commentType']==0) { ?><span class="fl rc">（喜欢）</span> <?php } elseif ($item['commentType']==1 ) { ?> <span class="fl rc">（值得）</span> <?php } elseif ($item['commentType']==2 ) { ?> <span class="fl gc">（认为不值得）</span> <?php } ?>

												<span class="fr gc">来自 本站 </span>

												<span class="fr gc mr10"><?php echo date('Y-m-d H:i:s',$item['addtime'])?></span>

											</div>
                                            
                                        <?php if($item['recomment']) { ?>

										<div class="post-reply" data-cmtid="">
            								<span class="info">回复 
                                             <a class="J_UserNick" href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['recomment'][user][userid]))?>" target="_blank" title="<?php echo $item['recomment'][user][username];?>"><?php echo $item['recomment'][user][username];?></a>
                    								<span class="time">/  <?php echo date('m-d H:i',$item['recomment'][addtime])?></span></span>
            								<p class="post-quoteContent" title="">
            								
            								<?php echo $item['recomment'][content];?>      								
            								</p>
            								<span class="post-floor"></span>
            							</div>
                             <?php } ?>               
											<p><?php echo $item['content'];?></p>
                                            <a class="J_CmtReplyBtn btn" data-username="<?php echo $item['user'][username];?>" data-referid="<?php echo $item['commentid'];?>">回复<em class="J_ReplyCount" data-count="0"></em></a>
                                            

										</div>

									</div>
									
									<?php } else { ?>
									<div class="cmt clearfix cmt-nojudement">

										<div class="user-pic">

										<img src="<?php echo SITE_URL;?>public/images/noavatar.gif" />

																			</div>

										<div class="cmt-doc bg-gray">

											<div class="cmt-info clearfix">
																								

												<span class="fl gc">来自 互联网 </span>

												<span class="fr gc mr10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d',$item['addtime'])?></span>

											</div>

											<p><?php echo $item['content'];?></p>

										</div>

									</div>
									<?php } ?>
												<?php }?>
<?php } ?>												

																	

																								

																	

																							</div>

						</div>

						<div class="clearfix">

							<div class="pagin fr pagination" id="J_Pagination">

								<?php echo $pageUrl;?>

							</div>

						</div>

					</div>

				</div>

				

			</div>

			<!-- aside begin -->

			<div id="aside">
            
<?php if($strShare['url']!=='') { ?>

				<div class="block">

					<div class="clearfix">
				
                <a class="likes" href="javascript:;" data-type="0"><em id="J_LikeCount" data-val="<?php echo $LikeNum;?>"><?php echo $LikeNum;?></em></a>

						<div class="stat-box" <?php if(!$istaobao) { ?>style="background-image:url(<?php echo SITE_URL;?>images/stat-bg2.png);"<?php } ?>>
					
							<span class="fl">
                             <?php if($istaobao) { ?>
                            	 <a data-type="0" data-itemid="<?php echo $iitemid;?>" data-tmpl="290x380" data-templid="5" data-rd="1" data-style="1" href="http://item.taobao.com/item.htm?id=<?php echo $iitemid;?>" target="_blank" title="<?php echo $strShare['name'];?>" style=" display:block; width:80px; height:47px;"></a>
                            <?php } else { ?>
                            	 <a href="<?php echo $strShare['url'];?>" target="_blank" title="<?php echo $strShare['name'];?>" style=" display:block; width:80px; height:47px;"></a>
                            <?php } ?>
                           </span>
                            

							<span class="fr"><?php echo $commentNum;?></span>

						</div>

					</div>

					<div class="evaluate">

						<div class="value J_CountValue">

							<div class="pb10">

															<span class="gc6"><em class="scount"><?php echo $scountNum;?></em>人认为值得<i class="mlr5">/</i><em class="bcount"><?php echo $bcountNum;?></em>人已鉴定</span>

							</div>

							<div class="value-bar">

								<div class="worth" id="J_Worth" data-bcount="<?php echo $bcountNum;?>" data-scount="<?php echo $scountNum;?>"></div>

							</div>

							<div class="mt10 clearfix J_IdentityWorth">

								<a class="sbl-btn mr10" href="javascript:;" data-type="1">值得</a>

								<a class="sgr-btn" href="javascript:;" data-type="2">不值得</a>

							</div>

						</div>

						<div class="evaluate-say">

							<div class="arrow-u"></div>

							<a class="close" href="javascript:;"></a>


						</div>

					</div>

				</div>
                
                <?php } ?>
                
                <?php doAction('adcode',null,'10')?>

                

				<div class="block">

					<h3>发现喜欢…</h3>

					<div id="J_FindGoods">

						<div class="finding">
	<div class="finds clearfix">
			<?php if(is_array($arrfinds)) { ?>
			<?php foreach((array)$arrfinds as $key=>$item) {?>
			<a class="finds-item" href="<?php echo SITE_URL;?><?php echo tsurl('baobei',$item['goods_id'])?>" data-likeCnt="<?php echo $item['count_like'];?>" data-commentCnt="<?php echo $item['count_comment'];?>" data-saleCnt="0"><img src="<?php echo SITE_URL;?><?php echo $item['img'];?>" alt="<?php echo $item['name'];?>" /></a>
			<?php }?>
			<?php } ?>
		</div>
</div>
<div class="finding-stat clearfix" id="J_FindsCount">
	<a class="like-num like-count" href="javascript:;"><?php echo $item['count_like'];?></a>
	<span>评论：<em class="cmt-count">0</em></span>
	<!--<span>最近销量：<em class="sale-count">0</em></span>-->
</div>
	<input type="hidden" id="J_HiddenProductId" value="<?php echo $goods_id;?>"/>

	<input type="hidden" id="J_HiddenUserId" value="<?php echo $TS_USER['user'][userid];?>"/>

	<input type="hidden" id="J_HiddenUserNick" value="<?php echo $TS_USER['user'][username];?>"/>

	<input type="hidden" id="J_HiddenUserPhoto" value="<?php echo $strUser['face'];?>"/>


					</div>

					<div class="another clearfix">

						<div class="tick-bar">

							<div class="ticking"></div>

							<div class="tick-txt"><em>10</em>秒后离你而去</div>

						</div>

					<a class="bbl-btn ml15" href="javascript:;" id="J_ChangeGroupBtn" data-proId="1004427" data-index="1" data-cate="23" data-tagids="   2117,   2102,   785,   2118,   660  " data-minid="1003116">换一个</a>
					</div>

				</div>
                

					<?php doAction('adcode',null,'11')?>

                
                
                
                <div class="block">
					<h3>喜欢它的人...</h3>
					<ul class="likers clearfix">
            <?php if(is_array($arrLikers)) { ?>
			<?php foreach((array)$arrLikers as $key=>$item) {?>
            	<?php if($item['user'][userid]) { ?>
                <li>
                        <a href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['user'][userid]))?>" target="_blank"><img src="<?php echo $item['user'][face];?>" alt="<?php echo $item['user'][username];?>"><span><?php echo $item['user'][username];?></span></a>
                        </li>
               <?php } ?>
            <?php }?>
			<?php } ?>
										</ul>
				</div>

				

							</div><!--aside end-->

					<!-- aside end -->

		</div>
        
<?php include pubTemplate("JsConstant");?>

<div class="tooltip" style="left: 712px; top: 179px; display: none; ">
<?php if($strShare['shop_info']) { ?>
											<div class="shop-bg">
												<div class="shop-con">
													<div class="shop-arrow"></div>
																										<div class="shop-card clearfix">
														<div class="card-logo logo-taobao">
														taobao
														</div>
														<div class="card-info">
															<h4><?php echo $arrshop_info['nick'];?></h4>
															<p>
																<span class="shop-rank A<?php echo $strShare['seller_credit_score'];?>"></span>
															</p>
														</div>
													</div>
													<div class="shop-rate">
														<h4>动态评分<!--<span class="compare">与同行比</span>--></h4>
														<ul>
															<li>
                          										描述相符:<em class="count"><?php echo $arrshop_info['item_score'];?></em>
															</li>
                   											<li>
                          										服务态度:<em class="count"><?php echo $arrshop_info['service_score'];?></em>
															</li>
															<li>
                          										发货速度:<em class="count"><?php echo $arrshop_info['delivery_score'];?></em>
                        									</li>
														</ul>
													</div>
													<div class="shop-details">
														
													</div>
																									</div>
											</div>
<?php } ?>                 
										</div>

<script src="<?php echo SITE_URL;?>js/jquery-1.6.4.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo SITE_URL;?>js/jquery.tools.min.js"></script>

<script type="text/javascript" src="<?php echo SITE_URL;?>js/jquery.cookie.min.js?t=2012112603" async="true"></script>

<script type="text/javascript" src='<?php echo SITE_URL;?>js/guang.min.js?t=20120106230000.js'></script>

<script type="text/javascript" src='<?php echo SITE_URL;?>js/comment.min.js'></script>

<script type="text/javascript" src="<?php echo SITE_URL;?>js/ajaxfileupload.min.js"></script>

<script type="text/javascript" src="<?php echo SITE_URL;?>js/detail.js"></script>

<script type="text/javascript">

$(".share a").click(function(){
		var title='<?php echo $strShare['name'];?> - <?php echo $TS_APP['options'][appname];?> - <?php echo $TS_SITE['base'][site_title];?>',
		link=encodeURIComponent(window.location.href),
		cls = $(this).attr("class");
		title = encodeURIComponent(title);
		switch (cls){
			case "s-sina":
				window.open('http://service.t.sina.com.cn/share/share.php?title='+title+'&pic=&url='+link);
				break;
			case "s-tencent":
				window.open('http://v.t.qq.com/share/share.php?url='+link+'&title='+title+'&pic=&site='+link);
				break;
			case "s-douban":
				window.open('http://www.douban.com/recommend/?url='+link+'&title='+title);
				break;
			case "s-qzone":
				window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+link);
				break;
			case "s-renren":
				window.open('http://share.renren.com/share/buttonshare.do?link='+link+'&title='+title);
				break;
			case "s-163":
				window.open('http://t.163.com/article/user/checkLogin.do?link='+link+'&source=&info='+title+'&images=');
		}
		
	});
	
	</script>
<script type="text/javascript" src='<?php echo SITE_URL;?>js/common.min.js'></script>

<script type="text/javascript">
(function(win,doc){
var s = doc.createElement("script"), h = doc.getElementsByTagName("head")[0];
if (!win.alimamatk_show) {
s.charset = "gbk";
s.async = true;
s.src = "http://a.alimama.cn/tkapi.js";
h.insertBefore(s, h.firstChild);
}
var o = {
pid: "<?php echo $TS_SITE['base']['tdj_PID'];?>",
appkey: "",
unid: ""
}
win.alimamatk_onload = win.alimamatk_onload || [];
win.alimamatk_onload.push(o);
})(window,document);
</script>
<?php include template('footer'); ?>