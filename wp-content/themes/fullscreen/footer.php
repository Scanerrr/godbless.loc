<?php $theme_author_link = "http://graphpaperpress.com"; ?>
<?php 
$theme = wp_get_theme();
$theme_name = $theme['Name'];
$theme_url = $theme->get('ThemeURI');
$url = $theme->{'Author URI'}; 
?>
<br class="clear" />
</div>
<div id="footer-wrap">
<div id="footer">
<div class="span-3 append-1 small">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom-Left') ) : ?>
<?php endif; ?>
</div>
<div class="column span-3 append-1 small">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom-Middle') ) : ?>
<?php endif; ?>
</div>
<div class="column span-9 append-1 small">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom-Right') ) : ?>
<?php endif; ?>
</div>
<div class="column span-6 small last">
<h6 class="sub"><?php esc_html_e('Credits', 'fullscreen'); ?></h6>
<div class="quiet">
    <div class="icon">
		<?php
		printf( __( '<a href="%1$s" title="%2$s WordPress theme"><span class="ui-icon ui-icon-power"></span>%2$s WordPress Theme</a> by <a href="%3$s" title="Graph Paper Press">Graph Paper Press</a>', 'fullscreen' ), $theme_url, $theme_name, $url ); ?>
	</div>
	<br class="clear" />
    <div class="icon"><a href="http://wordpress.org"><span class="ui-icon ui-icon-gear"></span><?php esc_html_e('Powered by Wordpress', 'fullscreen'); ?></a></div><br class="clear" />
		<div class="icon"><a href="<?php bloginfo('rss2_url'); ?>"><span class="ui-icon ui-icon-signal-diag"></span><?php esc_html_e('Subscribe', 'fullscreen'); ?></a></div><br class="clear" />
		<div class="icon"><a href="<?php bloginfo('comments_rss2_url'); ?>"><span class="ui-icon ui-icon-signal-diag"></span><?php esc_html_e('Comments', 'fullscreen'); ?></a></div><br class="clear" />
		<div class="icon"><a href="<?php echo home_url(); ?>/" title="Home"><span class="ui-icon ui-icon-key"></span>&copy; <?php echo date("Y"); ?>, <?php bloginfo('name'); ?></a></div><br class="clear" />
		<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
</div>
</div>
<br class="clear" />
</div>
</div>
<?php wp_footer(); ?>

</body>
</html>