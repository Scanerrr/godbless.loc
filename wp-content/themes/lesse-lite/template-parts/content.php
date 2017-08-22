<?php
/**
 * Template part for displaying posts.
 *
 * @package Lesse Lite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php lesse_thumbnail( 'full', sprintf( '<figure class="lesse-post-thumb" ><a href="%s">' , get_permalink() ) , '</a></figure>' ); ?>

	<div class="lesse-article-content">

		<?php if ( ! is_single() ) { ?>
		<div class="entry-date-wrapper">
			<?php lesse_posted_on(); ?>
		</div>
		<?php } ?>

		<div class="lesse-content-wrapper">

			<?php if ( ! is_single() ) { ?>
			<header class="entry-header clearfix">
				<div class="title-meta-wrapper">
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
					if ( 'post' == get_post_type() ) : ?>
					<div class="entry-meta">
						<?php lesse_entry_header(); ?>
					</div>
					<?php endif; ?>
				</div>
			</header><!-- .entry-header -->
			<?php } ?>

			<div class="entry-content clearfix">
				<?php lesse_content(); ?>

				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lesse-lite' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->

			<?php if ( lesse_entry_footer() ) { ?>
				<footer class="entry-footer">
					<?php echo lesse_entry_footer(); ?>
				</footer><!-- .entry-footer -->
			<?php } ?>

		</div>

	</div>

</article><!-- #post-## -->
