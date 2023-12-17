<?php
/**
 * Featured Posts Slider.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
$meta_value  = '1';
$kingorderby = 'modified';
if ( get_field( 'show_slider', 'options' ) === 'featured-post' ) {
	$meta_key = 'featured-post';
} elseif ( get_field( 'show_slider', 'options' ) === 'editors_choice' ) {
	$meta_key = 'editors_choice';
} elseif ( get_field( 'show_slider', 'options' ) === 'keep_trending' ) {
	$meta_key = 'keep_trending';
} elseif ( get_field( 'show_slider', 'options' ) === 'most_views' ) {
	$meta_key    = '_post_views';
	$meta_value  = '';
	$kingorderby = 'meta_value_num';
} elseif ( get_field( 'show_slider', 'options' ) === 'most_likes' ) {
	$meta_key    = 'king_like_count';
	$meta_value  = '';
	$kingorderby = 'meta_value_num';
}
if ( get_field( 'slider_template', 'options' ) === 'slider-template-1' ) {
	$posts_per_page = 5;
	$gridtemplate   = get_field_object( 'select_grid_template', 'options' );
	if ( $gridtemplate['value'] == 'grid-template-3' || $gridtemplate['value'] == 'grid-template-8' || $gridtemplate['value'] == 'grid-template-9' ) {
		$posts_per_page = 4;
	} elseif ( $gridtemplate['value'] == 'grid-template-4' ) {
		$posts_per_page = 6;
	} elseif ( $gridtemplate['value'] == 'grid-template-7' ) {
		$posts_per_page = 6;
	} elseif ( $gridtemplate['value'] == 'grid-template-10' ) {
		$posts_per_page = 3;
	} elseif ( $gridtemplate['value'] == 'grid-template-11' ) {
		$posts_per_page = 4;
	}
} elseif ( get_field( 'slider_template', 'options' ) === 'slider-template-2' ) {
	$posts_per_page = get_field( 'length_slider', 'options' );
}
// get posts.
$featured = get_posts(
	array(
		'posts_per_page' => $posts_per_page,
		'meta_key'       => $meta_key,
		'meta_value'     => $meta_value,
		'orderby'        => $kingorderby,
		'order'          => 'DESC',
		'post_type'      => king_post_types(),
	)
);

if ( $featured ) :
	?>
	<div class="lr-padding king-featured-top">
<?php if ( get_field( 'slider_template', 'options' ) === 'slider-template-1' ) : ?>
	<div class="king-featured-grid <?php echo esc_attr( $gridtemplate['value'] ); ?>">
<?php elseif ( get_field( 'slider_template', 'options' ) === 'slider-template-2' ) : ?>
	<?php if ( get_field( 'slider_2_layout', 'options' ) === 'slider-layout-2' ) : ?>
		<div class="owl-carousel king-featured-4">
	<?php elseif ( get_field( 'slider_2_layout', 'options' ) === 'slider-layout-3' ) : ?>
		<div class="owl-carousel king-featured-5">
	<?php elseif ( get_field( 'slider_2_layout', 'options' ) === 'slider-layout-4' ) : ?>
		<div class="owl-carousel king-featured king-featured-6">
	<?php else : ?>
		<div class="king-featured king-featured-3 owl-carousel">
	<?php endif; ?>
<?php endif; ?>
	<?php
	$i = '';
	foreach ( $featured as $post ) :
		$i++;
		?>
	<div class="featured-posts grid-<?php echo esc_attr( $i ); ?>">

		<a href="<?php the_permalink(); ?>">
			<?php
			if ( has_post_thumbnail() ) :
				$attachment_id = get_post_thumbnail_id( $post->ID );
				$thumb         = wp_get_attachment_image_src( $attachment_id, 'large' );
				?>
			<div class="featured-post">
				<div class="king-box-bg" data-king-img-src="<?php echo esc_url( $thumb[0] ); ?>"></div>
			</div>
			<?php else : ?>
				<span class="no-thumb"></span>
			<?php endif; ?>
		</a>       
		<div class="featured-content">
			<?php echo wp_kses_post( king_post_format() ); ?>
			<a href="<?php the_permalink(); ?>"  class="featured-title"><?php the_title(); ?></a>
			<div class="featured-meta">
				<span class="post-views"><i class="fa fa-eye" aria-hidden="true"></i><?php echo esc_attr( king_postviews( get_the_ID(), 'display' ) ); ?></span>
				<span class="post-comments"><i class="fa fa-comment" aria-hidden="true"></i><?php comments_number( ' 0 ', ' 1 ', ' % ' ); ?></span>
				<span class="post-time"><i class="far fa-clock"></i><?php the_time( 'F j, Y' ); ?></span>
			</div>
		</div>
</div>
<?php endforeach; ?>
	<?php wp_reset_postdata(); ?>
</div>
	<?php if ( get_field( 'slider_2_layout', 'options' ) === 'slider-layout-4' ) : ?>
		<div class="featured-thumbs king-scroll">
			<?php foreach ( $featured as $index => $thumbs ) : ?>
			<div class="featured-post-thumb  <?php echo esc_attr( ( empty( $index ) ? 'active' : '' ) ); ?>"  data-slide="<?php echo esc_attr( $index ); ?>">
					<?php
					if ( has_post_thumbnail() ) :
						$attachment_id = get_post_thumbnail_id( $thumbs->ID );
						$thumb         = wp_get_attachment_image_src( $attachment_id, 'large' );
						?>
						<div class="king-box-bg" data-king-img-src="<?php echo esc_url( $thumb[0] ); ?>"></div>
					<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>
 </div>

<?php endif; ?>
