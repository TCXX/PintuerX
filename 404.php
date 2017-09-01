<?php 
/**
 * 自定义404页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo showText('404'); ?></title>
</head>
<body>
<div class="main">
<p><?php echo showText('404'); ?></p>
<p><a href="javascript:history.back(-1);">&laquo;<?php echo showText('BACK'); ?></a></p>
</div>
</body>
</html>
