<?php
/**
 * King AMP Head.
 *
 * @package King_Theme
 */
?>
<?php 
	$amp_image = king_get_post_image_metadata();
	$amp_title = get_the_title();
	$amp_url = get_permalink();
	$amp_author = get_userdata( $post->post_author );
	$amp_icon_url = get_site_icon_url( 150 );
?>
	<title><?php wp_title( $amp_title ); ?></title>
	<link rel="canonical" href="<?php echo esc_url( $amp_url ); ?>">
	<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
	<script type="application/ld+json">
		{
			"@context": "http://schema.org",
			"@type": "Article",
			"mainEntityOfPage" : "<?php echo esc_url( $amp_url ); ?>",
			"headline": "<?php echo esc_attr( $amp_title ); ?>",
			"datePublished": "<?php echo get_the_date( 'c' ); ?>",
			"author": {
				"@type": "Person",
				"name": "<?php echo esc_attr( $amp_author->display_name ); ?>"
			},
			"publisher": {
				"@type": "Organization",
				"name": "<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>",
<?php if ( $amp_icon_url ) : ?>
				"logo": {
					"@type": "ImageObject",
					"url": "<?php echo esc_url( $amp_icon_url ); ?>",
					"width": 150,
					"height": 150
				}
<?php endif; ?>
			},	
<?php if ( $amp_image ) : ?>
			"image": {
				"@type": "ImageObject",
				"url": "<?php echo esc_url( $amp_image['url'] ); ?>",
				"height": <?php echo esc_attr( $amp_image['height'] ); ?>,
				"width": <?php echo esc_attr( $amp_image['width'] ); ?> 
			}
<?php endif; ?>
		}
	</script>
	<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
	<script async custom-element="amp-vimeo" src="https://cdn.ampproject.org/v0/amp-vimeo-0.1.js"></script>
	<script async custom-element="amp-facebook" src="https://cdn.ampproject.org/v0/amp-facebook-0.1.js"></script>
	<script async custom-element="amp-soundcloud" src="https://cdn.ampproject.org/v0/amp-soundcloud-0.1.js"></script>
	<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
	<script async custom-element="amp-anim" src="https://cdn.ampproject.org/v0/amp-anim-0.1.js"></script>
	<script async custom-element="amp-video" src="https://cdn.ampproject.org/v0/amp-video-0.1.js"></script>
	<script async custom-element="amp-audio" src="https://cdn.ampproject.org/v0/amp-audio-0.1.js"></script>
	<script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
	<script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>	

	<link rel="stylesheet" href="https:<?php echo king_google_fonts_url(); ?>" >
	<style amp-custom>
abbr,
acronym,
address,
applet,
article,
aside,
audio,
b,
big,
blockquote,
body,
canvas,
caption,
center,
cite,
code,
dd,
del,
details,
dfn,
div,
dl,
dt,
em,
fieldset,
figcaption,
figure,
font,
footer,
form,
h1,
h2,
h3,
h4,
h5,
h6,
header,
hgroup,
html,
i,
iframe,
img,
ins,
kbd,
label,
legend,
li,
mark,
menu,
nav,
object,
ol,
p,
pre,
q,
s,
samp,
section,
small,
span,
strike,
strong,
sub,
summary,
sup,
table,
tbody,
td,
tfoot,
th,
thead,
time,
tr,
tt,
u,
ul,
var,
video {
  margin: 0;
  padding: 0;
  border-width: 0;
  border-style: solid;
  outline: 0;
  font-size: 100%;
  vertical-align: baseline;
  background: 0 0
}	
	body {
		margin: 0;
<?php if ( get_field( 'amp_body_background_color', 'option' ) ) : ?>
	background-color: <?php the_field( 'amp_body_background_color', 'option' ); ?>;
<?php else : ?>
	background-color: #ffffff;
<?php endif; ?>		
<?php if ( get_field( 'google_fonts','options' ) ) :
	$fonts = get_field_object( 'google_fonts', 'options' );
	$value = $fonts['value'];
	$font_family = $fonts['choices'][ $value ]; ?>
		font-family: '<?php echo esc_attr( $font_family ); ?>', sans-serif;
<?php else : ?>
		font-family: 'Open Sans', sans-serif;
<?php endif; ?>	
		line-height:28px;
<?php if ( get_field( 'amp_container_text_color', 'option' ) ) : ?>
	color: <?php the_field( 'amp_container_text_color', 'option' ); ?>;
<?php else : ?>
	color: #666;
<?php endif; ?>		
	}
	<?php $amp_image = king_get_post_image_metadata(); ?>
	<?php 
	$author_id = get_post_field ( 'post_author', get_the_ID() );
	if ( get_field( 'author_image','user_' . $author_id ) ) :
		$image = get_field( 'author_image','user_' . $author_id );
	?>
	<?php endif; ?>	
	<?php if ( has_post_thumbnail() ) : ?>
	.amp-header-background { background-image: url(<?php echo esc_url( $amp_image['url'] ); ?>); }
	<?php endif; ?>    
	.post-author-avatar { background-image: url(<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>); }
