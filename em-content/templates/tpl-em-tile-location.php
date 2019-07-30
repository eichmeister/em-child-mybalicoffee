<div class="em-location-tile">

	<a href="<?php echo get_permalink($em_post_id); ?>">

		<figure>
			<?php echo wp_get_attachment_image( get_field('preview_photo', $em_post_id), 'landscape_800' ); ?>
		</figure>

		<div class="inner">

			<div class="place">
				<?php echo get_term( get_field('place', $em_post_id), 'place' )->name; ?>
			</div>

			<h3>
				<?php echo get_the_title($em_post_id); ?>
			</h3>

			<div class="address">
				<?php the_field('address', $em_post_id); ?>, <?php the_field('zip_code', $em_post_id); ?> <?php echo get_term( get_field('place', $em_post_id), 'place' )->name; ?>
			</div>
			

			<div class="btn-line-left">Ansehen</div>

		</div>

	</a>

</div>