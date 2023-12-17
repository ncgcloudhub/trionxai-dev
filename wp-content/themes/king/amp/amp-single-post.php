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
<?php if ( have_rows( 'news_list_items' ) ) : ?>

		<div class="king-lists">
			<?php $i = 1; ?>
			<?php while ( have_rows( 'news_list_items' ) ) :
				the_row();
				$image = get_sub_field( 'news_list_image' );
				$size = 'large';
				$media = get_sub_field( 'news_list_media', false, false );
				$vid = king_parse_video_uri( $media );
				$media_id = isset($vid['id']) ? $vid['id'] : '';
				$title = get_sub_field( 'news_list_title' );
				$content = get_sub_field( 'news_list_content' );
			?>
			<div class="list-item">

				<span class="list-item-title"><span class="list-item-number"><?php echo esc_html( $i ); ?></span><h3><?php echo esc_html( $title ); ?></h3></span>
				<?php if ( $image ) : ?>
					<?php if ( $image['mime_type'] == 'image/gif' ) : ?>
						<amp-anim width=<?php echo esc_attr( $image['sizes'][ $size . '-width' ] ); ?> height=<?php echo esc_attr( $image['sizes'][ $size . '-height' ] ); ?> src="<?php echo esc_url( $image['url'] ); ?>" layout="responsive" >
							<amp-img placeholder width=<?php echo esc_attr( $image['sizes'][ $size . '-width' ] ); ?> height=<?php echo esc_attr( $image['sizes'][ $size . '-height' ] ); ?> src="<?php echo esc_url( $image['sizes'][ 'medium_large' ] ); ?>">
							</amp-img>
						</amp-anim>
					<?php else : ?>	
						<span class="list-item-image">
							<amp-img src="<?php echo esc_url( $image['sizes'][ $size ] ); ?>" alt="<?php echo esc_html( $image['alt'] ) ?>" height="<?php echo esc_attr( $image['sizes'][ $size . '-height' ] ); ?>" width="<?php echo esc_attr( $image['sizes'][ $size . '-width' ] ); ?>" layout="responsive" srcset="<?php echo wp_get_attachment_image_srcset( $image['id'], $size ); ?>"></amp-img>
						</span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $media ) : ?>
					<span class="list-item-media">
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
						<span class="list-item-media">
							<?php echo get_sub_field( 'news_list_media' ); ?>
						</span>
					<?php endif; ?>			

				<?php endif; ?>
			</span>
			<span class="list-item-content">
				<?php echo wp_kses_data( $content ); ?>
			</span>

		</div>

		<?php $i++;
		endwhile; ?>

	</div>

<?php endif; ?>