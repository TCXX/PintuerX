<?php 
/**
 * 阅读文章页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="container">
	<div class="line">
	<div class="xl12 xs12 xm9 xb9">
	<!--list.start-->
		<div class="doc-right">
			<div class="panel">
			<div class="panel-body">
			<br>
			<h1 align="center"><?php topflg($top); ?><?php echo $log_title; ?></h1>
			<p class="text-center text-small"><?php echo gmdate('Y-n-j', $date); ?> <?php blog_sort($logid); ?> <?php blog_tag($logid); ?> <?php editflg($logid,$author); ?></p>
			<br>
			<hr class="article-hr">
			<?php echo $log_content; ?>
			</div>
			<p class="nextlog text-center"><?php neighbor_log($neighborLog); ?></p>
			<br>
			<?php doAction('log_related', $logData); ?>
			<div class="panel-body">
				<?php blog_comments($comments); ?>
				<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
			</div>
		</div>
	</div>
	<!--list.end-->

</div>
<?php
 include View::getView('side');
 include View::getView('footer');
?>