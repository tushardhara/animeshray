<?php

/**
 * Register the gallery categories taxononmy associated to media items.
 */
function thb_superba_register_gallery_categories_args() {
	$thb_superba_gallery_categories_args = array(
		'hierarchical'   => true,
		'labels' => array(
			'name'              => __( 'Gallery Categories', 'thb_text_domain' ),
			'singular_name'     => __( 'Gallery Category', 'thb_text_domain' ),
			'search_items'      => __( 'Search Gallery Categories', 'thb_text_domain' ),
			'all_items'         => __( 'All Gallery Categories', 'thb_text_domain' ),
			'parent_item'       => __( 'Parent Gallery Category', 'thb_text_domain' ),
			'parent_item_colon' => __( 'Parent Gallery Category:', 'thb_text_domain' ),
			'edit_item'         => __( 'Edit Gallery Category', 'thb_text_domain' ),
			'update_item'       => __( 'Update Gallery Category', 'thb_text_domain' ),
			'add_new_item'      => __( 'Add New Gallery Category', 'thb_text_domain' ),
			'new_item_name'     => __( 'New Gallery Category Name', 'thb_text_domain' ),
			'menu_name'         => __( 'Gallery Categories', 'thb_text_domain' )
		),
		'rewrite'        => true,
		'query_var'      => true
	);

	register_taxonomy( 'superba_gallery_categories', 'attachment', $thb_superba_gallery_categories_args );
}

add_action( 'init', 'thb_superba_register_gallery_categories_args' );