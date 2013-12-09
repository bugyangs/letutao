<?php
defined('IN_TS') or die('Access Denied.');

class NetGet{

	var $db;
	private $share_module;
	private $url;

	//通过URL构造获取相应的采集解析模型
	public function __construct($url)
	{

		$rs = preg_match("/^(http:\/\/|https:\/\/)/",$urlt,$match);
		if(intval($rs)==0)
		{
			$urlt = "http://".$urlt;
		}
		$rs= parse_url($urlt);

		$scheme = isset($rs['scheme'])?$rs['scheme']."://":"http://";
		$host = isset($rs['host'])?$rs['host']:"none";
        $host = explode('.',$host);
        $host = array_slice($host,-2,2);
        $domain = implode('.',$host);
		$class = 'taobao';

		$file = THINKROOT."/letutao/class.share.php";
		if(file_exists($file))
		{
			require_once $file;
			$class_name = $class."_sharegoods";
			if(class_exists($class_name))
			{
				$this->share_module = new $class_name;
			}
		}
		$this->url = $url;
	}

	/**
	 * 返回结果为false时采集失败
	 */
	public function fetch()
	{
		if($this->share_module)
		{
			return $this->share_module->fetch($this->url);
		}
		else
			return false;
	}

	/**
	 * 获取该商品的标识，用于检测是否已经采集
	 */
	public function getKey()
	{
		if($this->share_module)
		{
			return $this->share_module->getKey($this->url);
		}
		else
			return '';
	}

	/**
	 * 检测是否已经采集过商品
	 */
	public function getExists($goods)
	{
		$key = $this->getKey();
		if(isset($goods[$key]))
			return true;
		else
			return false;
	}
	
	/**
	 * 根据标题标签判断所属类别
	 */
	
	public function getCateByTags($tags)
	{
		global $db;
		static $tag_cates = array();

		$tags = array_unique($tags);

		foreach($tags as $tag)
		{
			if(!empty($tag))
			{
		$arrttg = $db->fetch_all_assoc("select tag_id,tag_name from ".dbprefix."goods_tags where tag_name LIKE '%".$tag."%'");
		
		foreach($arrttg as $data)
					{
						$arrcate = $db->fetch_all_assoc("select cate_id,weight from ".dbprefix."goods_category_tags where tag_id = '".$data['tag_id']."'");
						foreach($arrcate as $cdata)
							{
								$cateid = $cdata['cate_id'];
								$cate_id[$cateid] += $cdata['weight'];
							}
					}
			}
		}
		if(empty($cate_id))
			return '1';
		return array_search(max($cate_id),$cate_id);
	}
	
	
		//获取并写入互联网评论

		public function GetAndIntoComment($shareid,$url,$cnum)
	{
		global $db;
		
		$cnum = 10;
		
		if(empty($url) || empty($shareid)) return '';
		
		$urlid = $this->getID($url);
		
		$meta      =     get_meta_tags($url);
		
		$arrusernumid = $meta['microscope-data'];
		
		preg_match_all('/(userid)=(\d+)/is', $arrusernumid, $usernumidd);
		
		$usernumid= $usernumidd[2][0];
		
	
		
		$re_url = 'http://rate.taobao.com/detail_rate.htm?userNumId='.$usernumid.'&auctionNumId='.$urlid.'&showContent=1';
		
		$str= file_get_contents($re_url);
		if(empty($str)){
		$str= file_get_contents($re_url);
		}
		if(empty($str)){
		$str= file_get_contents($re_url);
		}
		
			
		
		$darrstr = mb_convert_encoding($str,"UTF-8","gb2312");
		$arrstr =explode('"rateContent":"',$darrstr);
	
		
		foreach ($arrstr as $itme)
		{
			$doarrstr =explode('","rateDate"',$itme);
			$i=0;
			foreach ($doarrstr as $iitme)
			{
					if(($i/2)=='0' && !strstr($iitme,'scoreInfo')){
					
						$arrData	= array(
						'shareid'			=> $shareid,
						'userid'			=> '0',
						'content'	        => $iitme,
						'addtime'		    => time(),
					);
					if(!empty($iitme)){
					$commentid = $db->insertArr($arrData,dbprefix.'share_goods_comments');
					}
	
					//统计评论数
					$count_comment = $db->once_num_rows("select * from ".dbprefix."share_goods_comments where shareid='$shareid'");
					
					$uptime = time();
				
					$db->query("update ".dbprefix."share_goods set uptime='$uptime',count_comment='$count_comment' where goods_id='$shareid'");
					

					}
				$i++;
			}
		}
		
	}
	
	public function getID($url)
	{
		$id = 0;
		$parse = parse_url($url);
		if(isset($parse['query']))
		{
            parse_str($parse['query'],$params);
			if(isset($params['id']))
				$id = $params['id'];
            elseif(isset($params['item_id']))
                $id = $params['item_id'];
			elseif(isset($params['default_item_id']))
                $id = $params['default_item_id'];
        }
		return $id;
	}
	//获取商品多图
		
		public function GetMorepic(){
			
		$urlid = $this->getID($this->url);
			
		$content      =  file_get_contents('http://www.lebulin.com/goods-"'.$urlid.'"html');
		$content = mb_convert_encoding($content,"UTF-8","gb2312");
		preg_match_all('/<div class="tb-pic tb-s40">\s+<a href="#"><img src=".+/', $content, $arrpic);
		$strpic = implode('img',$arrpic[0]);
		
		preg_match_all('/<img src=.+\/>/', $strpic, $doarrpic);
		
		foreach ($doarrpic[0] as $item)
		{
			$item = str_replace('_40x40.jpg','_100x100.jpg',$item);
			$pichtml.='<li><a href="javascript:;">'.$item.'</a><i></i></li>';
		}
		return $pichtml;

		}
}