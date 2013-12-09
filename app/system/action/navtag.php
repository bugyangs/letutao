<?php 
defined('IN_TS') or die('Access Denied.');


switch($ts){
	case "":
		$title = '导航设置';
		
		$cate_id = intval($_GET['cate_id']);
		
		//获取分类标签
		$arrnavtag = $db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where cate_id='$cate_id' order by id asc");
		
		$strcate = $db->once_fetch_assoc("select * from ".dbprefix."goods_cate  where cate_id='$cate_id'");
		
		$arr_cates = aac('sharetag')->getObjTagByCateid_new($cate_id);
		
		include template("navtag");
	break;
		
	case "subcate_ico":
		$title = '设置图标';
		
		$subcate_id = intval($_GET['subcate_id']);
		$cate_id = intval($_GET['cate_id']);
		
		include template("subcate_ico");
	break;
	
	case "do_subcate_ico":
		$title = '设置图标';
		$cate_id = intval($_POST['cate_id']);
		$subcate_id = intval($_POST['subcate_id']);
		if(!empty($_FILES['cate_icon']['name'])) {
		
			$f=$_FILES['cate_icon'];
			$uptypes = array( 
			'image/jpg',
			'image/jpeg',
			'image/png',
			'image/pjpeg',
			'image/gif',
			'image/x-png',
			);
		
		if (!in_array($f['type'],$uptypes)) {
					qiMsg("你上传的图片类型不正确，系统仅支持 jpg,gif,png 格式的图片！");
				}
				
			$newdir = date('Ymd',time());
			$dest_dir='uploadfile/subcate_ico/'.$newdir;
			createFolders($dest_dir);
			
			//原图
			$fileInfo=pathinfo($f['name']);
			$extension=$fileInfo['extension'];
			$newphotoname = $extension;
			$dest=$dest_dir.'/'.date("Ymd_His") . '_' . rand(100,999).'.'.$newphotoname;

			move_uploaded_file($f['tmp_name'],mb_convert_encoding($dest,"gb2312","UTF-8"));
			chmod($dest, 0755);
			
			$db->query("update ".dbprefix."goods_subcate set `subcate_icon`='$dest' where subcate_id='$subcate_id'");
			
			header("Location: index.php?app=system&ac=navtag&cate_id=$cate_id");

			}else{
				qiMsg("请选择要上传的图片！");
			}
		
		include template("subcate_ico");
	break;
		
	case "do_subtag":
		
		$subcate_id = intval($_POST['subcate_id']);
		$tag = trim($_POST['tag']);
		$tag = str_replace(',','，',$tag);
		$tag = str_replace(' ','，',$tag);
		$tag = str_replace('，，','，',$tag);
		$db->query("update ".dbprefix."goods_subcate set `tag`='$tag' where subcate_id='$subcate_id'");
		echo 1;
	break;
	case "do_catename":
		
		$cate_id = intval($_POST['cate_id']);
		$cate_name = trim($_POST['cate_name']);
		$strsubcate = $db->once_fetch_assoc("select parent_id from ".dbprefix."goods_cate  where cate_id='$cate_id'");
		$strcate = $db->once_fetch_assoc("select appname from ".dbprefix."goods_cate  where cate_id='".$strsubcate['parent_id']."'");
		$appname = $strcate['appname'];
		$db->query("update ".dbprefix."goods_cate set `cate_name`='$cate_name',`appname`='$appname' where cate_id='$cate_id'");
		echo 1;
	break;
	case "add_subcate":
		
		$cate_id = intval($_POST['cate_id']);
		$db->query("insert into ".dbprefix."goods_subcate (`cate_id`,`create_time`) values ('$cate_id','".time()."')");
		$subcate_id = $db->insert_id();
		
		echo $subcate_id;
	break;
	case "add_cate":
		
		$cate_id = intval($_POST['cate_id']);
		$strsubcate = $db->once_fetch_assoc("select parent_id from ".dbprefix."goods_cate  where cate_id='$cate_id'");
		$strcate = $db->once_fetch_assoc("select appname from ".dbprefix."goods_cate  where cate_id='".$strsubcate['parent_id']."'");
		$appname = $strcate['appname'];
		$db->query("insert into ".dbprefix."goods_cate (`parent_id`,`cate_name`,`appname`) values ('$cate_id','请修改','$appname')");
		$cate_id = $db->insert_id();
		echo $cate_id;
		
	break;
	case "del_subtag":
		
		$subcate_id = intval($_POST['subcate_id']);
		$db->query("DELETE FROM ".dbprefix."goods_subcate where subcate_id='$subcate_id'");
		echo 1;
	break;
	case "del_cate":
		
		$cate_id = intval($_POST['cate_id']);
		
		$strsubcate = $db->once_fetch_assoc("select * from ".dbprefix."goods_subcate  where cate_id='$cate_id'");
		if(is_array($strsubcate)) {
			echo 2;
			exit;
		}
		$db->query("DELETE FROM ".dbprefix."goods_cate where cate_id='$cate_id'");
		echo 1;
	break;
	
	case "do":
	
		$strtag = trim($_POST['strtag']);
		
		$cate_id = trim($_POST['cate_id']);
		$strtag = str_replace(' ',',',$strtag);
		$strtag = str_replace('，',',',$strtag);
		$arrkeywords = explode(",",$strtag);
		ksort($arrkeywords);
		
		$db->query("DELETE FROM ".dbprefix."goods_category_tags WHERE cate_id = '".$cate_id."'");
		
		foreach($arrkeywords as $item){
			if($item){
			$tagcount = $db->once_num_rows("select * from ".dbprefix."goods_tags where tag_name='".$item."'");
			if($tagcount == '0'){
						$db->query("INSERT INTO ".dbprefix."goods_tags (`tag_id`,`tag_name`,`tag_code`,`sort`,`is_hot`,`count`) VALUES (NULL,'".$item."','".$item."','100','0','1')");
						$tagid = $db->insert_id();
						$db->query("INSERT INTO ".dbprefix."goods_category_tags (`id`,`cate_id`,`tag_id`,`weight`) VALUES (NULL,'".$cate_id."','".$tagid."','100')");
				}else {
				
					$tagid = aac('sharetag')->getTagId($item);
					$good_catecount = $db->once_num_rows("select * from ".dbprefix."goods_category_tags where cate_id='$cate_id' and tag_id='$tagid'");
					if($good_catecount == '0'){
						$db->query("INSERT INTO ".dbprefix."goods_category_tags (`id`,`cate_id`,`tag_id`,`weight`) VALUES (NULL,'".$cate_id."','".$tagid."','100')");
					}
				}
				}
		}
		
		qiMsg("标签设置成功！","<a href=\"index.php?app=system&ac=navtag&cate_id=$cate_id\">返回</a>");
	break;
}