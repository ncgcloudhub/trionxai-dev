<?php
/**
 * Submit Image Page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide'] = 'hide';
global $king_submit_errors;

if ( isset( $_POST['king_post_upload_form_submitted'] ) && wp_verify_nonce( $_POST['king_post_upload_form_submitted'], 'king_post_upload_form' ) ) {
	$title              = sanitize_text_field( $_POST['king_post_title'] );
	$thumb              = sanitize_text_field( $_POST['acf']['field_611ba9d3a8ba9'] );
	$king_submit_errors = array();

	if ( get_field( 'maximum_title_length', 'option' ) ) {
		$title_length = get_field( 'maximum_title_length', 'option' );
	} else {
		$title_length = '140';
	}

	if ( trim( $title ) === '' ) {
		$king_submit_errors['title_empty'] = esc_html__( 'Title is required.', 'king' );
	} elseif ( strlen( $title ) > $title_length ) {
		$king_submit_errors['title_empty'] = esc_html__( 'Title is too long.', 'king' );
	}
	if ( is_super_admin() ) {
		$poststatus = 'publish';
	} elseif ( get_field( 'moderate_stories', 'option' ) ) {
		$poststatus = 'pending';
	} else {
		$poststatus = 'publish';
	}

	if ( empty( $king_submit_errors ) ) {
		$postid = wp_insert_post(
			array(
				'post_title'  => wp_strip_all_tags( $title ),
				'post_status' => $poststatus,
				'post_author' => get_current_user_id(),
				'post_type'   => 'stories',
			)
		);

		if ( isset( $_POST['storyjs'] ) ) {
			foreach ( $_POST['storyjs'] as $row => $value ) {
				$product  = $_POST['storyjs'][$row];
				$content  = sanitize_text_field( $product );
				$storytag = 'king_story_' . $row;
				add_post_meta( $postid, $storytag, $content );
			}
		}

		set_post_thumbnail( $postid, $thumb );

		do_action( 'acf/save_post', $postid );

		if ( $postid ) {
			$permalink = get_post_type_archive_link( 'stories' );
			wp_safe_redirect( $permalink );
			exit;
		}
	}
}

?>

<?php
acf_form_head();
get_header();
?>
<?php $GLOBALS['hide'] = 'hide';?>
<header class="page-top-header">
	<h1 class="page-title"><?php echo esc_html_e( 'Create Story', 'king' ); ?></h1>
</header><!-- .page-header -->


<?php if ( ! is_user_logged_in() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to create a post !', 'king' ); ?>
	<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>" class="king-alert-button"><?php esc_html_e( 'Log in ', 'king' ); ?></a>
	<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_register'] ); ?>"><?php esc_html_e( 'Register', 'king' ); ?></a>
</div>

<?php elseif ( ! get_field( 'enable_stories', 'options' ) ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i>
		<?php esc_html_e( 'You do not have permission to view this page!', 'king' ); ?></div>
<?php elseif ( get_field( 'only_verified', 'options' ) === true && ! get_field( 'verified_account', 'user_' . get_current_user_id() ) && ! is_super_admin() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to view this page!', 'king' );?></div>
<?php elseif ( get_field( 'enable_user_groups', 'options' ) && ! king_groups_permissions( 'groups_create_posts' ) && ! is_super_admin() ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i><?php esc_html_e( 'You do not have permission to view this page!', 'king' ); ?></div>
<?php else : ?>
	<!-- #primary BEGIN -->
	<div id="primary" class="page-content-area king-story-page">
		<div id="controls" class="story-add">
			<div id="addcanvas" class="controls-item"><i class="fas fa-plus"></i></div>
			<span onclick="changeView('canvas1', this);" id="sc-canvas1" class="controls-item sactive"><i class="far fa-id-badge"></i></span>
		</div>
		<form id="king_posts_form" action="" method="POST" enctype="multipart/form-data">
			<div class="king-story-block" id="stblock">

				<div id="story-canvas1" class="king-story-box boxactive">
					<canvas id="canvas1"></canvas>
					<textarea id="text-canvas1" name="storyjs[]" class="hide"></textarea>
				</div>

			</div>
			<div id="storycontrol" class="story-control">
				<div class="king-form-group">
					<label for="king_post_title"><?php esc_html_e( 'Title', 'king' ); ?></label>
					<input class="form-control bpinput" name="king_post_title" id="king_post_title" type="text" value="<?php echo esc_attr( isset( $_POST['king_post_title'] ) ? $_POST['king_post_title'] : '' ); ?>" maxlength="<?php the_field( 'maximum_title_length', 'option' );?>" required />
				</div>
				<?php
				if ( isset( $king_submit_errors['title_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_submit_errors['title_empty'] ); ?></div>
				<?php endif; ?>
				<div class="inside acf-fields king-storyacf king-repeater">
					<ul class="poll-radio storytabs">
						<li class="active"><label href="#storyimg" data-toggle="tab"><i class="fas fa-camera"></i></label></li>
						<li><label href="#storyvideo" data-toggle="tab"><i class="fas fa-play"></i></label></li>
						<li><label href="#storytext" data-toggle="tab"><i class="fas fa-heading"></i></label></li>
						<?php if ( ! get_field( 'disable_adding_links', 'options' ) ) : ?>
						<li><label href="#storylink" data-toggle="tab"><i class="fas fa-link"></i></label></li>
						<?php endif; ?>
						<li><label id="clear"><i class="fas fa-trash-alt"></i></label></li>
					</ul>

					<div class="acf-field acf-field-image acf-field-611ba9d3a8ba9 storytab active" data-key="field_611ba9d3a8ba9" data-name="_thumbnail_id" data-type="image" id="storyimg">
						<div class="acf-input">
							<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="jpg, png, jpeg, gif, mp4" data-preview_size="large" data-uploader="wp">
								<input name="acf[field_611ba9d3a8ba9]" type="hidden" value="" id="simge">
								<div class="show-if-value image-wrap">
									<a class="story-addbutton" id="saddimg" title="Add"><i class="fas fa-arrow-left"></i></a>
									<img alt="" data-name="image" id="simg" src="" style="max-height: 100px;">
									<div class="acf-actions -hover">
										<a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit">
										</a>
										<a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove">
										</a>
									</div>
								</img>
							</div>
							<div class="hide-if-value">
								<p>
									<a class="acf-button button" data-name="add" href="#">
										<?php echo esc_html_e( 'Add Image', 'king' ); ?>
									</a>
								</p>
							</div>
						</input>
					</div>
				</div>
			</div>
			<div class="acf-field acf-field-file acf-field-61151c458953f storytab" data-key="field_61151c458953f" data-name="story_video" data-type="file" hidden="" style="min-height: 90px;" id="storyvideo">
				<div class="acf-input">
					<div class="acf-file-uploader" data-library="uploadedTo" data-mime_types="mp4" data-uploader="wp">
						<input data-name="id" disabled="" name="acf[field_61151c458953f]" type="hidden" value="">
						<div class="show-if-value file-wrap">
							<a class="story-addbutton" id="saddvid" title="Add"><i class="fas fa-arrow-left"></i></a>
							<div class="file-info">
								<a data-name="filename" href="" id="svid"></a>
							</div>
							<div class="acf-actions -hover">
								<a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit">
								</a>
								<a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove">
								</a>
							</div>
						</div>
						<div class="hide-if-value">

							<p>
								<a class="acf-button button" data-name="add" href="#">
									<?php echo esc_html_e( 'Add File', 'king' ); ?>
								</a>
							</p>
						</div>
					</input>
				</div>
			</div>
		</div>
		<div class="storytab" id="storytext">
			<div id="storyh1" class="story-button"><i class="fas fa-heading"></i><?php esc_html_e( 'Add Text', 'king' ); ?></div>
			<div id="storyalign">
				<div class="text-align story-options">
					<p>
					<span onclick="textAlign('left')"><i class="fas fa-align-left"></i></span>
					<span onclick="textAlign('center')"><i class="fas fa-align-center"></i></span>
					<span onclick="textAlign('right')"><i class="fas fa-align-right"></i></span>
					<span onclick="textAlign('justify')"><i class="fas fa-align-justify"></i></span>
					</p>
					<p>
						<span onclick="textStyle('style1')"><i class="fas fa-heading"></i></span>
						<span onclick="textStyle('style2')" class="sstyle2"><i class="fas fa-h-square"></i></span>
						<span onclick="textStyle('style3')"><i class="fas fa-h-square"></i></span>
					</p>
					<p>
						<span onclick="textfamily('\'Amatic SC\', cursive')" style="font-family: 'Amatic SC', cursive;">Aa</span>
						<span onclick="textfamily('\'Monoton\', cursive')" style="font-family: 'Monoton', cursive;">Aa</span>
						<span onclick="textfamily('\'Meow Script\', cursive')" style="font-family: 'Meow Script', cursive;">Aa</span>
						<span onclick="textfamily('\'Shadows Into Light\', cursive')" style="font-family: 'Shadows Into Light', cursive;">Aa</span>
						<span onclick="textfamily('\'Rubik Beastly\', cursive')" style="font-family: 'Rubik Beastly', cursive;">Aa</span>
						<span onclick="textfamily('\'Ubuntu\', sans-serif')" style="font-family: 'Ubuntu', sans-serif;">Aa</span>
					</p>
				</div>
				<div class="sfont-size story-options">
					<i class="fas fa-font"></i><input type="range" id="sfonts" name="vol" min="9" max="80"><i class="fas fa-font fa-2x"></i>
				</div>
			</div>
		</div>
		<?php if ( ! get_field( 'disable_adding_links', 'options' ) ) : ?>
			<div class="storytab" id="storylink">
				<div class="story-button"><i class="fas fa-arrow-left" id="saddurl"></i><input class="sinput" id="slinki" type="text" value="" maxlength="240" placeholder="<?php esc_html_e( 'URL here', 'king' ); ?>" /></div>
			</div>
		<?php endif; ?>
	</div>
	<div id="styleZone" class="story-options"></div>
	<button class="king-submit-button" data-loading-text="<?php esc_html_e( 'Loading...', 'king' ); ?>" type="submit" value="send" name="submit_type" id="submit-loading"><?php esc_html_e( 'Create Story', 'king' ); ?></button>
	<?php echo wp_nonce_field( 'king_post_upload_form', 'king_post_upload_form_submitted', true, false ); ?>
</div>
</form>
</div><!-- .main-column -->
<?php endif; ?>
<?php wp_enqueue_media(); ?>
<?php get_footer(); ?>
