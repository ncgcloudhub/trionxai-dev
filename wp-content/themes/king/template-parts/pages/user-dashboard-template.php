<?php
/**
 * User following users posts page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$this_user = wp_get_current_user();
if ( ! $this_user->ID ) {
	wp_redirect( site_url() );
}

if ( empty( get_query_var( 'orderby' ) ) ) {
	$user_query = new WP_User_Query(
		array(
			'meta_query' => array(
				array(
					'key'     => 'wp__user_followd',
					'value'   => '"user-' . $this_user->ID . '";i:' . $this_user->ID . ';',
					'compare' => 'LIKE',
				),
			),
		)
	);
	if ( ! empty( $user_query->results ) ) {
		foreach ( $user_query->results as $user ) {
			$followtags[] = $user->ID;
		}
	} else {
		$followtags = array('0');
	}
} else {
	$followtags = get_user_meta( $this_user->ID, 'king_follow_tags', true );
	if ( empty( $followtags ) ) {
		$followtags = array( '0' );
	}
}
?>
<?php get_header(); ?>
<div class="king-dashboard-user">
	<div class="king-dashboard-avatar">
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] ); ?>">
			<?php if ( get_field( 'author_image','user_' . $this_user->ID ) ) : $image = get_field( 'author_image','user_' . $this_user->ID ); ?>
				<img src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" />
			<?php endif; ?>
		</a>
	</div>
	<div class="king-dashboard-username">
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] ); ?>">
			<h4><?php echo esc_attr( $this_user->data->display_name ); ?></h4>
		</a>
		<?php if ( get_query_var( 'orderby' ) === 'cats' ) : ?>
			<?php echo esc_html_e( ' / Following Categories', 'king' ); ?>
			<?php elseif ( get_query_var( 'orderby' ) === 'tags' ) : ?>
				<?php echo esc_html_e( ' / Following Tags', 'king' ); ?>
				<?php else : ?>
					<?php echo esc_html_e( ' / Following Users Posts', 'king' ); ?>
				<?php endif; ?>
			</div>
			<div class="king-3rd-nav">
				<?php if ( get_field( 'enable_category_follow', 'options' ) || get_field( 'enable_tag_follow', 'options' ) ) : ?>
				<span>
					<a class="<?php if ( empty( get_query_var( 'orderby' ) ) ) { echo 'active'; } ?>" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_dashboard'] ); ?>" ><?php esc_html_e( 'Following Users', 'king' ); ?></a>
					<?php if ( get_field( 'enable_category_follow', 'options' ) ) : ?>
					<a class="<?php if ( get_query_var( 'orderby' ) === 'cats' ) {  echo 'active'; } ?>" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_dashboard'] . '/' . '?orderby=cats' ); ?>" ><?php esc_html_e( 'Categories', 'king' ); ?></a>
					<?php endif; ?>
					<?php if ( get_field( 'enable_tag_follow', 'options' ) ) : ?>
					<a class="<?php if ( get_query_var( 'orderby' ) === 'tags' ) {  echo 'active'; } ?>" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_dashboard'] . '/' . '?orderby=tags' ); ?>" ><?php esc_html_e( 'Tags', 'king' ); ?></a>
					<?php endif; ?>	
				</span>
			<?php endif; ?>
			</div>
			<div class="king-dashboard-nav">
				<?php foreach ( $followtags as $key => $value ) : ?>
					<?php if ( ( get_query_var( 'orderby' ) === 'cats' ) && get_field( 'enable_category_follow', 'options' ) ) : ?>
						<?php if ( get_cat_name( $value ) ) : ?>
							<a href="<?php echo get_category_link( $value ); ?>"><i class="fas fa-star-of-life fa-sm"></i> <?php echo get_cat_name( $value ); ?></a>
						<?php endif; ?>
					<?php
					elseif ( ( get_query_var( 'orderby' ) === 'tags' ) && get_field( 'enable_tag_follow', 'options' ) ) :
						$tag = get_tag( $value );
						if ( isset( $tag->name ) ) :
							?>
							<a href="<?php echo get_tag_link( $value ); ?>">#<?php echo esc_attr( $tag->name ); ?></a>
						<?php endif; ?>
					<?php elseif ( empty( get_query_var( 'orderby' ) ) ) : ?>
						<?php $user_info = get_userdata( $value );
						if ( isset( $user_info->user_login ) ) :?>
							<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $user_info->user_login ); ?>">@<?php echo esc_attr( $user_info->user_login ); ?></a>
						<?php endif; ?>
					<?php endif; ?>	
			<?php endforeach; ?>
		</div>
</div>

<?php
if ( get_field( 'enable_stories', 'options' ) ) {
	$storyargs['users'] = $followtags;
	$storyargs['class'] = 'str-dash';
	$storyargs['dash']  = true;
	get_template_part( 'template-parts/king', 'stories', $storyargs );
}
if ( get_field( 'select_default_display_option', 'options' ) ) {
		$display_option = get_field( 'select_default_display_option', 'options' );
	} else {
		$display_option = 'king-grid-01';
	}
$htemplate = get_field( 'dashboard_template', 'options' );
if ( $htemplate ) {
	$sidebar = $htemplate['sidebar'];
	if ( $htemplate['column'] ) {
		$column = ' ' . $htemplate['column'];
	} else {
		$column = '';
	}
	$display_option = ! empty($htemplate['post_layout']) ? $htemplate['post_layout'] : $display_option;
} else {
	$sidebar = 'king-sidebar-01';
	$column  = '';
}
?>
<div id="primary" class="content-area lr-padding <?php echo esc_attr( $display_option ); ?>">
<div class="site-main-top kflex <?php echo esc_attr( $sidebar . $column ); ?>">
	<?php
	if ( ( 'king-sidebar-02' === $sidebar ) || ( 'king-sidebar-03' === $sidebar ) ) {
		get_sidebar( '2' );
	}
	?>
	<main id="main" class="site-main">	
		<ul class="king-posts">
		<li class="grid-sizer"></li>                
			<?php
			$paged = isset( $_GET['page'] ) ? $_GET['page'] : 0 ;
			if ( get_field( 'length_of_users_dashboard', 'options' ) ) {
				$length_dashboard = get_field( 'length_of_users_dashboard', 'option' );
			} else {
				$length_dashboard = '10';
			}

			if ( ( get_query_var( 'orderby' ) === 'cats' ) && get_field( 'enable_category_follow', 'options' ) ) {
				$followarray = 'category__in';
			} elseif ( ( get_query_var( 'orderby' ) === 'tags' ) && get_field( 'enable_tag_follow', 'options' ) ) {
				$followarray = 'tag__in';
			} else {
				$followarray = 'author__in';
			}
			$the_query = new WP_Query(
				array(
					'posts_per_page' => $length_dashboard,
					'post_type'      => king_post_types(),
					$followarray     => $followtags,
					'paged'          => $paged,
					'post__not_in'   => get_option( 'sticky_posts' ),
				)
			);
			if ( ! empty( $the_query->have_posts() ) ) :
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					get_template_part( 'template-parts/content-templates/' . $display_option );
				}
				wp_reset_postdata();
				;else : ?>
				<div class="no-follower"><i class="fab fa-slack-hash fa-2x"></i><?php esc_html_e( 'you\'re not following yet', 'king' ); ?> </div>
			<?php endif; ?>	


			<?php if ( ! empty( $the_query->have_posts() ) ) : ?>
				<div class="king-pagination">
					<?php
					$format      = '?page=%#%';
					$url         = site_url() . '/' . $GLOBALS['king_dashboard'] . '%_%';
							$big = 999999999; // need an unlikely integer.
							echo paginate_links(
								array(
									'base'      => $url,
									'format'    => $format,
									'current'   => max( 1, $paged ),
									'total'     => $the_query->max_num_pages,
									'prev_next' => true,
									'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
									'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
								)
							);
							?>
						</div>
					<?php endif; ?>	
				</ul>
			</main><!-- #main -->
		<?php
		if ( ( 'king-sidebar-01' === $sidebar ) || ( 'king-sidebar-03' === $sidebar ) || ( 'king-sidebar-05' === $sidebar ) ) {
			get_sidebar();
			if ( ( 'king-sidebar-05' === $sidebar ) ) {
				get_sidebar( '2' );
			}
		}
		?>
		</div><!-- #primary -->
		<?php get_footer(); ?>
