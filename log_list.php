<?php 
/**
 * 站点首页模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="container">
<div class="line">
	<div class="xm9">
		<!--list.start-->
		<div class="doc-right">
		<?php doAction('index_loglist_top'); ?>
			
		<?php if (blog_tool_ishome()){ home_flash('Works', 3);} ?>	
		
		<div class="panel">
			<div class="panel-head">
			<?php
				if($sortName){
					echo $sortName;
				}elseif($tag){
					echo $tag;
				}elseif($record){
					echo $record;
				}elseif($keyword){
					echo $keyword;
				}elseif($logid){
					echo '查看文章';
				}elseif($tws){
					echo $tws;
				}else{
					echo '文章列表';
				}
			?>
			</div>
			<div class="panel-body panel-body-bordered">
		<?php 
		if (!empty($logs)):
		foreach($logs as $value): 
		?>
			<h3 class="article-title padding-small-top"><?php topflg($value['top'], $value['sortop'], isset($sortid)?$sortid:''); ?><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a></h3>
			<br>
			<?php 
			$search_pattern = '%<img[^>]*?src=[\'\"]((?:(?!\/admin\/|>).)+?)[\'\"][^>]*?>%s';
			preg_match($search_pattern, $value['content'], $img);
			if(isset($img[1]) && !empty($img[1])) { ?>
				<div class="article-div">
				<div class="article-pic float-left hidden-l"><img src="<?php echo $img[1] ?>" class="img-border radius" /></div>
				<?php } else { ?>
					<div class="article-div-img">
				<?php } ?>
			<div class="article-text">
				<?php
				echo subString(strip_tags($value['log_description']),0,250,"……");
				?>
			</div>
			</div>
			<div class="padding-small-top">
				<span class="float-left">
					<?php echo gmdate('Y-n-j', $value['date']); ?> 
						<?php editflg($value['logid'],$value['author']); ?>
				</span>
				<small class="float-right text-small">评论(<?php echo $value['comnum']; ?>) | 浏览(<?php echo $value['views']; ?>)</small>
			</div>
			<br>
			<hr class="article-hr">
		<?php 
		endforeach;
		else:
		?>
		<h2>未找到</h2>
		<p>抱歉，没有符合您查询条件的结果。</p>
		<?php endif;?>
		</div>
		<!--list.end-->
		<div id="pagenavi" class="text-center">
			<?php if(!$page_url): ?>
			共一页
			<?php endif; ?>
			<?php echo $page_url;?>
		</div>
		</div>
		</div>
	</div>
<!-- end #contentleft-->
<?php
 include View::getView('side');
 include View::getView('footer');
?>