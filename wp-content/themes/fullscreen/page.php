<?php get_header(); ?>
    <div id="content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
			<h2 class="entry-title"><?php the_title(); ?></h2>
			<?php the_content('<p class="serif">'. esc_html__('Read the rest of this page &raquo;', 'fullscreen') . '</p>'); ?> 
			<?php wp_link_pages(array('before' => '<p><strong>'. esc_html__('Pages:','fullscreen') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</div>
	</div>
		<?php endwhile; endif; ?>
	 <?php edit_post_link(esc_html__('Edit this entry.', 'fullscreen'), '<p>', '</p>'); ?>
<?php get_footer(); ?>