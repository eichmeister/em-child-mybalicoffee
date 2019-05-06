<?php

defined( 'ABSPATH' ) || exit;

$region_field = get_field('gebiet_region');
$region_term_meta = get_term_meta( $region_field->term_id ); 

$flavor_field = get_field('bohnenart');
$flavor_term_meta = get_term_meta( $flavor_field->term_id ); 
?>
<div class="region padding-bot-100">
	<div class="row">

		<div class="col_6">
			<div class="region-background" style="background-color: <?php echo $region_term_meta['background_color'][0]; ?>"></div>
			<?php echo wp_get_attachment_image(array_shift($region_term_meta['background_image']), $size = 'full' ); ?>
		</div>
		<div class="col_6 content">
			<h3 class="hl3"><b><?php echo $region_field->name; ?></b></br><?php echo array_shift($region_term_meta['sub_headline']); ?></h3>
			<p><?php echo $region_field->description; ?></p>
		</div>
	
	</div>
</div>


<div class="flavor padding-bot-50">
	<div class="row">

		<div class="col_6 order-2">
			<div class="flavor-background" style="background-color: <?php echo array_shift($flavor_term_meta['background_color']); ?>"></div>
			<?php echo wp_get_attachment_image(array_shift($flavor_term_meta['background_image']), $size = 'full' ); ?>
		</div>

		<div class="col_6 content order-1">
			<h3 class="hl3"><b><?php echo $flavor_field->name; ?></b></br><?php echo array_shift($flavor_term_meta['sub_headline']); ?></h3>
			<p><?php echo $flavor_field->description; ?></p>
		</div>
	
	</div>
</div>