article,
aside,
details,
figcaption,
figure,
footer,
header,
hgroup,
menu,
nav,
section {
  display: block
}
ol,
ul {
  list-style: none
}

blockquote,
q {
  quotes: none
}

:focus {
  outline: 0
}

ins {
  text-decoration: none
}

del {
  text-decoration: line-through
}

ul {
  margin-left: 2em;
  list-style-type: circle
}

ol {
  margin-left: 2em;
  list-style-type: decimal
}

dl {
  margin-bottom: 1.5em
}

dt {
  font-weight: 700
}

dd {
  margin-bottom: .75em
}

pre {
  overflow: auto;
  white-space: pre;
  white-space: pre-wrap;
  word-wrap: break-word
}

code {
  font-family: monospace, serif
}

pre code {
  padding: .75em;
  display: block;
  border-width: 0
}

blockquote {
  min-height: 32px;
  padding: 0 22px
}
a {
  cursor: pointer;
  text-decoration: none;
  border-width: 0;
  border-style: solid
}

a:active,
a:hover {
  outline: 0
}
.amp-king-video {
	margin: 12px 0;
}
.amp-king-header {
	display:block;
<?php if ( get_field( 'amp_header_background', 'option' ) ) : ?>
	background-color:  <?php the_field( 'amp_header_background', 'option' ); ?>;
<?php else : ?>
	background-color: #ffffff;
<?php endif; ?>
	text-align:center;
	position:fixed;
	width:100%;
	height:60px;
	z-index:12;
	top:0;
	-webkit-box-shadow: 0 2px 4px 0 rgba(0,0,0,.15);
    box-shadow: 0 2px 4px 0 rgba(0,0,0,.15);
}
.amp-header-background {
    min-height: 140px;
    background-repeat: no-repeat;
    background-size: cover;
    display:block;
    background-position: center;
    position:relative;
    text-align:center;
    padding: 30px 20px 60px 20px;
    margin-bottom: 8px;
    border-radius: 8px;
}

.amp-king-article-header {
	display:block;
	margin-top:20px;
	z-index:8;
	position:relative;
	color:#949191;
}
.amp-king-article-header .entry-title {
	display:block;
	padding:0;
	margin:0;
	color:#fff;
	z-index:8;
	position:relative;

}
.amp-king-container {
	margin: 60px auto 0;
	width: 778px;
	display:block;
	position: relative;
	padding: 9px;
	box-sizing: border-box;
}
.amp-king-logo amp-img {
	max-height: 60px;
    max-width: 180px;
}
.amp-king-article {
<?php if ( get_field( 'amp_container_background', 'option' ) ) : ?>
	background-color:  <?php the_field( 'amp_container_background', 'option' ); ?>;
<?php else : ?>
	background-color: #ffffff;
<?php endif; ?>	
	padding:10px 0;
}
.list-item-image amp-img {
	display:block;
}
.amp-king-share a{
	display:inline-block;
	background-color:#dedbdb;
	width:20%;
	height:50px;
	border-radius:8px;
	line-height:50px;
	text-align:center;
}
.amp-king-share {
<?php if ( get_field( 'amp_share_box_background', 'option' ) ) : ?>
	background-color:  <?php the_field( 'amp_share_box_background', 'option' ); ?>;
<?php else : ?>
	background-color: #ffffff;
<?php endif; ?>	
    border-radius: 8px;
    display: block;
    text-align: center;
    padding: 1px 8px;
    z-index: 2;
    margin: -40px 8px 8px;
    position: relative;
}

.amp-king-share amp-social-share {
    border-radius: 32px;
    padding: 0 6px;
    background-size: 30%;
    display: inline-block;
    outline: 0;
    background-color: #dadbe2;
    background-position: center;
    margin-top: 6px;
    -webkit-transition-duration: .3s;
    transition-duration: .3s;
    -webkit-transition-property: -webkit-transform, box-shadow, width;
    transition-property: transform, box-shadow, width;
    -webkit-transition-timing-function: ease-in-out;
    transition-timing-function: ease-in-out;
}
.amp-king-share amp-social-share:hover {
-webkit-transform: translateY(-2px);
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(0, 0, 0, .15);
}
.amp-header-background:after {
	content: '';
	position: absolute;
	top:0;
	right: 0;
	left: 0;
	bottom:0;
	border-radius: 8px;
    background-color: rgba(30, 30, 30, 0.2);
    -webkit-backdrop-filter: saturate(180%) blur(5px);
    backdrop-filter: saturate(180%) blur(5px);
}
.amp-king-article-footer a {
    color: #989dad;
    background-color: #f3f3f3;
	padding:12px 0;
	border-radius: 5px;
	text-align:center;
	display:block;
	text-decoration:none;
	margin-top:40px;
}
.list-item-content {
	display:block;
	margin:14px 0;
}
.list-item-title .list-item-number {
	float:left;
	display:block;
	margin-right:10px;
	margin-top:8px;
	background-color: #464646;
    border-radius: 32px;
    text-align: center;
    color: #fff;
    font-size: 14px;
    font-weight: bold;
    height: 28px;
    width: 28px;
    line-height: 28px;
}
h3 {
    font-size: 32px;
    line-height: 40px;
    font-weight:400;
    margin:18px 0;
}

