<div class="side-nav">
	<h2>帐号设置</h2>
	<ul>
<li><a <?php if($ts=="base") { ?>class="on"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>base))?>">基本信息</a></li>
<li><a <?php if($ts=="face") { ?>class="on"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>face))?>">会员头像</a></li>
<li><a <?php if($ts=="pwd") { ?>class="on"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>pwd))?>">修改密码</a></li>
<li><a <?php if($ts=="city") { ?>class="on"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl('user','set',array(ts=>city))?>">所在地</a></li>
        	</ul>
</div>