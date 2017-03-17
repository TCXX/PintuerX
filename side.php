<?php 
/**
 * 侧边栏
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="hidden-l hidden-s xm3">
	<div class="doc-sidebar">
		
	<div class="banner" height="100">
	<div class="carousel">
		<div class="item">
		</div>
	</div>
	</div>
<?php 
$widgets = !empty($options_cache['widgets1']) ? unserialize($options_cache['widgets1']) : array();
doAction('diff_side');

if (!blog_tool_ishome()){ home_flash(showText('WORKS'), 1);} 	

foreach ($widgets as $val)
{
	$widget_title = @unserialize($options_cache['widget_title']);
	$custom_widget = @unserialize($options_cache['custom_widget']);
	if(strpos($val, 'custom_wg_') === 0)
	{
		$callback = 'widget_custom_text';
		if(function_exists($callback))
		{
			call_user_func($callback, htmlspecialchars($custom_widget[$val]['title']), $custom_widget[$val]['content']);
		}
	}else{
		$callback = 'widget_'.$val;
		if(function_exists($callback))
		{
			preg_match("/^.*\s\((.*)\)/", $widget_title[$val], $matchs);
			$wgTitle = isset($matchs[1]) ? $matchs[1] : $widget_title[$val];
			call_user_func($callback, htmlspecialchars($wgTitle));
		}
	}
}
?>
<?php if (Option::get('rss_output_num')):?>
	</div>
</div>

<?php endif;?>
<!--end #siderbar-->