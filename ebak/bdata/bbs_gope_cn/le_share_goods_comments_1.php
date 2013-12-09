<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_share_goods_comments`;");
E_C("CREATE TABLE `le_share_goods_comments` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `referid` int(11) DEFAULT '0',
  `shareid` int(11) DEFAULT '0' COMMENT '分享ID',
  `userid` int(11) DEFAULT '0' COMMENT '用户ID',
  `content` text COMMENT '回复内容',
  `commentType` tinyint(1) DEFAULT '0',
  `addtime` int(11) DEFAULT '0' COMMENT '回复时间',
  PRIMARY KEY (`commentid`),
  KEY `shareid` (`shareid`),
  KEY `userid` (`userid`),
  KEY `referid` (`referid`,`shareid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='分享回复/评论'");
E_D("replace into `le_share_goods_comments` values('1','0','1','0','只能说是荧光绿 而不是黄色 质量一般  味道有点浓','0','1377760666');");
E_D("replace into `le_share_goods_comments` values('2','0','1','0','颜色质地都非常好，穿上轻松舒适。','0','1377760666');");
E_D("replace into `le_share_goods_comments` values('3','0','1','0','是偶胖了么。。。衣服好小哦。。不过颜色超亮的~~','0','1377760666');");
E_D("replace into `le_share_goods_comments` values('4','0','1','0','配黑裙子买的，质量还不错的，在空调间穿穿可以','0','1377760666');");
E_D("replace into `le_share_goods_comments` values('5','0','1','0','还行','0','1377760666');");
E_D("replace into `le_share_goods_comments` values('6','0','1','0','还可以，味道重','0','1377760666');");
E_D("replace into `le_share_goods_comments` values('7','0','1','0','没什么色差，质量不错，线头什么的都几乎没有。','0','1377760666');");
E_D("replace into `le_share_goods_comments` values('8','0','1','0','有点偏宽松 ','0','1377760666');");
E_D("replace into `le_share_goods_comments` values('9','0','2','0','不错哦u0001不错哦','0','1377760773');");
E_D("replace into `le_share_goods_comments` values('10','0','2','0','挺好的，喜欢','0','1377760773');");
E_D("replace into `le_share_goods_comments` values('11','0','3','0','太给力了，28号早上拍的，30号早上发货，昨天下班鞋子就到了，对快递相当满意！鞋子今天试穿还行，也不会很累！店家放了除味包，总的说对得起这个价吧！','0','1377760807');");
E_D("replace into `le_share_goods_comments` values('12','0','3','0','瘦款的鞋型比较适合我，大小合适，高度准确，翻毛细腻，不知道经不经穿，看起来质量还不错。穿几天再追加。客服服务很好哦，送了半码垫和丝袜。','0','1377760807');");
E_D("replace into `le_share_goods_comments` values('13','0','3','0','昨天下午鞋子就到了，但是本人不在家！快递哥哥很用心，帮我放在楼下超市还给我打了电话安顿呢！鞋子刚刚试穿了，超赞超给力。比我想象中的还要好！祝店家生意兴隆......','0','1377760807');");
E_D("replace into `le_share_goods_comments` values('14','0','3','0','鞋的样子很漂亮 角度也可以 就是有点不跟脚 一走路后跟会出来 还送了丝袜 半码垫 后跟贴 很贴心 留下了 ','0','1377760807');");
E_D("replace into `le_share_goods_comments` values('15','0','3','0','今天刚收到宝贝，我为了看效果，同学让我马上试，大家都一致认为，好看，发物流太给了，因送货时间延误，店主竟然送了我两双丝袜，太贴心了，下次还会再来的','0','1377760807');");
E_D("replace into `le_share_goods_comments` values('16','0','3','0','这次的鞋子 总的来说没上次的那双好   做工不是很好。 但是穿着还是比较舒服、 谢谢卖家的礼物  好多哦。','0','1377760807');");
E_D("replace into `le_share_goods_comments` values('17','0','3','0','帮朋友买的，很好走，自己也想买双33的，可惜没有。有点味道，跟图片不一样，看的是红底，到货是肉色的。付款了好几天才发货。不过还是谢谢你，赠品朋友很喜欢','0','1377760807');");
E_D("replace into `le_share_goods_comments` values('18','0','3','0','鞋子挺满意的，之前买了36码的大了，换了35码的刚好，卖家服务态度很好，给5分，下次还来购买<br/>\n','0','1377760807');");

require("../../inc/footer.php");
?>