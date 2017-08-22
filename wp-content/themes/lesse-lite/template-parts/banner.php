<?php
/**
 * Shows Featured Banner Image
 * @package Lesse Lite
 */

$cannot_show_banner = (
	lesse_has_full_page_slider()
	||
	is_404()
	||
	is_search()
	||
	( is_home() && is_front_page() )
);

if ( $cannot_show_banner ) {
	return;
}

$queried_object_id   = get_queried_object_id();
$show_featured_image = ! is_archive() && ! is_search() && has_post_thumbnail( $queried_object_id );
$banner_class        = $show_featured_image ? 'lesse-has-banner-image' : 'lesse-no-banner-image';
?>

<figure class="lesse-wide-thumb <?php echo esc_attr( $banner_class ); ?> ">
	<?php if( $show_featured_image ) echo get_the_post_thumbnail( $queried_object_id, 'full' ); ?>
	<div class="lesse-overlay"></div>
	<div class="lesse-wide-thumb-content">
		<header class="row-container entry-header">
			<?php if ( is_single() ) {
				global $post;
				setup_postdata( $post );
			?>
				<div class="title-meta-wrapper">
					<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
						lesse_posted_on();
					if ( 'post' == get_post_type() ) : ?>
						<div class="entry-meta">
							<?php lesse_entry_header(); ?>
						</div>
					<?php endif; ?>
				</div>

				<?php wp_reset_postdata(); ?>
			<?php } else { ?>
				<h1 class="lesse-banner-title"><?php echo esc_html( lesse_banner_title( $queried_object_id ) ); ?></h1>
			<?php } ?>
		</header>
	</div>
</figure>

