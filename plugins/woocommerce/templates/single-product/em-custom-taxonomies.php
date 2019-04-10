<?php

defined( 'ABSPATH' ) || exit;

$region_field = get_field('gebiet_region');
$region_term_meta = get_term_meta( $region_field->term_id ); 

$flavor_field = get_field('bohnenart');
$flavor_term_meta = get_term_meta( $flavor_field->term_id ); 
?>
<div class="region">
	<div class="row">

		<div class="col_6">
			<div class="custom-background"></div>
			<?php echo wp_get_attachment_image(array_shift($flavor_term_meta['background_image']), $size = 'full' ); ?>
		</div>
		<div class="col_6">
			<div class="content">
				<h3 class="hl3"><?php echo $flavor_field->name; ?></h3>
				<h4 class="hl4"><?php echo array_shift($flavor_term_meta['sub_headline']); ?></h4>
				<p><?php echo $flavor_field->description; ?></p>
			</div>
		</div>
	
	</div>
</div>


<div class="flavor">
	<div class="row">

		<div class="col_6">
			<div class="content">
				<h3 class="hl3"><?php echo $region_field->name; ?></h3>
				<h4 class="hl4"><?php echo array_shift($region_term_meta['sub_headline']); ?></h4>
				<p><?php echo $region_field->description; ?></p>
			</div>
		</div>

		<div class="col_6">
			<div class="custom-background"></div>
			<?php echo wp_get_attachment_image(array_shift($region_term_meta['background_image']), $size = 'full' ); ?>
		</div>
	
	</div>
</div>