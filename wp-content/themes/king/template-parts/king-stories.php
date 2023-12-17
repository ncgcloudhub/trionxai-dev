<?php
/**
 * Featured Posts Mini Slider.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
	$userss   = '';
	$featured = '';
	if ( get_field( 'enable_stories', 'options' ) ) {
		$posts_per_page = get_field( 'total_number_of_stories', 'options' );
	}
	$arry = array(
		'posts_per_page' => $posts_per_page,
		'order'          => 'DESC',
		'post_type'      => 'stories',
	);

	$arry['author__in'] = isset( $args['users'] ) ? $args['users'] : '';

	$drange = get_field( 'stories_date_range', 'options' );
	if ( 'week' === $drange && ! $args['profile'] ) {
		$arry['date_query'] = array(
			'column' => 'post_date',
			'after'  => '- 7 days',
		);
	} elseif ( 'day' === $drange && ! $args['profile'] ) {
		$arry['date_query'] = array(
			'column' => 'post_date',
			'after'  => '- 1 days',
		);
	}
	if ( isset( $args['profile'] ) ) {
		$arry['meta_key'] = 'king_highlights';
	}
	if ( isset( $args['home'] ) && get_field( 'display_featured_stories', 'options' ) ) {
		$arry['meta_key']   = 'featured_story';
		$arry['meta_value'] = 1;
	}
	$sarry = array(
		'has_published_posts' => array( 'stories' ),
	);
	$dstyle = get_field( 'stories_display_style', 'options' );

	if ( 'last' === $dstyle && ! isset( $args['profile'] ) ) {
		if ( isset( $args['dash'] ) ) {
			$sarry['include'] = $args['users'];
		}
		$userss = get_users( $sarry );
	} elseif ( 'all' === $dstyle || isset( $args['profile'] ) ) {
		$featured = get_posts( $arry );
	}

	if ( $featured || $userss || ! get_field( 'hide_create_story', 'options' ) && ! isset( $args['profile'] ) ) :
		?>
		<div class="king-editorschoice lr-padding king-stories-top <?php echo esc_attr( isset( $args['class'] ) ? $args['class'] : '' ); ?>">
			<?php if ( get_field( 'stories_slider_title', 'options' ) ) : ?>
				<h4 class="king-editorschoice-title"><?php the_field( 'stories_slider_title', 'options' ); ?></h4>
			<?php endif; ?>
			<div class="king-featured-small king-stories-owl owl-carousel">
			<?php
			if ( is_user_logged_in() && ! get_field( 'hide_create_story', 'options' ) && ! isset( $args['profile'] ) ) :
				if ( get_field( 'author_image', 'user_' . get_current_user_id() ) && ! isset( $args['profile'] ) ) :
					$sstory = get_field( 'author_image', 'user_' . get_current_user_id() );
					?>
					<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_snews'] . '/story' ); ?>" class="editorschoice-story story-addnew" data-king-img-src="<?php echo esc_url( $sstory['sizes']['medium_large'] ); ?>"><i class="fas fa-plus"></i><span><?php echo esc_html_e( 'Create Story', 'king' ); ?></span></a>
				<?php else : ?>
					<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_snews'] . '/story' ); ?>" class="editorschoice-story story-addnew"><i class="fas fa-plus"></i><span><?php echo esc_html_e( 'Create Story', 'king' ); ?></span></a>
				<?php endif; ?>
			<?php endif; ?>
				<?php
				if ( $featured ) :
					foreach ( $featured as $post ) :
						?>
					<div class="editorschoice-post editorschoice-story">
						<span class="king-stories-avatar">
							<?php
							$author_id = $post->post_author;
							$author    = get_the_author_meta( 'user_nicename', $author_id );
							if ( get_field( 'author_image', 'user_' . $author_id ) ) :
								$image = get_field( 'author_image', 'user_' . $author_id );
								?>
								<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>">
									<img class="content-author-avatar" src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" />
								</a>
							<?php else : ?>
								<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>" class="content-author-avatar"></a>
							<?php endif; ?>
								<a class="king-stories-alink" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>"><?php echo esc_attr( $author ); ?></a>
						</span>
						<?php
						if ( has_post_thumbnail() ) :
							$attachment_id = get_post_thumbnail_id( $post->ID );
							$thumb         = wp_get_attachment_image_src( $attachment_id, 'medium_large' );
							?>
							<a class="editorschoice-post-img story-popup" href="<?php echo esc_url( get_permalink() ); ?>">
								<div class="king-box-bg" data-king-img-src="<?php echo esc_attr( $thumb[0] ); ?>"></div>
							</a>
						<?php else : ?>
							<a class="editorschoice-post-no-thumb story-popup" href="<?php echo esc_url( get_permalink() ); ?>"></a>
						<?php endif; ?>     
						<div class="editorschoice-post-in">    
							<span class="editorschoice-post-title" ><?php the_title(); ?></span>
						</div>

					</div>
					<?php endforeach; ?>
					<?php
				elseif ( $userss ) :
					foreach ( $userss as $users ) :
						?>
					<div class="editorschoice-post editorschoice-story">
						<?php
							$author_id = $users->ID;
							$author    = get_the_author_meta( 'user_nicename', $author_id );

							$uposts = get_posts(
								array(
									'posts_per_page' => 1,
									'author'         => $author_id,
									'post_type'      => 'stories',
								)
							);
						if ( $uposts ) {
							$url = get_permalink( $uposts[0]->ID );
						}
						if ( get_field( 'author_image', 'user_' . $author_id ) ) :
							$image = get_field( 'author_image', 'user_' . $author_id );
							?>
								<a class="editorschoice-post-img story-popup" href="<?php echo esc_url( $url ); ?>">
									<div class="king-box-bg" data-king-img-src="<?php echo esc_attr( $image['sizes']['medium_large'] ); ?>"></div>
								</a>
							<?php
							elseif ( has_post_thumbnail() ) :
								$attachment_id = get_post_thumbnail_id( $uposts[0]->ID );
								$thumb         = wp_get_attachment_image_src( $attachment_id, 'medium_large' );
								?>
								<a class="editorschoice-post-img story-popup" href="<?php echo esc_url( $url ); ?>">
									<div class="king-box-bg" data-king-img-src="<?php echo esc_attr( $thumb[0] ); ?>"></div>
								</a>
							<?php else : ?>
								<a class="editorschoice-post-no-thumb story-popup" href="<?php echo esc_url( $url ); ?>"></a>
							<?php endif; ?>
							<div class="editorschoice-post-in">  
							<span class="editorschoice-post-title" ><?php echo esc_attr( $users->user_login ); ?></span>
						</div>
					</div>
						<?php
						endforeach;
					endif;
				?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
<?php endif; ?>
