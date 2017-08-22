<form role="search" method="get" class="lesse-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search For :' , 'lesse-lite' ) ?></span>
		<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search...', 'lesse-lite' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php esc_attr_e( 'Search for:', 'lesse-lite' ); ?>" />
	</label>
	<input type="submit" class="search-submit" value="<?php esc_attr_e( 'Search', 'lesse-lite' ); ?>" />
</form>
