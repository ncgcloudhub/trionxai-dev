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
$pid = get_query_var( 'orderby' );
$second = get_field( 'redirect_after', 'options' );
$url = get_field( 'ad_link', $pid );
if ( empty( $url ) ) {
	wp_safe_redirect( get_home_url() );
	exit;
}
?>
<?php get_header(); ?> 
<div id="primary" class="content-area king-membership">
	<main id="main" class="site-main-middle" style="text-align: center;">
		<h2><?php echo esc_html_e( 'Redirecting you to ', 'king' ) . '"' . get_the_title( $pid ) . '"'; ?></h2>
		<h4><?php echo esc_html_e( 'in ', 'king' ); ?><b id="timer"><?php echo esc_attr( $second ); ?></b><?php echo esc_html_e( ' seconds.', 'king' ); ?></h4>
		<div><?php echo get_field( 'redirect_page_ad_code', 'options' ); ?></div>
		<h5><?php
				echo sprintf(
				    esc_html__( 'Please %s if you have not been redirected automatically.', 'king' ),
				    '<a href="' . esc_url( $url ) . '">' . esc_html__( 'click here', 'king' ) . '</a>'
				);
				?>
		</h5>
			<script type="text/javascript">
				// Set the number of seconds to count down
				var count = <?php echo esc_attr( $second ); ?>;
				// Get the HTML element to display the countdown timer
				var timer = document.getElementById("timer");
				// Start the countdown
				var interval = setInterval(function() {
				    count--;
				    timer.innerHTML = count;
				    if (count === 0) {
				        clearInterval(interval);
				        // Redirect to the specified URL
				        window.location.href = "<?php echo esc_url( $url ); ?>";
				    }
				}, 1000);
			</script>
	</main><!-- #main -->
</div><!-- #primary -->
