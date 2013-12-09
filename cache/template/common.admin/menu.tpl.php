<h2>首页管理</h2>
<div class="tabnav">
<ul>
<li <?php if($mg=='info' && $ts=='about') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=common&ac=admin&mg=info&ts=about">关于我们</a></li>
<li <?php if($mg=='info' && $ts=='contact') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=common&ac=admin&mg=info&ts=contact">联系我们</a></li>
<li <?php if($mg=='info' && $ts=='agreement') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=common&ac=admin&mg=info&ts=agreement">用户条款</a></li>


</ul>
</div>