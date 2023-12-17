<?php
/**
 * Single Story Page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-story
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
$aimage       = '';
$amp_title    = get_the_title();
$amp_url      = get_permalink();
$amp_author   = get_userdata( $post->post_author );
$author_id    = $post->post_author;
$amp_icon_url = get_site_icon_url( 150 );
?>
<!doctype html>
	<html amp lang="en">
	<head>
	<meta charset="utf-8">
	<script async src="https://cdn.ampproject.org/v0.js"></script>
	<script async custom-element="amp-story" src="https://cdn.ampproject.org/v0/amp-story-1.0.js"></script>
	<script async custom-element="amp-video" src="https://cdn.ampproject.org/v0/amp-video-0.1.js"></script>
	<title><?php echo esc_attr( $amp_title ); ?></title>
	<meta name="viewport" content="width=device-width">
	<link href="https://fonts.googleapis.com/css2?family=Amatic+SC&family=Meow+Script&family=Monoton&family=Rubik+Beastly&family=Shadows+Into+Light&family=Ubuntu&display=swap" rel="stylesheet">
	<link rel="canonical" href="<?php echo esc_url( $amp_url ); ?>">
		<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
		<style amp-custom>
			amp-story{font-family:'Quicksand',sans-serif;}
			amp-story-page *{color:white;}
			.button{align-items:center;background-color:rgb(255 255 255 / 60%);-webkit-backdrop-filter:saturate(180%) blur(5px);backdrop-filter:saturate(180%) blur(5px);color:#333333;display:flex;height:50px;margin:0 auto;max-width:200px;text-decoration:none;justify-content:center;border-radius:32px;font-size:16px;}
			[template=thirds]{padding:0;}
			.savatar{position:absolute;top:20px;left:5px;text-decoration:none;display:flex;align-items:center;}
			.savatar amp-img{border-radius:100%;border:2px solid #fff;margin:0 8px;background-color:#ccd6dd;object-fit:cover;}
			.savatar amp-img img{border-radius:100%;object-fit:cover;}
		</style>
	</head>
	<body>
		<amp-story standalone
		title="<?php echo esc_attr( $amp_title ); ?>"
		publisher="<?php echo esc_attr( $amp_author->display_name ); ?>"
		<?php
		if ( get_field( 'author_image', 'user_' . $author_id ) ) :
			$image  = get_field( 'author_image', 'user_' . $author_id );
			$aimage = $image['sizes']['thumbnail'];
			?>
			publisher-logo-src="<?php echo esc_url( $aimage ); ?>"
		<?php endif; ?>
		poster-portrait-src="<?php echo esc_url( $aimage ); ?>" >
		<?php
		$storiesjs = get_post_custom( get_the_ID() );
		for ( $i = 0; $i <= 30; $i++ ) :
			$storyjs = !empty($storiesjs[ 'king_story_' . $i ]) ? $storiesjs[ 'king_story_' . $i ] : '';
			if ( !empty( $storyjs ) ) :
				foreach ( $storyjs as $key => $value ) :
					$story = json_decode( $value, true );
					$bg    = isset( $story['background'] ) ? $story['background'] : '#94959c';
					?>
					<amp-story-page id="story-<?php echo esc_attr( $i ); ?>" style="background-color: <?php echo esc_attr( $bg ); ?>;">
						<amp-story-grid-layer template="vertical">
							<?php foreach ( $story['objects'] as $key => $value ) : ?>
								<?php
								if ( 'image' === $value['type'] ) :
									$fstyle  = 'position:absolute;';
									$fstyle .= 'width:' . esc_attr( $value['width'] ) . 'px;height:' . esc_attr( $value['height'] ) . 'px;';
									$fstyle .= 'left:' . esc_attr( king_num_perc( $value['left'], '424' ) ) . ';top:' . esc_attr( king_num_perc( $value['top'], '713' ) ) . ';';
									$fstyle .= 'bottom:auto;right:auto;';
									$sx      = isset( $value['scaleX'] ) ? $value['scaleX'] : '1';
									$sy      = isset( $value['scaleY'] ) ? $value['scaleY'] : '1';
									$angle   = isset( $value['angle'] ) ? $value['angle'] : '0';
									$fstyle .= 'transform: translate(-50%, -50%) scale(' . esc_attr( $sx ) . ', ' . esc_attr( $sy ) . ') rotate(' . $angle . 'deg);';
									?>	
									<?php if ( ! empty( $value['src'] ) ) : ?>
										<amp-img style="<?php echo $fstyle; ?>" src="<?php echo esc_url( $value['src'] ); ?>" layout="fill"></amp-img>
									<?php elseif ( ! empty( $value['video_src'] ) ) : ?>
										<amp-video style="<?php echo $fstyle; ?>" autoplay loop layout="fill">
											<source src="<?php echo esc_url( $value['video_src'] ); ?>" type="video/mp4">
											</amp-video>
										<?php endif; ?>
									<?php endif; ?>
						</amp-story-grid-layer>
								<?php if ( 'rect' === $value['type'] ) : ?>
									<amp-story-page-outlink layout="nodisplay">
										<a href="<?php echo esc_url( $value['fillRule'] ); ?>" title="Go to"></a>
									</amp-story-page-outlink>
								<?php endif; ?>
									<?php
									if ( 'textbox' === $value['type'] ) :
										$style   = 'position:absolute;font-size:' . esc_attr( $value['fontSize'] ) . 'px;font-family:' . esc_attr( $value['fontFamily'] ) . ';line-height:' . esc_attr( $value['fontSize'] + 10 ) . 'px;';
										$style  .= 'left:' . esc_attr( king_num_perc( $value['left'], '424' ) ) . ';top:' . esc_attr( king_num_perc( $value['top'], '693' ) ) . ';';
										$style  .= 'width:' . esc_attr( $value['width'] ) . 'px;height:' . esc_attr( $value['height'] ) . 'px;';
										$sx      = isset( $value['scaleX'] ) ? $value['scaleX'] : '1';
										$sy      = isset( $value['scaleY'] ) ? $value['scaleY'] : '1';
										$angle   = isset( $value['angle'] ) ? $value['angle'] : '0';
										$style  .= 'transform: translate(-50%, -50%) scale(' . esc_attr( $sx ) . ', ' . esc_attr( $sy ) . ') rotate(' . $angle . 'deg);';
										$style  .= isset( $value['textAlign'] ) ? 'text-align:' . $value['textAlign'] . ';' : '';
										$style2  = isset( $value['textBackgroundColor'] ) ? '-webkit-box-decoration-break: clone;box-decoration-break: clone;padding: 0 1rem 0.2rem;border-radius: 8px;background-color: ' . $value['textBackgroundColor'] . ';' : '';
										$style2 .= 'font-weight:400;color:' . esc_attr( $value['fill'] ) . ';';
										?>
										<amp-story-grid-layer template="vertical">
											<h1 style="<?php echo $style; ?>"><span style="<?php echo $style2; ?>"><?php echo nl2br( $value['text'] ); ?></span></h1>
										</amp-story-grid-layer>
									<?php endif; ?>
								<?php endforeach; ?>
							<amp-story-grid-layer template="vertical">
								<a
								href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $amp_author->display_name ); ?>"
								role="link"
								data-tooltip-icon="./assets/ic_amp_googblue_1x_web_24dp.png"
								data-tooltip-text="Go to profile"
								class="savatar"
								>
								<amp-img src="<?php echo esc_url( $aimage ); ?>" width="34" height="34"></amp-img>
								<?php echo esc_attr( $amp_author->display_name ); ?>
							</a>
						</amp-story-grid-layer>
					</amp-story-page>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endfor; ?>
	</amp-story>
</body>
</html>


