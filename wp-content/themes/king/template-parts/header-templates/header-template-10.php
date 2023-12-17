<?php
/**
 * The header template-04.
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
global $hide;
?>
<div id="page" class="site header-template-10">
<?php get_template_part( 'template-parts/header-templates/header-parts/headerstrip' ); ?>

<header id="masthead" class="site-header">
	<div class="king-header header-10 lr-padding">
		<?php get_template_part( 'template-parts/header-templates/header-parts/logo' ); ?>
		<div class="header-10-toggle" data-toggle="dropdown" data-target=".king-leftmenu" aria-expanded="false" role="button"><i class="fa-solid fa-bars"></i></div>
		<?php get_template_part( 'template-parts/header-templates/header-parts/search' ); ?>
		<div class="king-header-right no-radi">
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
</header><!-- #masthead -->
<?php get_template_part( 'template-parts/header-templates/header-parts/leftmenu' ); ?>