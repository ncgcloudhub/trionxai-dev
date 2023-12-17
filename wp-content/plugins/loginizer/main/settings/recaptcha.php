<?php

if(!defined('ABSPATH')){
	die('Hacking Attempt!');
}

//---------------------
// Admin Menu Pro Pages
//---------------------

// Loginizer - reCaptcha Page
function loginizer_page_recaptcha(){
	
	global $loginizer, $lz_error, $lz_env;
	 
	if(!current_user_can('manage_options')){
		wp_die('Sorry, but you do not have permissions to change settings.');
	}
	
	if(!loginizer_is_premium() && count($_POST) > 0){
		$lz_error['not_in_free'] = __('This feature is not available in the Free version. <a href="'.LOGINIZER_PRICING_URL.'" target="_blank" style="text-decoration:none; color:green;"><b>Upgrade to Pro</b></a>', 'loginizer');
		return loginizer_page_recaptcha_T();
	}

	/* Make sure post was from this page */
	if(count($_POST) > 0){
		check_admin_referer('loginizer-options');
	}
	
	// Themes
	$lz_env['theme']['light'] = 'Light';
	$lz_env['theme']['dark'] = 'Dark';
	
	// Langs
	$lz_env['lang'][''] = 'Auto Detect';
	$lz_env['lang']['ar'] = 'Arabic';
	$lz_env['lang']['bg'] = 'Bulgarian';
	$lz_env['lang']['ca'] = 'Catalan';
	$lz_env['lang']['zh-CN'] = 'Chinese (Simplified)';
	$lz_env['lang']['zh-TW'] = 'Chinese (Traditional)';
	$lz_env['lang']['hr'] = 'Croatian';
	$lz_env['lang']['cs'] = 'Czech';
	$lz_env['lang']['da'] = 'Danish';
	$lz_env['lang']['nl'] = 'Dutch';
	$lz_env['lang']['en-GB'] = 'English (UK)';
	$lz_env['lang']['en'] = 'English (US)';
	$lz_env['lang']['fil'] = 'Filipino';
	$lz_env['lang']['fi'] = 'Finnish';
	$lz_env['lang']['fr'] = 'French';
	$lz_env['lang']['fr-CA'] = 'French (Canadian)';
	$lz_env['lang']['de'] = 'German';
	$lz_env['lang']['de-AT'] = 'German (Austria)';
	$lz_env['lang']['de-CH'] = 'German (Switzerland)';
	$lz_env['lang']['el'] = 'Greek';
	$lz_env['lang']['iw'] = 'Hebrew';
	$lz_env['lang']['hi'] = 'Hindi';
	$lz_env['lang']['hu'] = 'Hungarain';
	$lz_env['lang']['id'] = 'Indonesian';
	$lz_env['lang']['it'] = 'Italian';
	$lz_env['lang']['ja'] = 'Japanese';
	$lz_env['lang']['ko'] = 'Korean';
	$lz_env['lang']['lv'] = 'Latvian';
	$lz_env['lang']['lt'] = 'Lithuanian';
	$lz_env['lang']['no'] = 'Norwegian';
	$lz_env['lang']['fa'] = 'Persian';
	$lz_env['lang']['pl'] = 'Polish';
	$lz_env['lang']['pt'] = 'Portuguese';
	$lz_env['lang']['pt-BR'] = 'Portuguese (Brazil)';
	$lz_env['lang']['pt-PT'] = 'Portuguese (Portugal)';
	$lz_env['lang']['ro'] = 'Romanian';
	$lz_env['lang']['ru'] = 'Russian';
	$lz_env['lang']['sr'] = 'Serbian';
	$lz_env['lang']['sk'] = 'Slovak';
	$lz_env['lang']['sl'] = 'Slovenian';
	$lz_env['lang']['es'] = 'Spanish';
	$lz_env['lang']['es-419'] = 'Spanish (Latin America)';
	$lz_env['lang']['sv'] = 'Swedish';
	$lz_env['lang']['th'] = 'Thai';
	$lz_env['lang']['tr'] = 'Turkish';
	$lz_env['lang']['uk'] = 'Ukrainian';
	$lz_env['lang']['vi'] = 'Vietnamese';
	
	// Sizes
	$lz_env['size']['normal'] = 'Normal';
	$lz_env['size']['compact'] = 'Compact';

	// reCAPTCHA Domains
	$lz_env['captcha_domains']['www.google.com'] = 'google.com';
	$lz_env['captcha_domains']['www.recaptcha.net'] = 'recaptcha.net';
	
	if(isset($_POST['save_lz'])){
	
		// Clear captcha
		if(empty($_POST['captcha_status'])){
			
			// Save the options
			update_option('loginizer_captcha', '');
			
			// Mark as saved
			$GLOBALS['lz_cleared'] = true;
			
		}else{
		
			// Google Captcha
			$option['captcha_type'] = lz_optpost('captcha_type');
			$option['captcha_key'] = lz_optpost('captcha_key');
			$option['captcha_secret'] = lz_optpost('captcha_secret');
			$option['captcha_theme'] = lz_optpost('captcha_theme');
			$option['captcha_size'] = lz_optpost('captcha_size');
			$option['captcha_lang'] = lz_optpost('captcha_lang');
			$option['captcha_domain'] = lz_optpost('captcha_domain');
			
			// No Google Captcha
			$option['captcha_text'] = lz_optpost('captcha_text');
			$option['captcha_time'] = (int) lz_optpost('captcha_time');
			$option['captcha_words'] = (int) lz_optpost('captcha_words');
			$option['captcha_add'] = (int) lz_optpost('captcha_add');
			$option['captcha_subtract'] = (int) lz_optpost('captcha_subtract');
			$option['captcha_multiply'] = (int) lz_optpost('captcha_multiply');
			$option['captcha_divide'] = (int) lz_optpost('captcha_divide');
			
			// Checkboxes
			$option['captcha_user_hide'] = (int) lz_optpost('captcha_user_hide');
			$option['captcha_no_css_login'] = (int) lz_optpost('captcha_no_css_login');
			$option['captcha_login'] = (int) lz_optpost('captcha_login');
			$option['captcha_lostpass'] = (int) lz_optpost('captcha_lostpass');
			$option['captcha_resetpass'] = (int) lz_optpost('captcha_resetpass');
			$option['captcha_register'] = (int) lz_optpost('captcha_register');
			$option['captcha_comment'] = (int) lz_optpost('captcha_comment');
			$option['captcha_wc_checkout'] = (int) lz_optpost('captcha_wc_checkout');
			
			// Are we to use Math Captcha ?
			if(!empty($_POST['captcha_status']) && $_POST['captcha_status'] == 2){
				
				$option['captcha_no_google'] = 1;
				
				// Make the checks
				if(strlen($option['captcha_text']) < 1){
					$lz_error['captcha_text'] = __('The Captcha key was not submitted', 'loginizer');
				}
				
			}else{
			
				// Make the checks
				if(strlen($option['captcha_key']) < 32 || strlen($option['captcha_key']) > 50){
					$lz_error['captcha_key'] = __('The reCAPTCHA key is invalid', 'loginizer');
				}
				
				// Is secret valid ?
				if(strlen($option['captcha_secret']) < 32 || strlen($option['captcha_secret']) > 50){
					$lz_error['captcha_secret'] = __('The reCAPTCHA secret is invalid', 'loginizer');
				}
				
				// Is theme valid ?
				if(empty($lz_env['theme'][$option['captcha_theme']])){
					$lz_error['captcha_theme'] = __('The reCAPTCHA theme is invalid', 'loginizer');
				}
				
				// Is size valid ?
				if(empty($lz_env['size'][$option['captcha_size']])){
					$lz_error['captcha_size'] = __('The reCAPTCHA size is invalid', 'loginizer');
				}
				
				// Is lang valid ?
				if(empty($lz_env['lang'][$option['captcha_lang']])){
					$lz_error['captcha_lang'] = __('The reCAPTCHA language is invalid', 'loginizer');
				}

				if(empty($lz_env['captcha_domains'][$option['captcha_domain']])){
					$lz_error['captcha_domain'] = __('The reCAPTCHA domain is invalid', 'loginizer');
				}
				
			}
			
			// Is there an error ?
			if(!empty($lz_error)){
				return loginizer_page_recaptcha_T();
			}
			
			// Save the options
			update_option('loginizer_captcha', $option);
			
			// Mark as saved
			$GLOBALS['lz_saved'] = true;
		}
		
	}
	
	// Call the theme
	loginizer_page_recaptcha_T();
	
}

