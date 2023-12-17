<?php
/**
 * The template for membership.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php get_header(); ?> 
<div id="primary" class="content-area king-membership">
	<main id="main" class="site-main-middle">
		<div class="king-membership-page">
			<?php
			if ( get_query_var( 'template' ) === 'myplan' ) :
				$stts       = '---';
				$order_name = '---';
				$time       = '---';
				$usrid      = get_current_user_id();
				$customer   = new WC_Customer( $usrid );
				$time       = get_field( 'membership_expiration_date', 'user_' . $usrid );
				$last_order = $customer->get_last_order();
				if ( $last_order ) {
					$surl = $last_order->get_view_order_url();
					$stts = esc_html__( 'Active', 'king' );
					foreach ( $last_order->get_items() as $item ) :
						$idz        = $item->get_product_id();
						$thumbnail  = get_the_post_thumbnail_url( $idz, 'medium_large' );
						$order_name = $item->get_name();

					endforeach;
				}
				if ( ! get_field( 'premium_member', 'user_' . $usrid ) || ( king_plugin_active( 'WC_Subscription' ) && ! wcs_user_has_subscription( $usrid ) ) ) {
					$stts       = '---';
					$order_name = '---';
					$time       = '---';
					$thumbnail  = '';
				} elseif ( get_field( 'premium_member', 'user_' . $usrid ) && get_field( 'membership_unlimited', 'user_' . $usrid ) ) {
					$time = esc_html__( 'Unlimited', 'king' );
				} elseif ( get_field( 'premium_member', 'user_' . $usrid ) && $time < date( 'm/d/Y' ) ) {
					$stts = esc_html__( 'Expired', 'king' );
					$time = '---';
				}
				if ( king_plugin_active( 'WC_Subscription' ) && wcs_user_has_subscription( $usrid ) ) {
					$subscriptions = wcs_get_users_subscriptions( $usrid );
					foreach ( $subscriptions as $subscription_id => $subscription ) :
						$stts = $subscription->get_status();
						$surl = $subscription->get_view_order_url();
						$time = date( 'm/d/Y', $subscription->get_time( 'next_payment' ) );
						if ( $time < date( 'm/d/Y' ) ) {
							$time = '---';
						}
					endforeach;
				}
				?>
				<div class="king-ms-exp">
					<h3 class="king-ms-title"><?php echo esc_html_e( 'My Membership', 'king' ); ?></h3>
					<span class="exp-thumb" style="background-image: url(<?php echo esc_url( $thumbnail ); ?>);"></span>
					<div class="king-ms-det">
						<span><?php echo esc_html_e( 'Name', 'king' ); ?></span>
						<h4><?php echo esc_attr( $order_name ); ?></h4>
						<span><?php echo esc_html_e( 'Status', 'king' ); ?></span>
						<h4><?php echo esc_attr( $stts ); ?></h4>
						<span><?php echo esc_html_e( 'Next Payment', 'king' ); ?></span>
						<h4><?php echo esc_attr( $time ); ?></h4>
					</div>
				</div>
					<span class="membership-buttons">
					<?php if ( isset( $surl ) ) : ?>
						<a class="membership-button" href="<?php echo esc_url( $surl ); ?>"><i class="fas fa-file-invoice-dollar"></i>  <?php echo esc_html_e( 'See Order', 'king' ); ?></a>
					<?php endif; ?>
						<a class="membership-button" href="<?php echo esc_url( add_query_arg( array( 'template' => 'membership' ), site_url() . '/' . $GLOBALS['king_dashboard'] ) ); ?>"><?php echo esc_html_e( 'Other Plans', 'king' ); ?> <i class="fas fa-chevron-circle-right"></i></a>
					</span>
				<?php
			elseif ( get_query_var( 'template' ) === 'membership' ) :
				$args = array(
					'post_type'  => 'product',
					'stock'      => 1,
					'meta_key'   => 'membership_product',
					'meta_value' => '1',
					'orderby'    => 'date',
					'order'      => 'ASC',
				);
				$loop = new WP_Query( $args );
				if ( ! empty( $loop->have_posts() ) ) :
					?>
					<div class="membership-plans">
						<?php
						while ( $loop->have_posts() ) :
							$loop->the_post();
							global $product;
							$thumbnail = get_the_post_thumbnail_url( $product->get_id(), 'medium_large' );
							$period    = get_field( 'membership_period_number', $product->get_id() );
							$perday    = get_field( 'membership_period_days', $product->get_id() );
							?>
							<div class="membership-plan">
								<?php if ( $thumbnail ) : ?>
									<span class="membership-back" style="background-image: url(<?php echo esc_url( $thumbnail ); ?>);"></span>
								<?php endif; ?>
								<h4 class="membership-title"><?php echo esc_attr( get_the_title() ); ?></h4>
								<?php if ( 'subscription' !== $product->get_type() ) : ?>
									<p><?php echo esc_attr( $period ); ?> <?php echo esc_attr( $perday ); ?><?php if ( $period > 1 ) { echo 's'; } ?></p>
								<?php endif; ?>
								<span class="membership-desc"><?php echo wp_kses_post( $product->get_description() ); ?></span>
								<span class="membership-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
								<a class="membership-buy" href="<?php echo esc_url( get_permalink() ); ?>?add-to-cart=<?php echo esc_attr( $product->get_id() ); ?>&quantity=1"><?php echo esc_html_e( 'Purchase now', 'king' ); ?><i class="fas fa-chevron-circle-right"></i></a>
							</div>
						<?php endwhile; ?>
					</div>
					<?php
					wp_reset_postdata();
				endif;
			endif;
			?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->
