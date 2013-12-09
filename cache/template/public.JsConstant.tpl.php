<script type="text/javascript">
	var photo = "";
	if(photo == ""){
		photo = "<?php echo SITE_URL;?>public/images/noavatar.gif";
	}else{
		photo = "<?php echo SITE_URL;?>"+photo;
	}
	GUANGER = {
		staticVersion : "20130818",
		userId:"<?php echo $TS_USER['user'][userid];?>",
		nick:"<?php echo $TS_USER['user'][username];?>",
		userPhoto:photo,
		path:"<?php echo SITE_URL;?>",
		referer : "<?php echo SITE_URL;?>",
		login : "",
		<?php if($mediaImgList||$mediaVideoList) { ?>
		mediaImgList:<?php echo $mediaImgList;?>,
		mediaVideoList:<?php echo $mediaVideoList;?>,
		<?php } ?>
		<?php if($strGroup['groupid']) { ?>
		groupid : "<?php echo $strGroup['groupid'];?>",
		<?php } ?>
		<?php if($goods_id) { ?>
		cmurl:"<?php echo SITE_URL;?><?php echo tsurl('baobei',$goods_id)?>",
		<?php } ?>
		login_qq:"<?php if(in_array('qq',$isL_Open)) { ?>1<?php } ?>",
		login_taobao:"<?php if(in_array('taobao',$isL_Open)) { ?>1<?php } ?>",
		login_sina:"<?php if(in_array('sina',$isL_Open)) { ?>1<?php } ?>",
		urltype: '<?php echo $TS_SITE['base'][site_urltype];?>',
		resulthtml: '<?php echo $resulthtml;?>'
	}
</script>