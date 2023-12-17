<div class="amp-king-video">
<?php
	$media = get_field( 'video-url', false, false );
	$vid = king_parse_video_uri( $media );
	$media_id = $vid['id'];
?>
<?php if ( get_field( 'video_tab', get_the_ID() ) ) : ?>
<?php
	$videofile = get_field( 'video_upload', get_the_ID() );
	if ( has_post_thumbnail() ) :
		$audio_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
	else :
		$audio_thumb['0'] = '';
	endif;
	?>
	<?php if ( $videofile['type'] === 'audio' ) : ?>
		<amp-audio width="auto"	height="50"	src="<?php echo esc_url( $videofile['url'] ); ?>">
			<div fallback><p>Your browser doesn’t support HTML5 audio</p></div>
		</amp-audio>
	<?php elseif ( $videofile['type'] === 'video' ) : ?>
		<amp-video controls	width="<?php echo esc_attr( $audio_thumb['1'] ); ?>" height="<?php echo esc_attr( $audio_thumb['2'] ); ?>" layout="responsive"
		poster="<?php echo esc_url( $audio_thumb['0'] ); ?>">
			<source src="<?php echo esc_url( $videofile['url'] ); ?>" type="video/mp4" />
			<div fallback>
				<p>This browser does not support the video element.</p>
			</div>
		</amp-video>
	<?php endif; ?>
<?php else : ?>
		<?php if ( $vid['type'] == 'youtube' ) : ?>
			<amp-youtube width="480"
			height="270"
			layout="responsive"
			data-videoid="<?php echo esc_attr( $media_id ); ?>"></amp-youtube>						
		<?php elseif ( $vid['type'] == 'vimeo' ) : ?>
			<amp-vimeo
			data-videoid="<?php echo esc_attr( $media_id ); ?>"
			layout="responsive"
			width="500" height="281"></amp-vimeo>
		<?php elseif ( $vid['type'] == 'facebook' ) : ?>
			<amp-facebook width="476" height="316"
			layout="responsive"
			data-embed-as="video"
			data-href="<?php echo esc_attr( $media_id ); ?>"></amp-facebook>
		<?php elseif ( $vid['type'] == 'soundcloud' ) : ?>	
			<amp-soundcloud height=657
			layout="fixed-height"
			data-trackid="<?php echo esc_attr( $media_id ); ?>"
			data-visual="true"></amp-soundcloud>
		<?php else : ?>
				<?php the_field( 'video-url', get_the_ID() ); ?>
		<?php endif; ?>
<?php endif; ?>
</div>

<?php
the_content( sprintf(
	/* translators: %s: Name of current post. */
	wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'king' ), array( 'span' => array( 'class' => array() ) ) ),
	the_title( '<span class="screen-reader-text">"', '"</span>', false )
) );

wp_link_pages( array(
	'before' => '<div class="page-links">',
	'after'  => '</div>',
) );
?>
