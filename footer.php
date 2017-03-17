<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
</div>
</div>
</div>
</div>
<!--end #content-->
<div class="container doc-footer">Powered by Emlog | Theme By Pintuer | <?php echo showText('COPY_RIGHT'); ?> &copy; <a href="http://www.tcxx.info">甜欣屋</a> <?php echo $icp; ?> <?php echo $footer_info; ?><?php doAction('index_footer'); ?></div>
<div class="doc-backtop win-backtop icon-arrow-circle-up"></div>
<script type="text/javascript">
	$('.doc-animation').click(function() {
		var e = $(this);
		var style = e.attr("data-style");
		e.addClass(style);
		setTimeout(function() {
			e.removeClass(style)
		}, 1800);
	});
</script>
<script>prettyPrint();</script>
</body>
</html>