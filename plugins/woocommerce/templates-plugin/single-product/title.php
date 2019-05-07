<?php
$region_field = get_field( 'gebiet_region', $product->get_id() );
$flavor_field = get_field( 'bohnenart', $product->get_id() );

echo '<h2 class="span">' . $flavor_field->name . '</h2>';
the_title( '<h1 class="hl1">', '</h1>' );
echo '<h3 class="span">' . $region_field->name . '</h3>';