<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_share_goods`;");
E_C("CREATE TABLE `le_share_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `themeid` int(10) DEFAULT '0',
  `comment` text NOT NULL,
  `count_comment` int(11) DEFAULT '0',
  `count_view` int(11) DEFAULT '0',
  `count_like` int(11) DEFAULT '0',
  `count_worth` int(11) DEFAULT '0',
  `img` varchar(255) DEFAULT '',
  `img_w` int(10) DEFAULT NULL,
  `img_h` int(10) DEFAULT NULL,
  `oldimg_w` int(10) DEFAULT NULL,
  `oldimg_h` int(10) DEFAULT NULL,
  `simg` varchar(100) DEFAULT NULL,
  `simg_170` varchar(100) DEFAULT '',
  `simg_str` text,
  `smimg` varchar(100) DEFAULT NULL,
  `bigpic` varchar(100) DEFAULT NULL,
  `oldimg` text,
  `bd_oldimg` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `price` decimal(10,2) DEFAULT '0.00',
  `coupon_price` decimal(10,2) DEFAULT '0.00',
  `coupon_start_time` int(11) DEFAULT '0',
  `coupon_end_time` int(11) DEFAULT '0',
  `cate_id` int(11) NOT NULL DEFAULT '0',
  `taoke_url` varchar(1024) DEFAULT '',
  `istop` tinyint(1) DEFAULT '0',
  `sort` smallint(5) DEFAULT '10',
  `seller_credit_score` int(2) DEFAULT '0',
  `shop_info` varchar(1024) NOT NULL,
  `uptime` int(11) DEFAULT '0',
  PRIMARY KEY (`goods_id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8");
E_D("replace into `le_share_goods` values('1','1','0','测试数据','8','0','0','0','cache/thumb/index/20130829/Wj6q9j2k0K2x7Sw210.jpg',NULL,'210',NULL,NULL,NULL,'',NULL,NULL,NULL,'http://img03.taobaocdn.com/bao/uploaded/i3/13955023481311466/T16UGLXy4fXXXXXXXX_!!0-item_pic.jpg|http://img04.taobaocdn.com/imgextra/i4/60993955/T2UxF7XilbXXXXXXXX_!!60993955.jpg|',NULL,'特Catworld女装2013夏装新款15002546菱格纹小花镂空针织外套','http://item.taobao.com/item.htm?id=25236744490','49.00','0.00','0','0','2','','0','10','0','a:4:{s:4:\"nick\";s:12:\"obuy_catwalk\";s:14:\"delivery_score\";s:3:\"4.8\";s:10:\"item_score\";s:3:\"4.7\";s:13:\"service_score\";s:3:\"4.8\";}','1377760666');");
E_D("replace into `le_share_goods` values('2','1','0','测试数据','2','1','0','0','cache/thumb/index/20130829/iaf9h3pCgiynP9w210.jpg',NULL,'210','800','800',NULL,'',NULL,NULL,NULL,'http://gi1.md.alicdn.com/bao/uploaded/i1/12349021653481580/T1BVV_XvhgXXXXXXXX_!!0-item_pic.jpg|http://gi3.md.alicdn.com/imgextra/i3/12349021592778729/T1hK5XXARaXXXXXXXX_!!0-item_pic.jpg|http://gi1.md.alicdn.com/imgextra/i1/1024332349/T2vhPKXaFXXXXXXXXX_!!1024332349.jpg|http://gi2.md.alicdn.com/imgextra/i2/1024332349/T2aZDQXaBXXXXXXXXX_!!1024332349.jpg|http://gi3.md.alicdn.com/imgextra/i3/1024332349/T2mVqVXhXbXXXXXXXX_!!1024332349.jpg|',NULL,'温茜2013新款女士网格蛋糕裙蓬蓬裙杏色短裙半身裙子夏装女包邮','http://item.taobao.com/item.htm?id=17933585282','98.00','0.00','0','0','3','','0','10','0','a:4:{s:4:\"nick\";s:15:\"温茜旗舰店\";s:14:\"delivery_score\";s:3:\"4.8\";s:10:\"item_score\";s:3:\"4.8\";s:13:\"service_score\";s:3:\"4.9\";}','1377760773');");
E_D("replace into `le_share_goods` values('3','1','0','测试数据','8','0','0','0','cache/thumb/index/20130829/87sjiig6evV9ccw210.jpg',NULL,'210',NULL,NULL,NULL,'',NULL,NULL,NULL,'http://img01.taobaocdn.com/bao/uploaded/i1/12428021031645878/T12elWXqtcXXXXXXXX_!!0-item_pic.jpg|http://img02.taobaocdn.com/imgextra/i2/12428020229210150/T1AwFEXpxeXXXXXXXX_!!0-item_pic.jpg|http://img03.taobaocdn.com/imgextra/i3/12428021011977229/T1BZ0VXwXcXXXXXXXX_!!0-item_pic.jpg|http://img01.taobaocdn.com/imgextra/i1/516632428/T2vDLzXlhaXXXXXXXX_!!516632428.jpg|http://img01.taobaocdn.com/imgextra/i1/516632428/T2yYjAXe0aXXXXXXXX_!!516632428.jpg|',NULL,'2013秋季新款真皮防水台细高跟鞋羊皮厚底单鞋女式鞋','http://item.taobao.com/item.htm?id=22709932266','330.00','0.00','0','0','4','','0','10','0','a:4:{s:4:\"nick\";s:9:\"薰倚草\";s:14:\"delivery_score\";s:3:\"4.8\";s:10:\"item_score\";s:3:\"4.8\";s:13:\"service_score\";s:3:\"4.8\";}','1377760807');");
E_D("replace into `le_share_goods` values('4','1','0','测试数据','0','1','0','0','cache/thumb/index/20130829/yTsj3gSBgFW0spw210.jpg',NULL,'247','800','942',NULL,'',NULL,NULL,NULL,'http://img04.taobaocdn.com/bao/uploaded/i4/15505028474635939/T1L1dDFahcXXXXXXXX_!!0-item_pic.jpg|http://img03.taobaocdn.com/imgextra/i3/91465505/T2xnAYXmdXXXXXXXXX_!!91465505.jpg|http://img01.taobaocdn.com/imgextra/i1/91465505/T2nsIZXftaXXXXXXXX_!!91465505.jpg|http://img01.taobaocdn.com/imgextra/i1/91465505/T2MakZXbdaXXXXXXXX_!!91465505.jpg|http://img03.taobaocdn.com/imgextra/i3/91465505/T2QrMZXnBXXXXXXXXX_!!91465505.jpg|',NULL,'2013韩版夏季新款时尚休闲帆布糖果色超级大容量单肩包包欧美女包','http://item.taobao.com/item.htm?id=19697970132','65.00','0.00','0','0','5','','0','10','0','a:4:{s:4:\"nick\";s:23:\"领衔时尚vs大天王\";s:14:\"delivery_score\";s:3:\"4.7\";s:10:\"item_score\";s:3:\"4.7\";s:13:\"service_score\";s:3:\"4.7\";}','1377760857');");

require("../../inc/footer.php");
?>