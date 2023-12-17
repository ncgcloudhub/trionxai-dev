<?php
/**
 * King AMP Sidebar.
 *
 * @package King_Theme
 */
?>
<amp-sidebar id="sidebar" layout="nodisplay" side="left">
	<div class="amp-king-sidebar">
		<ul class="amp-king-side-links">
		<?php if ( ! get_field( 'hide_news_Link', 'options' ) ) : ?>
			<li><a href="<?php echo esc_url( get_post_format_link( 'quote' ) ); ?>"><span class="nav-icon nav-news" ></span><?php echo esc_html_e( 'News', 'king' ) ?></a></li><?php endif; ?>
		<?php if ( ! get_field( 'hide_video_Link', 'options' ) ) : ?>
			<li><a href="<?php echo esc_url( get_post_format_link( 'video' ) ); ?>"><span class="nav-icon nav-video" ></span><?php echo esc_html_e( 'Video', 'king' ) ?></a></li><?php endif; ?>
		<?php if ( ! get_field( 'hide_image_Link', 'options' ) ) : ?>
			<li><a href="<?php echo esc_url( get_post_format_link( 'image' ) ); ?>"><span class="nav-icon nav-image" ></span><?php echo esc_html_e( 'Image', 'king' ) ?></a></li><?php endif; ?>
		<?php get_template_part( 'template-parts/header-templates/header-parts/newnav' ); ?>
		</ul>
		<div class="king-cat-list-mobile">
			<ul>
			<?php wp_list_categories( array(
					'orderby'    => 'name',
					'hide_title_if_empty' => true,
					'title_li' => '',
				) ); ?>
			</ul>
		</div>
	</div><!-- .amp-king-sidebar -->
</amp-sidebar>