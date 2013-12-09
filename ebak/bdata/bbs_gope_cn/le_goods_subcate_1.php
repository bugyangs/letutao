<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `le_goods_subcate`;");
E_C("CREATE TABLE `le_goods_subcate` (
  `subcate_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) DEFAULT NULL,
  `subcate_icon` varchar(255) DEFAULT '',
  `tag` text,
  `create_time` int(11) DEFAULT '0',
  PRIMARY KEY (`subcate_id`),
  KEY `cate_id` (`cate_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8");
E_D("replace into `le_goods_subcate` values('1','48','uploadfile/subcate_ico/20130824/20130824_214652_441.jpg','衬衫，雪纺衫，T恤，薄外套，背心，蕾丝衫，长袖T，无袖衫，开衫，小西装，棒球衫，娃娃衫，花朵衫，卫衣，防晒衫，风衣','1377351572');");
E_D("replace into `le_goods_subcate` values('2','47','uploadfile/subcate_ico/20130824/20130824_214825_382.jpg','娃娃领，宽松，大码，条纹，格纹，花朵，短款','1377351693');");
E_D("replace into `le_goods_subcate` values('3','46','uploadfile/subcate_ico/20130824/20130824_214851_444.jpg','甜美，简约，代购，街头，公主，卡通，韩版，街拍','1377351700');");
E_D("replace into `le_goods_subcate` values('4','45','uploadfile/subcate_ico/20130827/20130827_161208_709.png','雪纺，真丝，牛仔，蕾丝，纯棉','1377351705');");
E_D("replace into `le_goods_subcate` values('5','49','uploadfile/subcate_ico/20130825/20130825_124913_275.jpg','甜美，复古，雪纺，蕾丝，花朵，娃娃领，公主风，收腰，显瘦，露肩，棉质，雪纺，薄纱','1377405822');");
E_D("replace into `le_goods_subcate` values('6','51','uploadfile/subcate_ico/20130825/20130825_124835_291.jpg','连衣裙，半身裙，短袖裙，长袖裙，牛仔裙，长裙，包臀裙','1377405909');");
E_D("replace into `le_goods_subcate` values('7','50','uploadfile/subcate_ico/20130825/20130825_124936_762.jpg','短裤，牛仔裤，小脚裤，哈伦裤，打底裤，背带裤，休闲裤，连体裤，牛仔短裤，运动裤，西装裤，高腰裤，裙裤，修身裤，印花裤，铅笔裤','1377405939');");
E_D("replace into `le_goods_subcate` values('8','52','uploadfile/subcate_ico/20130825/20130825_125627_873.jpg','高腰，小脚，显瘦，宽松，破洞，原单，大码，修身，七分','1377405967');");
E_D("replace into `le_goods_subcate` values('9','53','uploadfile/subcate_ico/20130826/20130826_092027_974.jpg','平底鞋，高跟鞋，尖头鞋，圆头鞋，粗跟鞋，坡跟鞋，方头鞋，漆皮鞋，牛津鞋，水钻单鞋，软底鞋','1377479682');");
E_D("replace into `le_goods_subcate` values('10','57','uploadfile/subcate_ico/20130826/20130826_091845_277.jpg','豆豆鞋，镂空凉鞋，草编凉鞋，雨鞋，拖鞋，印花鞋，婚鞋，系带凉鞋，平跟鞋，娃娃鞋，早秋新品','1377479715');");
E_D("replace into `le_goods_subcate` values('11','55','uploadfile/subcate_ico/20130826/20130826_091816_949.jpg','百搭，豹纹，流苏，原单，水钻，系带，松糕，圆头，学生党','1377479764');");
E_D("replace into `le_goods_subcate` values('12','54','uploadfile/subcate_ico/20130826/20130826_091934_702.jpg','帆布鞋，松糕鞋，运动鞋，厚底鞋，球鞋，高帮鞋，低帮鞋，小白鞋，板鞋，布鞋，草编鞋，高帮帆布鞋，魔术贴，厚底帆布','1377479820');");
E_D("replace into `le_goods_subcate` values('13','61','uploadfile/subcate_ico/20130826/20130826_102825_589.jpg','单肩包，手提包，斜挎包，双肩包，手拿包，零钱包，铆钉包，旅行包','1377484072');");
E_D("replace into `le_goods_subcate` values('14','60','uploadfile/subcate_ico/20130826/20130826_103208_344.jpg','小香风，机车包，枕头型，迷你型定型包，水桶包，流苏包，学院风','1377484323');");
E_D("replace into `le_goods_subcate` values('15','59','uploadfile/subcate_ico/20130826/20130826_103440_252.jpg','豹纹，菱格，甜美，欧美，链条，铆钉，撞色，复古','1377484407');");
E_D("replace into `le_goods_subcate` values('16','58','uploadfile/subcate_ico/20130826/20130826_103446_882.jpg','真皮，牛皮，PU包，羊皮，帆布，果冻感，漆皮，草编','1377484427');");
E_D("replace into `le_goods_subcate` values('17','62','uploadfile/subcate_ico/20130826/20130826_104213_556.jpg','纯银，黄金，镶钻，水晶，开运，宝石，辟邪，施华洛世奇','1377484667');");
E_D("replace into `le_goods_subcate` values('18','65','uploadfile/subcate_ico/20130826/20130826_104156_653.jpg','戒指，耳环，发夹，项链，胸针，发圈，发箍，手链','1377484700');");
E_D("replace into `le_goods_subcate` values('19','64','uploadfile/subcate_ico/20130826/20130826_104202_696.jpg','发饰，胸饰，耳饰，手表，腰带，假领，镜框，手饰','1377484728');");
E_D("replace into `le_goods_subcate` values('20','63','uploadfile/subcate_ico/20130826/20130826_104208_447.jpg','复古，韩版，日系，朋克，杂志款，英伦，撞色，百搭','1377484749');");
E_D("replace into `le_goods_subcate` values('21','67','uploadfile/subcate_ico/20130826/20130826_104806_663.jpg','洁面，面膜，卸妆，唇膏，乳液，精华，面霜，化妆水','1377485130');");
E_D("replace into `le_goods_subcate` values('22','66','uploadfile/subcate_ico/20130826/20130826_104811_920.jpg','BB霜，遮瑕，唇彩，睫毛膏，隔离霜，粉底，眼影，眼线','1377485157');");
E_D("replace into `le_goods_subcate` values('23','68','uploadfile/subcate_ico/20130826/20130826_104818_501.jpg','控油，保湿，去黑头，美白，敏感肌肤，紧致，收缩毛孔','1377485184');");
E_D("replace into `le_goods_subcate` values('24','69','uploadfile/subcate_ico/20130826/20130826_104824_734.jpg','贝玲妃，雅漾，DIOR，倩碧，兰蔻，雅诗兰黛，资生堂，DHC','1377485215');");
E_D("replace into `le_goods_subcate` values('25','70','uploadfile/subcate_ico/20130828/20130828_165042_248.png','盆栽，礼品，马克杯，便当盒，文具，玻璃杯，雨伞，风扇，婚礼，烛台，七夕礼物，多肉，盆栽','1377485374');");
E_D("replace into `le_goods_subcate` values('26','71','uploadfile/subcate_ico/20130828/20130828_165101_791.png','衣帽钩，相片墙，贴纸，地垫，靠垫，盖布，时钟，置物架，盆栽，相机，冰箱贴，挂钟，马口铁，收纳','1377485394');");
E_D("replace into `le_goods_subcate` values('27','72','uploadfile/subcate_ico/20130828/20130828_165115_967.png','抱枕，坐垫，摆件，窗帘，香薰，加湿器，衣柜，床品套件，床头灯，懒人沙发','1377485414');");
E_D("replace into `le_goods_subcate` values('28','73','uploadfile/subcate_ico/20130828/20130828_165128_663.png','餐具，勺子，便当盒，烘焙，调味瓶，模具，茶具，密封罐，杯垫','1377485428');");

require("../../inc/footer.php");
?>