<?php
/**
 * Submit news page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $king_submit_errors;
$GLOBALS['hide'] = 'hide';

if ( isset( $_POST['king_post_upload_form_submitted'] ) && wp_verify_nonce( $_POST['king_post_upload_form_submitted'], 'king_post_upload_form' ) ) {

	$title    = ( isset( $_POST['king_post_title'] ) && $_POST['king_post_title'] ) ? htmlspecialchars( $_POST['king_post_title'] ) : '';
	$tags     = sanitize_text_field( $_POST['king_post_tags'] );
	$content  = stripslashes( $_POST['king_post_content'] );
	$category = isset( $_POST['king_post_category'] )?$_POST['king_post_category']:'';

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

	// title must be set.
	if ( trim( $title ) === '' ) {
		$king_submit_errors['title_empty'] = esc_html__( 'Title is required.', 'king' );
	} elseif ( strlen( $title ) > $title_length ) {
		$king_submit_errors['title_empty'] = esc_html__( 'Title is too long.', 'king' );
	}

	// Content must be set.
	if ( trim( $content ) === '' ) {
		$king_submit_errors['content_empty'] = esc_html__( 'Content is required.', 'king' );
	} elseif ( strlen( $content ) > $content_length ) {
		$king_submit_errors['content_empty'] = esc_html__( 'Content is too long.', 'king' );
	}

	if ( empty( $king_submit_errors ) ) {

		switch ( $_POST['submit_type'] ) {
			case 'send':
				if ( is_super_admin() ) {
					$poststatus = 'publish';
				} elseif ( get_field( 'verified_posts', 'option' ) === true && get_field( 'verified_account', 'user_' . get_current_user_id() ) ) {
					$poststatus = 'publish';
				} elseif ( get_field( 'disable_post_moderation', 'option' ) ) {
					$poststatus = 'publish';
				} elseif ( get_field( 'enable_user_groups', 'options' ) && king_groups_permissions( 'groups_create_posts_without_approval' ) && get_field( 'groups_create_posts_without_approval', 'options' ) ) {
					$poststatus = 'publish';
				} else {
					$poststatus = 'pending';
				}
				break;
			case 'save':
				$poststatus = 'draft';
				break;
		}

		if ( 'list' === get_query_var( 'template' ) ) {
			$posttype = 'list';
		} elseif ( 'poll' === get_query_var( 'template' ) ) {
			$posttype = 'poll';
		} elseif ( 'trivia' === get_query_var( 'template' ) ) {
			$posttype = 'trivia';
		} elseif ( 'link' === get_query_var( 'template' ) ) {
			$posttype = 'post';
		} else {
			$posttype = 'post';
		}
		$postid = wp_insert_post(
			array(
				'post_title'    => wp_strip_all_tags( $title ),
				'post_content'  => $content,
				'tags_input'    => $tags,
				'post_category' => $category,
				'post_status'   => $poststatus,
				'post_author'   => get_current_user_id(),
				'post_type'     => $posttype,
			)
		);
		if ( '' === get_query_var( 'template' ) ) {
			$tagg = 'post-format-quote';
			wp_set_post_terms( $postid, $tagg, 'post_format' );
		} elseif ( 'link' === get_query_var( 'template' ) ) {
			$tagg = 'post-format-link';
			wp_set_post_terms( $postid, $tagg, 'post_format' );
		}

		if ( isset( $_POST['linkurl'] ) ) {
			$linkurl = $_POST['linkurl'];
			update_field( 'ad_link', $linkurl, $postid );
			update_post_meta( $postid, '_ad_link', 'field_5a568932429f7' );

			
			$ar = isset( $_POST['afregu'] ) ? $_POST['afregu'] : '' ;
			update_field( 'regular_price', $ar, $postid );
			update_post_meta( $postid, '_regular_price', 'field_63c1339acf1c4' );
			
			$as = isset( $_POST['afsale'] ) ? $_POST['afsale'] : '' ;
			update_field( 'sale_price', $as, $postid );
			update_post_meta( $postid, '_sale_price', 'field_63c1347acf1c5' );

			update_field( 'enable_affiliate', true, $postid );
			update_post_meta( $postid, '_enable_affiliate', 'field_63c1335bcf1c3' );
		}
		if ( isset( $_POST['king_nsfw'] ) ) {
			$king_nsfw = '1';
			update_field( 'nsfw_post', $king_nsfw, $postid );
			update_post_meta( $postid, '_nsfw_post', 'field_57d041d6ab8e2' );
		}
		do_action( 'acf/save_post', $postid );

		if ( $postid ) {
			$permalink = get_permalink( $postid );
			wp_safe_redirect( $permalink );
			exit;
		}
	}
}
if ( 'link' === get_query_var( 'template' ) ) :
	require_once KING_INCLUDES_PATH . 'videothumbs.php';
	$link = isset($_POST['kinglink']) ? $_POST['kinglink'] : '';
	$out = king_get_title($link);
	$_POST['king_post_title'] = isset($out['title']) ? $out['title'] : '';
	$_POST['king_post_content'] = isset($out['desc']) ? $out['desc'] : '';
	$thumb = isset($out['thumb']) ? $out['thumb'] : '';
	$thumbid = isset($out['thumbid']) ? $out['thumbid'] : '';
endif;

?>
<?php
acf_form_head();
get_header();
?>
<header class="page-top-header">
	<h1 class="page-title">
		<?php
		if ( 'list' === get_query_var( 'template' ) ) :
			echo esc_html_e( 'Submit List', 'king' );
		elseif ( 'poll' === get_query_var( 'template' ) ) :
			echo esc_html_e( 'Submit Poll', 'king' );
		elseif ( 'trivia' === get_query_var( 'template' ) ) :
			echo esc_html_e( 'Submit Trivia Quiz', 'king' );
		elseif ( 'link' === get_query_var( 'template' ) ) :
			echo esc_html_e( 'Submit Link', 'king' );
		else :
			echo esc_html_e( 'Submit News', 'king' );
		endif;
		?>
	</h1>
</header><!-- .page-header -->

<?php get_template_part( 'template-parts/king-header-nav' ); ?>

<?php if ( ! is_user_logged_in() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to create a post !', 'king' ); ?>
	<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>" class="king-alert-button"><?php esc_html_e( 'Log in ', 'king' ); ?></a>
	<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_register'] ); ?>"><?php esc_html_e( 'Register', 'king' ); ?></a>
</div>
<?php elseif ( '' === get_query_var( 'template' ) && get_field( 'disable_news', 'options' ) !== false || get_field( 'disable_users_submit', 'options' ) !== false ) : ?>
<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to view this page!', 'king' ); ?></div>
<?php elseif ( ( 'list' === get_query_var( 'template' ) && get_field( 'disable_list', 'options' ) ) || ( 'poll' === get_query_var( 'template' ) && get_field( 'disable_polls', 'options' ) ) || ( 'trivia' === get_query_var( 'template' ) && get_field( 'disable_trivia', 'options' ) ) || ( 'link' === get_query_var( 'template' ) && get_field( 'disable_link', 'options' ) ) ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to view this page!', 'king' ); ?></div>
<?php elseif ( get_field( 'only_verified', 'options' ) === true && ! get_field( 'verified_account', 'user_' . get_current_user_id() ) && ! is_super_admin() ) : ?>  
<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to view this page!', 'king' ); ?></div>
<?php elseif ( get_field( 'enable_user_groups', 'options' ) && ! king_groups_permissions( 'groups_create_posts' ) && ! is_super_admin() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to view this page!', 'king' ); ?></div>
<?php else : ?>
	<!-- #primary BEGIN -->
	<div id="primary" class="page-content-area">
		<main id="main" class="page-news-main">
			<form id="king_posts_form" action="" method="POST" enctype="multipart/form-data">
				<div class="submit-news-left">
					<?php if ( get_field( 'custom_message_news', 'options' ) ) : ?>
						<div class="king-message-submit">
							<?php the_field( 'custom_message_news', 'options' ); ?>
						</div>
					<?php endif; ?>
					<div class="king-form-group">
						<label for="king_post_title"><?php esc_html_e( 'Title', 'king' ); ?></label>
						<input class="form-control bpinput" name="king_post_title" id="king_post_title" type="text" value="<?php echo esc_attr( isset( $_POST['king_post_title'] ) ? $_POST['king_post_title'] : '' ); ?>" maxlength="<?php the_field( 'maximum_title_length', 'option' ); ?>" required/>
					</div>
					<?php if ( isset( $king_submit_errors['title_empty'] ) ) : ?>
						<div class="king-error"><?php echo esc_attr( $king_submit_errors['title_empty'] ); ?></div>
					<?php endif; ?>

					<?php
					$include    = array();
					$categories = get_terms(
						'category',
						array(
							'include'    => $include,
							'hide_empty' => false,
						)
					);

					$categories_count = count( $categories );
					if ( $categories_count > 1 ) :
						?>
						<div class="king-form-group form-categories">
							<span class="form-label"><?php esc_html_e( 'Select Category', 'king' ); ?></span>

							<ul>
								<?php
								if ( 'list' === get_query_var( 'template' ) ) :
									$for = 'for_list';
								elseif ( 'poll' === get_query_var( 'template' ) ) :
									$for = 'for_poll';
								elseif ( 'trivia' === get_query_var( 'template' ) ) :
									$for = 'for_trivia';
								elseif ( 'link' === get_query_var( 'template' ) ) :
									$for = 'for_link';
								else :
									$for = 'for_news';
								endif;
								foreach ( $categories as $cat ) {
									if ( $cat->parent == 0 ) {
										$catsfor = get_field( 'category_for', $cat );
										if ( $catsfor && in_array( $for, $catsfor, true ) || ! $catsfor ) :
											echo '<li class="form-categories-item"><input type="checkbox" id="king_post_cat-' . esc_attr( $cat->term_id ) . '" name="king_post_category[]" value="' . esc_attr( $cat->term_id ) . '" /><label for="king_post_cat-' . esc_attr( $cat->term_id ) . '">' . esc_attr( $cat->name ) . '</label></li>';
										endif;
										foreach ( $categories as $subcategory ) {
											if ( $subcategory->parent == $cat->term_id ) {
												$scatsfor = get_field( 'category_for', $subcategory );
												if ( $scatsfor && in_array( $for, $scatsfor, true ) || ! $scatsfor ) :
													echo '<li class="form-categories-item"><input type="checkbox" id="king_post_cat-' . esc_attr( $subcategory->term_id ) . '" name="king_post_category[]" value="' . esc_attr( $subcategory->term_id ) . '" /><label class="king-post-subcat" for="king_post_cat-' . esc_attr( $subcategory->term_id ) . '">' . esc_attr( $subcategory->name ) . '</label></li>';
												endif;
											}
										}
									}
								}
								?>
							</ul>
						</div>
					<?php endif; ?>
					<div class="king-form-group">
						<?php 
						if ( get_field( 'enable_ai', 'options' ) ) :
							$use = get_field('use_in_these_pages', 'options');
							$gai = get_query_var( 'template' );
							$for = false;
							if ( 'list' === $gai && in_array( $gai, $use ) ) :
								$for = true;
							elseif ( 'poll' === $gai && in_array( $gai, $use ) ) :
								$for = true;
							elseif ( 'trivia' === $gai && in_array( $gai, $use ) ) :
								$for = true;
							elseif ( '' === $gai && in_array( 'news', $use ) ) :
								$for = true;
							endif;
							if ( $for ) :
							?>
						<?php get_template_part( 'template-parts/pages/king-ai' ); ?>
						<?php endif; ?>
						<?php endif; ?>
						<label for="king_post_content"><?php esc_html_e( 'Content', 'king' ); ?></label>
						<div class="tinymce" id="king_post_content"><?php echo wp_kses_post( isset( $_POST['king_post_content'] ) ? $_POST['king_post_content'] : '' ); ?></div>
					</div>
					<?php if ( isset( $king_submit_errors['content_empty'] ) ) : ?>
						<div class="king-error"><?php echo esc_attr( $king_submit_errors['content_empty'] ); ?></div>
					<?php endif; ?>

					<?php
					if ( 'list' === get_query_var( 'template' ) ) :
						get_template_part( 'template-parts/pages/king-submit-list' );
					elseif ( 'poll' === get_query_var( 'template' ) ) :
						get_template_part( 'template-parts/pages/king-submit-poll' );
					elseif ( 'trivia' === get_query_var( 'template' ) ) :
						get_template_part( 'template-parts/pages/king-submit-trivia' );
					elseif ( 'link' === get_query_var('template') ) :
						?>
						<div class="king-form-group">
							<label for="acf-field_5a568932429f7"><i class="fa-solid fa-link"></i> <?php esc_html_e( 'Link', 'king' ); ?></label>
							<input type="url" class="bpinput" name="linkurl" value="<?php echo esc_attr( isset( $link ) ? $link : '' ); ?>" readonly="readonly"/>
						</div>

						<?php if ( get_field( 'enable_affiliate_links', 'options' ) ) : ?>
							<div class="king-form-group">
								<label for="acf-field_5a568932429f7"><i class="fa-solid fa-money-check-dollar"></i> <?php esc_html_e( 'Regular Price ($)', 'king' ); ?></label>
								<input type="number" class="bpinput" name="afregu" placeholder="19.99" min="0"/>
							</div>
							<div class="king-form-group">
								<label for="acf-field_5a568932429f7"><i class="fa-solid fa-money-check-dollar"></i> <?php esc_html_e( 'Sale Price ($)', 'king' ); ?></label>
								<input type="number" class="bpinput" name="afsale" placeholder="9.99" min="0"/>
							</div>
						<?php endif; ?>
					<?php endif; ?>


								<div class="king-form-group">
									<label for="king_post_tags"><?php esc_html_e( 'Tags', 'king' ); ?></label>
									<input class="form-control bpinput" name="king_post_tags" id="king_post_tags" type="text" value="<?php echo esc_attr( isset( $_POST['king_post_tags'] ) ? $_POST['king_post_tags'] : '' ); ?>"  autocomplete="off" />
								</div>
								<span class="help-block"><?php esc_html_e( 'Separate each tag by comma. (tag1, tag2, tag3)', 'king' ) ?></span>

							</div>
							<div class="submit-news-right">
								<div class="submit-news-right-fixed">
									<div class="king-form-group">
										<div class="acf-field acf-field-image acf-field-58f5594a975cb" data-name="_thumbnail_id" data-type="image" data-key="field_58f5594a975cb">
											<div class="acf-input">
												<div class="acf-image-uploader <?php echo esc_attr( ! empty( $thumbid ) ? 'has-value' : '' ); ?>" data-preview_size="medium" data-library="uploadedTo" data-mime_types="jpg, png, gif, jpeg, webp" data-uploader="wp">
													<input type="hidden" name="acf[field_58f5594a975cb]" value="<?php echo esc_attr( ! empty( $thumbid ) ? $thumbid : '' ); ?>" required="required">
													<div class="show-if-value image-wrap" style="width: 100%;">
														<img src="<?php echo esc_attr( isset( $thumb ) ? $thumb : '' ); ?>" alt="" data-name="image" style="width: 100%;border-radius: 10px;">
															<div class="acf-actions -hover">
																<a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit"></a>
																<a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove"></a>
															</div>
													</div>
												<div class="hide-if-value inputprev-span">
													<a data-name="add" class="acf-button button featured-image-upload" href="#"><?php esc_html_e( 'Select thumbnail', 'king' ); ?></a>
												</div>
												</div>
											</div>
										</div>
									</div>
									<?php if ( get_field( 'enable_nsfw', 'options' ) ) : ?>
										<div class="king-nsfw">
											<input id="king_nsfw" type="checkbox" name="king_nsfw" value="0">
											<label for="king_nsfw"><?php esc_html_e( 'This post is Not Safe for Work', 'king' ) ?></label>
										</div>
									<?php endif; ?>
									<button class="king-submit-button" data-loading-text="<?php esc_html_e( 'Loading...', 'king' ) ?>" type="submit" value="send" name="submit_type" id="submit-loading"><?php esc_html_e( 'Submit Post', 'king' ); ?></button>
									<?php if ( get_field( 'enable_save_posts', 'options' ) ) : ?>
										<button class="king-submit-button" data-loading-text="<?php esc_html_e( 'Loading...', 'king' ) ?>" name="submit_type" type="submit" id="submit-loading2" value="save"><?php esc_html_e( 'Save', 'king' ); ?></button>
									<?php endif; ?>							
									<?php echo wp_nonce_field( 'king_post_upload_form', 'king_post_upload_form_submitted', true, false ); ?>
								</div>
							</div>
						</form>
					</main><!-- #main -->
				</div><!-- #primary -->

			<?php endif; ?>
			<?php wp_enqueue_media(); ?>
			<?php get_footer(); ?>
