<script type="text/template" data-tpl="thb-gallery-item">
	<li class="<?php echo thb_get_grid_layout_item_class(); ?>" data-filter-{{ filters }}="">
		<a href="{{ image }}" class="item-thumb">
			<span class="thb-overlay"></span>
			<img src="{{ image }}" alt="">
		</a>
		<# if ( title || project ) { #>
			<div class="thb-gallery-data">
				<# if ( title ) { #>
					<h3>{{ title }}</h3>
				<# } #>

				<# if ( project ) { #>
					<p>
						<a href="{{ project.permalink }}">{{ project.name }}</a>
					</p>
				<# } #>
			</div>
		<# } #>
	</li>
</script>