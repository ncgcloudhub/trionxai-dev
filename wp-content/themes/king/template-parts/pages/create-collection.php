<?php
/**
 * Create collection.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="king-collection-main">
	<div class="king-collection-up">
	<ul class="king-scroll">
		<?php
		$usrid = get_current_user_id();
		$colls = get_user_meta( $usrid, 'king_collections', true );
		$ccolls = !empty($colls) ? count($colls) : 0;
		if ( $colls ) :
			foreach ( $colls as $coll ) :
				$collin = get_user_meta( $usrid, 'king_collect_' . $coll, true );
				$bucket = get_user_meta( $usrid, 'king_collection_' . $coll, true );
				$arever = is_array( $bucket ) ? array_reverse( $bucket ) : '';
				$cp1    = isset( $arever[0] ) ? get_the_post_thumbnail_url( $arever[0], 'medium_large' ) : '';
				$postid = get_the_ID();
				if ( is_array( $bucket ) && in_array( $postid, $bucket ) ) {
					$class = ' king-bucketed';
				} else {
					$class = '';
				}
				?>
				<li class="king-collection-add<?php echo esc_attr( $class ); ?>" data-collid="<?php echo esc_attr( $coll ); ?>" data-pid="<?php echo esc_attr( $postid ); ?>" data-tid="<?php echo esc_attr( get_post_thumbnail_id() ); ?>">
					<a href="#">
						<div class="king-collectionadd-img" style="background-image:url('<?php echo esc_url( $cp1 ); ?>');"></div>
						<div class="king-collection-content">
							<span class="king-collection-t">
								<?php echo esc_attr( $collin['t'] ); ?>
								<?php if ( true === $collin['p'] ) : ?>
									<i class="fa-solid fa-lock"></i>
								<?php endif; ?>	
							</span>
							<span><?php echo esc_attr( isset( $collin['d'] ) ? $collin['d'] : '' ); ?></span>
						</div>
					</a>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
	<?php if ( $ccolls < get_field( 'max_collection_number', 'options' ) ) : ?>
	<a href="#" class="create-bucket-link"><?php echo esc_html_e( 'Create New Collection', 'king' ); ?></a>
	<?php endif; ?>
	</div>
	<?php if ( $ccolls < get_field( 'max_collection_number', 'options' ) ) : ?>
	<div class="king-collection-form">
		<h3><?php echo esc_html_e( 'Create Collection', 'king' ); ?></h3>
		<form action="" class="create-bucket" method="post" enctype="multipart/form-data" autocomplete="off">
			<div class="king-form-group">
				<input tabindex="1" type="text" class="bpinput" name="king_ctitle" placeholder="<?php esc_html_e( 'Title', 'king' ); ?>" value="<?php echo isset( $kingc['king_ctitle'] ) ? esc_attr( $kingc['king_ctitle'] ) : ''; ?>" maxlength="50" required/>
				<?php if ( isset( $king_cerrors['title_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_cerrors['title_empty'] ); ?></div>
				<?php endif; ?>
			</div>
			<div class="king-form-group">
				<label><?php esc_html_e( 'Private', 'king' ); ?></label>
				<label>
					<input type="checkbox" name="king_cprv" class="king-switch-input" autocomplete="off">
					<div class="king-swi">
						<div class="king-swi-slider"></div>
					</div>
				</label>
			</div>
			<div class="king-form-group">
				<?php if ( isset( $king_cerrors['desc_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_cerrors['desc_empty'] ); ?></div>
				<?php endif; ?>		
				<textarea name="king_cdesc" class="bptextarea" rows="2" cols="50" maxlength="140" placeholder="<?php esc_html_e( 'Description (optional)', 'king' ); ?>"></textarea>
			</div>
			<input type="submit" id="king-submitbutton" class="king-submit-button" name="king_ccollec" value="<?php echo esc_html_e( 'Create', 'king' ); ?>" />
			<input type="hidden" id="king-burl" name="king_burl" value="<?php echo esc_url( add_query_arg( 'term', 'bucketings', the_permalink() ) ); ?>" />

			<?php wp_nonce_field( 'king_ccollecn', 'king_ccollecn_nonce' ); ?>
		</form>
	</div>
	<?php endif; ?>
</div>
