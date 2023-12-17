<?php
/**
 * The singe post part - share.
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
<div class="king-modal-login modal" id="sharemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="king-modal-content">
		<div class="king-modal-share">
			<?php
			if ( has_post_thumbnail() ) :
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
				?>
				<div class="share-modal-image">
					<img src="<?php echo esc_url( $thumb['0'] ); ?>">
				</div>
			<?php endif; ?>
			<button type="button" class="king-modal-close" data-dismiss="modal" aria-label="Close"><i class="icon fa fa-fw fa-times"></i></button>
			<div class="king-modal-share">
				<?php echo esc_attr( king_social_share() ); ?>
			</div>
		</div>
	</div>
</div>
