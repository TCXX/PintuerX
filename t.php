<?php 
/**
 * 微语部分
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="container">
<div class="line">
	<div class="xm9">
		<!--list.start-->
		<div class="doc-right">		
		<?php
		if (!empty($tws)): 
	    foreach($tws as $val):
	    $author = $user_cache[$val['author']]['name'];
	    $avatar = empty($user_cache[$val['author']]['avatar']) ? 
	                BLOG_URL . 'admin/views/images/avatar.jpg' : 
	                BLOG_URL . $user_cache[$val['author']]['avatar'];
	    $tid = (int)$val['id'];
	    $img = empty($val['img']) ? "" : '<img src="'.BLOG_URL.$val['img'].'" width="64" height="64" class="img-responsive img-border radius-circle bg-white"></a>';
	    
	    ?>
		<div class="line margin-top">
			<div class="x2 text-right">
				<div class="float-right text-center">
					<img src="<?php echo $avatar; ?>" width="64" height="64" class="img-responsive img-border radius-circle bg-white">
					<strong><?php echo $author; ?></strong>
				</div>
			</div>
			<div class="x10">
				<div class="popo">
					<div class="popo-left">
						<a href="#">
							<div class="popo-body popo-yellow left box-shadow">
								<?php echo $val['t'].'<br/>'.$img;?>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="hr"></div>
		<?php 
		endforeach;
		else:
		?>
		<h2><?php echo showText('NOT_FOUND'); ?></h2>
		<p><?php echo showText('NO_RESULTS'); ?></p>
		<?php endif;?>
		<div id="pagenavi" class="text-center">
			<?php echo $page_url;?>
		</div>
		</div>
		<!--list.end-->
	</div>
<!-- end #contentleft-->
<?php
 include View::getView('side');
 include View::getView('footer');
?>