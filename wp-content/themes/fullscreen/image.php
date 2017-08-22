<?php get_header(); ?>

<div id="content">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div <?php if(function_exists('post_class')) : ?><?php post_class(); ?><?php else : ?>class="post post-<?php the_ID(); ?>"<?php endif; ?>>
    <h2 class="entry-title"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <?php the_title(); ?></h2>
    <p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'large' ); ?></a></p>
	<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?></div>

	<?php the_content('<p class="serif">'. esc_html__('Read the rest of this entry &raquo;', 'fullscreen') . '</p>'); ?>  

	<div class="navigation">
		<div class="alignleft"><?php previous_image_link() ?></div>
		<div class="alignright"><?php next_image_link() ?></div>
	</div>
	<br class="clear" />
        <div class="postmetadata">
            <div class="icon"><span class="ui-icon ui-icon-clock"></span> <?php the_time('l, F jS, Y') ?> at <?php the_time() ?></div> <div class="icon"><span class="ui-icon ui-icon-folder-open"></span> <?php if (the_category(', '))  the_category(); ?> <?php if (get_the_tags()) the_tags(' | '); ?></div> <div class="icon"><?php edit_post_link(esc_html__('Edit', 'fullscreen'), '<span class="ui-icon ui-icon-pencil"></span>', ''); ?></div>
        <br class="clear" />
        </div>
    </div>
<?php endwhile; else: ?>
    <p><?php _e('Sorry, no posts matched your criteria.', 'fullscreen'); ?></p>
<?php endif; ?>

</div>

<?php get_footer(); ?>