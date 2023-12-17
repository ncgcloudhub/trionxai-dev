<?php
/**
 * The singe post part - Next Prev.
 *
 * This is a content template part.
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
<footer class="entry-footer">
	<?php king_entry_footer(); ?>
	<div class="post-meta">
		<span class="post-views"><i class="fa fa-eye" aria-hidden="true"></i><?php echo esc_attr( king_postviews( get_the_ID(), 'display' ) ); ?></span>
		<span class="post-comments"><i class="fa fa-comment" aria-hidden="true"></i><?php comments_number( ' 0 ', ' 1 ', ' % ' ); ?></span>
		<span class="post-time"><i class="far fa-clock"></i><?php the_time( 'F j, Y' ); ?></span>
	</div>
	<?php
		if ( 'post' === get_post_type() || 'list' === get_post_type() ) :
			$post_author = get_post_field( 'post_author', get_the_ID() );
			$current_user = wp_get_current_user();
			if ( is_user_logged_in() && get_field( 'enable_post_edit', 'options' ) ) :
				if ( ( esc_attr( $post_author ) === esc_attr( $current_user->ID ) ) || is_super_admin() ) :
					if ( ( get_field( 'verified_edit_posts', 'options' ) && get_field( 'verified_account', 'user_' . $current_user->ID ) || ! get_field( 'verified_edit_posts', 'options' ) ) || ( get_field( 'enable_user_groups', 'options' ) && king_groups_permissions( 'groups_edit_their_own_posts' ) )  ) :
						?>
						<a href="<?php echo esc_url( add_query_arg( 'term', get_the_ID(), home_url( $GLOBALS['king_updte'] . '/' ) ) ); ?>" class="king-fedit"><i class="fa fa-pencil" aria-hidden="true"></i><?php echo esc_html__( ' Edit', 'king' ); ?></a>
						<?php
					endif;
				endif;
			endif;
		endif;
	if ( is_super_admin() ) :
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'king' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	endif;
	?>
</footer><!-- .entry-footer -->
<div class="post-nav">
	<?php
	$next_post = get_next_post();
	if ( ! empty( $next_post ) ) :
		?>
		<div class="post-nav-np">
			<?php
			if ( has_post_thumbnail( $next_post->ID ) ) :
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post->ID ), 'medium' );
				?>
				<div class="post-nav-image" style="background-image: url('<?php echo esc_url( $thumb['0'] ); ?>');"></div>
			<?php endif; ?>
			<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="next-link" ><i class="fa fa-angle-left"></i> <?php echo esc_attr( $next_post->post_title ); ?></a>
		</div>
	<?php endif; ?>
	<?php
	$prev_post = get_previous_post();
	if ( ! empty( $prev_post ) ) :
		?>
		<div class="post-nav-np">
			<?php
			if ( has_post_thumbnail( $prev_post->ID ) ) :
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post->ID ), 'medium' );
				?>
				<div class="post-nav-image" style="background-image: url('<?php echo esc_url( $thumb['0'] ); ?>');"></div>			
			<?php endif; ?>
			<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="prev-link" ><?php echo esc_attr( $prev_post->post_title ); ?> <i class="fa fa-angle-right"></i></a>
		</div>
	<?php endif; ?>
</div>
<?php if ( 'badges-2' === get_field( 'post_page_buttons_style', 'options' ) ) : ?>
</div>
</div>
<?php endif; ?>