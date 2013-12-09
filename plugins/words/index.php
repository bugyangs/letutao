<?php
require_once ('words_class.php');
$B = new WordsService();
$A = implode(' ',$B -> segment('笔记本/作业本记事本/工作手册日记本/日程本理财本/单词本便签本/N次贴',100));
echo $A;
?>