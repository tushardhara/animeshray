<?php

if ( ! isset( $post_meta ) ) {
	$post_meta = false;
}

$thb_socials = thb_get_social_networks( $post_meta );

?>

<?php if ( ! empty( $thb_socials ) && count( $thb_socials ) > 0 ) : ?>
	<div id="thb-social-icons">
		<?php foreach ( $thb_socials as $social ) : ?>
			<a href="<?php echo thb_get_social_network_url( $social ); ?>" target="_blank" class="thb-social-icon thb-<?php echo str_replace('social_', '', $social); ?>">
				<?php echo $social; ?>
			</a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>