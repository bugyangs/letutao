<?php
defined('IN_TS') or die('Access Denied.');
class sharetag{

	var $db;

	function sharetag($dbhandle){
		$this->db = $dbhandle;
	}
	
	//添加多个标签 
	function addTag($objname,$idname,$objid,$tags){
	
		if($objname != '' && $idname != '' && $objid!='' && $tags!=''){
			$arrTag = explode(' ',$tags);
			foreach($arrTag as $item){
				$tagname = t($item);
				if(strlen($tagname) < '32' && $tagname != ''&&$tagname != 'class'&&$tagname != 'span'){
					$uptime = time();
					$tagcount = $this->db->once_num_rows("select * from ".dbprefix."goods_tags where tag_name='".$tagname."'");
					if($tagcount == '0'){
						$this->db->query("INSERT INTO ".dbprefix."goods_tags (`tag_id`,`tag_name`,`tag_code`,`sort`,`is_hot`,`count`) VALUES (NULL,'".$tagname."','".$tagname."','100','0','1')");
						$tagid = $this->db->insert_id();
						$tagIndexCount = $this->db->once_num_rows("select * from ".dbprefix."tag_".$objname."_goods where ".$idname."='".$objid."' and tagid='".$tagid."'");
						if($tagIndexCount == '0'){
							$this->db->query("INSERT INTO ".dbprefix."tag_".$objname."_goods (`".$idname."`,`tagid`) VALUES ('".$objid."','".$tagid."')");
						}
						$tagIdCount = $this->db->once_num_rows("select * from ".dbprefix."tag_".$objname."_goods where tagid='".$tagid."'");
						$this->db->query("update ".dbprefix."goods_tags set `count`='".$tagIdCount."' where tag_id='".$tagid."'");
					}else{
						$tagData = $this->db->once_fetch_assoc("select * from ".dbprefix."goods_tags where tag_name='".$tagname."'");
						
						$tagIndexCount = $this->db->once_num_rows("select * from ".dbprefix."tag_".$objname."_goods where ".$idname."='".$objid."' and tagid='".$tagData['tag_id']."'");
						if($tagIndexCount == '0'){
							$this->db->query("INSERT INTO ".dbprefix."tag_".$objname."_goods (`".$idname."`,`tagid`) VALUES ('".$objid."','".$tagData['tag_id']."')");
						}
						$tagIdCount = $this->db->once_num_rows("select * from ".dbprefix."tag_".$objname."_goods where tagid='".$tagData['tag_id']."'");
						$this->db->query("update ".dbprefix."goods_tags set `count`='".$tagIdCount."' where tag_id='".$tagData['tag_id']."'");
					}
					
				}
			}
		}
	}
	
	//通过cate获取tag
	function getObjTagByCateid($objid,$num='20',$is_index=0){
		
		$strCateTags = $this->getSubCateid($objid);
		$arrTagCateid = $this->db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where cate_id in (".$strCateTags.") and is_index=".$is_index." order by id asc limit ".$num);
		
		if(is_array($arrTagCateid)){
		foreach($arrTagCateid as $item){
			$arrTag[] = $this->getOneTag($item['tag_id']);
		}
		}
		
		return $arrTag;
		
	}
	
	//最新_通过cate获取tag
	function getObjTagByCateid_new($cate_id,$is_Simple=false){
		$arr_cate = $this->db->fetch_all_assoc("select * from ".dbprefix."goods_cate  where parent_id='$cate_id'");
		if($is_Simple) {return $arr_cate;exit;}//返回简单数组
		foreach($arr_cate as $key=>$item){
			$arr_cates[] = $item;
			$arr_subcate = $this->db->fetch_all_assoc("select * from ".dbprefix."goods_subcate  where cate_id='".$item['cate_id']."'");
			foreach($arr_subcate as $kkey=>$iitem){
				$arr_subcate[$kkey]['arr_tag'] = explode('，',$iitem['tag']);
			}
			$arr_cates[$key]['subcate'] = $arr_subcate;
		}
		return $arr_cates;
		
	}
	
	//通过tag获取cate
	function getObjCateByTag($objid){
		$arrTagCateid = $this->db->fetch_all_assoc("select * from ".dbprefix."goods_category_tags where tag_id='$objid'");
		
		if(is_array($arrTagCateid)){
		foreach($arrTagCateid as $item){
			$arrCate[] = $this->db->once_fetch_assoc("select * from ".dbprefix."goods_cate where cate_id='".$item['cate_id']."'");
		}
		}
		
		return $arrCate;
		
	}
	
