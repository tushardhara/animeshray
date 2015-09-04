<?php
	$thb_post_id     = get_the_ID();
	$thb_category    = get_the_category();
	$thb_tags        = get_the_tags();
	$thb_link_url    = thb_get_post_format_link_url();
	$thb_format      = thb_get_post_format();
	$thb_title       = get_the_title();
	$thb_title_alt   = get_the_title();
	$wrapper_classes = 'post-wrapper';
	$comment_number  = get_comments_number();

	if( $thb_format === 'quote' ) {
		$thb_title_alt = thb_get_post_format_quote_text();
		$thb_subtitle = thb_get_post_format_quote_author();
	}

	if( post_password_required() ) {
		$thb_title = __('Protected: ', 'thb_text_domain') . get_the_title();
	}

	$feature_image_src = '';

	if( $thb_format === 'image' ) {
		$feature_image_src = thb_get_post_format_image_src( $thb_thumb_size );
	}
	elseif( $thb_format !== 'gallery' && $thb_format !== 'aside' ) {
		$feature_image_src = thb_get_featured_image( $thb_thumb_size );
	}

	if ( !empty( $feature_image_src ) ) {
		$wrapper_classes .= ' w-image';
	} else {
		$wrapper_classes .= ' wout-image';
	}
?>

<div class="<?php echo esc_attr( $wrapper_classes ); ?>">

	<?php if( $thb_format != 'aside' && ( !empty( $thb_title ) || !empty( $thb_title_alt ) ) ) : ?>

		<header class="item-header">

			<?php if ( !empty( $thb_title ) || !empty( $thb_title_alt ) ) : ?>

				<?php if( $thb_format === 'quote' ) : ?>
					<h1 class="entry-title">
						<a href="<?php the_permalink(); ?>">
							<?php echo $thb_title_alt; ?>
						</a>
					</h1>
				<?php else : ?>
					<h1 class="entry-title">
						<a href="<?php the_permalink(); ?>">
							<?php echo $thb_title; ?>
						</a>
					</h1>

					<?php
						$timestamp = strtotime( get_the_date() );
						$microdate = date( 'Ymd', $timestamp );
					?>
					<p class="updated published thb-post-date" title="<?php echo $microdate; ?>"><?php echo get_the_date(); ?></p>
				<?php endif; ?>

			<?php endif; ?>

			<?php if( thb_get_post_format() === 'quote' ) : ?>

				<span class="quote-author">
					<?php
						if ( ( $thb_quote_url = thb_get_post_format_quote_url() ) != '' ) {
							printf( '<a href="%s">%s</a>', $thb_quote_url, $thb_subtitle );
						} else {
							echo $thb_subtitle;
						}
					?>
				</span>

				<p class="thb-post-date"><?php echo get_the_date(); ?></p>

			<?php endif; ?>

			<?php if( thb_get_post_format() === 'link') : ?>
				<span class="post-format-link-url">
					<a href="<?php echo $thb_link_url; ?>" rel="external">
						<?php echo $thb_link_url; ?>
					</a>
				</span>
			<?php endif; ?>

		</header>

	<?php endif; ?>

	<?php if( $thb_format == 'aside' ) : ?>
		<header class="item-header hidden">
			<h1 class="hidden"><?php echo $thb_title_alt; ?></h1>
		</header>
	<?php endif; ?>

	<?php if ( !empty( $feature_image_src ) || $thb_format === 'gallery' || ( thb_page_has_video( get_the_ID() ) || thb_page_has_audio( get_the_ID() ) ) ) : ?>

		<div class="thb-loop-image-wrapper">

			<div class="thb-loop-image-inner-wrapper">

				<?php
					if ( $thb_format != 'video' ) {

						if ( !empty( $feature_image_src ) ) {
							$thb_image_config = array();

							if ( isset( $thb_thumbnails_open_post ) && $thb_thumbnails_open_post ) {
								$thb_image_config['link_href'] = get_permalink( get_the_ID() );
							}

							if( $thb_format === 'image' ) {
								thb_post_format_image( $thb_thumb_size, $thb_image_config );
							}
							elseif( $thb_format !== 'gallery' && $thb_format !== 'aside' ) {
								thb_featured_image( $thb_thumb_size, $thb_image_config );
							}
						}

						if( $thb_format === 'gallery' ) {
							thb_post_format_gallery( $thb_thumb_size, 'full', 'rsTHB' );
						}

					}

					if ( thb_page_has_video( get_the_ID() ) || thb_page_has_audio( get_the_ID() ) ) {
						echo '<div class="format-embed-wrapper">';
							if( $thb_format === 'video' ) {
								thb_post_format_video();
							} elseif ( $thb_format === 'audio' ) {
								thb_post_format_audio();
							}
						echo '</div>';
					}
				?>
			</div>

		</div>

	<?php endif; ?>

	<?php if( thb_get_post_format() != 'quote') : ?>
	<div class="loop-post-content">

		<div class="item-content">
			<?php if( get_the_excerpt() != '' && $thb_format != 'aside' ) : ?>
				<div class="thb-text">
					<?php if( !post_password_required() ) : ?>
						<?php the_excerpt(); ?>
					<?php else : ?>
						<?php _e('This post is password protected.', 'thb_text_domain'); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $thb_format == 'aside' ) : ?>
				<div class="thb-text">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="loop-post-meta">
			<ul>
				<?php if ( !empty( $thb_category ) ) : ?>
					<li class="category"><?php _e( 'on', 'thb_text_domain' ); ?> <?php the_category(', '); ?></li>
				<?php endif; ?>
				<li class="thb-comments-number <?php if( !empty( $comment_number ) ) : ?>w-comments<?php endif; ?>">
					<a href="<?php comments_link(); ?>">
						<span><?php thb_comments_number( true ); ?></span>
					</a>
				</li>
				<?php if ( thb_is_blog_likes_active() ) : ?>
					<li class="thb-post-like">
						<?php thb_like(); ?>
					</li>
				<?php endif; ?>
			</ul>
		</div>

	</div>

	<?php endif; ?>
</div>