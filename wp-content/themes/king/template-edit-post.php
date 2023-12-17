<?php
/**
 * Post Edit template
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$postid = get_query_var( 'term' );
$gid = get_query_var( 'template' );
if ($postid) :
global $king_submit_errors;
$format = get_post_format( $postid );
$status = get_post_status( $postid );

if ( isset( $_POST['king_edit_post_upload_form_submitted'] ) && wp_verify_nonce( $_POST['king_edit_post_upload_form_submitted'], 'king_edit_post_upload_form' ) ) { // input var okay; sanitization okay.

	// Get clean input variables
	$edit_title         = sanitize_text_field( $_POST['king_post_title'] );
	$tags               = sanitize_text_field( $_POST['king_post_tags'] );
	$edit_content       = stripslashes( $_POST['king_post_content'] );
	$category           = isset( $_POST['king_post_category'] ) ? $_POST['king_post_category'] : '';
	$king_submit_errors = array();
	if ( get_field( 'maximum_title_length', 'option' ) ) {
		$title_length = get_field( 'maximum_title_length', 'option' );
	} else {
		$title_length = '140';
	}

	if ( get_field( 'maximum_content_length', 'option' ) ) {
		$content_length = get_field( 'maximum_content_length', 'option' );
	} else {
		$content_length = '2000';
	}

	if ( trim( $edit_title ) === '' ) {
		$king_submit_errors['title_empty'] = esc_html__( 'Title is required.', 'king' );
	} elseif ( strlen( $edit_title ) > $title_length ) {
		$king_submit_errors['title_empty'] = esc_html__( 'Title is too long.', 'king' );
	}

	if ( trim( $edit_content ) === '' ) {
		$king_submit_errors['content_empty'] = esc_html__( 'Content is required.', 'king' );
	} elseif ( strlen( $edit_content ) > $content_length ) {
		$king_submit_errors['content_empty'] = esc_html__( 'Content is too long.', 'king' );
	}

	if ( $format === 'video' ) {
		$video_url    = '';
		$video_upload = '';
		$embed_url    = get_field( 'video-url', $postid, false );
		if ( isset( $_POST['acf']['field_587be2665e807'] ) ) {
			$video_url = esc_url( wp_unslash( $_POST['acf']['field_587be2665e807'] ) ); // Input var okey.
		}
		if ( isset( $_POST['acf']['field_58f5335001eed'] ) ) {
			$video_upload = esc_url( wp_unslash( $_POST['acf']['field_58f5335001eed'] ) ); // Input var okey.
		}
		if ( trim( $video_url ) === '' && trim( $video_upload ) === '' ) {
			$king_submit_errors['videourl_empty'] = esc_html__( 'Media is required.', 'king' );
		}
	}
	if ( empty( $king_submit_errors ) ) {

		if ( is_super_admin() ) {
			$poststatus = 'publish';
		} elseif ( get_field( 'moderate_posts_edit', 'option' ) || $status == 'pending' || $status == 'draft' ) {
			$poststatus = 'pending';
		} else {
			$poststatus = 'publish';
		}
		$post_information = array(
			'ID'            => $postid,
			'post_title'    =>  wp_strip_all_tags( $edit_title ),
			'post_content'  => $edit_content,
			'tags_input'    => $tags,
			'post_category' => $category,
			'post_status'   => $poststatus,
		);

		if ( 'delete' === $_POST['king-editpost'] ) {
			wp_delete_post( $postid );
			wp_redirect( home_url() );
			exit;
		} else {
			$post_id = wp_update_post( $post_information );
		}

		
		if ( $format === 'video' ) {
			if ( $embed_url !== $video_url ) {
				require_once KING_INCLUDES_PATH . 'videothumbs.php';
				$ktype = king_source( $video_url );

				if ( 'vimeo.com' === $ktype || 'dailymotion.com' === $ktype || 'metacafe.com' === $ktype || 'vine.co' === $ktype || 'instagram.com' === $ktype || 'vid.me' === $ktype ) {

					$image_url = king_get_thumb( $video_url );

				} elseif ( 'youtube.com' === $ktype || 'youtu.be' === $ktype ) {

					$image_url = king_youtube( $video_url );

				} elseif ( 'soundcloud.com' === $ktype ) {

					$image_url = king_soundcloud( $video_url );

				} else {
					$image_url = king_get_thumb( $video_url );
				}
				$attach_id = king_upload_user_file_video( $image_url, $post_id );
				set_post_thumbnail( $post_id, $attach_id );
			}
		}
		do_action( 'acf/save_post' , $postid );
		if ( $post_id ) {
			$permalink = get_permalink( $post_id );
			wp_redirect( $permalink );
			exit;
		}
	}
}

acf_form_head();
get_header(); ?>
<?php
$title          = get_the_title( $postid );
$content        = apply_filters( 'the_content', get_post_field( 'post_content', $postid ) );
$tags           = strip_tags( get_the_term_list( $postid, 'post_tag', '', ', ', '' ) );
$post_thumb     = get_post_thumbnail_id( $postid );
$post_thumb_url = get_the_post_thumbnail_url( $postid, 'medium' );
$post_author    = get_post_field( 'post_author', $postid );
$current_user   = wp_get_current_user();
?>
<?php get_template_part( 'template-parts/king-header-nav' ); ?>
<?php if ( ! is_user_logged_in() || empty( $postid ) || ! get_field( 'enable_post_edit', 'options' ) || empty( $title ) ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to edit this post !', 'king' ); ?></div>
<?php elseif ( esc_attr( $post_author ) !== esc_attr( $current_user->ID ) && ! is_super_admin() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to edit this post !', 'king' ); ?></div>
<?php elseif ( ( get_field( 'verified_edit_posts', 'options' ) && ! get_field( 'verified_account', 'user_' . $current_user->ID ) ) && ( get_field( 'enable_user_groups', 'options' ) && ! king_groups_permissions( 'groups_edit_their_own_posts' ) ) && ! is_super_admin() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to edit this post !', 'king' ); ?></div>
<?php else : ?>
<div id="primary" class="page-content-area">
	<main id="main" class="page-news-main king-post-edit">
		<form id="king_posts_form" action="" method="POST" enctype="multipart/form-data">
			<div class="submit-news-left">
				<div class="king-form-group">
					<label for="king_post_title"><?php esc_html_e( 'Title', 'king' ); ?></label>
					<input class="form-control bpinput" name="king_post_title" id="king_post_title" type="text" value="<?php echo esc_attr( $title ); ?>" maxlength="<?php the_field( 'maximum_title_length', 'option' ); ?>" required />
				</div>
				<?php if ( isset( $king_submit_errors['title_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_submit_errors['title_empty'] ); ?></div>
				<?php endif; ?>				
				<?php
				$include          = array();
				$categories       = get_terms(
					'category',
					array(
						'include'    => $include,
						'hide_empty' => false,
					)
				);
				$categories_count = count( $categories );

				// get post categories.
				$post_cats     = get_the_category( $postid );
				$post_cats_arr = array();

				foreach ( $post_cats as $post_cat ) {
					$post_cats_arr[] = $post_cat->term_id;
				}
				if ( $categories_count > 1 ) :
					?>
				<div class="king-form-group form-categories">
					<span class="form-label"><?php esc_html_e( 'Select Category', 'king' ); ?></span>
					<ul>
						<?php
						foreach ( $categories as $cat ) {
							if ( $format === 'quote' ) {
								$catsfor = get_field( 'category_for', $cat );
								if ( $catsfor && in_array( 'for_news', $catsfor, true ) || ! $catsfor ) :
									$checked = '';
									if ( in_array( $cat->term_id, $post_cats_arr ) ) {
										$checked = 'checked';
									}
									echo '<li class="form-categories-item"><input type="checkbox" id="king_post_cat-' . esc_attr( $cat->term_id ) . '" name="king_post_category[]" value="' . esc_attr( $cat->term_id ) . '" ' . esc_attr( $checked ) . ' /><label for="king_post_cat-' . esc_attr( $cat->term_id ) . '">' . esc_attr( $cat->name ) . '</label></li>';
								endif;
							} elseif ( $format === 'image' ) {
								$catsfor = get_field( 'category_for', $cat );
								if ( $catsfor && in_array( 'for_image', $catsfor, true ) || ! $catsfor ) :
									$checked = '';
									if ( in_array( $cat->term_id, $post_cats_arr ) ) {
										$checked = 'checked';
									}
									echo '<li class="form-categories-item"><input type="checkbox" id="king_post_cat-' . esc_attr( $cat->term_id ) . '" name="king_post_category[]" value="' . esc_attr( $cat->term_id ) . '" ' . esc_attr( $checked ) . ' /><label for="king_post_cat-' . esc_attr( $cat->term_id ) . '">' . esc_attr( $cat->name ) . '</label></li>';
								endif;
							} elseif ( $format === 'video' ) {
								$catsfor = get_field( 'category_for', $cat );
								if ( $catsfor && in_array( 'for_video', $catsfor, true ) || ! $catsfor ) :
									$checked = '';
									if ( in_array( $cat->term_id, $post_cats_arr ) ) {
										$checked = 'checked';
									}
									echo '<li class="form-categories-item"><input type="checkbox" id="king_post_cat-' . esc_attr( $cat->term_id ) . '" name="king_post_category[]" value="' . esc_attr( $cat->term_id ) . '" ' . esc_attr( $checked ) . ' /><label for="king_post_cat-' . esc_attr( $cat->term_id ) . '">' . esc_attr( $cat->name ) . '</label></li>';
								endif;
							} elseif ( $format === 'audio' ) {
								$catsfor = get_field( 'category_for', $cat );
								if ( $catsfor && in_array( 'for_music', $catsfor, true ) || ! $catsfor ) :
									$checked = '';
									if ( in_array( $cat->term_id, $post_cats_arr ) ) {
										$checked = 'checked';
									}
									echo '<li class="form-categories-item"><input type="checkbox" id="king_post_cat-' . esc_attr( $cat->term_id ) . '" name="king_post_category[]" value="' . esc_attr( $cat->term_id ) . '" ' . esc_attr( $checked ) . ' /><label for="king_post_cat-' . esc_attr( $cat->term_id ) . '">' . esc_attr( $cat->name ) . '</label></li>';
								endif;

							} elseif ( 'list' === get_post_type( $postid ) ) {
								$catsfor = get_field( 'category_for', $cat );
								if ( $catsfor && in_array( 'for_list', $catsfor, true ) || ! $catsfor ) :
									$checked = '';
									if ( in_array( $cat->term_id, $post_cats_arr ) ) {
										$checked = 'checked';
									}
									echo '<li class="form-categories-item"><input type="checkbox" id="king_post_cat-' . esc_attr( $cat->term_id ) . '" name="king_post_category[]" value="' . esc_attr( $cat->term_id ) . '" ' . esc_attr( $checked ) . ' /><label for="king_post_cat-' . esc_attr( $cat->term_id ) . '">' . esc_attr( $cat->name ) . '</label></li>';
								endif;
							}
						}
						?>
					</ul>
				</div>
			<?php endif; ?>			
			<div class="king-form-group">
				<label for="king_post_content"><?php esc_html_e( 'Content', 'king' ); ?></label>
				<div class="tinymce" id="king_post_content"><?php echo( wp_kses_post( html_entity_decode( $content ) ) ); ?></div>
			</div>
			<?php if ( isset( $king_submit_errors['content_empty'] ) ) : ?>
				<div class="king-error"><?php echo esc_attr( $king_submit_errors['content_empty'] ); ?></div>
			<?php endif; ?>			
			<?php
			if ( ( $format === 'quote' && get_field( 'news_list_items', $postid ) ) || 'list' === get_post_type( $postid ) ) {
				acf_form(
					array(
						'post_id'      => $postid,
						'form'         => false,
						'return'       => '',
						'uploader'     => false,
						'field_groups' => array( 'group_58bddb03a9046' ),
					)
				);
			} elseif ( $format === 'image' ) {
				acf_form(
					array(
						'post_id'      => $postid,
						'form'         => false,
						'return'       => '',
						'uploader'     => false,
						'field_groups' => array( 'group_60ae46c60a552' ),
					)
				);
			} elseif ( $format === 'video' || $format === 'audio' ) {
				?>
			<div class="king-repeater">
				<?php
				acf_form(
					array(
						'post_id'  => $postid,
						'form'     => false,
						'return'   => '',
						'uploader' => false,
						'fields'   => array( 'field_58f533f201eee', 'field_587be2665e807', 'field_58f5335001eed', 'field_58f5594a975cb', 'field_59c9812458fe6' ),
					)
				);
				if ( ! get_field( 'disable_creating_playlist', 'options' ) ) {
					acf_form(
						array(
							'post_id'  => $postid,
							'form'     => false,
							'return'   => '',
							'uploader' => false,
							'fields'   => array( 'field_5ee7d2907603a' ),
						)
					);
				}
				?>
			</div>
			<?php } ?>
			<?php if ( ( $format === 'video' || $format === 'audio' ) && isset( $king_submit_errors['videourl_empty'] ) ) : ?>
				<div class="king-error"><?php echo esc_attr( $king_submit_errors['videourl_empty'] ); ?></div>
			<?php endif; ?> 			
				<div class="king-form-group">
					<label for="king_post_tags"><?php esc_html_e( 'Tags', 'king' ); ?></label>
					<input class="form-control bpinput" name="king_post_tags" id="king_post_tags" type="text" value="<?php echo esc_attr( $tags ); ?>" />
				</div>
				<span class="help-block"><?php esc_html_e( 'Separate each tag by comma. (tag1, tag2, tag3)', 'king' ); ?></span>
			</div>
			<div class="submit-news-right">
			<div class="submit-news-right-fixed">
			<?php if ( $format !== 'video' ) : ?>
				<div class="acf-field acf-field-image acf-field-58f5594a975cb" style="width: 100%; min-height: 210px;" data-name="_thumbnail_id" data-type="image" data-key="field_58f5594a975cb" data-width="50">
					<div class="acf-input">
						<div class="acf-image-uploader acf-cf has-value" data-preview_size="medium" data-library="uploadedTo" data-mime_types="jpg, png, gif, jpeg" data-uploader="wp">
							<input name="acf[field_58f5594a975cb]" value="<?php echo esc_attr( $post_thumb ); ?>" type="hidden">	<div class="view show-if-value acf-soh" style="width: 100%;">
							<img data-name="image" src="<?php echo esc_url( $post_thumb_url ); ?>">
							<ul class="acf-hl acf-soh-target">
								<li><a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit"></a></li>
								<li><a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove"></a></li>
							</ul>
						</div>
						<div class="view hide-if-value inputprev-span">
							<a data-name="add" class="acf-button button featured-image-upload" href="#"><?php esc_html_e( 'Add Image', 'king' ); ?></a>
						</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
				<button class="king-submit-button"  type="submit" value="send" id="king-submitbutton" name="king-editpost"><?php esc_html_e( 'Update Post', 'king' ); ?></button>
				<?php if ( current_user_can( 'edit_post', $postid ) && get_field( 'allow_users_to_delete_their_posts', 'option' ) ) : ?>
				<button class="king-submit-button king-delete-post" type="submit" value="delete" id="king-submitbutton" name="king-editpost"><?php esc_html_e( 'Delete Post', 'king' ); ?></button>
				<?php endif; ?>
			</div>	
			</div>
			<?php echo wp_nonce_field( 'king_edit_post_upload_form', 'king_edit_post_upload_form_submitted', true, false ); ?>
		</form>	

	</main><!-- #main -->
</div><!-- #primary -->
<?php wp_enqueue_media(); ?>
<?php endif; ?>
<?php get_footer(); ?>

<?php elseif ($gid) : ?>
<?php
if ( get_field( 'enable_lightbox_gallery', 'option' ) ) {
	get_template_part( 'template-parts/post-templates/single-parts/gallery' );
}
?>
<?php endif; ?>


