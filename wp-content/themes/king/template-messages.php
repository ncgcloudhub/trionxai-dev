<?php
/**
* The template for Private Messages
*
* @package King
*/

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$profile_id = get_query_var( 'profile_id' );
if ( $profile_id ) {
	$this_user = get_user_by( 'login',$profile_id );
} else {
	$this_user = wp_get_current_user();
}
if ( ! $this_user->ID || ! get_field( 'enable_private_messages', 'options' ) || ! is_user_logged_in() ) {
	wp_redirect( site_url() );
}
$message_sender2 = 'king_private_' . get_current_user_id();
$message_sender = 'king_private_' . $this_user->ID;
if ( isset( $_POST['king-message'] ) &&  wp_verify_nonce( $_POST['king_sendmessage_nonce'], 'king_sendmessage' ) ) {
	$king_sendmessage_errors = array();
	$message    = sanitize_text_field( $_POST['king-message'] );
	if ( trim( $message ) === '' ) {
		$king_sendmessage_errors['message_empty'] = esc_html__( 'Message is empty.', 'king' );
	}
	if ( empty( $king_sendmessage_errors ) ) {
		$get_message = get_user_meta( get_current_user_id(), $message_sender, true );
		if ( $get_message === '' ) {
			$get_message = array();
		}
		array_push( $get_message, $message );

		update_user_meta( get_current_user_id(), $message_sender, $get_message );
		$total = get_user_meta( $this_user->ID, 'king_prvtmsg_notify', true );
		$total = (int) $total + 1;
		update_user_meta( $this_user->ID , 'king_prvtmsg_notify', $total );
		wp_redirect( esc_url_raw( add_query_arg( array( 'action' => 'sent' ), site_url() . '/' . $GLOBALS['king_prvtmsg'] . '/' . $this_user->data->user_login ) ) );
		exit;
	}
}
?>
<?php get_header(); ?> 
<header class="page-top-header prvtmsg">
	<h1 class="page-title"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i> <?php esc_html_e( 'Private Messages', 'king' ); ?></h1>
</header><!-- .page-header -->
<?php get_template_part( 'template-parts/king-header-nav' ); ?>

<div id="primary" class="content-area">
	<main id="main" class="page-site-main king-prvtmsg">
		<?php if ( $profile_id ) : ?>
	<a class="prvt-goback" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_prvtmsg'] ); ?>">
		<i class="fa fa-arrow-left" aria-hidden="true"></i>
	</a>
	<div class="send-message-dialog king-scroll">
		<div class="king-received">
			<?php
				$usermessages = get_user_meta( $this_user->ID , $message_sender2, true );
			if ( $usermessages ) :
				foreach( $usermessages as $thing ) : ?>
				<div class="king-messagebody">
				<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $this_user->user_login ); ?>" target="_blank">
					<div class="king-inbox-avatar">
						<?php if ( get_field( 'author_image','user_' . $this_user->ID ) ) : $image = get_field( 'author_image','user_' . $this_user->ID ); ?>
							<img src="<?php  echo esc_url( $image['sizes']['thumbnail'] ); ?>" alt="profile" />
						<?php endif; ?>	   
					</div>
				</a>	
					<div class="king-messagebox"><?php echo esc_attr( $thing ); ?></div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>						
		</div>
		<div class="king-sent">
			<?php
				$usermessages2 = get_user_meta( get_current_user_id(), $message_sender, true );
				if ( $usermessages2 ) :
					$user_info = get_userdata( get_current_user_id() );
					foreach( $usermessages2 as $thing2 ) : ?>
					<div class="king-messagebody">
					<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $user_info->user_login ); ?>" target="_blank">
						<div class="king-inbox-avatar">
							<?php if ( get_field( 'author_image','user_' . $user_info->ID ) ) : $image = get_field( 'author_image','user_' . $user_info->ID ); ?>
								<img src="<?php  echo esc_url( $image['sizes']['thumbnail'] ); ?>" alt="profile" />
							<?php endif; ?>	   
						</div>
					</a>
						<div class="king-messagebox"><?php echo esc_attr( $thing2 ); ?></div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>	
		</div>
	</div>
		<?php
		if ( isset( $_GET['action'] ) && $_GET['action'] === 'sent' ) : ?>
		<div class="alert alert-success">
			<?php esc_html_e( 'Your message has been successfully sent', 'king' ) ?>						
		</div>
	<?php else : ?>
		<form action="" class="send-message" method="post" enctype="multipart/form-data" autocomplete="off">
			<div class="king-form-group">
				<label for="king-message"><?php esc_attr_e( 'Send Private Message to - ', 'king' ); ?><?php echo esc_attr( $this_user->display_name ); ?></label>
				<?php if ( isset( $king_sendmessage_errors['message_empty'] ) ) : ?>
					<div class="king-error"><?php echo esc_attr( $king_sendmessage_errors['message_empty'] ); ?></div>
				<?php endif; ?>		
				<textarea name="king-message" id="king-message" class="bptextarea" rows="2" cols="50" maxlength="140"></textarea>
				<input type="submit" id="king-submitbutton" class="king-submit-button" name="king-sendmessage" value="Send">
				<?php wp_nonce_field( 'king_sendmessage', 'king_sendmessage_nonce' ); ?>
			</div>
		</form>	
	<?php endif; ?>
<?php else : ?>
	<?php
	delete_user_meta( get_current_user_id(), 'king_prvtmsg_notify' );
	$user_query = new WP_User_Query( array(
		'meta_key' => 'king_private_' . get_current_user_id(),
		'order' => 'DESC',
	) );
	if ( ! empty( $user_query->results ) ) :
		foreach ( $user_query->results as $user ) :
			$usermessages = get_user_meta( $user->ID , $message_sender2, true );
			$count_usermessages = max( array_keys( $usermessages ) );
		?>

		<div class="king-inbox-users">
			<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_prvtmsg'] . '/' . $user->user_login ); ?>">
				<div class="king-inbox-avatar">
					<?php if ( get_field( 'author_image','user_' . $user->ID ) ) : $image = get_field( 'author_image','user_' . $user->ID ); ?>
						<img src="<?php  echo esc_url( $image['sizes']['thumbnail'] ); ?>" alt="profile" />
					<?php endif; ?>	   
				</div>
				<div class="inbox-login"><strong><?php echo esc_attr( $user->user_login ); ?></strong></div>
				<div class="inbox-msg"><?php echo esc_attr( $usermessages[ $count_usermessages ] ); ?></div>
			</a>
		</div>
	<?php endforeach; ?>
<?php else : ?>
	<div class="no-follower"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i><?php esc_html_e( 'Your inbox is empty', 'king' ); ?> </div>
<?php endif; ?>	
<?php endif; ?>
</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
