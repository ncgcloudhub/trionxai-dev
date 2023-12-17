<?php
/**
 * User Card.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$user = $args;
?>
<div class="king-users-v2">
	<div class="users-posts-v2">
		<?php
		$author_query = array( 'posts_per_page' => '2', 'author' => $user->ID, 'post_type' => king_post_types() );
		$author_posts = new WP_Query( $author_query );
		if ( $author_posts->have_posts() ) :
			while ( $author_posts->have_posts() ) :
				$author_posts->the_post();
				?>
				<div class="users-post">
					<?php if ( get_field( 'nsfw_post' ) && ! is_user_logged_in() ) : ?>
					<div class="nsfw-users-post">
						<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>" >
							<i class="fa fa-paw fa-3x"></i>
							<div><h1><?php echo esc_html_e( 'Not Safe For Work', 'king' ); ?></h1></div>
							<span><?php echo esc_html_e( 'Click to view this post.', 'king' ); ?></span>
						</a>
					</div>
				<?php else : ?>
				<a href="<?php the_permalink(); ?>">
					<?php
					if ( has_post_thumbnail() ) :
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
						?>
						<div class="users-post-img">
							<img data-king-img-src="<?php echo $thumb[0] ?>" class="king-lazy"/>
						</div>
					<?php else : ?>
						<span class="users-post-no-thumb"></span>
					<?php endif; ?>
				</a> 
				<?php endif; ?>
			</div> 
		<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
	<?php else : ?>
		<?php
		if ( get_field( 'cover_image','user_' . $user->ID ) ) {
			$coverimage = get_field( 'cover_image','user_' . $user->ID );
			$cover = '<img data-king-img-src="'.$coverimage['sizes']['medium'].'" class="king-lazy"/>';
		} elseif ( get_field( 'default_cover', 'options' ) ) {
			$coverimage = get_field( 'default_cover', 'options' );
			$cover = '<img data-king-img-src="'.$coverimage['sizes']['medium'].'" class="king-lazy"/>';
		} else {
			$cover = '';
		}
		?>
		<span class="users-noposts"><?php echo wp_kses_post( $cover ); ?></span>
	<?php endif; ?>
</div>
<div class="users-card-v2">
	<div class="users-avatar">
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $user->user_login ); ?>">
			<?php if ( get_field( 'author_image', 'user_' . $user->ID ) ) : $image = get_field( 'author_image', 'user_' . $user->ID ); ?>
				<img src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" alt="profile" />
			<?php else : ?>
				<span class="users-noavatar"></span>
			<?php endif; ?>
		</a>
	</div>
	<div class="users-info-v2">
		<a class="users-info-name" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $user->user_login ); ?>">
			<h4><?php echo esc_html( $user->display_name ); ?></h4>
			<?php if ( get_field( 'verified_account', 'user_' . $user->ID ) ) : ?>
				<i class="fa fa-check-circle verified_account" aria-hidden="true" title="<?php echo esc_html_e( 'verified account', 'king' ); ?>"></i>
			<?php endif; ?>
		</a>    
		<div class="users-followers">
			<span>
				<?php
				$followers = get_user_meta( $user->ID, 'wp__post_follow_count', true );
				if ( ! empty( $followers ) ) {
					echo '<strong>' . esc_html( $followers ) . '</strong>';
				} else {
					echo '<strong>0</strong>';
				}

				?>
				<?php echo esc_html_e( 'Followers', 'king' ); ?>
			</span>
			<span>
				<?php echo '<strong>' . esc_attr( count_user_posts( $user->ID, array('post', 'list', 'poll', 'trivia') ) ) . '</strong>'; ?>
				<?php echo esc_html_e( 'Posts', 'king' ); ?>
			</span>
		</div>
		<?php if ( is_user_logged_in() ) : ?>
			<?php
			$current_user = wp_get_current_user();
			if ( $user->data->display_name !== $current_user->data->display_name ) {
				echo king_get_simple_follows_button( $user->ID );
			}
			?>
		<?php endif; ?>
	</div>
</div>
</div>