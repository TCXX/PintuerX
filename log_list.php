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
					echo showText('VIEW_ARTICLE');
				}elseif($tws){
					echo $tws;
				}else{
					echo showText('ARTICLE_LIST');
				}
			?>
			</div>
			<div class="panel-body panel-body-bordered">
		<?php 
		if (!empty($logs)):
		foreach($logs as $value): 
		?>
			<h3 class="padding-small-top">
				<a class="article-title" href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a>
			
				<div class="float-right"><?php topflg($value['top'], $value['sortop'], isset($sortid)?$sortid:''); ?></div>
				</h3>
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
				$content = preg_replace('/\<p class=\"readmore\"\>(.*)\<\/p\>/i','',$value['log_description']);
                echo subString(strip_tags($content),0,250,"……");
                ?>
			</div>
			</div>
			<div class="padding-small-top">
				<span class="article-info float-left">
					<?php echo gmdate('Y-n-j', $value['date']); ?> 
						<?php editflg($value['logid'],$value['author']); ?>
				</span>
				<small class="article-info float-right text-small"><?php echo showText('COMMENT'); ?>(<?php echo $value['comnum']; ?>) | <?php echo showText('VIEW'); ?>(<?php echo $value['views']; ?>)</small>
			</div>
			<br>
			<hr class="article-hr">
		<?php 
		endforeach;
		else:
		?>
		<h2><?php echo $en['NOT_FOUND'];?></h2>
		<p><?php echo $en['NO_RESULTS'];?></p>
		<?php endif;?>
		</div>
		<!--list.end-->
		<div id="pagenavi" class="text-center">
			<?php if(!$page_url): ?>
			<?php echo $en['ONE_PAGE'];?>
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