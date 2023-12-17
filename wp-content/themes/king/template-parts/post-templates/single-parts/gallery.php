<?php
/**
 * Gallery View.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_head();
$gid = get_query_var( 'template' );
$images = get_field( 'images_gallery', $gid );
?>
<div class="king-gallery" id="gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="king-gallery-container">
			<div class="king-gallery-header">
				<?php
				if ( get_field( 'page_logo', 'options' ) ) :
					$logo = get_field( 'page_logo', 'options' );
					?>
					<a href="<?php echo esc_url( site_url() ); ?>" class="king-gallery-logo">
						<img class="king-lazy" data-king-img-src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ); ?>"/>
					</a>
				<?php endif; ?>
				<div class="king-gallery-title">
					<header><h3 class="entry-title"><?php echo get_the_title($gid); ?></h3></header>
					<?php
					$author_id = get_post_field( 'post_author', $gid );
					$author = get_the_author_meta( 'user_nicename', $author_id );
					?>
					<?php esc_html_e( 'by ', 'king' ); ?><a class="king-gallery-author" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>"><?php echo esc_attr( $author ); ?></a>
				</div>
				<div class="king-gallery-thumbs">
					<?php if ( has_post_thumbnail($gid) ) : ?>
						<a href="<?php echo esc_url( '#first' ); ?>" class="king-gallery-thumb">
							<?php echo get_the_post_thumbnail( $gid, 'thumbnail' ); ?>
						</a>
					<?php endif; ?>
					<?php if ( get_field( 'enable_lightbox_ad', 'option' ) ) : ?>
						<a href="<?php echo esc_url( '#second' ); ?>" class="king-gallery-thumb gallery-ad"></a>
					<?php endif; ?>
					<?php if ( have_rows( 'images_lists', $gid ) ) : ?>
						<?php
						while ( have_rows( 'images_lists', $gid ) ) :
							the_row();
							$image = get_sub_field( 'images_list', $gid );
							$thumb = isset( $image['sizes']['medium_large'] ) ? $image['sizes']['medium_large'] : '';
							$id = isset( $image['ID'] ) ? $image['ID'] : '';
							?>
							<a href="<?php echo esc_url( '#' . $id ); ?>" class="king-gallery-thumb" >				
								<?php if ( $image ) : ?>
									<img class="king-lazy" data-king-img-src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
								<?php endif; ?>
							</a>
						<?php endwhile; ?>
					<?php endif; ?>
					<?php if ( $images ) : ?>
						<?php foreach ( $images as $image_id ) : ?>
							<a href="<?php echo esc_url( '#' . $image_id['ID'] ); ?>" class="king-gallery-thumb" >				
								<img class="king-lazy" data-king-img-src="<?php echo esc_url( $image_id['sizes']['thumbnail'] ); ?>" alt="<?php echo esc_attr( $image_id['alt'] ); ?>" />
							</a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<button type="button" class="king-gallery-close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
			</div>
			<div class="king-gallery-images owl-carousel">
				<?php if ( has_post_thumbnail($gid) ) : ?>
					<div class="king-gallery-image" data-hash="first">
						<?php echo get_the_post_thumbnail( $gid, 'full' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( get_field( 'enable_lightbox_ad', 'option' ) ) : ?>
					<div class="king-gallery-image" data-hash="second">
						<?php echo do_shortcode( the_field( 'lightbox_gallery_ad_code', 'options' ) ); ?>
					</div>
				<?php endif; ?>
				<?php if ( have_rows( 'images_lists', $gid ) ) : ?>
					<?php
					while ( have_rows( 'images_lists', $gid ) ) :
						the_row();
						$image = get_sub_field( 'images_list', $gid );
						?>
							<div class="king-gallery-image" data-hash="<?php echo esc_attr( $image['ID'] ); ?>">				
								<?php if ( $image ) : ?>
									<img class="king-lazy" data-king-img-src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" height="<?php echo esc_attr( $image['height'] ); ?>" width="<?php echo esc_attr( $image['width'] ); ?>" />
								<?php endif; ?>
							</div>
					<?php endwhile; ?>
				<?php endif; ?>
				<?php if ( $images ) : ?>
					<?php foreach ( $images as $image_id ) : ?>
						<div class="king-gallery-image" data-hash="<?php echo esc_attr( $image_id['ID'] ); ?>" >
							<?php if ( $image_id ) : ?>
								<img src="<?php echo esc_url( $image_id['url'] ); ?>" alt="<?php echo esc_attr( $image_id['alt'] ); ?>"  height="<?php echo esc_attr( $image_id['height'] ); ?>" width="<?php echo esc_attr( $image_id['width'] ); ?>"/>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	<?php endwhile; ?>
</div>
<?php wp_footer(); ?>