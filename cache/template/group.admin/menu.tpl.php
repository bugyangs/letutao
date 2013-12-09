<h2>板块管理</h2>
<div class="tabnav">
<ul>
<li <?php if($mg=='options') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=group&ac=admin&mg=options">板块配置</a></li>

<?php if($TS_APP['options'][ismode]=='0') { ?>

<li <?php if($mg=='group' && $ts=='list') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=group&ac=admin&mg=group&ts=list">全部板块</a></li>

<?php if($mg=='group' && $ts=='edit') { ?><li class="select"><a href="">编辑<?php echo $arrGroup['groupname'];?></a></li><?php } ?>

<?php if($mg=='cate' && $ts=='edit') { ?><li class="select"><a href="">编辑<?php echo $strCate['catename'];?>分类</a></li><?php } ?>

<?php } ?>
<li <?php if($mg=='options') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=group&ac=admin&mg=options">话题管理</a></li>
</ul>
</div>