	//通过topic获取tag
	function getObjTagByObjid($objname,$idname,$objid){
		$arrTagIndex = $this->db->fetch_all_assoc("select * from ".dbprefix."tag_".$objname."_goods where ".$idname."='$objid'");
		
		if(is_array($arrTagIndex)){
		foreach($arrTagIndex as $item){
			if($this->getOneTag($item['tagid'])){
				$arrTag[] = $this->getOneTag($item['tagid']);
				}
			}
		}
		
		return $arrTag;
		
	}
	
	//通过tagid获得tagname
	function getOneTag($tagid){
		$tagData = $this->db->once_fetch_assoc("select * from ".dbprefix."goods_tags where tag_id='$tagid'");
		if($tagData['tag_name']=='span'||$tagData['tag_name']=='class'||is_numeric($tagData['tag_name'])) {
			return '';
		}else{
			return $tagData;
		}
	}
	
	//通过tagname获取tagid
	function getTagId($tagname){
		
		$strTag = $this->db->once_fetch_assoc("select tag_id from ".dbprefix."goods_tags where `tag_name`='$tagname'");
		
		return $strTag['tag_id']?$strTag['tag_id']:0;
	}
	
	//获取商品数最多的tag
		function getmoreTag($num){
		$tagData = $this->db->fetch_all_assoc("select * from ".dbprefix."goods_tags order by count desc limit ".$num);
		
		return $tagData;
	}
	
		//通过tagname获取商品
		function getGoodsByTagname($tagname,$cate_id){
		
		$subCate = $this -> getSubCateid($cate_id,'arr');
		$tagid = $this -> getTagId($tagname);
		$arrgoodstag = $this->db->fetch_all_assoc("select goods_id from ".dbprefix."tag_share_goods where tagid='$tagid'");
		
		foreach($arrgoodstag as $key=>$item){
				$str_goods = $this->db->once_fetch_assoc("select cate_id from ".dbprefix."share_goods where goods_id='".$item['goods_id']."'");
				if(in_array($str_goods['cate_id'],$subCate)){
				$arrgoodstags[] = $item;
				}
				
		}
		return $arrgoodstags;
	}
	
	
	function getgoodnum($tagid){

        $num = $this->db->once_fetch_assoc("select count(goods_id) as num from ".dbprefix."tag_share_goods where `tagid`='$tagid'");
	    return $num['num'];
	}
	
	//通过cateid获取二级分类cateid,返回字符串或数组
	function getSubCateid($cateid,$type='str'){

     $catetags = $this->getObjTagByCateid_new($cateid);
			//筛选下级分类数组
			foreach($catetags as $key=>$item){
				$str_s .="'".$item['cate_id']."',";
				$arr_s[] = $item['cate_id'];
			}
			$str = $str_s."'".$cateid."'";
		if($type=='arr'){
			$arr_s[count($arr_s)] = $cateid;
			return $arr_s;
		}else{
			return $str;
		}
	}
	
	function getidbysubcate($cateid,$subcate){
			//筛选下级分类数组

		   $goods_cate = $this->db->once_fetch_assoc("select * from ".dbprefix."goods_cate where cate_name='".$subcate."' and parent_id = '".$cateid."'");

		$sub_tags=$this->db->fetch_all_assoc("select tag from ".dbprefix."goods_subcate where cate_id =".$goods_cate['cate_id']);
		
		foreach($sub_tags as $stkey=>$stitem){

			$taga=explode("，",$stitem['tag']);
			foreach($taga as $tagitem){
				$tagid=$this->getTagId($tagitem);
				if($tagid) $tagidstr.=$tagid.",";
			}
			
		}
		$tagidstra=explode(",",$tagidstr);
		$tagidstrs="";
		foreach($tagidstra as $jitem){
			if($jitem){
				if($tagidstrs){
			     $tagidstrs.=",".$jitem;
			   }else{
			    $tagidstrs.=$jitem;	
			  }
			}
		
		}

		$arrgoodstag = $this->db->fetch_all_assoc("select a.goods_id from ".dbprefix."tag_share_goods AS a LEFT JOIN ".dbprefix."share_goods AS b on a.goods_id=b.goods_id where a.tagid in (".$tagidstrs.") and b.cate_id=".$cateid."");
		
		return $arrgoodstag;
	}
	
	
}