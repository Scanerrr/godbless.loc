<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php





		$arg = array(
			'post_type' => 'game',
			'posts_per_page' => 5,
			'orderby' => 'ID',
			'order'   => 'ASC',
			//'cache_results'  => false,
			//'update_post_meta_cache' => false
		);

		$query = new WP_Query( $arg );

		// Start the loop.
		while ( $query->have_posts() ) : $query->the_post();

			// Include the page content template.
			get_template_part( 'template-parts/preview', 'game' );


			// End of the loop.
		endwhile;
		wp_reset_postdata();
		?>

		<?php

		$home_id = 45;
		$home_post  = get_post( $home_id );
		$home_output =  apply_filters( 'the_content', $home_post->post_content );
		echo "<div class='unfreeze_home'> $home_output </div>";

		?>




		<?php // echo do_shortcode('[wpdatatable id=3]'); ?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
