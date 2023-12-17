<?php
/**
 * The template for displaying the Users page
 *
 * Template Name: users
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>
<?php $GLOBALS['hide'] = 'hide'; ?>
<header class="page-top-header users">
	<h1 class="page-title"><i class="fa fa-universal-access fa-lg" aria-hidden="true"></i> <?php esc_html_e( 'Users', 'king' ); ?></h1>
</header><!-- .page-header -->
<?php get_template_part( 'template-parts/king-header-nav' ); ?>

<div id="primary" class="content-area kflex lr-padding">
	<main id="main" class="site-main">

		<?php
		if ( get_field( 'length_users', 'options' ) ) {
			$number = get_field( 'length_users', 'option' );
		} else {
			$number = '10';
		}
		$paged       = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$offset      = ( $paged - 1 ) * $number;
		$args        = array(
			'orderby'     => 'post_count',
			'order'       => 'DESC',
			'offset'      => $offset,
			'number'      => $number,
			'count_total' => false,
			'fields'      => 'all',
			'who'         => '',
		);
		$users       = get_users();
		$query       = get_users( $args );
		$total_users = count( $users );
		$total_query = count( $query );
		$total_pages = intval( $total_users / $number ) + 1;
		// Array of stdClass objects.
		foreach ( $query as $user ) {
			?>
			<div class="king-users">

				<div class="users-card">
					<div class="users-avatar">
						<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $user->user_login ); ?>">
							<?php if ( get_field( 'author_image', 'user_' . $user->ID ) ) : $image = get_field( 'author_image', 'user_' . $user->ID ); ?>
								<img src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" alt="profile" />
							<?php else : ?>
								<span class="users-noavatar"></span>
							<?php endif; ?>
						</a>						       
					</div>

					<div class="users-info">
						<a class="users-info-name" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $user->user_login ); ?>">
							<?php echo esc_html( $user->display_name ); ?>
							<?php if ( get_field( 'verified_account', 'user_' . $user->ID ) ) : ?>
								<i class="fa fa-check-circle verified_account" aria-hidden="true" title="<?php echo esc_html_e( 'verified account', 'king' ); ?>"></i>
							<?php endif; ?>
						</a>    
						<div class="users-followers">
							<p>
								<?php
								$followers = get_user_meta( $user->ID, 'wp__post_follow_count', true );
								if ( ! empty( $followers ) ) {
									echo esc_html( $followers );
								} else {
									echo '0';
								}

								?>
								<?php echo esc_html_e( 'Followers', 'king' ); ?>
							</p>
							<p>
								<?php echo esc_html( count_user_posts( $user->ID ) ); ?>
								<?php echo esc_html_e( 'Posts', 'king' ); ?>
							</p>

						</div>            
						<?php if ( is_user_logged_in() ) : ?>
							<?php
							$cuser = wp_get_current_user();
							if ( $user->data->display_name !== $cuser->data->display_name ) {
								echo king_get_simple_follows_button( $user->ID );
							}
							?>
						<?php endif; ?>            
					</div>
				</div>
				<div class="users-posts">
					<?php
					$author_query = array( 'posts_per_page' => '4', 'author' => $user->ID, 'post_type' => king_post_types() );
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
							<?php
							if ( has_post_thumbnail() ) :
								$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
								?>
							<div class="users-post-img" style="background-image: url('<?php echo esc_url( $thumb['0'] ); ?>')"></div>
						<?php else : ?>
							<span class="users-post-no-thumb"></span>
						<?php endif; ?>  

						<a href="<?php the_permalink(); ?>">       
							<div class="users-post-in">        
								<span class="users-post-title" ><?php the_title(); ?></span>
								<span class="users-post-date" ><?php the_time( 'F j, Y' ); ?></span>
							</div>
						</a> 
					<?php endif; ?>    
				</div> 
			<?php endwhile; ?>
		<?php else : ?>
			<span class="users-noposts">@<?php echo esc_html( $user->display_name ); ?> <?php echo esc_html_e( 'has not posted yet.', 'king' ); ?> </span>
		<?php endif; ?>
	</div>
</div> 
<?php } ?>
<div class="king-pagination">
	<?php
	if ( $total_users > $number ) {

		$pl_args = array(
			'base'      => add_query_arg( 'paged', '%#%' ),
			'format'    => '',
			'total'     => ceil( $total_users / $number ),
			'current'   => max( 1, $paged ),
			'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
			'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
		);
		// for /page/n.
		if ( $GLOBALS['wp_rewrite']->using_permalinks() ) {
			$pl_args['base'] = user_trailingslashit( trailingslashit( get_pagenum_link( 1 ) ) . 'page/%#%/', 'paged' );
		}

		echo paginate_links( $pl_args );
	}
	?>
</div>  
</main><!-- #main --> 
</div><!-- #primary -->

<?php get_footer(); ?>
