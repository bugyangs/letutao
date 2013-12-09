<?php 
defined('IN_TS') or die('Access Denied.');
/*
 *模型：板块
 *class.group.php
 *By QINIAO
 */
 
class group{

	var $db;

	function group($dbhandle){
		$this->db = $dbhandle;
	}

	//显示所有板块带分页
	function getArrGroup($page='1',$prePageNum,$where=''){
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$limit = $prePageNum ? "LIMIT $start_limit, $prePageNum" : '';
		$groups	= $this->db->fetch_all_assoc("select * from ".dbprefix."group ".$where." ".$limit."");
		return $groups;
	}
	
	//显示所有板块分类带分页
	function getArrCate($page='1',$prePageNum,$where=''){
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$limit = $prePageNum ? "LIMIT $start_limit, $prePageNum" : '';
		$cates	= $this->db->fetch_all_assoc("select * from ".dbprefix."group_cates ".$where." ".$limit."");
		if($cates){
		foreach($cates as $item){
			$topCate = $this->getOneCateById($item['catereferid']);
			$arrCate[] = array(
				'cateid'			=> $item['cateid'],
				'catename'	=> $item['catename'],
				'topcateid'		=> $topCate['cateid'],
				'topcatename'		=> $topCate['catename'],
			);
		}}
		
		return $arrCate;
	}
	
	//获取一条分类的名字BY cateid
	function getOneCateById($cateid){
		$strCate = $this->db->once_fetch_assoc("select * from ".dbprefix."group_cates where cateid='$cateid'");
		return $strCate;
	}
	
	//获取一个板块
	function getOneGroup($groupid){
		$strGroup = $this->db->once_fetch_assoc("select * from ".dbprefix."group where groupid=$groupid");
		if($strGroup['groupicon'] == ''){
			$strGroup['icon_48'] = SITE_URL.'public/images/group.gif';
			$strGroup['icon_16'] = SITE_URL.'public/images/group.gif';
		}else{
			$strGroup['icon_48'] = SITE_URL.miniimg($strGroup['groupicon'],'group',48,48,$strGroup['path'],1);
			$strGroup['icon_16'] = SITE_URL.miniimg($strGroup['groupicon'],'group',16,16,$strGroup['path'],1);
		}
		return $strGroup;
	}
	
	//或者板块ID和板块名字
	function getSimpleGroup($groupid){
		$strGroup = $this->db->once_fetch_assoc("select groupid,groupname,path,groupicon from ".dbprefix."group where groupid=$groupid");
		if($strGroup['groupicon'] == ''){
			$strGroup['icon_48'] = SITE_URL.'public/images/group.gif';
			$strGroup['icon_16'] = SITE_URL.'public/images/group.gif';
		}else{
			$strGroup['icon_48'] = SITE_URL.miniimg($strGroup['groupicon'],'group',48,48,$strGroup['path'],1);
			$strGroup['icon_16'] = SITE_URL.miniimg($strGroup['groupicon'],'group',16,16,$strGroup['path'],1);
		}
		return $strGroup;
	}
	
	//获取板块分类数 
	function getCateNum($where=''){
		$sql = "SELECT * FROM ".dbprefix."group_cates ".$where."";
		$cateNum = $this->db->once_num_rows($sql);
		return $cateNum;
	}
	
	/*
	 *获取板块全部内容列表
	 */

	function getGroupContent($page = 1, $prePageNum,$groupid){
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$limit = $prePageNum ? "LIMIT $start_limit, $prePageNum" : '';
		$arrGroupContent	= $this->db->fetch_all_assoc("select * from ".dbprefix."group_topics where groupid='$groupid' order by addtime desc $limit");
		return $arrGroupContent;
	}
	
	//获取推荐的板块
	function getRecommendGroup($num){
		$arrRecommendGroups = $this->db->fetch_all_assoc("select groupid from ".dbprefix."group where isrecommend='1' limit $num");
		
		$arrRecommendGroup = array();
		
		if(is_array($arrRecommendGroups)){
			foreach($arrRecommendGroups as $item){
				$arrRecommendGroup[] = $this->getOneGroup($item['groupid']);
			}
		}
		return $arrRecommendGroup;
	}
	
