<?php
/*
Template Name:拼图响应式前端框架模板
Description:拼图模板，简洁优雅
Version:1.1x
Author:pintuer, TCXX
Author Url:http://www.pintuer.com
Sidebar Amount:1
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
	<!DOCTYPE html>
	<html lang="zh-CN">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="renderer" content="webkit">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="keywords" content="<?php echo $site_key; ?>" />
		<meta name="description" content="<?php echo $site_description; ?>" />
		<meta name="generator" content="pintuer" />
		<title><?php echo $site_title; ?></title>
		
		<link rel="stylesheet" href="http://www.pintuer.com/css/pintuer.css">
		<!--<link href="<?php echo TEMPLATE_URL; ?>style.css" rel="stylesheet">-->
		<link href="<?php echo TEMPLATE_URL; ?>main.css" rel="stylesheet">
		<link href="<?php echo BLOG_URL; ?>admin/editor/plugins/code/prettify.css" rel="stylesheet" type="text/css" />			
		<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
		<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
		<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php echo BLOG_URL; ?>rss.php" />

		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
		<script src="http://www.pintuer.com/js/pintuer.js"></script>
		<!--<script src="http://www.pintuer.com/plugins/respond.js"></script>
		<script src="http://www.pintuer.com/plugins/layer/layer.js"></script>-->
		<script src="<?php echo BLOG_URL; ?>admin/editor/plugins/code/prettify.js" type="text/javascript"></script>
		<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
		<!--[if IE 6]>
		<script src="<?php echo TEMPLATE_URL; ?>iefix.js" type="text/javascript"></script>
		<![endif]-->
		<style type="text/css">
		#calendar .calendartop{width:50%;}
		#calendar .calendar{width:100%;}
		#pagenavi {list-style: none;margin: 0;padding: 0;display: inline-block;vertical-align: bottom;}
		#pagenavi span {display: inline-block;border: solid 1px;border-radius: 4px;padding: 8px 12px;line-height: 18px;transition: all 1s cubic-bezier(0.175, 0.885, 0.32, 1) 0s;}
		#pagenavi a {display: inline-block;border: solid 1px;border-radius: 4px;padding: 8px 12px;line-height: 18px;transition: all 1s cubic-bezier(0.175, 0.885, 0.32, 1) 0s;}
		.popo .popo-left {width: 100%;}
		.popo .popo-body.left {width: 100%;max-width: 100%;}
		.input-group {border-collapse: separate;display: block;position: relative;}
		.cuttitle{ display: block; width: 220px; height:24px; overflow:  hidden; white-space: nowrap; -o-text-overflow: ellipsis; text-overflow:  ellipsis; }
		</style>
		<script type="text/javascript">
			$(window).scroll(function(){
			if($(this).scrollTop()>220){
			$('#txw-nav').addClass('topfixed');
			} else {
			$('#txw-nav').removeClass('topfixed');
			}
				
			if($(this).scrollTop()>10){
			$('#txw-bg-small').addClass('topfixed');
			$('#txw-nav-small').addClass('topfixed');
			} else {
			$('#txw-bg-small').removeClass('topfixed');
			$('#txw-nav-small').removeClass('topfixed');
			}
			
			});
		</script>
		<?php doAction('index_head'); ?>
	</head>
		<body>
		<div class="doc-header">
			<div class="hidden-s hidden-m hidden-b show-l">
				<div class="box-shadow-small" id="txw-bg-small"></div>
				<div class="box-shadow-small" id="txw-bg-hold"></div>
				<div id="txw-title-small"><?php echo $blogname; ?></div>
				<button class="button icon-navicon float-right" data-target="#txw-nav-small" id="txw-menu-button"></button>
				<ul class="nav nav-navicon padding-small-top box-shadow-small nav-inline" id="txw-nav-small">
					<?php blog_navi($blogname);?>
				</ul>
			</div>
			<div class="bg-main doc-intro show-s show-m show-b hidden-l" id="txw-bg-main">
				<div class="container">
					<div id="txw-container">
						<div id="txw-bg-img1">
							<img src="<?php echo TEMPLATE_URL; ?>images/QXin.png">
						</div>
						<div id="txw-bg-img2">
							<img src="<?php echo TEMPLATE_URL; ?>images/QHeart.png">
						</div>
						<div id="txw-bg-title">
							<h1><?php echo $blogname; ?></h1>
							<p><?php echo $bloginfo; ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="bg-inverse">
				<ul class="fixable nav nav-navicon padding-small-top box-shadow-small nav-inline" id="txw-nav">
			  	<?php blog_navi($blogname);?>
				</ul>
			</div>
		</div>
		
		