.amp-king-author {
	display:block;
	bottom:8px;
	left:8px;
	right:8px;
	z-index:8;
}
.amp-king-author .post-author-avatar {
	display:inline-block;
	width:32px;
	height:32px;
	background-size:cover;
	background-position:center;
	border-radius:32px;
	border:2px solid #fff;
	background-color:#666;
	margin-right:10px;
}
.amp-king-author .post-author-name {
	display:inline-block;
	vertical-align:top;
	color:#efefef;
	margin-top:4px;
}
.amp-king-author .post-time {
	display:inline-block;
	vertical-align:top;
	color:#efefef;
	font-size:9px;
	margin-top:5px;
}
.amp-related-post {
	display:block;
	position:relative;
}
.amp-king-video iframe {
	width: 100%;
}
.amp-related-post amp-img {
	border-radius:8px;
	box-shadow: 0 4px 14px rgba(0,0,0,.15);
	margin:10px;
}
.amp-related-info {
	position:absolute;
	top:20%;
	left:10px;
	right:10px;
	display:block;
	z-index:4;
	text-align:center;
}
.amp-entry-title a {
	color:#fff;
	font-size:24px;
	display:block;
	margin:10px;
	text-shadow: 1px 2px 2px rgba(0, 0, 0, 0.4);
    word-wrap: break-word;
}
.post-meta {
	color:#efefef;
	font-size:12px;

}
.post-meta i {
	margin:0 3px 0 18px;
	color:#fff;
}
.amp-related-title {
	margin:20px 8px;
	font-size:24px;
	color:#000;
	text-align:center;
}
.simple-post-entry-format {
    background-color: rgba(255, 255, 255, 0.62);
    display: inline-block;
    padding: 4px 12px;
    font-size: 11px;
    color: #343434;
    border-radius: 32px;
    line-height: 18px;
    font-weight: 600;

}
.amp-related-meta {
    color: #a5a5a5;
    font-size: 12px;
    font-weight: 400;
    margin-top: 10px;
    background-color: rgb(255 255 255);
    padding: 18px;
    text-align: center;
    position: absolute;
    bottom: 0;
    left: 10px;
    right: 10px;
    border-radius: 0 0 8px 8px;
}
.amp-related-meta i {
    margin: 0 3px 0 18px;
    color: #fff;
}
.ampstart-btn {
	display: block;
    cursor: pointer;
    position: fixed;
    top: 0;
    left: 20px;
    z-index: 14;
    height: 60px;
    width: 28px;
}
.ampstart-btn span {
  display: block;
  position: absolute;
  top: 28px;
  left: 0;
  right: 0;
  height: 4px;
  background: #050505;
  border-radius:16px;
}

.ampstart-btn span::before,
.ampstart-btn span::after {
  position: absolute;
  display: block;
  width: 100%;
  height: 4px;
  background-color: #050505;
  content: "";
  border-radius:16px;
}
.ampstart-btn span::before {
  top: 8px;
}
.ampstart-btn span::after {
  bottom: 8px;
}
.amp-king-sidebar {
    display: block;
    margin: 20px;
}
.amp-king-sidebar ul li, .amp-king-sidebar ul {
	list-style:none;
	margin-left:0;
}
.amp-king-sidebar ul.children {
	padding-left:20px;
	margin-bottom:10px;
}
amp-sidebar {
	background-color: #fff;
}
.amp-king-sidebar ul li a {
	color:#898c98;
	display:block;
	padding:6px 0;
	min-width:240px;
	border-bottom:1px solid #efefef;
}
.amp-king-side-links {
	margin-bottom:20px;
}
#sidebar::-webkit-scrollbar {
    width: 6px;
}
#sidebar::-webkit-scrollbar-track {
    background-color: #f5f5f5;
}
#sidebar::-webkit-scrollbar-thumb {
    background-color: #c9c9c9;
    border-radius:16px;
    visibility:hidden;
}
#sidebar:hover::-webkit-scrollbar-thumb {
	visibility:visible;
}
#sidebar::-webkit-scrollbar-thumb:hover {
  background-color: #000;
}
#sidebar .ampstart-btn {
	padding-top:16px;
	height:44px;
	color:#050505;
}
@media screen and (max-width:850px) {
.amp-king-container {
    width: 100%;
}
.amp-king-entry-content iframe {
	width:100%;
}
}
<?php if ( get_field( 'amp_custom_css', 'option' ) ) : ?>
	<?php the_field( 'amp_custom_css', 'option' ); ?>
<?php endif; ?>
</style>