	//获取最新创建的板块
	function getNewGroup($num){
		$arrNewGroups = $this->db->fetch_all_assoc("select groupid from ".dbprefix."group where isshow='0' order by addtime desc limit $num");
		if(is_array($arrNewGroups)){
			foreach($arrNewGroups as $item){
				$arrNewGroup[] = $this->getOneGroup($item['groupid']);
			}
		}
		return $arrNewGroup;
	}
	
	//获取热门的板块
	function getHotGroup($num){
		$arrHotGroups = $this->db->fetch_all_assoc("select groupid from ".dbprefix."group where isshow='0' order by count_user desc limit $num");
		if(is_array($arrHotGroups)){
			foreach($arrHotGroups as $item){
				$arrHotGroup[] = $this->getOneGroup($item['groupid']);
			}
		}
		return $arrHotGroup;
	}
	
	//获取板块的所有分类 
	function getCates(){
		$ArrTopCates = $this->db->fetch_all_assoc("select * from ".dbprefix."group_cates where catereferid='0'");
		
		$arrCate = array();
		
		if(is_array($ArrTopCates)){
			foreach($ArrTopCates as $item){
				$arrCate[] = array(
					'cateid'	=> $item['cateid'],
					'catename'	=> $item['catename'],
					'count_group'	=> $item['count_group'],
					'cates'	=> $this->db->fetch_all_assoc("select * from ".dbprefix."group_cates where catereferid='".$item['cateid']."'"),
				);
				
			}
		}
		
		return $arrCate;
		
	}
	
	//我的板块（加入的和管理的）
	function getMyGroup(){
		
	}
	
	
	
	/*
	 *获取板块全部内容数
	 */
	
	function getGroupContentNum($virtue, $setvirtue){
		$where = 'where '.$virtue.'='.$setvirtue.'';
		$sql = "SELECT * FROM ".dbprefix."group_topics $where";
		$groupContentNum = $this->db->once_num_rows($sql);
		return $groupContentNum;
	}
	
	/*
	 *获取内容
	 */
	 
	function getOneGroupContent($topicid){
		$strGroupContent = $this->db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid=$topicid");
		return $strGroupContent;
	}
	
	/*
	 *获取内容评论列表
	 */
	
	function getGroupContentComment($page = 1, $prePageNum,$topicid){
		$start_limit = !empty($page) ? ($page - 1) * $prePageNum : 0;
		$limit = $prePageNum ? "LIMIT $start_limit, $prePageNum" : '';
		$arrGroupContentComment	= $this->db->fetch_all_assoc("select * from ".dbprefix."group_topics_comments where topicid='$topicid' order by addtime desc $limit");
		
		if(is_array($arrGroupContentComment)){
			foreach($arrGroupContentComment as $key=>$item){
				$arrGroupContentComment[$key]['user'] = aac('user')->getUserForApp($item['userid']);
				$arrGroupContentComment[$key]['content'] = editor2html($item['content']);
				$arrGroupContentComment[$key]['recomment'] = $this->recomment($item['referid']);
			}
		}
		
		return $arrGroupContentComment;
	}
	
	//Refer二级循环，三级循环暂时免谈
	function recomment($referid){
		$strComment = $this->db->once_fetch_assoc("select * from ".dbprefix."group_topics_comments where commentid='$referid'");
		$strComment['user'] = aac('user')->getUserForApp($strComment['userid']);
		$strComment['content'] = editor2html($strComment['content']);
		
		return $strComment;
	}
	
	/*
	 *获取内容评论列表数
	 */
	
	function getGroupContentCommentNum($virtue, $setvirtue){
		$where = 'where '.$virtue.'='.$setvirtue.'';
		$sql = "SELECT * FROM ".dbprefix."group_topics_comments $where";
		$groupContentCommentNum = $this->db->once_num_rows($sql);
		return $groupContentCommentNum;
	}
	
	/*
	 *获取指定板块的名字
	 */
	 
	function getGroupName($groupid){
		$groupDate = $this->db->once_fetch_array("select groupname from ".dbprefix."group where groupid=$groupid");
		$groupName = $groupDate['groupname'];
		return $groupName;
	}
	
	//获取一条话题 
	function getOneTopic($topicid){
		$isTopic = $this->db->once_num_rows("select * from ".dbprefix."group_topics where topicid='$topicid'");
		if($isTopic == '0'){
			@header("http/1.1 404 not found"); 
			@header("status: 404 not found");
			include template("404");
			exit(); 
		}else{
			$strTopic = $this->db->once_fetch_assoc("select * from ".dbprefix."group_topics where topicid='$topicid'");
			return $strTopic;
		}
	}
	
