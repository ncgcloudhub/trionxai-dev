<?php 
	if ( has_post_thumbnail() ) :
		$amp_img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
	else :
		$amp_img['0'] = '';
	endif;
?>
<div class="amp-king-image">
	<amp-carousel width="600" height="400" layout="responsive" type="slides">
		<amp-img src="<?php echo esc_url( $amp_img['0'] ); ?>" width="<?php echo esc_attr( $amp_img['1'] ); ?>" height="<?php echo esc_attr( $amp_img['2'] ); ?>" layout="responsive" ></amp-img>
			<?php if ( have_rows( 'images_lists' ) ) : ?>
				<?php while ( have_rows( 'images_lists' ) ) : the_row();
					$image = get_sub_field( 'images_list' );
				?>
				<amp-img src="<?php echo esc_url( $image['sizes']['large'] ); ?>" width="<?php echo esc_attr( $image['sizes']['large-width'] ); ?>" height="<?php echo esc_attr( $image['sizes']['large-height'] ); ?>"></amp-img>
				<?php endwhile; ?>
			<?php endif; ?>
	</amp-carousel>
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
