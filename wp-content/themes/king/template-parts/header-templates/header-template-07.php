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
<div id="page" class="site header-template-07">
	<?php get_template_part( 'template-parts/header-templates/header-parts/headerstrip' ); ?>
	<div class="king-top-header top-header-07 lr-padding">
		<div class="king-top-header-menu">
			<?php wp_nav_menu( array( 'theme_location' => 'top-header-menu' ) ); ?>
		</div>
		<div class="king-top-header-icons">
			<?php
			$group     = get_field( 'header_03_options', 'options' );
			$repeaters = $group['top_header_right_icons'];
			if ( $repeaters ) :
				foreach ( $repeaters as $repeater ) {
					echo '<a href="' . esc_url( $repeater['link_url'] ) . '" >' . wp_kses_post( $repeater['icon_code'] ) . '</a>';
				}
			endif;
			?>
		</div>
	</div><!-- .king-top-header -->
	<header id="masthead" class="site-header">
		<div class="king-header header-07 lr-padding">
			<?php get_template_part( 'template-parts/header-templates/header-parts/logo' ); ?>
			<?php get_template_part( 'template-parts/header-templates/header-parts/search' ); ?>
			<div class="king-h07-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
			</div>
		</div><!-- .king-header -->
		

	</header><!-- #masthead -->
	<div class="king-bottom-header lr-padding">
		<div class="king-leftmenu-toggle-v2" data-toggle="dropdown" data-target=".king-leftmenu" aria-expanded="false" role="button"><span class="leftmenu-toggle-line"></span></div>
		<?php
			$args['dots'] = false;
			get_template_part( 'template-parts/header-templates/header-parts/headnav', null, $args );
			?>
		<div class="king-header-right no-back">
			<?php get_template_part( 'template-parts/header-templates/header-parts/extraicons' ); ?>
			<?php
			if ( get_field( 'enable_bookmarks', 'options' ) && is_user_logged_in() ) :
				echo king_header_bookmark();
			endif;
			?>
			<?php get_template_part( 'template-parts/header-templates/header-parts/notify' ); ?>
			<?php if ( get_field( 'disable_users_submit', 'options' ) !== true ) : ?>
			<?php get_template_part( 'template-parts/header-templates/header-parts/submit' ); ?>
		<?php endif; ?>	
			
			<?php get_template_part( 'template-parts/header-templates/header-parts/user' ); ?>
		</div>
	</div><!-- .king-top-header -->
	<?php get_template_part( 'template-parts/header-templates/header-parts/leftmenu' ); ?>