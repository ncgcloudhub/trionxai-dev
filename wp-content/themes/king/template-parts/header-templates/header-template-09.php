<?php
/**
 * The header template-06.
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
<div id="page" class="site header-template-09">
	<?php get_template_part( 'template-parts/header-templates/header-parts/headerstrip' ); ?>
	<header id="masthead" class="site-header">
		<div class="king-header header-09 lr-padding">
			<div class="king-leftmenu-toggle-v2" id="t09-toggle" aria-toggle="false" role="button"><span class="leftmenu-toggle-line"></span></div>	
			<?php get_template_part( 'template-parts/header-templates/header-parts/logo' ); ?>
			<?php get_template_part( 'template-parts/header-templates/header-parts/search' ); ?>
			<div class="king-header-right no-back">
				<?php get_template_part( 'template-parts/header-templates/header-parts/extraicons' ); ?>
				<?php
				if ( get_field( 'enable_bookmarks', 'options' ) && is_user_logged_in() ) :
					echo king_header_bookmark();
				endif;
				?>
				<?php get_template_part( 'template-parts/header-templates/header-parts/notify' ); ?>
				<?php get_template_part( 'template-parts/header-templates/header-parts/submit' ); ?>
				<?php get_template_part( 'template-parts/header-templates/header-parts/user' ); ?>
			</div>
	</div><!-- .king-header -->
	<?php get_template_part( 'template-parts/header-templates/header-parts/leftmenu' ); ?>
	</header><!-- #masthead -->
