<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'king_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function king_entry_footer() {
		if ( 'page' !== get_post_type()) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ' ', 'king' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( '%1$s', 'king' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( 'king_entry_cat' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function king_entry_cat() {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ' ', 'king' ) );
		printf( '<span class="cat-links">' );
		if ( has_post_format( 'link' ) ) {
			$parsed = wp_parse_url( get_field( 'ad_link' ) );
			printf( '<span class="link-links"><i class="fa-brands fa-hubspot"></i> ' . ( isset( $parsed['host'] ) ? $parsed['host'] : '') . '</span>' );
		}
		if ( $categories_list && king_categorized_blog() ) {
			printf( esc_html__( '%1$s', 'king' ), $categories_list ); // WPCS: XSS OK.
		}

		printf( '</span>'  );
	}
endif;
/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function king_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'king_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories(
			array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				'number'     => 2,
			)
		);

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'king_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so king_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so king_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in king_categorized_blog.
 */
function king_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'king_categories' );
}
add_action( 'edit_category', 'king_category_transient_flusher' );
add_action( 'save_post',     'king_category_transient_flusher' );

if ( ! function_exists( 'king_user_groups' ) ) :
	/**
	 * User Groups.
	 *
	 * @param <type> $user_id  The user identifier.
	 *
	 * @return string  ( description_of_the_return_value )
	 */
	function king_user_groups( $user_id ) {
		$groups = get_field( 'user_groups', 'options' );
		$rtrn   = '';
		if ( $groups ) :
			$rtrn .= '<div class="user-group">';
			foreach ( $groups as $group ) :
				$usergroups = $group['group_users'];
				if ( $usergroups ) :
					foreach ( $usergroups as $usergroup ) :
						if ( $usergroup == $user_id ) :
							$rtrn .= '<span class="group-icon" title="' . $group['group_name'] . '" style="background-color: ' . $group['group_color'] . ';">' . $group['group_icon'] . '' . $group['group_name'] . '</span>';
						endif;
					endforeach;
				endif;
			endforeach;
			$rtrn .= '</div>';
		endif;
		return $rtrn;
	}
endif;
