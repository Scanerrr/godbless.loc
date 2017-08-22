<?php
/**
 * Contains features list of Lesse Pro.
 *
 * @package Lesse Lite.
 */
?>

<ul class="lesse-pro-features">
	<?php
	$lesse_pro_features = array(
		__( 'Unlimited Color Schemes', 'lesse-lite' ),
		__( 'Infinite Ajax-Scrolling, Load-More', 'lesse-lite' ),
		__( '600+ Google Web Fonts', 'lesse-lite' ),
		__( 'More SEO Optimized', 'lesse-lite' ),
		__( 'More Options for Customization', 'lesse-lite' ),
		__( 'Home Page Template', 'lesse-lite' ),
		__( 'Show/Hide Sidebar for Each Post', 'lesse-lite' ),
		__( '7 Home Sections', 'lesse-lite' ),
		__( 'Full Page Slider on Homepage', 'lesse-lite' ),
		__( 'Options to Add Social Links', 'lesse-lite' ),
		__( 'Show Full-Content/Excerpt', 'lesse-lite' ),
		__( 'Choose Excerpt Length', 'lesse-lite' ),
		__( 'Options for Ad Codes/Google-Adverts', 'lesse-lite' ),
		__( 'Add CSS/JS to Each Post', 'lesse-lite' ),
		__( 'No Developer Link', 'lesse-lite' ),
	);

	foreach ( $lesse_pro_features as $lesse_pro_feature ) {
		printf( '<li class="dashicons dashicons-yes">%s</li>', esc_html( $lesse_pro_feature ) );
	}
	?>
</ul>
<div class="clear lesse-pro-buttons">
	<?php
	$theme_uri = 'http://supernovathemes.com/';

	printf(
		'<a href="%s" rel="designer" class="lesse-pro-pricing-link" target="_blank"><input type="button" class="button button-primary" value="%s"></a>',
		esc_url( $theme_uri ) . 'lesse-pro-pricing/',
		esc_attr__( 'See Pricing', 'lesse-lite' )
	);

	printf(
		'<a href="%s" rel="designer" target="_blank"><input type="button" class="button button-primary" value="%s"></a>',
		esc_url( $theme_uri ) . 'lesse-demo/',
		esc_attr__( 'View Demo', 'lesse-lite' )
	);

	?>
</div>
