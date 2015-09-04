<?php if( $data['thb_format'] != 'aside' && ( !empty( $data['thb_title'] ) || !empty( $data['thb_title_alt'] ) ) ) : ?>

	<header class="item-header">

		<?php if ( !empty( $data['thb_title'] ) || !empty( $data['thb_title_alt'] ) ) : ?>

			<?php if( $data['thb_format'] === 'quote' ) : ?>
				<h1 class="entry-title">
					<a href="<?php the_permalink(); ?>">
						<?php echo $data['thb_title_alt']; ?>
					</a>
				</h1>
			<?php else : ?>
				<h1 class="entry-title">
					<a href="<?php the_permalink(); ?>">
						<?php echo $data['thb_title']; ?>
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
						printf( '<a href="%s">%s</a>', $thb_quote_url, $data['thb_subtitle'] );
					} else {
						echo $data['thb_subtitle'];
					}
				?>
			</span>

			<p class="thb-post-date"><?php echo get_the_date(); ?></p>

		<?php endif; ?>

		<?php if( thb_get_post_format() === 'link') : ?>
			<span class="post-format-link-url">
				<a href="<?php echo $data['thb_link_url']; ?>" rel="external">
					<?php echo $data['thb_link_url']; ?>
				</a>
			</span>
		<?php endif; ?>

	</header>

<?php endif; ?>