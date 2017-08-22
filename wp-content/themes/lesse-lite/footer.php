<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Lesse Lite
 */

?>

	</div><!-- #content -->

	<?php do_action('lesse_before_footer'); ?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php do_action('lesse_footer_top'); ?>
			<?php if ( is_active_sidebar( 'sidebar-2' ) ){ ?>
			<div class="lesse-footer-widgets row-content">
				<div class="row">
					<?php dynamic_sidebar( 'sidebar-2' ); ?>
				</div>
			</div>
			<?php } ?>

			<div class="lesse-scroll-bar">
				<div class="lesse-scroll-icon icon-up-open-big"></div>
			</div>

			<div class="lesse-site-info-container row-content">
				<div class="site-info row-container">
					<div class="row">
						<div class="lesse-site-info small-12 medium-6 large-6 column">
						<span class="lesse-copyright-text">
							<?php echo sprintf( __( '&copy %s ', 'lesse-lite' ), date('Y') ); ?>
							<span class="lesse-copyright-customizer"><?php echo esc_html( lesse_copyright_text() ) ?></span>
							<?php if ( ! LESSE_PRO ) { ?>
								<span class="sep"> | </span>
							<?php } ?>
						</span>

						<?php
							if ( ! LESSE_PRO ) {
								$theme_uri = 'http://supernovathemes.com/';
								echo sprintf( esc_html__( '%1$s by %2$s', 'lesse-lite' ), 'Lesse', '<a href="' . esc_url( $theme_uri ) . '" rel="designer">Supernova Themes</a>' );
							}
						?>
						</div>
						<?php do_action('lesse_footer_bottom'); ?>
					</div>
				</div>
			</div>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
