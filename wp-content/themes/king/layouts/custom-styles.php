<?php
/**
 * Custom css Option.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
/* Typography
--------------------------*/
<?php if ( ! get_field( 'disable_custom_css', 'option' ) ) : ?>
/* ------CustomCSS------ */
<?php if ( get_field( 'custom_css', 'option' ) ) : ?>
<?php the_field( 'custom_css', 'option' ); ?>
<?php endif; ?>
/* ------body------ */
<?php if ( get_field( 'body_background', 'option' ) || get_field( 'google_fonts', 'option' ) ) : ?>
body {
<?php if ( get_field( 'body_background', 'option' ) ) : ?>
background-color:<?php the_field( 'body_background', 'option' ); ?>;<?php endif; ?>	
		<?php
		if ( get_field( 'google_fonts', 'option' ) ) :
			$fonts       = get_field_object( 'google_fonts', 'option' );
			$value       = $fonts['value'];
			$font_family = $fonts['choices'][ $value ];
			?>
	font-family: '<?php echo esc_attr( $font_family ); ?>', sans-serif;
<?php endif; ?>	
}
<?php endif; ?>
<?php if ( get_field( 'page_link_hover_color', 'option' ) ) : ?>
a:hover, 
.king-head-nav a:hover, 
.owl-prev:hover, 
.owl-next:hover {
	color:<?php the_field( 'page_link_hover_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'post_background', 'option' ) ) : ?>
article.hentry {
	background-color:<?php the_field( 'post_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'page_link_color', 'option' ) ) : ?>
a, 
.king-order-nav ul li .active, 
.king-order-nav ul li a:hover {
	color:<?php the_field( 'page_link_color', 'option' ); ?>;
}
.king-order-nav ul li .active:after, 
.king-order-nav ul li a:hover:after {
	border-color: <?php the_field( 'page_link_color', 'option' ); ?>;
}
.king-categories-head a {
	color: <?php the_field( 'page_link_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'posts_meta_color', 'option' ) ) : ?>	
article.hentry .entry-meta {
	color:<?php the_field( 'posts_meta_color', 'option' ); ?>!important;
}
<?php endif; ?>
<?php if ( get_field( 'posts_meta_background', 'option' ) ) : ?>
article.hentry .entry-meta {
	background-color:<?php the_field( 'posts_meta_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'load_more_background', 'option' ) ) : ?>
.ias-trigger-next {
<?php if ( get_field( 'load_more_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'load_more_background', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'load_more_button_text_color', 'option' ) ) : ?>
.ias-trigger a {
<?php if ( get_field( 'load_more_button_text_color', 'option' ) ) : ?>
	color:<?php the_field( 'load_more_button_text_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'button_colors', 'option' ) || get_field( 'button_text_color', 'option' ) ) : ?>
button,
input[type="button"],
input[type="reset"],
input[type="submit"],
.king-alert-button {
<?php if ( get_field( 'button_colors', 'option' ) ) : ?>
	background-color:<?php the_field( 'button_colors', 'option' ); ?>;
	border-color:<?php the_field( 'button_colors', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'button_text_color', 'option' ) ) : ?>
	color:<?php the_field( 'button_text_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'follow_button_background', 'option' ) ) : ?>
.user-follow-button a {
	background-color:<?php the_field( 'follow_button_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'follow_button_text_color', 'option' ) ) : ?>
.user-follow-button .sl-count, .user-follow-button i {
	color:<?php the_field( 'follow_button_text_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'post_entry_content_color', 'option' ) ) : ?>
article .entry-content, .king-profile-sidebar {
	color:<?php the_field( 'post_entry_content_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'post_title_color', 'option' ) ) : ?>
article.hentry .entry-title a {
	color:<?php the_field( 'post_title_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_nsfw', 'option' ) ) : ?>
.nsfw-post, .nsfw, .nsfw-post-page, .nsfw-post-simple {
	background-color:<?php the_field( 'color_for_nsfw', 'option' ); ?>;
}
<?php endif; ?>
/* ------header------ */
<?php if ( get_field( 'headerstrip_background', 'option' ) || get_field( 'headerstrip_text_color', 'option' ) ) : ?>
.king-headerstrip {
<?php if ( get_field( 'headerstrip_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'headerstrip_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'headerstrip_text_color', 'option' ) ) : ?>
	color:<?php the_field( 'headerstrip_text_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'headerstrip_background', 'option' ) || get_field( 'headerstrip_button_color', 'option' ) ) : ?>
.king-hs-button {
<?php if ( get_field( 'headerstrip_button_color', 'option' ) ) : ?>
	background-color:<?php the_field( 'headerstrip_button_color', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'headerstrip_background', 'option' ) ) : ?>
	color:<?php the_field( 'headerstrip_background', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'headerstrip_button_color', 'option' ) ) : ?>
.king-hs-close {
	color:<?php the_field( 'headerstrip_button_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'buttons_hover_background', 'option' ) ) : ?>
.king-login-buttons a:hover {
	background-color:<?php the_field( 'buttons_hover_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'header_background', 'option' ) ) : ?>
.king-header, .king-search-top .active {
	background-color:<?php the_field( 'header_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'navigation_background', 'option' ) ) : ?>
.main-navigation, .main-navigation ul ul, .main-navigation ul ul ul {
	background-color:<?php the_field( 'navigation_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'header_menu_background_color', 'option' ) ) : ?>
.king-cat-list {
	background-color:<?php the_field( 'header_menu_background_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'header_menu_link_colors', 'option' ) ) : ?>
.king-cat-list li a {
	color:<?php the_field( 'header_menu_link_colors', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'header_menu_link_hover_colors', 'option' ) ) : ?>
.king-cat-list li a:hover {
	color:<?php the_field( 'header_menu_link_hover_colors', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'header_link_color', 'option' ) ) : ?>
.king-head-nav a, .king-cat-dots, .search-close, .king-head-nav .king-head-nav-a {
	color:<?php the_field( 'header_link_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'header_search_background', 'option' ) ) : ?>
.king-search-top .header-search-form {
	background-color:<?php the_field( 'header_search_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'small_navigation_background', 'option' ) ) : ?>
.king-3rd-nav span {
	background-color:<?php the_field( 'small_navigation_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'small_navigation_links', 'option' ) ) : ?>
.king-3rd-nav a {
	color:<?php the_field( 'small_navigation_links', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'small_navigation_links_hover', 'option' ) ) : ?>
.king-3rd-nav .active, .king-3rd-nav a:hover {
	background-color:<?php the_field( 'small_navigation_links_hover', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_news', 'option' ) ) : ?>
.term-post-format-quote .page-top-header {
	background-color:<?php the_field( 'color_for_news', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_news', 'option' ) ) : ?>
.nav-news i{
	color:<?php the_field( 'color_for_news', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_videos', 'option' ) ) : ?>
.term-post-format-video .page-top-header {
	background-color:<?php the_field( 'color_for_videos', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_videos', 'option' ) ) : ?>
.nav-video i {
	color:<?php the_field( 'color_for_videos', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_images', 'option' ) ) : ?>
.term-post-format-image .page-top-header {
	background-color:<?php the_field( 'color_for_images', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_images', 'option' ) ) : ?>
.nav-image i{
	color:<?php the_field( 'color_for_images', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_music', 'option' ) ) : ?>
.term-post-format-audio .page-top-header {
	background-color:<?php the_field( 'color_for_music', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_music', 'option' ) ) : ?>
.nav-music i {
	color:<?php the_field( 'color_for_music', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_list', 'option' ) ) : ?>
.post-type-archive-list .page-top-header {
	background-color:<?php the_field( 'color_for_list', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_list', 'option' ) ) : ?>
.nav-list i {
	color:<?php the_field( 'color_for_list', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_poll', 'option' ) ) : ?>
.post-type-archive-poll .page-top-header {
	background-color:<?php the_field( 'color_for_poll', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_poll', 'option' ) ) : ?>
.nav-poll i {
	color:<?php the_field( 'color_for_poll', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_trivia_quiz', 'option' ) ) : ?>
.post-type-archive-trivia .page-top-header {
	background-color:<?php the_field( 'color_for_trivia_quiz', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'color_for_trivia_quiz', 'option' ) ) : ?>
.nav-trivia i {
	color:<?php the_field( 'color_for_trivia_quiz', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'submit_background', 'option' ) ) : ?>
.king-submit-open, .king-submit-drop {
	background-color:<?php the_field( 'submit_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'submit_background', 'option' ) ) : ?>
.king-submit-drop:before{
	border-bottom-color:<?php the_field( 'submit_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'submit_background', 'option' ) ) : ?>
.king-submit.open .king-submit-open {
	box-shadow: 0px 0px 2px 5px <?php the_field( 'submit_background', 'option' ); ?>50;
}
<?php endif; ?>
<?php if ( get_field( 'submiticon_color', 'option' ) ) : ?>	
.king-submit-open, .king-submit-buttons li a i {
	color:<?php the_field( 'submiticon_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'submit_button_link_colors', 'option' ) ) : ?>
.king-submit-buttons li a {
	color:<?php the_field( 'submit_button_link_colors', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'notification_icon_background', 'option' ) || get_field( 'notification_icon_color', 'option' ) ) : ?>
.king-notify-toggle {
<?php if ( get_field( 'notification_icon_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'notification_icon_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'notification_icon_color', 'option' ) ) : ?>	
	color:<?php the_field( 'notification_icon_color', 'option' ); ?>;<?php endif; ?>	
}
<?php endif; ?>
<?php if ( get_field( 'notification_box_background', 'option' ) ) : ?>
.king-notify-menu {
	background-color:<?php the_field( 'notification_box_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'notification_box_background', 'option' ) ) : ?>
.king-notify-menu:before {
	border-bottom-color:<?php the_field( 'notification_box_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'notification_box_inside_background', 'option' ) ) : ?>
.king-notify-inside {
	background-color:<?php the_field( 'notification_box_inside_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'notifications_text_color', 'option' ) ) : ?>
.king-notify-inside li a, 
.king-notify-inside li {
	color:<?php the_field( 'notifications_text_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'user_points_badge_background', 'option' ) || get_field( 'user_points_badge_color', 'option' ) ) : ?>
.king-points {
<?php if ( get_field( 'user_points_badge_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'user_points_badge_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'user_points_badge_color', 'option' ) ) : ?>	
	color:<?php the_field( 'user_points_badge_color', 'option' ); ?>;<?php endif; ?>	
}
<?php endif; ?>
<?php if ( get_field( 'navigation_links', 'option' ) ) : ?>
.header-nav a {
	color:<?php the_field( 'navigation_links', 'option' ); ?>;	
}
.king-switch .btn-default label {
	color:<?php the_field( 'navigation_links', 'option' ); ?>;	
}
<?php endif; ?>
<?php if ( get_field( 'navigation_links_active', 'option' ) ) : ?>
.header-nav .current-menu-item:before {
	background-color: <?php the_field( 'navigation_links_active', 'option' ); ?>;
}
.header-nav .current-menu-item a {
	color: <?php the_field( 'navigation_links_active', 'option' ); ?>;
}
.header-nav a:after {
	background-color: <?php the_field( 'navigation_links_active', 'option' ); ?>;
}
.header-nav a:hover {
	color: <?php the_field( 'navigation_links_active', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'slider_height', 'option' ) ) : ?>
.king-featured,
.king-featured .featured-posts,
.king-featured-4,
.king-featured-4 .featured-posts>a,
.king-featured-5,
.king-featured-5 .featured-posts,
.featured-video video {
	height:<?php the_field( 'slider_height', 'option' ); ?>px;
}

.featured-thumbs {
	height:<?php the_field( 'slider_height', 'option' ); ?>px;
}
<?php endif; ?>
<?php if ( get_field( 'grid_height', 'option' ) ) : $gridh = get_field( 'grid_height', 'option' ); ?>
.king-featured-grid {
	height:<?php echo esc_attr( $gridh ); ?>px;
	grid-auto-rows: <?php echo esc_attr( $gridh / 2 ); ?>px;
}
.king-featured-grid.grid-template-7 {
	height:auto;
	grid-auto-rows: <?php echo esc_attr( $gridh / 6 ); ?>px;
}
<?php endif; ?>
<?php if ( get_field( 'display_mini_slider', 'option' ) ) : ?>
<?php if ( get_field( 'mini_slider_post_height', 'option' ) ) : ?>
.editorschoice-height {
	height:<?php the_field( 'mini_slider_post_height', 'option' ); ?>px;
}
.editorschoice-height-up {
	min-height:<?php the_field( 'mini_slider_post_height', 'option' ); ?>px;
}
<?php endif; ?>
<?php if ( get_field( 'mini_slider_paddings', 'option' ) ) : ?>
.king-editorschoice {
	padding:0 <?php the_field( 'mini_slider_paddings', 'option' ); ?>px;
}
<?php endif; ?>
<?php endif; ?>
<?php if ( get_field( 'page_header_background', 'option' ) || get_field( 'page_header_text_color', 'option' ) ) : ?>
.page-top-header {
<?php if ( get_field( 'page_header_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'page_header_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'page_header_text_color', 'option' ) ) : ?>	
	color:<?php the_field( 'page_header_text_color', 'option' ); ?>;<?php endif; ?>	
}
<?php endif; ?>
<?php if ( get_field( 'login_and_register_buttons_background', 'option' ) ) : ?>
.king-login-buttons a {
	background-color:<?php the_field( 'login_and_register_buttons_background', 'option' ); ?>;
}
<?php endif; ?>
<?php $hero = get_field( 'header_03_options', 'options' );
	if ( isset( $hero['background1'] ) ) :
?>
.king-top-header {
	background-color: <?php echo esc_attr( $hero['background1'] ); ?>;
	background: -moz-linear-gradient(left, <?php echo esc_attr( $hero['background1'] ); ?> 0%, <?php echo esc_attr( $hero['background2'] ); ?> 100%);
	background: -webkit-linear-gradient(left, <?php echo esc_attr( $hero['background1'] ); ?> 0%, <?php echo esc_attr( $hero['background2'] ); ?> 100%);
	background: linear-gradient(to right, <?php echo esc_attr( $hero['background1'] ); ?> 0%, <?php echo esc_attr( $hero['background2'] ); ?> 100%);
}
.king-top-header-menu ul ul {
	background-color: <?php echo esc_attr( $hero['background1'] ); ?>;
}
<?php endif; ?>
<?php if ( isset( $hero['font_color'] ) ) : ?>
.king-top-header-menu a {
	color: <?php echo esc_attr( $hero['font_color'] ); ?>;
}
.king-top-header-menu .menu-item-has-children:after {
	color: <?php echo esc_attr( $hero['font_color'] ); ?>;
}
.king-top-header-icons a {
	color: <?php echo esc_attr( $hero['font_color'] ); ?>;
	border-color: <?php echo esc_attr( $hero['font_color'] ); ?>;
}
<?php endif; ?>
<?php if ( isset( $hero['second_header_background'] ) ) : ?>
.king-bottom-header {
	background-color: <?php echo esc_attr( $hero['second_header_background'] ); ?>;
}
<?php endif; ?>
<?php if ( isset( $hero['second_header_links'] ) ) : ?>
.king-bottom-header .king-head-nav .king-head-nav-a,
.king-bottom-header .king-head-eicons,
.king-bottom-header .king-rlater,
.king-bottom-header .king-notify-toggle,
.king-bottom-header .king-head-nav-a:hover {
	color: <?php echo esc_attr( $hero['second_header_links'] ); ?>;
}
.king-bottom-header .king-leftmenu-toggle-v2:before, 
.king-bottom-header .king-leftmenu-toggle-v2:after, 
.king-bottom-header .leftmenu-toggle-line {
	background-color: <?php echo esc_attr( $hero['second_header_links'] ); ?>;
}
<?php endif; ?>
<?php
	$leftmenu = get_field( 'header_09_options', 'options' );
	if ( $leftmenu['left_menu_background'] ) :
?>
.king-leftmenu {
	background-color: <?php echo esc_attr( $leftmenu['left_menu_background'] ); ?>;
}
<?php endif; ?>
<?php if ( $leftmenu['left_menu_links_color'] ) : ?>
.king-leftmenu a {
	color: <?php echo esc_attr( $leftmenu['left_menu_links_color'] ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'gallery_background', 'option' ) || get_field( 'gallery_text_color', 'option' ) ) : ?>
.king-gallery-container {
<?php if ( get_field( 'gallery_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'gallery_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'gallery_text_color', 'option' ) ) : ?>	
	color:<?php the_field( 'gallery_text_color', 'option' ); ?>;<?php endif; ?>	
}
<?php endif; ?>
<?php if ( get_field( 'bookmarks_icon_background', 'option' ) || get_field( 'bookmarks_icon_color', 'option' ) ) : ?>
.king-rlater {
<?php if ( get_field( 'bookmarks_icon_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'bookmarks_icon_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'bookmarks_icon_color', 'option' ) ) : ?>	
	color:<?php the_field( 'bookmarks_icon_color', 'option' ); ?>;<?php endif; ?>	
}
<?php endif; ?>
<?php if ( get_field( 'search_v2_button_background', 'option' ) || get_field( 'search_v2_icon_color', 'option' ) ) : ?>
#searchv2-button {
<?php if ( get_field( 'search_v2_button_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'search_v2_button_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'search_v2_icon_color', 'option' ) ) : ?>	
	color:<?php the_field( 'search_v2_icon_color', 'option' ); ?>;<?php endif; ?>	
}
<?php endif; ?>
<?php if ( get_field( 'search_v2_box_background', 'option' ) ) : ?>
.live-king-search-top {
	background-color: <?php the_field( 'search_v2_box_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'search_v2_input_background', 'option' ) ) : ?>
.live-king-search {
	background-color: <?php the_field( 'search_v2_input_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'padding_between_posts', 'option' ) || '0' === get_field( 'padding_between_posts', 'option' ) ) : ?>
.king-grid-10 .king-post-item,
.king-grid-17 .king-post-item {
	padding-left: <?php the_field( 'padding_between_posts', 'option' ); ?>px;
	padding-right: <?php the_field( 'padding_between_posts', 'option' ); ?>px;
	padding-bottom: <?php $n = get_field( 'padding_between_posts', 'option' ); $nx = $n * 2; echo esc_attr( $nx ); ?>px;
}
.king-grid-10 .king-posts,
.king-grid-17 .king-posts {
	margin-left: -<?php the_field( 'padding_between_posts', 'option' ); ?>px;
	margin-right: -<?php the_field( 'padding_between_posts', 'option' ); ?>px;
}
<?php endif; ?>
<?php if ( get_field( 'border_radius_of_posts', 'option' ) || '0' === get_field( 'border_radius_of_posts', 'option' ) ) : ?>
.king-grid-10 .site-main-top .entry-image-link {
	border-radius: <?php the_field( 'border_radius_of_posts', 'option' ); ?>px;
}
.king-grid-17 .entry-image {
	border-radius: <?php the_field( 'border_radius_of_posts', 'option' ); ?>px <?php the_field( 'border_radius_of_posts', 'option' ); ?>px 0 0;
}
.king-grid-10 article.hentry,
.king-grid-17 article.hentry {
	border-radius: <?php the_field( 'border_radius_of_posts', 'option' ); ?>px;
}
<?php endif; ?>
<?php if ( get_field( 'padding_between_grid_posts', 'option' )|| '0' === get_field( 'padding_between_grid_posts', 'option' ) ) : ?>
.king-featured-grid {
	column-gap: <?php the_field( 'padding_between_grid_posts', 'option' ); ?>px;
	row-gap: <?php the_field( 'padding_between_grid_posts', 'option' ); ?>px;
}
<?php endif; ?>
<?php if ( get_field( 'border_radius_of_grid_posts', 'option' ) || '0' === get_field( 'border_radius_of_grid_posts', 'option' ) ) : ?>
.king-featured-grid .featured-posts > a {
	border-radius: <?php the_field( 'border_radius_of_grid_posts', 'option' ); ?>px;
}
<?php endif; ?>
/* ------footer------ */
<?php if ( get_field( 'footer_background', 'option' ) || get_field( 'footer_text_color', 'option' ) ) : ?>
.site-footer {
<?php if ( get_field( 'footer_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'footer_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'footer_text_color', 'option' ) ) : ?>	
	color:<?php the_field( 'footer_text_color', 'option' ); ?>;<?php endif; ?>	
}
<?php endif; ?>
<?php if ( get_field( 'fatfooter_background', 'option' ) ) : ?>
.fatfooter {
	background-color:<?php the_field( 'fatfooter_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'footer_widgets_title_background', 'option' ) || get_field( 'footer_widgets_title_color', 'option' ) ) : ?>
.fatfooter .widget-title {
<?php if ( get_field( 'footer_widgets_title_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'footer_widgets_title_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'footer_widgets_title_color', 'option' ) ) : ?>	
	color:<?php the_field( 'footer_widgets_title_color', 'option' ); ?>;
	border-color:<?php the_field( 'footer_widgets_title_color', 'option' ); ?>;<?php endif; ?>		
}
<?php endif; ?>
<?php if ( get_field( 'footer_link_color', 'option' ) ) : ?>
.site-footer a {
	color:<?php the_field( 'footer_link_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'footer_links_hover', 'option' ) ) : ?>
.site-footer a:hover {
	color:<?php the_field( 'footer_links_hover', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'alert_background_color', 'option' ) || get_field( 'alert_text_color', 'option' ) ) : ?>
.king-alert-like {
<?php if ( get_field( 'alert_text_color', 'option' ) ) : ?>
	color:<?php the_field( 'alert_text_color', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'alert_background_color', 'option' ) ) : ?>
	background-color:<?php the_field( 'alert_background_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
/* ------sidebar------ */
<?php if ( get_field( 'sidebar_text_color', 'option' ) ) : ?>
.first-sidebar ul li {
	color:<?php the_field( 'sidebar_text_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'sidebar_links', 'option' ) ) : ?>
.first-sidebar ul li a {
	color:<?php the_field( 'sidebar_links', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'sidebar_widgets_title_background', 'option' ) || get_field( 'sidebar_widgets_title_color', 'option' ) ) : ?>
.widget-title, .king-related .related-title, .widget-title i {
<?php if ( get_field( 'sidebar_widgets_title_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'sidebar_widgets_title_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'sidebar_widgets_title_color', 'option' ) ) : ?>	
	color:<?php the_field( 'sidebar_widgets_title_color', 'option' ); ?>;<?php endif; ?>	
}
<?php endif; ?>
<?php if ( get_field( 'sidebar_posts_background', 'option' ) ) : ?>
.king-simple-post {
	background-color:<?php the_field( 'sidebar_posts_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'sidebar_widgets_post_meta_text_color', 'option' ) ) : ?>	
.entry-meta .post-views, .entry-meta .post-comments, .entry-meta .post-likes, .entry-meta .post-time,
.entry-meta .post-views i, .entry-meta .post-comments i, .entry-meta .post-time i, .entry-meta .post-likes i {
	color:<?php the_field( 'sidebar_widgets_post_meta_text_color', 'option' ); ?>!important;
}
<?php endif; ?>
/* ------PostPage------ */
<?php if ( get_field( 'font_size_in_post_page', 'option' ) ) : ?>
.post-page .hentry {
	font-size:<?php the_field( 'font_size_in_post_page', 'option' ); ?>px;
	line-height:<?php $fsize = get_field( 'font_size_in_post_page', 'option' ); echo esc_attr( $fsize + 10 ); ?>px;
}
<?php endif; ?>
<?php if ( get_field( 'post_content_background_color', 'option' ) || get_field( 'post_content_text_color', 'option' ) ) : ?>
.post-page .hentry {
<?php if ( get_field( 'post_content_background_color', 'option' ) ) : ?>
	background-color:<?php the_field( 'post_content_background_color', 'option' ); ?>;<?php endif; ?>
	<?php if ( get_field( 'post_content_text_color', 'option' ) ) : ?>	
	color:<?php the_field( 'post_content_text_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'post_content_text_color', 'option' ) ) : ?>
.tags-links a {
	color:<?php the_field( 'post_content_text_color', 'option' ); ?>;
	border-color: <?php the_field( 'post_content_text_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'post_author_box_background', 'option' ) || get_field( 'post_author_box_text_color', 'option' ) ) : ?>
.post-author {
<?php if ( get_field( 'post_author_box_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'post_author_box_background', 'option' ); ?>;<?php endif; ?>
	<?php if ( get_field( 'post_author_box_text_color', 'option' ) ) : ?>	
	color:<?php the_field( 'post_author_box_text_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'post_author_box_text_color', 'option' ) ) : ?>
.post-author-name {
	color:<?php the_field( 'post_author_box_text_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'post_meta_background', 'option' ) ) : ?>
.single-post .post-meta {
	background-color:<?php the_field( 'post_meta_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'post_meta_text_color', 'option' ) ) : ?>	
.single-post .post-views, .single-post .post-comments, .single-post .post-time, .single-post .post-likes,
.single-post .post-views i, .single-post .post-comments i, .single-post .post-time i, .single-post .post-likes i {
	color:<?php the_field( 'post_meta_text_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'editors_choice_badge_background', 'option' ) || get_field( 'editors_choice_badge_text', 'option' )  ) : ?>
.editors-badge {
<?php if ( get_field( 'editors_choice_badge_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'editors_choice_badge_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'editors_choice_badge_text', 'option' ) ) : ?>
	color:<?php the_field( 'editors_choice_badge_text', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'post_like_button_background', 'option' ) || get_field( 'post_like_button_icon_color', 'option' ) ) : ?>
.king-like {
<?php if ( get_field( 'post_like_button_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'post_like_button_background', 'option' ); ?>;
	border-color:<?php the_field( 'post_like_button_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'post_like_button_icon_color', 'option' ) ) : ?>
	color:<?php the_field( 'post_like_button_icon_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'post_bookmark_button_background', 'option' ) || get_field( 'post_bookmark_button_icon_color', 'option' ) ) : ?>
.king-ft-link {
<?php if ( get_field( 'post_bookmark_button_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'post_bookmark_button_background', 'option' ); ?>;
	border-color:<?php the_field( 'post_bookmark_button_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'post_bookmark_button_icon_color', 'option' ) ) : ?>
	color:<?php the_field( 'post_bookmark_button_icon_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'poll_results_background_color', 'option' ) ) : ?>
.voted .king-poll-result {
	background-color: <?php the_field( 'poll_results_background_color', 'option' ); ?>;
	opacity:.6;
}
<?php endif; ?>
<?php if ( get_field( 'poll_user_choice_background', 'option' ) ) : ?>
.king-poll-answer.vote {
	border-color: <?php the_field( 'poll_user_choice_background', 'option' ); ?>;
}
.voted .king-poll-answer.vote .king-poll-result {
	background-color: <?php the_field( 'poll_user_choice_background', 'option' ); ?>;
	opacity:.6;
}
<?php endif; ?>
<?php if ( get_field( 'triviaquiz_correct_answer_background', 'option' ) ) : ?>
.king-quiz-answer.correct .king-poll-answer-in {
	background-color: <?php the_field( 'triviaquiz_correct_answer_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'triviaquiz_wrong_answer_background', 'option' ) ) : ?>
.king-quiz-answer.not-correct .king-poll-answer-in {
	background-color: <?php the_field( 'triviaquiz_wrong_answer_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'post_share_button_background', 'option' ) || get_field( 'post_share_button_icon_color', 'option' ) ) : ?>
.king-share-dropdown {
<?php if ( get_field( 'post_share_button_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'post_share_button_background', 'option' ); ?>;
	border-color:<?php the_field( 'post_share_button_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'post_share_button_icon_color', 'option' ) ) : ?>
	color:<?php the_field( 'post_share_button_icon_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'vote_count_background', 'option' ) || get_field( 'vote_count_text_color', 'option' ) ) : ?>
.post-page .hentry .king-vote-count {
<?php if ( get_field( 'vote_count_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'vote_count_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'vote_count_text_color', 'option' ) ) : ?>
	color:<?php the_field( 'vote_count_text_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'vote_icons_color', 'option' ) ) : ?>
.king-vote-icon {
	color:<?php the_field( 'vote_icons_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'next-prev_posts_bars_background', 'option' ) ) : ?>
.post-nav-np {
	background-color:<?php the_field( 'next-prev_posts_bars_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'next-prev_posts_bars_text_color', 'option' ) ) : ?>
.post-nav-np a {
	color:<?php the_field( 'next-prev_posts_bars_text_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'comments_area_background_color', 'option' ) ) : ?>
.comments-area {
	background-color:<?php the_field( 'comments_area_background_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'comment_box_background', 'option' ) || get_field( 'comment_box_text_color', 'option' ) ) : ?>
#comments .comment-box, #comments .comments-title {
<?php if ( get_field( 'comment_box_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'comment_box_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'comment_box_text_color', 'option' ) ) : ?>
	color:<?php the_field( 'comment_box_text_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'comment_box_text_color', 'option' ) ) : ?>
#comments .user-header-settings cite, .comment-meta time {
	color:<?php the_field( 'comment_box_text_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'comments_reply_button_background', 'option' ) || get_field( 'comments_reply_button_value_color', 'option' ) ) : ?>
.comment-reply-link {
<?php if ( get_field( 'comments_reply_button_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'comments_reply_button_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'comments_reply_button_value_color', 'option' ) ) : ?>
	color:<?php the_field( 'comments_reply_button_value_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'comment_form_background', 'option' ) || get_field( 'comment_form_text_color', 'option' ) ) : ?>
.comment-respond {
<?php if ( get_field( 'comment_form_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'comment_form_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'comment_form_text_color', 'option' ) ) : ?>
	color:<?php the_field( 'comment_form_text_color', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'post_page_boxes_background', 'option' ) ) : ?>
.single-boxes {
	background-color: <?php the_field( 'post_page_boxes_background', 'option' ); ?>;
}	
<?php endif; ?>
<?php if ( get_field( 'post_page_boxes_title_background', 'option' ) ) : ?>
.single-boxes-title {
	background-color: <?php the_field( 'post_page_boxes_title_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'post_page_boxes_title_color', 'option' ) ) : ?>
.single-boxes-title h4 {
	color: <?php the_field( 'post_page_boxes_title_color', 'option' ); ?>;
}
<?php endif; ?>
/* ------KingflixPage------ */
<?php if ( get_field( 'kingflix_categories_title_color', 'option' ) ) : ?>
.kingflix-head a {
	color:<?php the_field( 'kingflix_categories_title_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'kingflix_posts_background', 'option' ) ) : ?>
.kingflix-post-content {
	background-color:<?php the_field( 'kingflix_posts_background', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'kingflix_posts_title_color', 'option' ) ) : ?>
.kingflix-post-title a,
.king-editorschoice-title {
	color:<?php the_field( 'kingflix_posts_title_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'kingflix_post_buttons_colors', 'option' ) ) : ?>
.kingflix-button {
	color:<?php the_field( 'kingflix_post_buttons_colors', 'option' ); ?>;
	border-color:<?php the_field( 'kingflix_post_buttons_colors', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'kingflix_post_meta_color', 'option' ) ) : ?>
.kingflix-post-in .cat-links a {
	color:<?php the_field( 'kingflix_post_meta_color', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'quick_view_background', 'option' ) || get_field( 'quick_view_post_content', 'option' ) ) : ?>
.mfp-content {
<?php if ( get_field( 'quick_view_background', 'option' ) ) : ?>
	background-color:<?php the_field( 'quick_view_background', 'option' ); ?>;<?php endif; ?>
<?php if ( get_field( 'quick_view_post_content', 'option' ) ) : ?>
	color:<?php the_field( 'quick_view_post_content', 'option' ); ?>;<?php endif; ?>
}
<?php endif; ?>
<?php if ( get_field( 'quick_view_post_title', 'option' ) ) : ?>
.mfp-content .entry-header {
	color:<?php the_field( 'quick_view_post_title', 'option' ); ?>;
}
<?php endif; ?>
<?php if ( get_field( 'quick_view_widget_title', 'option' ) ) : ?>
.mfp-content .king-related .related-title {
	color:<?php the_field( 'quick_view_widget_title', 'option' ); ?>;
}
<?php endif; ?>

<?php else : ?> 
<?php if ( get_field( 'google_fonts', 'options' ) ) : ?>
body {
<?php if ( get_field( 'google_fonts','options' ) ) :
	$fonts = get_field_object( 'google_fonts', 'options' );
	$value = $fonts['value'];
	$font_family = $fonts['choices'][ $value ];
?>
	font-family: '<?php echo esc_attr( $font_family ); ?>', sans-serif;<?php endif; ?>	
}
<?php endif; ?>
<?php if ( get_field( 'slider_height', 'option' ) ) : ?>
.king-featured, .king-featured .featured-posts {
	height:<?php the_field( 'slider_height', 'option' ); ?>px;
}
<?php endif; ?>
<?php endif; ?>
<?php if ( get_field( '1st_reaction', 'option' ) ) : ?>
.king-reactions ul li:first-child label:before,
.king-reaction-like {
	background-image: url(<?php the_field( '1st_reaction', 'option' ); ?>);
}
<?php endif; ?>
<?php if ( get_field( '2nd_reaction', 'option' ) ) : ?>
.king-reactions ul li:nth-child(2) label:before,
.king-reaction-love {
	background-image: url(<?php the_field( '2nd_reaction', 'option' ); ?>);
}
<?php endif; ?>
<?php if ( get_field( '3rd_reaction', 'option' ) ) : ?>
.king-reactions ul li:nth-child(3) label:before,
.king-reaction-haha {
	background-image: url(<?php the_field( '3rd_reaction', 'option' ); ?>);
}
<?php endif; ?>
<?php if ( get_field( '4th_reaction', 'option' ) ) : ?>
.king-reactions ul li:nth-child(4) label:before,
.king-reaction-wow {
	background-image: url(<?php the_field( '4th_reaction', 'option' ); ?>);
}
<?php endif; ?>
<?php if ( get_field( '5th_reaction', 'option' ) ) : ?>
.king-reactions ul li:nth-child(5) label:before,
.king-reaction-sad {
	background-image: url(<?php the_field( '5th_reaction', 'option' ); ?>);
}
<?php endif; ?>
<?php if ( get_field( '6th_reaction', 'option' ) ) : ?>
.king-reactions ul li:nth-child(6) label:before,
.king-reaction-angry {
	background-image: url(<?php the_field( '6th_reaction', 'option' ); ?>);
}
<?php endif; ?>
<?php
if ( get_field( 'default_avatar', 'options' ) ) :
	$avatar = get_field( 'default_avatar', 'options' );
	?>
.user-header-noavatar,
.king-notify-avatar-img,
.no-avatar,
.users-avatar .users-noavatar,
.king-dashboard-avatar,
.king-inbox-avatar,
.card-noavatar,
.king-leaderboard .lb-avatar,
.content-author-noavatar,
.king-lf-links .users-noavatar {
	background-image: url(<?php echo esc_url( $avatar['sizes']['thumbnail'] ); ?>);
	background-size: cover;
}
<?php endif; ?>
<?php
if ( get_field( 'enable_user_badges', 'option' ) ) :
	if ( have_rows( 'king_badges', 'option' ) ) :
		while ( have_rows( 'king_badges', 'option' ) ) :
			the_row();
			$badge_img  = get_sub_field( 'badge_icon' );
			$badge_ttle = get_sub_field( 'badge_title' );
			$badge_ttle = trim( str_replace( ' ', '_', $badge_ttle ) );
			if ( get_row_layout() == 'badges_for_points' ) :
?>
.king-profile-badge .<?php echo esc_attr( $badge_ttle ); ?> {
	background-image: url(<?php echo esc_url( $badge_img ); ?>);
}
<?php elseif ( get_row_layout() == 'badges_for_followers' ) : ?>
.king-profile-badge .<?php echo esc_attr( $badge_ttle ); ?> {
	background-image: url(<?php echo esc_url( $badge_img ); ?>);
}
<?php elseif ( get_row_layout() == 'badges_for_posts' ) : ?>
.king-profile-badge .<?php echo esc_attr( $badge_ttle ); ?> {
	background-image: url(<?php echo esc_url( $badge_img ); ?>);
}
<?php elseif ( get_row_layout() == 'badges_for_comments' ) : ?>
.king-profile-badge .<?php echo esc_attr( $badge_ttle ); ?> {
	background-image: url(<?php echo esc_url( $badge_img ); ?>);
}
<?php elseif ( get_row_layout() == 'badges_for_likes' ) : ?>
.king-profile-badge .<?php echo esc_attr( $badge_ttle ); ?> {
	background-image: url(<?php echo esc_url( $badge_img ); ?>);
}

<?php

			endif;
		endwhile;
	endif;
endif;
?>
<?php
if ( have_rows( 'leaderboard_badges', 'option' ) ) :
	while ( have_rows( 'leaderboard_badges', 'option' ) ) : the_row();
		$lb_badge_img = get_sub_field( 'leaderboard_badge_icon' );
		$lb_badge_ttle = get_sub_field( 'leaderboard_badge_title' );
		$lb_badge_ttle = trim( str_replace( ' ', '_', $lb_badge_ttle ) );
?>
.lb-<?php echo esc_attr( $lb_badge_ttle ); ?> {
	background-image: url(<?php echo esc_url( $lb_badge_img ); ?>);
}
<?php 
	endwhile;
endif;
?>
<?php if ( get_field( 'left_right_padding', 'option' ) ) : ?>
.lr-padding {
	padding-left: <?php the_field( 'left_right_padding', 'option' ); ?>%;
	padding-right: <?php the_field( 'left_right_padding', 'option' ); ?>%;
}
.king-nav-dropdown {
	left: <?php the_field( 'left_right_padding', 'option' ); ?>%;
	right: <?php the_field( 'left_right_padding', 'option' ); ?>%;
}
<?php endif; ?>
<?php if ( get_field( 'left_right_padding_sider', 'option' ) || '0' === get_field( 'left_right_padding_sider', 'option' ) ) : ?>
.king-featured-top {
	padding-left: <?php the_field( 'left_right_padding_sider', 'option' ); ?>%;
	padding-right: <?php the_field( 'left_right_padding_sider', 'option' ); ?>%;
}

<?php if ( '0' === get_field( 'left_right_padding_sider', 'option' ) ) : ?>
.king-featured .owl-stage-outer,
.king-featured-5 .owl-stage-outer {
		border-radius:0;
}
.king-featured .featured-posts,
.king-featured-5 .featured-posts {
    border-radius: 0;
}
.king-featured,
.king-featured-5 {
    margin-top: 0;
}
.king-featured-grid {
	padding-top: 0;
}

<?php endif; ?>
<?php endif; ?>

