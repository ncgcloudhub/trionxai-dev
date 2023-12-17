<?php
/**
 * Featured Categories in Mini Slider.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php

$posts_per_page = get_field( 'post_number_in_mini_slider', 'options' );

$categories = get_categories(
	array(
		'orderby'    => 'count',
		'hide_empty' => false,
		'order'      => 'DESC',
		'number'     => $posts_per_page,
	)
);
if ( $categories ) :
	?>
	<div class="king-editorschoice lr-padding editorschoice-height-up">
		<?php if ( get_field( 'mini_slider_title', 'options' ) ) : ?>
			<h4 class="king-editorschoice-title"><?php the_field( 'mini_slider_title', 'options' ); ?></h4>
		<?php endif; ?>
		<div class="king-featured-small king-editorschoice-owl owl-carousel">
			<?php
			foreach ( $categories as $cate ) :
				$bgimage = '';
				$bcolor  = '';
				$color   = get_field( 'category_colors', 'category_' . $cate->term_id );
				$catlogo = get_field( 'category_logo', 'category_' . $cate->term_id );
				$size    = 'thumbnail';
				$bgimage = get_field( 'category_background_image', 'category_' . $cate->term_id );
				if ( $bgimage ) {
					$bgimage = 'background-image:url(' . $bgimage['sizes']['medium'] . '); ';
				}
				if ( $color ) {
					$bcolor = 'background-color:' . $color . '; ';
				}
				?>
				<div class="editorschoice-post">
						<div class="editorschoice-post-img" <?php if ( $bcolor || $bgimage ) : ?>style="<?php echo esc_attr( $bcolor ); ?><?php echo esc_attr( $bgimage ); ?>" <?php endif; ?>></div>
							<div class="editorschoice-post-in">
								<span class="editorschoice-post-title" ><a href="<?php echo esc_url( get_category_link( $cate->term_id ) ); ?>"> <?php echo esc_attr( $cate->name ); ?></a> </span>
							</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>
