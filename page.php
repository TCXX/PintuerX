<?php 
/**
 * 自建页面模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="container">
	<div class="line">
	<div class="xl12 xs12 xm9 xb9">
	<div class="doc-right">
			<div class="panel">
			<div class="panel-body">
			<br>
			<h1 align="center"><?php topflg($top); ?><?php echo $log_title; ?></h1>
			<br>
			<hr class="article-hr">
			<?php echo $log_content; ?>
			<div class="panel-body">
				<?php blog_comments($comments); ?>
				<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
			</div>
			<div style="clear:both;"></div>
			</div>
		</div>
	</div>
</div>
<?php
 include View::getView('side');
 include View::getView('footer');
?>