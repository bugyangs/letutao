    <div class="footer" id="footer">
	<a class="guangLink" href="<?php echo SITE_URL;?>"></a>
	<div class="footer-nav clearfix">
		<dl class="about">

				<dt>关于我们</dt>

				<dd><a href="<?php echo SITE_URL;?><?php echo tsurl('common','about')?>" target="_blank">关于我们</a></dd>

				<dd> <a href="<?php echo SITE_URL;?><?php echo tsurl('common','contact')?>" target="_blank">联系我们</a></dd>

				<dd><a href="<?php echo SITE_URL;?><?php echo tsurl('common','agreement')?>" target="_blank">用户条款</a></dd>
                
                <dd><a href="<?php echo SITE_URL;?>sitemap.xml" target="_blank">网站地图</a></dd>

			</dl>
		<dl class="followus">
			<dt>关注我们</dt>
			<dd><a class="f-Qzone" href="#" rel="nofollow" target="_blank">QQ空间</a></dd>
			<dd><a class="f-sina" href="#" rel="nofollow" target="_blank">新浪微博</a></dd>
		</dl>
				<dl class="friendlinks">
			<dt>友情链接</dt>
				<?php links_html()?>		 
		</dl>
				<dl class="how">
			<dt>频道推荐</dt>
            
			<dd><a href="<?php echo SITE_URL;?><?php echo tsurl('faxian')?>" target="_blank">女人爱逛</a></dd>
			<dd><a href="<?php echo SITE_URL;?><?php echo tsurl('zhuti')?>" target="_blank">主题街</a></dd>
			<dd><a href="<?php echo SITE_URL;?><?php echo tsurl('feed')?>" target="_blank">好友动态</a></dd>
			<dd><a href="<?php echo SITE_URL;?><?php echo tsurl('tuan')?>" target="_blank">团购打折</a></dd>
		</dl>
	</div>
	<p class="cp">Copyright (c)2012, All Rights Reserved.  <?php echo $TS_SITE['base'][site_icp];?>  <script>
t="60,97,32,104,114,101,102,61,34,104,116,116,112,58,47,47,98,98,115,46,103,111,112,101,46,99,110,47,34,32,116,97,114,103,101,116,61,34,95,98,108,97,110,107,34,32,62,60,102,111,110,116,32,99,111,108,111,114,61,34,114,101,100,34,62,29399,25169,28304,30721,31038,21306,60,47,102,111,110,116,62,60,47,97,62"
t=eval("String.fromCharCode("+t+")");
document.write(t);</script>技术支持</p>
</div>
<a id="returnTop" href="javascript:;">回到顶部</a>
<?php doAction('pub_footer')?>
</body>