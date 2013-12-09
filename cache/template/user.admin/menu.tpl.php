<h2>用户管理</h2>
<div class="tabnav">
<ul>
<li <?php if($mg=='options') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=user&ac=admin&mg=options">用户配置</a></li>
<li <?php if($mg=='user' && $ts=='list') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=user&ac=admin&mg=user&ts=list">用户管理</a></li>

<?php if($mg=='user' && $ts=='view') { ?><li class="select"><a href="<?php echo SITE_URL;?>index.php?app=user&ac=admin&mg=user&ts=list"><?php echo $strUser['username'];?>用户信息</a></li>

<?php } ?>
<li <?php if($mg=='user' && $ts=='daren') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=user&ac=admin&mg=user&ts=daren">达人设置</a></li>
</ul>
</div>