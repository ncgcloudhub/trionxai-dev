<?php
/**
 * Post Page image galleries
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$galleryc = '';
if ( ! get_field( 'enable_lightbox_gallery', 'option' ) ) {
	$galleryc = ' gallery-disabled';
}
$gallery = get_field( 'gallery_layout', 'option' );
if ( $gallery ) {
	$gclass = $gallery;
} else {
	$gclass = 'king-gallery-01';
}
$images = get_field( 'images_gallery' );
if ( 'king-gallery-03' === $gclass || 'king-gallery-02' === $gclass ) :
	?>
	<div class="king-images <?php echo esc_attr( $gclass ); ?><?php echo esc_attr( $galleryc ); ?>">
		<?php if ( have_rows( 'images_lists' ) || $images ) : ?>
			<?php if ( ! $images ) : ?>
			<a href="<?php echo esc_url( add_query_arg( 'template', get_the_ID(), home_url( $GLOBALS['king_updte'] . '/' ) ) ); ?>#first" class="images-item iframe-link">
				<?php
				if ( has_post_thumbnail() ) :
					$fthumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium_large' );
					if ( 'king-gallery-03' === $gclass ) :
						?>
						<span class="images-item-span" style="background-image: url('<?php echo esc_url( $fthumb['0'] ); ?>');"></span>
					<?php else : ?>
						<img src="<?php echo esc_url( $fthumb['0'] ); ?>" />
					<?php endif; ?>
				<?php endif; ?>
			</a>
			<?php endif; ?>
			<?php if ( have_rows( 'images_lists' ) ) : ?>
			<?php
			while ( have_rows( 'images_lists' ) ) :
				the_row();
				$image = get_sub_field( 'images_list' );
				$thumb = isset( $image['sizes']['medium_large'] ) ? $image['sizes']['medium_large'] : '';
				$id = isset( $image['ID'] ) ? $image['ID'] : '';
				?>
				<a href="<?php echo esc_url( add_query_arg( 'template', get_the_ID(), home_url( $GLOBALS['king_updte'] . '/' ) ) ); ?>#<?php echo esc_attr( $id ); ?>" class="images-item iframe-link">				
					<?php
					if ( $image ) :
						if ( 'king-gallery-03' === $gclass ) :
							?>
							<span class="images-item-span" style="background-image: url('<?php echo esc_url( $thumb ); ?>');" ></span>
						<?php else : ?>
							<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
						<?php endif; ?>
					<?php endif; ?>
				</a>
			<?php endwhile; ?>
			<?php endif; ?>
				<?php if ( $images ) : ?>
				<?php foreach ( $images as $image_id ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 'template', get_the_ID(), home_url( $GLOBALS['king_updte'] . '/' ) ) ); ?>#<?php echo esc_attr( $image_id['ID'] ); ?>" class="images-item iframe-link">
					<?php if ( 'king-gallery-03' === $gclass ) : ?>
						<span class="images-item-span" style="background-image: url('<?php echo esc_url( $image_id['sizes']['medium_large'] ); ?>');" ></span>
					<?php else : ?>
						<img src="<?php echo esc_url( $image_id['sizes']['medium_large'] ); ?>" alt="<?php echo esc_attr( $image_id['alt'] ); ?>" />
					<?php endif; ?>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php else : ?>
			<div class="images-item image-alone">
				<?php
				if ( has_post_thumbnail() ) :
					echo get_the_post_thumbnail( get_the_ID(), 'full' );
				endif;
				?>
			</div>
		<?php endif; ?>	
	</div>
<?php else : ?>
	<div class="king-images">
	<?php if ( empty( $galleryc ) ) : ?>
		<a class="gallery-toggle iframe-link" href="<?php echo esc_url( add_query_arg( 'template', get_the_ID(), home_url( $GLOBALS['king_updte'] . '/' ) ) ); ?>"><i class="fas fa-camera"></i><?php esc_html_e( 'View Gallery', 'king' ); ?></a>
	<?php endif; ?>
		<div class="owl-carousel <?php echo esc_attr( $gclass ); ?><?php echo esc_attr( $galleryc ); ?>">
			<?php if ( ! $images ) : ?>
			<div class="images-item">
				<?php
				if ( has_post_thumbnail() ) :
					echo get_the_post_thumbnail( get_the_ID(), 'medium_large' );
				endif;
				?>
			</div>
			<?php endif; ?>
			<?php if ( have_rows( 'images_lists' ) ) : ?>
				<?php
				while ( have_rows( 'images_lists' ) ) :
					the_row();
					$image = get_sub_field( 'images_list' );
					$thumb = isset( $image['sizes']['medium_large'] ) ? $image['sizes']['medium_large'] : '' ;
					?>
					<div class="images-item">				
						<?php if ( $image ) : ?>
							<img class="king-lazy" data-king-img-src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" width="<?php echo esc_attr( $image['width'] ); ?>" height="<?php echo esc_attr( $image['height'] ); ?>" />
						<?php endif; ?>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>	
			<?php if ( $images ) : ?>
				<?php foreach ( $images as $image_id ) : ?>
					<div class="images-item">				
						<img class="king-lazy" data-king-img-src="<?php echo esc_url( $image_id['sizes']['medium_large'] ); ?>" alt="<?php echo esc_attr( $image_id['alt'] ); ?>" width="<?php echo esc_attr( $image_id['width'] ); ?>" height="<?php echo esc_attr( $image_id['height'] ); ?>" />
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
