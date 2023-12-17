<?php
/**
 * The header template-05.
 *
 * This is the header template.
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
<div id="page" class="site header-template-05">
<?php get_template_part( 'template-parts/header-templates/header-parts/headerstrip' ); ?>
<header id="masthead" class="site-header">
	<div class="king-header header-05">
		<span class="king-leftmenu-toggle" data-toggle="dropdown" data-target=".king-leftmenu" aria-expanded="false" role="button">
		</span>	
		<?php get_template_part( 'template-parts/header-templates/header-parts/logo' ); ?>

		<?php get_template_part( 'template-parts/header-templates/header-parts/user' ); ?>
		<?php if ( get_field( 'disable_users_submit', 'options' ) !== true ) : ?>
			<?php if ( get_option( 'permalink_structure' ) ) : ?>
				<div class="king-submit-v2-open"  data-toggle="modal" data-target="#submitmodal" role="button"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></div>
			<?php endif; ?>
		<?php endif; ?>				
		<?php get_template_part( 'template-parts/header-templates/header-parts/notify' ); ?>
		<?php
		if ( get_field( 'enable_bookmarks', 'options' ) && is_user_logged_in() ) :
			echo king_header_bookmark();
		endif;
		?>
		<div id="searchv2-button"><i class="fa fa-search fa-lg" aria-hidden="true"></i></div>
		<?php get_template_part( 'template-parts/header-templates/header-parts/extraicons' ); ?>
	</div><!-- .king-header -->
	<?php get_template_part( 'template-parts/header-templates/header-parts/submit-v2' ); ?>
	<?php get_template_part( 'template-parts/header-templates/header-parts/search-v2' ); ?>
</header><!-- #masthead -->
<?php get_template_part( 'template-parts/header-templates/header-parts/leftmenu' ); ?>