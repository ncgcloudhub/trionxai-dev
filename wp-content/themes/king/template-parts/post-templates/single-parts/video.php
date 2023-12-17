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
	<div class="post-video nsfw-post-page">
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
	<div class="post-video embed-responsive embed-responsive-16by9 <?php echo esc_attr( $floating ); ?>">	
		<?php
		if ( has_post_thumbnail() ) :
			$audio_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
		else :
			$audio_thumb['0'] = '';
		endif;
		if ( get_field( 'video_tab', get_the_ID() ) ) :
			$videofile = get_field( 'video_upload', get_the_ID() );
			if ($videofile) :
			
			if ( $videofile['type'] === 'audio' ) :
					?>
				<audio id="king-audio" class="video-js vjs-default-skin" preload="auto" poster="<?php echo esc_url( $audio_thumb['0'] ); ?>" data-setup='{ "controls": true, "preload": "auto" }'>
					<source src="<?php echo esc_url( $videofile['url'] ); ?>" type='audio/mp3'/>
				</audio>
			<?php elseif ( $videofile['type'] === 'video' ) : ?>
				<video id="king-video" class="video-js" controls preload="auto" poster="<?php echo esc_url( $audio_thumb['0'] ); ?>" data-setup='{}'>
					<source src="<?php echo esc_url( $videofile['url'] ); ?>" type="video/mp4"></source>
				</video>
			<?php endif; ?>
		<?php else : ?>	
			<?php the_field( 'media_embed_code', get_the_ID() ); ?>
		<?php endif; ?>
			<?php
		else :
			the_field( 'video-url', get_the_ID() );
		endif;
		?>
		<?php if ( get_field( 'enable_ad_video', 'options' ) && king_add_free_mode() ) : ?>
			<div class="king-loading-ad">
				<div class="king-loading-ad-content">
					<?php the_field( 'video_load_ad', 'options' ); ?>
					<span class="skip-ad">
						<span id="notice"><?php echo esc_html_e( 'You can skip ad in', 'king' ); ?> <?php the_field( 'skip_ad_after', 'options' ); ?>s</span> 
						<span id="hidead" style="display: none" ><?php echo esc_html_e( 'Skip Ad', 'king' ); ?></span>
					</span>
				</div>
			</div>
		<?php endif; ?>
	</div>	
<?php endif; ?>	
