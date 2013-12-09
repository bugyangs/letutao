<?php
defined('IN_TS') or die('Access Denied.');
//统计代码
function gobad_html($s,$w){
	$code = fileRead('data.php','plugins','pubs','gobad');
	echo stripslashes($code[$w]);
}

/*300广告位*/
//faxian首页右侧底部
addAction('adcode','gobad_html');

//动态首页右侧底部
addAction('feed_index_right_footer','gobad_html');

//板块话题页右侧底部
addAction('group_topic_right_footer','gobad_html');

//板块首页
addAction('group_index_right_footer','gobad_html');

//话题内容底部
addAction('topic_footer','gobad_html');

//板块页右侧底部
addAction('group_group_right_footer','gobad_html');

//板块用户页右侧底部
addAction('group_my_right_footer','gobad_html');

//用户user
addAction('user_space_right_footer','gobad_html');

//相册图片页右侧底部
addAction('photo_show_right_footer','gobad_html');

//苹果机首页右侧底部
addAction('apple_index_right_footer','gobad_html');

//苹果机内容页右侧底部
addAction('apple_show_right_footer','gobad_html');

//苹果机点评内容页右侧底部
addAction('apple_review_right_footer','gobad_html');

//电台首页右侧底部
addAction('radio_index_right_footer','gobad_html');