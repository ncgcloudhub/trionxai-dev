<?php
/**
 * The header part - Following users list.
 *
 * This is the header template part.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="king-leftmenu-followings">
	<?php
	$user_id = get_current_user_id();
	$args    = array(
		'meta_key'     => 'wp__user_followd',
		'meta_value'   => '"user-' . $user_id . '";i:' . $user_id . ';',
		'meta_compare' => 'LIKE',
		'order'        => 'DESC',
	);
	// The Query.
	$user_query = new WP_User_Query( $args );
	// User Loop.
	if ( ! empty( $user_query->get_results() ) ) :
		foreach ( $user_query->get_results() as $user ) :
			?>
			<a class="king-lf-links" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $user->user_login ); ?>">
			<?php if ( get_field( 'author_image','user_' . $user->ID ) ) : $image = get_field( 'author_image','user_' . $user->ID ); ?>
				<img src="<?php  echo esc_url( $image['sizes']['thumbnail'] ); ?>" />
			<?php else : ?>
				<span class="users-noavatar"></span>  
			<?php endif; ?>
				<?php echo esc_attr( $user->display_name ); ?>
			</a>
			<?php
		endforeach;
	else :
		?>
		<div class="king-lf-not"><?php esc_html_e( 'No users found', 'king' ); ?></div>
	<?php endif; ?>

</div><!-- .king-leftmenu-followings -->
