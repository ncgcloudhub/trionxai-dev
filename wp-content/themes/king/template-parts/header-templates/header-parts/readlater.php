<?php
/**
 * Bookmark modal content.
 *
 * This is the header template part.
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
<?php if ( get_field( 'enable_bookmarks', 'options' ) ) : ?>
<div class="king-modal-login modal" id="rlatermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="king-modal-content">
		<button type="button" class="king-modal-close" data-dismiss="modal" aria-label="Close"><i class="icon fa fa-fw fa-times"></i></button>
		<h3><i class="fas fa-bookmark"></i> <?php echo esc_html_e( 'My Bookmarks', 'king' ); ?></h3>
		<ul id="king-rlater-inside"><span class="king-rlater-center"><div class="loader"></div></span></ul>
	</div>
</div>
<?php endif; ?>
<?php if ( ! get_field( 'disable_link', 'options' ) ) : ?>
<div class="king-modal-login modal" id="addlink" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="king-modal-content">
        <button type="button" class="king-modal-close" data-dismiss="modal" aria-label="Close"><i class="icon fa fa-fw fa-times"></i></button>
        <h3><i class="fa-brands fa-hubspot"></i> <?php echo esc_html_e( 'Add Link', 'king' ); ?></h3>
        <form method="post" action="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_snews'] . '/link' ); ?>" class="addlinkin">
           
            <div class="king-form-group">
                 <input type="url" name="kinglink" class="bpinput" maxlength="150" placeholder="<?php echo esc_html_e( 'Paste url here.', 'king' ); ?>" required="required"/>
            </div>
            <button type="submit" class="king-submit-button"><?php echo esc_html_e( 'Add Link', 'king' ); ?></button>
        </form>
        
    </div>
</div>
<?php endif; ?>