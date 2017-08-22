<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Lesse Lite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content clearfix">
		<?php the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lesse-lite' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php edit_post_link( esc_html__( 'Edit', 'lesse-lite' ), '<span class="edit-link icon-brush">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

