<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Lesse Lite
 */

$show_full_width = apply_filters( 'lesse_show_full_width_page', false );

if ( ! is_active_sidebar( 'sidebar-1' ) || $show_full_width ) {
	return;
}
?>

<aside id="secondary" class="<?php lesse_secondary_classes(); ?>" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
