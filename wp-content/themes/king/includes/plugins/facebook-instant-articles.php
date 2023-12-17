<?php
/**
 * Facebook instant articles.
 *
 * @package King WP Theme
 */

use Facebook\InstantArticles\Elements\Video;
use Facebook\InstantArticles\Elements\Image;
use Facebook\InstantArticles\Elements\Audio;
use Facebook\InstantArticles\Elements\Paragraph;
use Facebook\InstantArticles\Elements\SocialEmbed;
use Facebook\InstantArticles\Elements\H2;


add_action( 'instant_articles_after_transform_post', function( $ia_post ) {
	$instant_article = $ia_post->instant_article;
	$post_id = $ia_post->get_the_id();
	$video_url = get_field( 'video-url', $post_id );

	if ( get_field( 'video_tab', $post_id ) ) :
		$videofile = get_field( 'video_upload', get_the_ID() );
		if ( $videofile['type'] === 'audio' ) :
			$instant_article->addChild( Audio::create()->withURL( $videofile['url'] ) );
		elseif ( $videofile['type'] === 'video' ) :
			$instant_article->addChild( Video::create()->withURL( $videofile['url'] ) );
		endif;
	else :
		$instant_article->addChild( SocialEmbed::create()->withHTML( stripslashes( $video_url ) ) );
	endif;

	if ( have_rows( 'news_list_items', $post_id ) ) :

		while ( have_rows( 'news_list_items', $post_id ) ) :
			the_row();
			$image = get_sub_field( 'news_list_image' );
			$size = 'large';
			$media = get_sub_field( 'news_list_media' );
			$title = get_sub_field( 'news_list_title' );
			$content = get_sub_field( 'news_list_content', false, false );
			
			if ( $title ) :
				$instant_article->addChild( H2::create()->appendText( $title ) );
			endif;
			if ( $image ) :
				$instant_article->addChild( Image::create()->withURL( $image['sizes'][ $size ] ) );
			endif;
			if ( $media ) :
				$instant_article->addChild( SocialEmbed::create()->withHTML( $media ) );
			endif;
			if ( $content ) :
				$instant_article->addChild( Paragraph::create()->appendText( $content ) );
			endif;

		endwhile;
	endif;

	if ( have_rows( 'images_lists', $post_id ) ) :
		while ( have_rows( 'images_lists' ) ) :
			the_row();
			$multpile_image = get_sub_field( 'images_list' );
			$instant_article->addChild( Image::create()->withURL( $multpile_image['sizes']['large'] ) );
		endwhile;
	endif;
} );