	//删除话题
	function deltopic($topicid){
		//删除话题
		$this->db->query("delete from ".dbprefix."group_topics where topicid='$topicid'");
		//删除话题收藏 
		$this->db->query("delete from ".dbprefix."group_topics_collects where topicid='$topicid'");
		//删除话题评论
		$this->db->query("delete from ".dbprefix."group_topics_comments where topicid='$topicid'");
		//删除话题digg
		$this->db->query("delete from ".dbprefix."group_topics_plugin_digg where topicid='$topicid'");
		//删除话题tag索引 
		$this->db->query("delete from ".dbprefix."tag_topic_index where topicid='$topicid'");
		
		//删除成功
		echo '1';
		
	}
	
	//匹配内容中的附件 
	function matchAttach($content){
		preg_match_all('/\[(attach)=(\d+)\]/is', $content, $attachs);
		if($attachs[2]){
			foreach ($attachs[2] as $aitem) {
				$content = str_replace("[attach={$aitem}]",'附件：', $content);
			}
		}
	}
	
	//匹配内容中的图片
	function get_mediaImgList($content) {
		
        preg_match_all('/\[图片\d{1,10}\]/',$content, $matches);
		$str=str_replace("[图片","",$matches[0]);
		$str_arrs=str_replace("]","",$str);
		foreach($str_arrs as $val){
			$imagearr=$this->db->once_fetch_assoc("select imageurl from ".dbprefix."image_file where imageid='$val'");

			$str_arr[$val] = preg_match('|^http://|',$imagearr['imageurl'])?$imagearr['imageurl']:SITE_URL.$imagearr['imageurl'];
	 	}
		return getJson($str_arr,true);
    }
	
	
	//匹配内容中的视频
	function get_mediaVideoList($content) {
		
        preg_match_all('/\[视频\d{1,10}\]/',$content, $matches);
		$str=str_replace("[视频","",$matches[0]);
		$str_arrs=str_replace("]","",$str);
		foreach($str_arrs as $val){
			$imagearr=$this->db->once_fetch_assoc("select imageurl from ".dbprefix."image_file where imageid='$val'");;
			$str_arr[$val] = $imagearr['imageurl'];
	 	}
		return getJson($str_arr,true);
    }
	
	//为内容准备的附件格式
	function attachForContent($attachid,$userid){
		$strAttach = acc('attach')->getOneAttach($attachid);
		$userScore = acc('user')->getUserScore($userid);
		if($strAttach['score'] > '0' && $userScore< $strAttach['score']) {
			$result = "下载附件：需要".$strAttach['score']."积分";
		}else{
			$result = '下载附件：<a href="'.SITE_URL.'index.php?app=attach&ajax&ts=down&attachid='.$strAttach["attachid"].'">'.$strAttach["attachname"].'</a>';
		}
	}
	
	//判断是否存在板块
	function isGroup($groupid){
		$isGroup = $this->db->once_fetch_assoc("select count(groupid) from ".dbprefix."group where groupid='$groupid'");
		if($isGroup['count(groupid)']==0){
			@header("http/1.1 404 not found"); 
			@header("status: 404 not found");
			include template("404");
			exit;
		}
	}
	
	//判断是否存在话题
	function isTopic($topicid){
		$isTopic = $this->db->once_fetch_assoc("select count(topicid) from ".dbprefix."group_topics where topicid='$topicid'");
		if($isTopic['count(topicid)']==0){
			@header("http/1.1 404 not found"); 
			@header("status: 404 not found");
			include template("404");
			exit(); 
		}
	}
	
	//获取话题第一张图片
	function getOnePhoto($topicid){
		$strTopic = $this->db->once_fetch_assoc("select content,isphoto from ".dbprefix."group_topics where `topicid`='$topicid'");
		if($strTopic['isphoto']=='1'){
			preg_match_all('/\[(photo)=(\d+)\]/is', $strTopic['content'], $photos);
			$photoid = $photos[2][0];
			
			$strPhoto = aac('photo')->getSamplePhoto($photoid);
			
			return $strPhoto;
			
		}
	}
	
}

