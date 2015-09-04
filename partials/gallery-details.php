<script type="text/template" data-tpl="thb-gallery-details">
	<# if ( type == 'image' ) { #>
		<div class="thb-image-container" style="background-image: url({{ image }});"></div>
	<# } else { #>
		<div class="thb-image-container">
			{{{ image }}}
		</div>
	<# } #>
</script>

<script type="text/template" data-tpl="thb-gallery-details-data">
	<div>
		<div class="thb-details-container <# {{ classes }} #>">
			<# if ( title != '' ) { #>
				<h1 class="thb-details-title">{{ title }}</h1>
			<# } #>

			<# if ( description != '' ) { #>
				<div class="thb-details-description">{{ description }}</div>
			<# } #>

			<# if ( project_url != '' ) { #>
				<div class="thb-details-project">
					<p><span><?php _e( 'Project', 'thb_text_domain' ); ?></span>
						<a href="{{ project_url }}">{{ project_name }}</a>
					</p>
				</div>
			<# } #>

			<# if ( exif != '' ) { #>
				<div class="thb-gallery-details-exif-container">
					<ul>
						<# _.each( exif, function( value, key ) {  #>
							<li class="thb-gallery-details-exif-<# {{ thb_convertToSlug(key) }} #>">
								<span>{{ key }}</span>
								{{ value }}
							</li>
						<# } ) #>
					</ul>
				</div>
			<# } #>

			<?php if ( thb_is_gallery_modal_share_active() ) : ?>
				<div class="meta social-actions">
					<div class="thb-content-share">
						<p class="thb-content-share-title">
							<?php _e('Share on', 'thb_text_domain'); ?>
						</p>
						<ul>
							<li>
								<a data-type="thb-facebook" href="http://www.facebook.com/sharer.php?u={{ link }}" target="_blank" class="thb-content-share-facebook">
									<span>
										<strong><?php _e('Share', 'thb_text_domain'); ?></strong> <?php _e('on Facebook', 'thb_text_domain'); ?>
									</span>
								</a>
							</li>
							<li>
								<a data-type="thb-pinterest" href="//pinterest.com/pin/create/button/?url={{ link }}&media={{ image }}&description={{ title }}" target="_blank" class="thb-content-share-pinterest">
									<span>
										<strong><?php _e('Pin', 'thb_text_domain'); ?></strong> <?php _e('this item', 'thb_text_domain'); ?>
									</span>
								</a>
							</li>
							<li>
								<# var twitter_text = thb_ristorante_urlencode( title + " " + link ); #>

								<a data-type="thb-twitter" href="https://twitter.com/intent/tweet?source=webclient&amp;text={{ twitter_text }}" target="_blank" class="thb-content-share-twitter">
									<span>
										<strong><?php _e('Tweet', 'thb_text_domain'); ?></strong> <?php _e('this item', 'thb_text_domain'); ?>
									</span>
								</a>
							</li>
							<li>
								<a data-type="thb-googleplus" href="https://plus.google.com/share?url={{ link }}" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
									<span>
										<strong><?php _e('Google Plus', 'thb_text_domain'); ?></strong> <?php _e('this item', 'thb_text_domain'); ?>
									</span>
								</a>
							</li>
							<li>
								<a data-type="thb-email" target="_blank" href="mailto:entertheaddress@example.com?subject={{ title }}&body={{ link }}" class="thb-content-share-email">
									<span>
										<strong><?php _e('Email', 'thb_text_domain'); ?></strong> <?php _e('a friend', 'thb_text_domain'); ?>
									</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</script>