<?php 
/**
 * 侧边栏组件、页面模块
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>

<?php
//全局匹配正文中的图片并存入imgsrc中
function img_zw($content){
	preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $content, $img);
	$imgsrc = !empty($img[1]) ? $img[1][0] : '';
	if($imgsrc):return $imgsrc;endif;
}

//Custom: 获取附件第一张图片
function img_fj($logid){
	$db = MySql::getInstance();
	$sql = "SELECT * FROM ".DB_PREFIX."attachment WHERE blogid=".$logid." AND (`filepath` LIKE '%jpg' OR `filepath` LIKE '%gif' OR `filepath` LIKE '%png') ORDER BY `aid` ASC LIMIT 0,1";
	$imgs = $db->query($sql);
	$img_path = "";
	while($row = $db->fetch_array($imgs)){
		$img_path .= BLOG_URL.substr($row['filepath'],3,strlen($row['filepath']));
	}
	return $img_path;
}?>

<?php //幻灯片(调用分类置顶)
function home_flash($title, $size){?>
	<div class="panel">
	<div class="panel-head"><?php echo $title; ?></div>
	<?php $db = MySql::getInstance();
	$sql =$db->query ("SELECT * FROM ".DB_PREFIX."blog inner join ".DB_PREFIX."sort WHERE hide='n' AND type='blog' AND sortop='y' AND sortid=sid order by date DESC limit 0,5");?>
	<div class="banner" data-pointer="1" data-interval="6" data-item="1" data-small="1" data-middle="<?php echo $size?>" data-big="<?php echo $size?>">
		<div class="carousel">
		<?php while($value = $db->fetch_array($sql)){
		$img_url = TEMPLATE_URL.'images/flash/'.rand(1,5).'.jpg';
		
		if(img_fj($value['gid'])){
			$img_url = img_fj($value['gid']);
		}elseif(img_zw($value['content'])){
			$img_url = img_zw($value['content']);
		}else{
			$img_url;
		}?>
			
		<div class="item">
			<a href="<?php echo Url::log($value['gid']);?>" title="<?php echo $value['title'];?>">
			<img src="<?php echo $img_url;?>" alt="<?php echo $value['title'];?>"/>
			</a></div><?php }?>
		</div></div></div><br>
<?php }?>

<?php
//widget：搜索
function widget_search($title){ ?>
	<div id="logsearch" class="input-group padding-little-top" title="<?php echo $title; ?>">
		<form name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php">
			<input type="text" class="input border-main search float-left" name="keyword" size="30" placeholder="<?php echo showText('KEY'); ?>" style="width:200px;" />
			<span class="addbtn"><button type="submit" class="button bg-main icon-search"></button></span>
		</form>
	</div>
	<br>
<?php } ?>
<?php
//widget：blogger
function widget_blogger($title){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
	<div class="panel">
		<div class="panel-head"><?php echo $title; ?></div>
		<div class="panel-body panel-body-bordered">
				<div class="media media-y">
					<?php if (!empty($user_cache[1]['photo']['src'])): ?>
					<img src="<?php echo BLOG_URL.$user_cache[1]['photo']['src']; ?>" width="128" height="128" class="radius" alt="blogger">
					<?php endif;?>
					<div class="media-body" style="width:200px;">
					<p>
						<strong class="text-center"><?php echo $name; ?></strong>
						<?php echo $user_cache[1]['des']; ?>
					</p>
					</div>
				</div>
		</div>
</div>
<br>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){ ?>
	<div class="tab-panel" id="tab-calendar">
		<div class="line">
			<div id="calendar">
				<script>sendinfo('<?php echo Calendar::url(); ?>','calendar');</script>
			</div>
		</div>
	</div>
	<br>
<?php }?>
<?php
//widget：热门文章
function widget_hotlog($title){
	$index_hotlognum = Option::get('index_hotlognum');
	$Log_Model = new Log_Model();
	$randLogs = $Log_Model->getHotLog($index_hotlognum);?>
	<div class="panel">
		<div class="panel-head"><?php echo $title; ?></div>
			<div class="tab-panel active" id="tab-hot">
				<ul class="list-link radius-none">
				<?php foreach($randLogs as $value): ?>
				<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
<br>
<?php }?>
<?php
//widget：最新文章
function widget_newlog($title){
	global $CACHE; 
	$newLogs_cache = $CACHE->readCache('newlog');
	?>
	<div class="panel">
		<div class="panel-head"><?php echo $title; ?></div>
		<ul class="list-link radius-none">
		<?php foreach($newLogs_cache as $value): ?>
		<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
		<?php endforeach; ?>
		</ul>
	</div>
	<br>
<?php }?>
<?php
//widget：随机文章
function widget_random_log($title){
	$index_randlognum = Option::get('index_randlognum');
	$Log_Model = new Log_Model();
	$randLogs = $Log_Model->getRandLog($index_randlognum);?>
	<div class="panel">
		<div class="panel-head"><?php echo $title; ?></div>
		<ul class="list-link radius-none">
		<?php foreach($randLogs as $value): ?>
			<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
		<?php endforeach; ?>
		</ul>
	</div>
	<br>
<?php }?>	
<?php
//widget：分类
function widget_sort($title){
	global $CACHE;
	$sort_cache = $CACHE->readCache('sort'); ?>
	<div class="panel">
		<div class="panel-head"><?php echo $title; ?></div>
				<ul class="list-link radius-none">
						<?php
						foreach($sort_cache as $value):
							if ($value['pid'] != 0) continue;
						?>
						<li><a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
						<?php if (!empty($value['children'])): ?>
							<ul>
							<?php
							$children = $value['children'];
							foreach ($children as $key):
								$value = $sort_cache[$key];
							?>
							<li>
								<a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
							</li>
							<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						</li>
						<?php endforeach; ?>
    			</ul>
		</div>
<br>
<?php }?>
<?php
//widget：归档
function widget_archive($title){
	global $CACHE; 
	$record_cache = $CACHE->readCache('record');
	?>
	<div class="panel">
		<div class="panel-head"><?php echo $title; ?></div>
			<ul class="list-link radius-none">
			<?php foreach($record_cache as $value): ?>
			<li><a href="<?php echo Url::record($value['date']); ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
			<?php endforeach; ?>
		</ul>
	</div>
		<br>
<?php } ?>
<?php
//widget：标签
function widget_tag($title){
	global $CACHE;
	$tag_cache = $CACHE->readCache('tags');?>
	<div class="panel">
		<div class="panel-head"><?php echo $title; ?></div>
		<div class="panel-body panel-body-bordered">
	<?php foreach($tag_cache as $value): ?>
		<span class="
			<?php 
				$rd_color=array("badge"=>"","badge bg-main"=>"","badge bg-sub"=>"","badge bg-back"=>"","badge bg-mix"=>"","badge bg-dot"=>"","badge bg-black"=>""
				,"badge bg-gray"=>"","badge bg-white"=>"","badge bg-red"=>"","badge bg-yellow"=>"","badge bg-blue"=>"","badge bg-green"=>"","badge bg-red-light"=>""
				,"badge bg-yellow-light"=>"","badge bg-blue-light"=>"","badge bg-green-light"=>"");
				echo array_rand($rd_color,1) 
			?>
				">
		<a href="<?php echo Url::tag($value['tagurl']); ?>" title="<?php echo $value['usenum']; ?> 篇文章"><?php echo $value['tagname']; ?></a></span>
	<?php endforeach; ?>
	</div>
	</div>
	<br>
<?php }?>
<?php
//widget：最新微语
function widget_twitter($title){
	global $CACHE; 
	$newtws_cache = $CACHE->readCache('newtw');
	$istwitter = Option::get('istwitter');
	?>
	<div class="panel">
		<div class="panel-head"><?php echo $title; ?></div>
		<div class="panel-body panel-body-bordered">
			<ul>
				<?php foreach($newtws_cache as $value): ?>
				<?php $img = empty($value['img']) ? "" : '<a title="view pic" class="t_img" href="'.BLOG_URL.str_replace('thum-', '', $value['img']).'" target="_blank">&nbsp;</a>';?>
				<li><a class="cuttitle"><?php echo $value['t']; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<br>
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $CACHE; 
	$com_cache = $CACHE->readCache('comment');
	?>
	<div class="panel">
		<div class="panel-head"><?php echo $title; ?></div>
		<div class="panel-body panel-body-bordered">
			<ul>
			<?php
			foreach($com_cache as $value):
			$url = Url::comment($value['gid'], $value['page'], $value['cid']);
			?>
			<li id="comment"><strong class="tag-yellow-light"><?php echo $value['name']; ?></strong>
			<br /><a href="<?php echo $url; ?>"><?php echo $value['content']; ?></a></li>
			<?php endforeach; ?>
			</ul>
	</div>
	</div>
	<br>
<?php }?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content){ ?>
	<div class="panel">
		<div class="panel-head"><?php echo $title; ?></div>
		<div class="panel-body panel-body-bordered">
			<div class="panel-panel active" id="panel-<?php echo $title; ?>">
				<?php echo $content; ?>
			</div>
		</div>
	</div>
	<br>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
	//if (!blog_tool_ishome()) return;#只在首页显示友链去掉双斜杠注释即可
	?>
	<div class="panel">
		<div class="panel-head"><?php echo $title; ?></div>
			<ul class="list-link radius-none">
				<?php foreach($link_cache as $value): ?>
				<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
				<?php endforeach; ?>
			</ul>
	</div>
<br>
<?php }?> 
<?php
//blog：导航
function blog_navi(){
	global $CACHE; 
	$navi_cache = $CACHE->readCache('navi');
	?>
	<ul class="bar">
	<?php
	foreach($navi_cache as $value):

        if ($value['pid'] != 0) {
            continue;
        }

		if($value['url'] == ROLE_ADMIN && (ROLE == ROLE_ADMIN || ROLE == ROLE_WRITER)):
			?>
			<li class="item common"><a href="<?php echo BLOG_URL; ?>admin/">管理站点</a></li>
			<li class="item common"><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
			<?php 
			continue;
		endif;
		$newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
        $value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
        $current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'current' : 'common';
		?>
		<li class="item <?php echo $current_tab;?>">
			<a href="<?php echo $value['url']; ?>" <?php echo $newtab;?>><?php echo $value['naviname']; ?></a>
			<?php if (!empty($value['children'])) :?>
            <ul class="sub-nav">
                <?php foreach ($value['children'] as $row){
                        echo '<li><a href="'.Url::sort($row['sid']).'">'.$row['sortname'].'</a></li>';
                }?>
			</ul>
            <?php endif;?>

            <?php if (!empty($value['childnavi'])) :?>
            <ul class="sub-nav">
                <?php foreach ($value['childnavi'] as $row){
                        $newtab = $row['newtab'] == 'y' ? 'target="_blank"' : '';
                        echo '<li><a href="' . $row['url'] . "\" $newtab >" . $row['naviname'].'</a></li>';
                }?>
			</ul>
            <?php endif;?>

		</li>
	<?php endforeach; ?>
	</ul>
<?php }?>
<?php
//blog：置顶
function topflg($top, $sortop='n', $sortid=null){
    if(blog_tool_ishome()) {
       echo $top == 'y' ? "<span class='icon-thumb-tack'></span>" : '';
    } elseif($sortid){
       echo $sortop == 'y' ? "<span class='icon-thumb-tack'></span>" : '';
    }
}
?>
<?php
//blog：编辑
function editflg($logid,$author){
	$editflg = ROLE == ROLE_ADMIN || $author == UID ? '<a href="'.BLOG_URL.'admin/write_log.php?action=edit&gid='.$logid.'" target="_blank">编辑</a>' : '';
	echo $editflg;
}
?>
<?php
//blog：分类
function blog_sort($blogid){
	global $CACHE; 
	$log_cache_sort = $CACHE->readCache('logsort');
	?>
	<?php if(!empty($log_cache_sort[$blogid])){ ?>
    <a href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>"><?php echo $log_cache_sort[$blogid]['name']; ?></a>			
	<?php } else { ?>
	<span><?php echo showText('NO_SORT'); ?></span>
<?php }}?>

<?php
//blog：文章标签
function blog_tag($blogid){
	global $CACHE;
	$log_cache_tags = $CACHE->readCache('logtags');
	if (!empty($log_cache_tags[$blogid])){
		$tag = showText('TAGS');
		foreach ($log_cache_tags[$blogid] as $value){
			$tag .= "	<a href=\"".Url::tag($value['tagurl'])."\">".$value['tagname'].'</a>';
		}
		echo $tag;
	} else {
		echo showText('NO_TAG');
	}
}
?>
<?php
//blog：文章作者
function blog_author($uid){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$author = $user_cache[$uid]['name'];
	$mail = $user_cache[$uid]['mail'];
	$des = $user_cache[$uid]['des'];
	$title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
	echo '<a href="'.Url::author($uid)."\" $title>$author</a>";
}
?>
<?php
//blog：相邻文章
function neighbor_log($neighborLog){
	extract($neighborLog);?>
	<?php if($prevLog):?>
	&laquo; <a href="<?php echo Url::log($prevLog['gid']) ?>"><?php echo $prevLog['title'];?></a>
	<?php endif;?>
	<?php if($nextLog && $prevLog):?>
		|
	<?php endif;?>
	<?php if($nextLog):?>
		 <a href="<?php echo Url::log($nextLog['gid']) ?>"><?php echo $nextLog['title'];?></a>&raquo;
	<?php endif;?>
<?php }?>
<?php
//blog：评论列表
function blog_comments($comments){
    extract($comments);
    if($commentStacks): ?>
    <a name="comments"></a>
    <strong class="text-main comment-header"><?php echo showText('COMMENT'); ?></strong>
	<?php endif; ?>
	<?php
	$isGravatar = Option::get('isgravatar');
	foreach($commentStacks as $cid):
    $comment = $comments[$cid];
	$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<div class="comment panel-body border-top text-small" id="comment-<?php echo $comment['cid']; ?>">
		<a name="<?php echo $comment['cid']; ?>"></a>
		<div class="comment-info">
			<b><?php echo $comment['poster']; ?> </b><span class="comment-time"><?php echo $comment['date']; ?></span>
			<div class="comment-content text-small padding-small-top height-small"><?php echo $comment['content']; ?></div>
			<div class="comment-reply text-small padding-small-top height-small"><a class="tag bg-white" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)"><?php echo showText('REPLY'); ?></a></div>
		</div>
		<?php blog_comments_children($comments, $comment['children']); ?>
	</div>
	<?php endforeach; ?>
    <div id="pagenavi">
	    <?php echo $commentPageUrl;?>
    </div>
<?php }?>
<?php
//blog：子评论列表
function blog_comments_children($comments, $children){
	$isGravatar = Option::get('isgravatar');
	foreach($children as $child):
	$comment = $comments[$child];
	$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<div class="comment comment-children panel-body border text-small margin-top radius" id="comment-<?php echo $comment['cid']; ?>">
		<a name="<?php echo $comment['cid']; ?>"></a>
		<div class="comment-info">
			<b><?php echo $comment['poster']; ?> </b><span class="comment-time"><?php echo $comment['date']; ?></span>
			<div class="comment-content text-small padding-small-top height-small"><?php echo $comment['content']; ?></div>
			<?php if($comment['level'] < 3): ?><div class="comment-reply"><a class="tag bg-white" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)"><?php echo showText('REPLY'); ?></a></div><?php endif; ?>
		</div>
		<?php blog_comments_children($comments, $comment['children']);?>
	</div>
	<?php endforeach; ?>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
	if($allow_remark == 'y'): ?>
	<div id="comment-place">
	<div class="comment-post" id="comment-post">
		<div class="cancel-reply tag bg-white" id="cancel-reply" style="display:none"><a href="javascript:void(0);" onclick="cancelReply()"><?php echo showText('CANCEL_REPLY'); ?></a></div>
		<strong class="comment-header"><?php echo showText('WRITE_COMMENT'); ?><a name="respond"></a></strong>
		<form method="post" name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" id="commentform">
			<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
			<?php if(ROLE == ROLE_VISITOR): ?>
			<div class="form-group" id="f_1447136101540">
				<div class="field">
					<input class="input" type="text" name="comname" maxlength="49" value="<?php echo $ckname; ?>" size="22" tabindex="1" data-validate="<?php echo showText('FILL_NICKNAME'); ?>" placeholder="<?php echo showText('FILL_NICKNAME'); ?>">
				</div>
				<div class="field">
					<input class="input" type="text" name="commail" maxlength="49" value="<?php echo $ckmail; ?>" size="22" tabindex="1" data-validate="<?php echo showText('FILL_EMAIL'); ?>" placeholder="<?php echo showText('FILL_EMAIL'); ?>">
				</div>
				<div class="field">
					<input class="input" type="text" name="comurl" maxlength="49" value="<?php echo $ckurl; ?>" size="22" tabindex="1" data-validate="<?php echo showText('FILL_SITE'); ?>" placeholder="<?php echo showText('FILL_SITE'); ?>">
				</div>
			</div>
			<?php endif; ?>
			<div class="form-group" id="f_1447136101540">
				<div class="field">
					<textarea class="input" name="comment" id="comment" rows="2" tabindex="4" data-validate="<?php echo showText('FILL_COMMENT'); ?>" placeholder="<?php echo showText('FILL_COMMENT'); ?>"></textarea>
				</div>
			</div>
			<div class="form-group" id="f_1447136116228">
				<p class="form-inline">
					<?php echo $verifyCode; ?>
				</p>
				<br>
				<input class="button bg-yellow button-block" type="submit" id="comment_submit" value="<?php echo showText('SUBMIT_COMMENT'); ?>" tabindex="6" />
			</div>
			<input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>
		</form>
	</div>
	</div>
	<?php endif; ?>
<?php }?>
<?php
//blog-tool:判断是否是首页
function blog_tool_ishome(){
    if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL){
        return true;
    } else {
        return FALSE;
    }
}

// For multi-lingual support. Change the value of $lang to indicate a preferred language.
function showText ($str) {
	$lang = 'en';
	
	$en = array();
	$cn = array();
	
	//footer
	$en['COPY_RIGHT'] = 'All rights reserved';
	$cn['COPY_RIGHT'] = '版权所有';
	$en['TXW'] = 'Xins Sweet Home';
	$cn['TXW'] = '甜欣屋';
	
	//t
	$en['NOT_FOUND'] = 'No Results Found';
	$cn['NOT_FOUND'] = '啥也没找到';
	$en['NO_RESULTS'] = 'Oops, no results is found. ';
	$cn['NO_RESULTS'] = '啥结果也没有喔。';
	
	//log_list
	$en['VIEW_ARTICLE'] = 'View Article';
	$cn['VIEW_ARTICLE'] = '查看文章';
	$en['ARTICLE_LIST'] = 'Article List';
	$cn['ARTICLE_LIST'] = '文章列表';
	$en['COMMENT'] = 'Comments ';
	$cn['COMMENT'] = '评论';
	$en['VIEW'] = 'Views ';
	$cn['VIEW'] = '浏览';
	$en['ONE_PAGE'] = 'One page in total';
	$cn['ONE_PAGE'] = '共一页';
	
	//module
	$en['KEY'] = 'keyword';
	$cn['KEY'] = '关键词';
	$en['NO_SORT'] = 'Uncategorized';
	$cn['NO_SORT'] = '未分类';
	$en['TAGS'] = 'Tags: ';
	$cn['TAGS'] = '标签：';
	$en['NO_TAG'] = 'No tags';
	$cn['NO_TAG'] = '无标签';
	$en['REPLY'] = 'Reply';
	$cn['REPLY'] = '回复';
	$en['CANCEL_REPLY'] = 'Cancel reply';
	$cn['CANCEL_REPLY'] = '取消回复';
	$en['WRITE_COMMENT'] = 'Write a comment';
	$cn['WRITE_COMMENT'] = '发表评论';
	$en['FILL_NICKNAME'] = 'Please write your nickname';
	$cn['FILL_NICKNAME'] = '请填写你的昵称';
	$en['FILL_EMAIL'] = 'Please write your email address (optional)';
	$cn['FILL_EMAIL'] = '请填写你的邮箱';
	$en['FILL_SITE'] = 'Please write your website address (optional)';
	$cn['FILL_SITE'] = '请填写你的网址';
	$en['FILL_COMMENT'] = 'Please write your comment';
	$cn['FILL_COMMENT'] = '请填写评论内容';
	$en['SUBMIT_COMMENT'] = 'Submit comment';
	$cn['SUBMIT_COMMENT'] = '提交评论';
	
	//404
	$en['404'] = 'Page Not Found';
	$cn['404'] = '页面找不到啦';
	$en['BACK'] = 'Submit comment';
	$cn['BACK'] = '返回';
	
	//side
	$en['WORKS'] = 'Works';
	$cn['WORKS'] = '作品展示';
	
	if ($lang == 'cn') {
		echo $cn[$str];
	} else {
		echo $en[$str];
	}
}

?>
