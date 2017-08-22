<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Lesse Lite
 */

if( ! function_exists( 'lesse_posted_on' ) ) :
	/**
	 * Markup for posted on
	 */
	function lesse_posted_on()
	{
		/**
		 * Prints HTML with meta information for the current post-date/time and author.
		 */
		$time_string = '<time class="entry-date published updated" datetime="%1$s">
							<span class="date">%2$s</span>
							<span class="month" >%3$s</span>
							<span class="year" >%4$s</span>
						</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">
								<span class="date">%2$s</span>
								<span class="month" >%3$s</span>
								<span class="year" >%4$s</span>
							</time>
							<time class="updated" datetime="%5$s">
								<span class="date">%6$s</span>
								<span class="month" >%7$s</span>
								<span class="year" >%8$s</span>
							</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date( 'd' ) ),
			esc_html( get_the_date( 'F' ) ),
			esc_html( get_the_date( 'Y' ) ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date( 'd' ) ),
			esc_html( get_the_modified_date( 'F' ) ),
			esc_html( get_the_modified_date( 'Y' ) )
		);

		$posted_on = sprintf(
			esc_html_x( '%s', 'post date', 'lesse-lite' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'lesse_entry_header' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function lesse_entry_header() {
		// Hide category and tag text for pages.
		$byline = sprintf(
			esc_html_x( '%s', 'post author', 'lesse-lite' ),
			'<span class="author icon-user-1 vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
		echo $byline;

		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'lesse-lite' ) );
			if ( $categories_list && lesse_categorized_blog() ) {
				printf( '<span class="cat-links icon-layers">' . esc_html__( '%1$s', 'lesse-lite' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link icon-comment-empty">';
			/* translators: %s: post title */
			comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'lesse-lite' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'lesse-lite' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link icon-brush">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'lesse_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function lesse_entry_footer() {
		$entry_footer = false;
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'lesse-lite' ) );
			if ( $tags_list ) {
				$entry_footer .= sprintf( '<span class="tags-links icon-tag-1">' . esc_html__( '%1$s', 'lesse-lite' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		return $entry_footer;
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function lesse_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'lesse_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'lesse_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so lesse_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so lesse_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in lesse_categorized_blog.
 */
function lesse_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'lesse_categories' );
}
add_action( 'edit_category', 'lesse_category_transient_flusher' );
add_action( 'save_post',     'lesse_category_transient_flusher' );
