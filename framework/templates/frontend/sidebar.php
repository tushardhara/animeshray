<?php thb_sidebar_before(); ?>

<?php
	$id = '';

	if ( ! empty( $sidebar_type ) ) {
		$id = 'thb-sidebar-' . $sidebar_type;
	}
?>

<aside class="sidebar <?php echo $sidebar_class; ?>" id="<?php echo $id; ?>">
	<?php thb_sidebar_start(); ?>
	<?php dynamic_sidebar($sidebar); ?>
	<?php thb_sidebar_end(); ?>
</aside>

<?php thb_sidebar_after(); ?>