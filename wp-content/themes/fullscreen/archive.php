<?php get_header(); rewind_posts(); ?>

<div id="content">

	<?php 
	query_posts($query_string);
	if (have_posts()) : ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ 
		if (is_category()) { ?>
			<h6 class="sub"><?php single_cat_title(); ?></h6>
		<?php /* If this is a tag archive */ 
		} elseif ( is_tag() ) { ?>
			<h6 class="sub"><?php _e('Posts Tagged', 'fullscreen'); ?> &#8216;<?php single_tag_title(); ?>&#8217;</h6>
		<?php /* If this is a daily archive */ 
		} elseif ( is_day() ) { ?>
			<h6 class="sub"><?php _e('Archive for', 'fullscreen'); ?> <?php the_time('F jS, Y'); ?></h6>
		<?php /* If this is a monthly archive */ 
		} elseif ( is_month() ) { ?>
			<h6 class="sub"><?php _e('Archive for', 'fullscreen'); ?> <?php the_time('F, Y'); ?></h6>
		<?php /* If this is a yearly archive */ 
		} elseif ( is_year() ) { ?>
			<h6 class="sub"><?php _e('Archive for', 'fullscreen'); ?> <?php the_time('Y'); ?></h6>
		<?php /* If this is an author archive */ 
		} elseif ( is_author() ) { ?>
			<h6 class="sub"><?php _e('Author Archive', 'fullscreen'); ?></h6>
		<?php /* If this is a paged archive */ 
		} elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) { ?>
			<h6 class="sub"><?php _e('Blog Archives', 'fullscreen'); ?></h6>
		<?php } ?>

		<?php while (have_posts()) : the_post(); ?>

			<article <?php post_class(); ?>>
				<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title() ?></a></h2>
				<?php the_content(); ?>
				<div class="clear"></div>
				<div class="postmetadata">
			    	<div class="icon"><span class="ui-icon ui-icon-clock"></span> <?php the_time('l, F jS, Y') ?> <?php _e('at', 'fullscreen'); ?> <?php the_time() ?></div> <div class="icon"><span class="ui-icon ui-icon-folder-open"></span> <?php if (the_category(', '))  the_category(); ?> <?php if (get_the_tags()) the_tags(' | '); ?></div> <div class="icon"><span class="ui-icon ui-icon-comment"></span><?php comments_popup_link(esc_html__('Leave A Comment &#187;', 'fullscreen'), esc_html__('1 Comment &#187;', 'fullscreen'), esc_html__('% Comments &#187;', 'fullscreen')); ?></div> <?php edit_post_link(esc_html__('Edit', 'fullscreen'), '| ', ''); ?>
					<div class="clear"></div>
				</div>
			</article>
		<?php endwhile; ?>
		<div class="clear"></div>

		<div class="nav-interior">
			<div class="prev"><?php next_posts_link(esc_html__('&laquo; Older Entries', 'fullscreen')) ?></div>
			<div class="next"><?php previous_posts_link(esc_html__('Newer Entries &raquo;', 'fullscreen')) ?></div>
		</div>
		<div class="clear"></div>

	<?php else : ?>

		<h2 class="center"><?php _e('Not Found', 'fullscreen'); ?></h2>
		<?php get_search_form(); ?>

	<?php endif; ?>

</div> <!-- #content -->

<!-- Begin Footer -->
<?php get_footer(); ?>