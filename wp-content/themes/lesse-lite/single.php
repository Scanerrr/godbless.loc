<?php
/**
 * The template for displaying all single posts.
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @package Lesse Lite
 */

get_header(); ?>

	<div id="primary" class="<?php lesse_primary_classes(); ?>">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			do_action( 'lesse_single_page_after_post' );
			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			do_action( 'lesse_single_after_comments' );

		endwhile; // End of the loop.
		?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_sidebar();

get_footer();
