<?php if ( get_field( 'display_related', 'options' ) ) : ?>
	<div class="amp-king-related">
		<div class="amp-related-title"><?php the_field( 'related_posts_heading', 'option' ) ?></div>
			<?php // Related Post Code Start.
			$relatednumber = get_field( 'related_length', 'options' );

			if ( get_field( 'display_related_posts_by', 'option' ) === 'categories' ) {

					// Get array of terms.
				$terms = get_the_terms( get_the_ID() , 'category' );
					// Pluck out the IDs to get an array of IDS.
				$relatedby = wp_list_pluck( $terms,'term_id' );
				$relatedby2 = 'category__in';

			} elseif ( get_field( 'display_related_posts_by', 'option' ) === 'tags' ) {

					// Get array of terms.
				$tagsterms = get_the_terms( get_the_ID() , 'post_tag', 'string' );
					// Pluck out the IDs to get an array of IDS.
				$relatedby = '123';
				if ( ! empty( $tagsterms ) ) {
					$relatedby = wp_list_pluck( $tagsterms,'term_id' );
				}

				$relatedby2 = 'tag__in';
			}

			$args = array(
				'' . $relatedby2 . '' => $relatedby,
				'post__not_in' => array( $post->ID ),
					'showposts' => $relatednumber,  // Number of related posts that will be shown.
					'ignore_sticky_posts' => 1,
				);

			$my_query = new wp_query( $args );
			if ( $my_query->have_posts() ) :
				while ( $my_query->have_posts() ) :
					$my_query->the_post(); 
					?>
					<div class="amp-related-post">
						<a href="<?php the_permalink(); ?>amp" class="amp-related-post-link">
							<?php if ( has_post_thumbnail() ) :
							$size_t = 'large';
							$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size_t );
							?>					
							<amp-img src="<?php echo esc_url( $thumb['0'] ); ?>" height="<?php echo esc_attr( $thumb['2'] ); ?>" width="<?php echo esc_attr( $thumb['1'] ); ?>" layout="responsive" ></amp-img>
						<?php endif; ?>
					</a>
					<div class="amp-related-info">	
						<?php the_title( sprintf( '<span class="amp-entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() . 'amp' ) ), '</a></span>' ); ?>
						<?php if ( has_post_format( 'quote' ) ) : ?>
							<a class="simple-post-entry-format" href="<?php echo esc_url( get_post_format_link( 'quote' ) ); ?>"><?php echo esc_html_e( 'News', 'king' ) ?></a>
						<?php elseif ( has_post_format( 'video' ) ) : ?>
							<a class="simple-post-entry-format" href="<?php echo esc_url( get_post_format_link( 'video' ) ); ?>"><?php echo esc_html_e( 'Video', 'king' ) ?></a>
						<?php elseif ( has_post_format( 'image' ) ) : ?>
							<a class="simple-post-entry-format" href="<?php echo esc_url( get_post_format_link( 'image' ) ); ?>"><?php echo esc_html_e( 'Image', 'king' ) ?></a>
						<?php endif; ?>
					</div>
					<div class="amp-related-meta">
						<span class="post-views"><strong><?php echo esc_attr( king_postviews( get_the_ID(), 'display' ) ); ?> </strong><?php esc_html_e( 'views', 'king' ); ?> • </span>
						<span class="post-comments"><strong><?php comments_number( ' 0 ', ' 1 ', ' % ' ); ?> </strong><?php esc_html_e( 'comments', 'king' ); ?> • </span>
						<span class="post-time"><?php the_time( 'F j, Y' ); ?></span>			
					</div>
				</div>				
				<?php endwhile;
				wp_reset_postdata();
			else :
				?>
				<div class="no-follower"><i class="fab fa-slack-hash fa-2x"></i><?php esc_html_e( 'Sorry, no posts were found', 'king' ); ?> </div>
			<?php endif; ?>
		</div> <!-- .king-related -->
	<?php endif; ?>