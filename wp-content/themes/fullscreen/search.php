<?php get_header(); ?>

<div id="content">

<?php if (have_posts()) : ?>

	<h6><?php _e('Search Results', 'fullscreen'); ?></h6>

<?php while (have_posts()) : the_post(); ?>
<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title() ?></a></h2>
<?php get_the_image(); ?>
<?php the_excerpt(); ?>
<div class="postmetadata">
    <div class="icon"><span class="ui-icon ui-icon-clock"></span> <?php the_time('l, F jS, Y') ?> at <?php the_time() ?></div> <div class="icon"><span class="ui-icon ui-icon-folder-open"></span> <?php if (the_category(', '))  the_category(); ?> <?php if (get_the_tags()) the_tags(' | '); ?></div> <div class="icon"><span class="ui-icon ui-icon-comment"></span><?php comments_popup_link(esc_html__('Leave A Comment &#187;', 'fullscreen'), esc_html__('1 Comment &#187;', 'fullscreen'), esc_html__('% Comments &#187;', 'fullscreen')); ?></div> <?php edit_post_link(esc_html__('Edit', 'fullscreen'), '| ', ''); ?>
<div class="clear"></div>
</div>
</div>
<div class="clear"></div>
<?php endwhile; ?>

<div class="clear"></div>

	<div class="navigation">
		<div><?php next_posts_link(esc_html__('&laquo; Older Entries', 'fullscreen')) ?></div>
		<div><?php previous_posts_link(esc_html__('Newer Entries &raquo;', 'fullscreen')) ?></div>
	</div>

<?php else : ?>

    <h2><?php _e('No posts found.', 'fullscreen'); ?></h2>
   	<h6><?php _e('Use the search tap at top right to start a new search.', 'fullscreen'); ?></h6>

<?php endif; ?>

</div>

<?php get_footer(); ?>