<?php
	$thb_title         = get_the_title();
	$thb_subtitle      = thb_get_portfolio_item_subtitle();
	$thb_fi            = thb_get_featured_image( $thb_size );
	$thb_item_class    = thb_get_grid_layout_item_class();
	$image_class       = '';
	$slideview_enabled = thb_get_post_meta( thb_get_page_ID(), 'portfolio_enable_slideviews' ) == '1';

	if ( $slideview_enabled && thb_text_contains( 'cropped', $thb_size ) ) {
		$image_class = 'slideview';
	}

	if( $thb_fi == '' ) {
		$thb_item_class .= ' thb-empty-image';
	} else {
		$thb_item_class .= ' thb-w-image';
	}

	$portfolio_images = array();

	if ( ! empty( $thb_fi ) ) {
		$portfolio_images[] = $thb_fi;
	}

	if ( $slideview_enabled && thb_text_contains( 'cropped', $thb_size ) ) {
		$portfolio_slides = thb_get_portfolio_item_slides( get_the_ID() );
		shuffle( $portfolio_slides );
		$portfolio_slides = array_slice( $portfolio_slides, 0, 9 );

		foreach ( $portfolio_slides as $slide ) {
			if ( $slide['type'] == 'image' ) {
				$portfolio_images[] = thb_image_get_size( $slide['id'], $thb_size );
			}
		}
	}

	$item_args = array(
		'thb_title'        => $thb_title,
		'thb_subtitle'     => $thb_subtitle,
		'portfolio_images' => $portfolio_images,
		'image_class'      => $image_class,
		'thb_fi'           => $thb_fi
	);

	$thb_item_class .= ' thb-block-type-element';

	$thb_item_class = $thb_item_class . ' ' . $thb_item_extra_class;
?>
<li <?php thb_portfolio_post_class( $thb_item_class ); ?> <?php thb_portfolio_item_datafilters(); ?>>
	<article class="work-inner-wrapper">

		<?php
			$data = array(
				'args' => $item_args
			);

			if ( trim( $thb_item_extra_class ) == 'thb-desc-inside' ) {
				thb_get_template_part( 'loop/portfolio-data-inside', $data );
			} else {
				thb_get_template_part( 'loop/portfolio-data-outside', $data );
			}
		?>

	</article>
</li>