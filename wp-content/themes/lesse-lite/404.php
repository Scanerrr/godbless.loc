<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Lesse Lite
 */

get_header(); ?>

<section class="error-404 not-found large-12 column">
	<header class="page-header">
		<h1 class="page-title"><span class="icon-emo-unhappy"></span><?php esc_html_e( '404 - Nothing to see here', 'lesse-lite' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">

		<p class="lesse-404-description"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'lesse-lite' ); ?></p>

		<?php get_search_form(); ?>

	</div><!-- .page-content -->
</section><!-- .error-404 -->

<?php
get_footer();