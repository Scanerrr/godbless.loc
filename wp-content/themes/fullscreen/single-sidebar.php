<?php get_header(); ?>

	<div id="content-wrapper" class="span-24 single-sidebar">
		<div id="content" class="span-15 colborder">

<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h2 class="entry-title"><?php the_title(); ?></h2>
<p><?php echo gPPGetVideo($post->ID); ?></p>
<?php the_content(); ?>
</div>
<div class="clear"></div>

<div class="postmetadata alt">
	<small>
		<?php { ?>
		<div class="icon"><span class="ui-icon ui-icon-clock"></span> <?php the_time('l, F jS, Y') ?> <?php _e('at', 'fullscreen'); ?> <?php the_time() ?></div> 
		<div class="icon"><span class="ui-icon ui-icon-folder-open"></span> <?php the_category(' | ') ?><?php if (get_the_tags()) the_tags(' | '); ?></div>
		<div class="icon"><span class="ui-icon ui-icon-signal-diag"></span>  <?php post_comments_feed_link('Feed'); ?></div> 
		<div id="dialog_link"><span class="ui-icon ui-icon-comment"></span><a href="#"> <?php _e('Comments', 'fullscreen'); ?></a></div>
		<div class="icon"><?php edit_post_link(esc_html__('Edit', 'fullscreen'), '<span class="ui-icon ui-icon-pencil"></span>', ''); ?></div>
		<div id="post-nav">
		    <div class="post-nav-prev"><?php previous_post_link('%link', __('<span class="ui-icon ui-icon-circle-triangle-w"></span> Previous', 'fullscreen'), TRUE); ?></div>
		    <div class="post-nav-next"><?php next_post_link('%link', __('<span class="ui-icon ui-icon-circle-triangle-e"></span> Next', 'fullscreen'), TRUE); ?></div>
		</div>
		<?php } ?>
    <br class="clear" />
	</small>
	<div class="clear"></div>
</div>

<div id="dialog" title="Comments">
<?php comments_template('', true); ?>
</div>

<div class="clear"></div>
			<?php endwhile; else : ?>

				<h2 class="center"><?php _e('Not Found', 'fullscreen'); ?></h2>
				<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.", 'fullscreen'); ?></p>
				<?php get_search_form(); ?>

			<?php endif; ?>    

</div>
		<div id="sidebar" class="span-8 last">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : endif; ?>
		</div>

</div>

<!-- Begin Footer -->
<?php get_footer(); ?>