<?php
/**
 * The singe post part - video.
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
<?php if ( get_field( 'nsfw_post' ) && ! is_user_logged_in() ) : ?>
	<div class="post-video nsfw-post-page king-top-playlist">
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>">
			<i class="fa fa-paw fa-3x"></i>
			<div><h1><?php echo esc_html_e( 'Not Safe For Work', 'king' ); ?></h1></div>
			<span><?php echo esc_html_e( 'Click to view this post.', 'king' ); ?></span>
		</a>	
	</div>
<?php else : ?>
	<?php
		$floating = '';
	if ( get_field( 'enable_floating_video', 'options' ) ) :
		$floating = 'floating-video';
	endif;
	?>
	<div class="post-video king-top-playlist embed-responsive embed-responsive-16by9 <?php echo esc_attr( $floating ); ?>">
		<?php

		if ( has_post_thumbnail() ) :
			$audio_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
			$audio_thumb  = $audio_thumbs['0'];
		else :
			$audio_thumb = '';
		endif;
		$videofile = get_field( 'video_upload', get_the_ID() );
		$videotype = is_array($videofile) ? $videofile['type'] : '';
		$videourl  = is_array($videofile) ? $videofile['url'] : '';
		$videotab  = get_field( 'video_tab', get_the_ID() );
		if ( get_field( 'media_lists', get_the_ID() ) && get_query_var( 'template' ) ) {
			$termd       = get_query_var( 'template' ) - 1;
			$tlists      = get_field( 'media_lists', get_the_ID() );

			$videotype   = isset($tlists[ $termd ]['media_upload']['type']) ? $tlists[ $termd ]['media_upload']['type'] : '';
			$audio_thumb = isset($tlists[ $termd ]['media_thumb']['sizes']['large']) ? $tlists[ $termd ]['media_thumb']['sizes']['large'] : '';
			$videourl    = isset($tlists[ $termd ]['media_upload']['url']) ? $tlists[ $termd ]['media_upload']['url'] : '';
			$videotab    = isset($tlists[ $termd ]['media_url_or_upload']) ? $tlists[ $termd ]['media_url_or_upload'] : '';
			$mediaurl    = isset($tlists[ $termd ]['media_url']) ? $tlists[ $termd ]['media_url'] : '';

		}
		if ( $videotab ) :
		if ( $videotype === 'audio' ) :
				?>
			<audio id="king-audio" class="video-js vjs-default-skin" preload="auto" poster="<?php echo esc_url( $audio_thumb ); ?>" data-setup='{ "controls": true, "preload": "auto" }'>
				<source src="<?php echo esc_url( $videourl ); ?>" type='audio/mp3'/>
			</audio>
		<?php elseif ( $videotype === 'video' ) : ?>
			<video id="king-video" class="video-js" controls preload="auto" poster="<?php echo esc_url( $audio_thumb ); ?>" data-setup='{}'>
				<source src="<?php echo esc_url( $videourl ); ?>" type="video/mp4"></source>
			</video>
		<?php else : ?>	
			<?php the_field( 'media_embed_code', get_the_ID() ); ?>
		<?php endif; ?>
	<?php else : ?>
		<?php
		if ( get_query_var( 'template' ) && $mediaurl ) {
			echo $mediaurl;
		} else {
			the_field( 'video-url', get_the_ID() );
		}
		?>
	<?php endif; ?>
		<?php if ( get_field( 'enable_ad_video','options' ) && king_add_free_mode() ) : ?>
			<div class="king-loading-ad">
				<div class="king-loading-ad-content">
					<?php the_field( 'video_load_ad','options' ); ?>
					<span class="skip-ad">
						<span id="notice"><?php echo esc_html_e( 'You can skip ad in', 'king' ); ?> <?php the_field( 'skip_ad_after','options' ); ?>s</span> 
						<span id="hidead" style="display: none" ><?php echo esc_html_e( 'Skip Ad', 'king' ); ?></span>
					</span>
				</div>
			</div>
		<?php endif; ?>
		<?php
		if ( have_rows( 'media_lists' ) ) :
			$pl_fimage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
			if ( $pl_fimage ) {
				$pl_fthumb = $pl_fimage['0'];
				$pl_fthumb = 'style="background-image: url(\'' . esc_url( $pl_fthumb ) . '\')"';
			} else {
				$pl_fthumb = '';
			}
			?>
			<div class="king-playlist">
				<ul>
					<li>
						<a href="<?php echo esc_url( get_permalink() ); ?>">
							<span class="king-pl-thumb" <?php echo wp_kses_post( $pl_fthumb ); ?>></span>
							<span class="king-pl-title"><?php echo the_title(); ?></span>
						</a>
					</li>
					<?php
					while ( have_rows( 'media_lists' ) ) :
						the_row();
						$pl_title  = get_sub_field( 'media_title' );
						$pl_url    = get_sub_field( 'media_url' );
						$pl_upload = get_sub_field( 'media_upload' );
						$pl_image  = get_sub_field( 'media_thumb' );
						if ( $pl_image ) {
							$pl_thumb = $pl_image['sizes']['thumbnail'];
							$pl_thumb = 'style="background-image: url(\'' . esc_url( $pl_thumb ) . '\')"';
						} else {
							$pl_thumb = '';
						}
						?>
						<li>
							<a class="<?php if ( get_query_var( 'template' ) == get_row_index() ) {  echo 'active'; } ?>" href="<?php echo esc_url( add_query_arg( 'template', get_row_index(), get_permalink() ) ); ?>">
								<span class="king-pl-thumb" <?php echo wp_kses_post( $pl_thumb ); ?>></span>
								<span class="king-pl-title"><?php echo esc_attr( $pl_title ); ?></span>
							</a>
						</li>
					<?php endwhile; ?>	
				</ul>
			</div>
		<?php endif; ?>
	</div>	
<?php endif; ?>