// Loginizer - reCaptcha Page Theme
function loginizer_page_recaptcha_T(){
	
	global $loginizer, $lz_error, $lz_env;
	
	// Universal header
	loginizer_page_header('reCAPTCHA Settings');
	
	loginizer_feature_available('reCAPTCHA');
	
	// Saved ?
	if(!empty($GLOBALS['lz_saved'])){
		echo '<div id="message" class="updated"><p>'. __('The settings were saved successfully', 'loginizer'). '</p></div><br />';
	}
	
	// Cleared ?
	if(!empty($GLOBALS['lz_cleared'])){
		echo '<div id="message" class="updated"><p>'. __('reCAPTCHA has been disabled !', 'loginizer'). '</p></div><br />';
	}
	
	// Any errors ?
	if(!empty($lz_error)){
		lz_report_error($lz_error);echo '<br />';
	}
	
	?>

<style>
input[type="text"], textarea, select {
    width: 70%;
}
</style>

	<div id="" class="postbox">
	
		<div class="postbox-header">
		<h2 class="hndle ui-sortable-handle">
			<span><?php echo __('reCAPTCHA Settings', 'loginizer'); ?></span>
		</h2>
		</div>
		
		<div class="inside">
		
		<form action="" method="post" enctype="multipart/form-data" loginizer-premium-only="1">
		<?php wp_nonce_field('loginizer-options'); ?>
		<table class="form-table">
			<tr>
				<td scope="row" valign="top" style="width:400px !important;"><label for="captcha_status"><b><?php echo __('Captcha Status', 'loginizer'); ?></b></label></td>
				<td>
					<select name="captcha_status" id="captcha_status" onchange="lz_captcha_status();">
						<?php
							echo '<option '.lz_POSTselect('captcha_status', 0, (empty($loginizer['captcha_key']) && empty($loginizer['captcha_no_google']) ? true : false)).' value="0">'.__('Disabled', 'loginizer').'</value>
							<option '.lz_POSTselect('captcha_status', 1, (!empty($loginizer['captcha_key']) ? true : false)).' value="1">'.__('Google reCAPTCHA', 'loginizer').'</value>
							<option '.lz_POSTselect('captcha_status', 2, (!empty($loginizer['captcha_no_google']) ? true : false)).' value="2">'.__('Math Captcha', 'loginizer').'</value>';
						?>
					</select>
				</td>
			</tr>
			<tr class="lz_google_cap">
				<td scope="row" valign="top"><label><b><?php echo __('reCAPTCHA type', 'loginizer'); ?></b></label><br>
				<?php echo __('Choose the type of reCAPTCHA', 'loginizer'); ?><br />
				<?php echo __('<a href="https://g.co/recaptcha/sitetypes/" target="_blank">See Site Types for more details</a>', 'loginizer'); ?>
				</td>
				<td>
					<input type="radio" value="v3" onchange="google_recaptcha_type()" <?php echo lz_POSTradio('captcha_type', 'v3', $loginizer['captcha_type']); ?> name="captcha_type" id="captcha_type_v3" /> <label for="captcha_type_v3"><?php echo __('reCAPTCHA v3', 'loginizer'); ?></label><br /><br />
					<input type="radio" value="" onchange="google_recaptcha_type()" <?php echo lz_POSTradio('captcha_type', '', $loginizer['captcha_type']); ?> name="captcha_type" id="captcha_type_v2" /> <label for="captcha_type_v2"><?php echo __('reCAPTCHA v2 - Checkbox', 'loginizer'); ?></label><br /><br />
					<input type="radio" value="v2_invisible" onchange="google_recaptcha_type()" <?php echo lz_POSTradio('captcha_type', 'v2_invisible', $loginizer['captcha_type']); ?> name="captcha_type" id="captcha_type_v2_invisible" /> <label for="captcha_type_v2_invisible"><?php echo __('reCAPTCHA v2 - Invisible', 'loginizer'); ?></label><br />
				</td>
			</tr>
			<tr class="lz_google_cap">
				<td scope="row" valign="top"><label for="captcha_key"><b><?php echo __('Site Key', 'loginizer'); ?></b></label><br>
				<?php echo __('Make sure you enter the correct keys as per the reCAPTCHA type selected above', 'loginizer'); ?>
				</td>
				<td>
					<input type="text" size="50" value="<?php echo lz_optpost('captcha_key', $loginizer['captcha_key']); ?>" name="captcha_key" id="captcha_key" /><br />
					<?php echo __('Get the Site Key and Secret Key from <a href="https://www.google.com/recaptcha/admin/" target="_blank">Google</a>', 'loginizer'); ?>
				</td>
			</tr>
			<tr class="lz_google_cap">
				<td scope="row" valign="top"><label for="captcha_secret"><b><?php echo __('Secret Key', 'loginizer'); ?></b></label></td>
				<td>
					<input type="text" size="50" value="<?php echo lz_optpost('captcha_secret', $loginizer['captcha_secret']); ?>" name="captcha_secret" id="captcha_secret" />
				</td>
			</tr>
			<tr class="lz_google_cap">
				<td scope="row" valign="top"><label for="captcha_theme"><b><?php echo __('Theme', 'loginizer'); ?></b></label></td>
				<td>
					<select name="captcha_theme" id="captcha_theme">
						<?php
							foreach($lz_env['theme'] as $k => $v){
								echo '<option '.lz_POSTselect('captcha_theme', $k, ($loginizer['captcha_theme'] == $k ? true : false)).' value="'.$k.'">'.$v.'</value>';								
							}
						?>
					</select>
				</td>
			</tr>
			<tr class="lz_google_cap">
				<td scope="row" valign="top"><label for="captcha_lang"><b><?php echo __('Language', 'loginizer'); ?></b></label></td>
				<td>
					<select name="captcha_lang" id="captcha_lang">
						<?php
							foreach($lz_env['lang'] as $k => $v){
								echo '<option '.lz_POSTselect('captcha_lang', $k, ($loginizer['captcha_lang'] == $k ? true : false)).' value="'.$k.'">'.$v.'</value>';								
							}
						?>
					</select>
				</td>
			</tr>
			<tr class="lz_google_cap lz_google_cap_size">
				<td scope="row" valign="top"><label for="captcha_size"><b><?php echo __('Size', 'loginizer'); ?></b></label></td>
				<td>
					<select name="captcha_size" id="captcha_size">
						<?php
							foreach($lz_env['size'] as $k => $v){
								echo '<option '.lz_POSTselect('captcha_size', $k, ($loginizer['captcha_size'] == $k ? true : false)).' value="'.$k.'">'.$v.'</value>';								
							}
						?>
					</select>
				</td>
			</tr>
			<tr class="lz_google_cap">
				<td scope="row" valign="top">
					<label for="captcha_domain"><b><?php echo __('reCAPTCHA Domain', 'loginizer'); ?></b></label><br>
					<?php echo __('If Google is not accessible or blocked in your country select other one', 'loginizer'); ?>
				</td>
				<td>
					<select name="captcha_domain" id="captcha_domain">
						<?php
							foreach($lz_env['captcha_domains'] as $k => $v){
								echo '<option '.lz_POSTselect('captcha_domain', $k, ($loginizer['captcha_domain'] == $k ? true : false)).' value="'.$k.'">'.$v.($k == 'www.google.com' ? ' '.__('(Default)', 'loginizer') : '').'</value>';								
							}
						?>
					</select>
				</td>
			</tr>
			<tr class="lz_math_cap">
				<td scope="row" valign="top">
					<label for="captcha_text"><b><?php echo __('Captcha Text', 'loginizer'); ?></b></label><br>
					<?php echo __('The text to be shown for the Captcha Field', 'loginizer'); ?>
				</td>
				<td>
					<input type="text" size="30" value="<?php echo lz_optpost('captcha_text', @$loginizer['captcha_text']); ?>" name="captcha_text" id="captcha_text" />
				</td>
			</tr>
			<tr class="lz_math_cap">
				<td scope="row" valign="top">
					<label for="captcha_time"><b><?php echo __('Captcha Time', 'loginizer'); ?></b></label><br>
					<?php echo __('Enter the number of seconds, a user has to enter captcha value.', 'loginizer'); ?>
				</td>
				<td>
					<input type="text" size="30" value="<?php echo lz_optpost('captcha_time', @$loginizer['captcha_time']); ?>" name="captcha_time" id="captcha_time" />
				</td>
			</tr>
			<tr class="lz_math_cap">
				<td scope="row" valign="top">
					<label for="captcha_words"><b><?php echo __('Display Captcha in Words', 'loginizer'); ?></b></label><br>
					<?php echo __('If selected the Captcha will be displayed in words rather than numbers', 'loginizer'); ?>
				</td>
				<td>
					<input type="checkbox" value="1" name="captcha_words" id="captcha_words" <?php echo lz_POSTchecked('captcha_words', (empty($loginizer['captcha_words']) ? false : true));?> />
				</td>
			</tr>
			<tr class="lz_math_cap">
				<td scope="row" valign="top" style="vertical-align: top !important;">
					<label><b><?php echo __('Mathematical operations', 'loginizer'); ?></b></label><br>
					<?php echo __('The Mathematical operations to use for Captcha', 'loginizer'); ?>
				</td>
				<td valign="top">
					<table class="wp-list-table fixed users" cellpadding="8" cellspacing="1">
						<?php echo '
						<tr>
							<td><label for="captcha_add">'.__('Addition (+)', 'loginizer').'</label></td>
							<td><input type="checkbox" value="1" name="captcha_add" id="captcha_add" '.lz_POSTchecked('captcha_add', (empty($loginizer['captcha_add']) ? false : true)).' /></td>
						</tr>
						<tr>
							<td><label for="captcha_subtract">'.__('Subtraction (-)', 'loginizer').'</label></td>
							<td><input type="checkbox" value="1" name="captcha_subtract" id="captcha_subtract" '.lz_POSTchecked('captcha_subtract', (empty($loginizer['captcha_subtract']) ? false : true)).' /></td>
						</tr>
						<tr>
							<td><label for="captcha_multiply">'.__('Multiplication (x)', 'loginizer').'</label></td>
							<td><input type="checkbox" value="1" name="captcha_multiply" id="captcha_multiply" '.lz_POSTchecked('captcha_multiply', (empty($loginizer['captcha_multiply']) ? false : true)).' /></td>
						</tr>
						<tr>
							<td><label for="captcha_divide">'.__('Division (÷)', 'loginizer').'</label></td>
							<td><input type="checkbox" value="1" name="captcha_divide" id="captcha_divide" '.lz_POSTchecked('captcha_divide', (empty($loginizer['captcha_divide']) ? false : true)).' /></td>
						</tr>';
						?>
					</table>
				</td>
			</tr>
			<tr class="lz_cap">
				<td scope="row" valign="top"><label><b><?php echo __('Show Captcha On', 'loginizer'); ?></b></label></td>
				<td valign="top">
					<table class="wp-list-table fixed users" cellpadding="8" cellspacing="1">
						<?php echo '
						<tr>
							<td><label for="captcha_login">'.__('Login Form', 'loginizer').'</label></td>
							<td><input type="checkbox" value="1" name="captcha_login" id="captcha_login" '.lz_POSTchecked('captcha_login', (empty($loginizer['captcha_login']) ? false : true)).' /></td>
						</tr>
						<tr>
							<td><label for="captcha_lostpass">'.__('Lost Password Form', 'loginizer').'</label></td>
							<td><input type="checkbox" value="1" name="captcha_lostpass" id="captcha_lostpass" '.lz_POSTchecked('captcha_lostpass', (empty($loginizer['captcha_lostpass']) ? false : true)).' /></td>
						</tr>
						<tr>
							<td><label for="captcha_resetpass">'.__('Reset Password Form', 'loginizer').'</label></td>
							<td><input type="checkbox" value="1" name="captcha_resetpass" id="captcha_resetpass" '.lz_POSTchecked('captcha_resetpass', (empty($loginizer['captcha_resetpass']) ? false : true)).' /></td>
						</tr>
						<tr>
							<td><label for="captcha_register">'.__('Registration Form', 'loginizer').'</label></td>
							<td><input type="checkbox" value="1" name="captcha_register" id="captcha_register" '.lz_POSTchecked('captcha_register', (empty($loginizer['captcha_register']) ? false : true)).' /></td>
						</tr>
						<tr>
							<td><label for="captcha_comment">'.__('Comment Form', 'loginizer').'</label></td>
							<td><input type="checkbox" value="1" name="captcha_comment" id="captcha_comment" '.lz_POSTchecked('captcha_comment', (empty($loginizer['captcha_comment']) ? false : true)).' /></td>
						</tr>';
						
						if(!defined('SITEPAD')){
						
						echo '<tr>
							<td><label for="captcha_wc_checkout">'.__('WooCommerce Checkout', 'loginizer').'</label></td>
							<td><input type="checkbox" value="1" name="captcha_wc_checkout" id="captcha_wc_checkout" '.lz_POSTchecked('captcha_wc_checkout', (empty($loginizer['captcha_wc_checkout']) ? false : true)).' /></td>
						</tr>';
						
						}
						
						?>
					</table>
				</td>
			</tr>
			<tr class="lz_cap">
				<td scope="row" valign="top"><label for="captcha_user_hide"><b><?php echo __('Hide CAPTCHA for logged in Users', 'loginizer'); ?></b></label></td>
				<td>
					<input type="checkbox" value="1" name="captcha_user_hide" id="captcha_user_hide" <?php echo lz_POSTchecked('captcha_user_hide', (empty($loginizer['captcha_user_hide']) ? false : true)); ?> />
				</td>
			</tr>
			<tr class="lz_google_cap">
				<td scope="row" valign="top"><label for="captcha_no_css_login"><b><?php echo __('Disable CSS inserted on Login Page', 'loginizer'); ?></b></label></td>
				<td>
					<input type="checkbox" value="1" name="captcha_no_css_login" id="captcha_no_css_login" <?php echo lz_POSTchecked('captcha_no_css_login', (empty($loginizer['captcha_no_css_login']) ? false : true)); ?> />
				</td>
			</tr>
		</table><br />
		<center><input name="save_lz" class="button button-primary action" value="<?php echo __('Save Settings','loginizer'); ?>" type="submit" /></center>
		</form>
	
		</div>
	</div>
	<br />

<script type="text/javascript">

function lz_captcha_status(){
	
	var cur_captcha_status = jQuery("#captcha_status option:selected").val();
	
	if(cur_captcha_status == 1){
		jQuery(".lz_google_cap").show();
		jQuery(".lz_math_cap").hide();
		jQuery(".lz_cap").show();
		google_recaptcha_type();
		
	}else if(cur_captcha_status == 2){
		jQuery(".lz_google_cap").hide();
		jQuery(".lz_math_cap").show();
		jQuery(".lz_cap").show();
	}else{
		jQuery(".lz_google_cap").hide();
		jQuery(".lz_math_cap").hide();
		jQuery(".lz_cap").hide();
	}
	
}

function google_recaptcha_type(){
	
	var cur_captcha_type = jQuery("input:radio[name='captcha_type']:checked").val();
	
	if(cur_captcha_type == 'v3' || cur_captcha_type == 'v2_invisible'){
		jQuery(".lz_google_cap_size").hide();
	}else{
		jQuery(".lz_google_cap_size").show();
	}
	
}

jQuery(document).ready(function(){
	lz_captcha_status();
});

</script>
	
	<?php
	loginizer_page_footer();
	
}