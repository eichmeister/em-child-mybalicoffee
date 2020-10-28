<div class="em-testimonial-tile photo">
	<?php if (get_field('photo', $em_post_id)): ?>
		<figure>
			<?php echo wp_get_attachment_image( get_field('photo', $em_post_id)['ID'], 'img_500' ); ?>
		</figure>
	<?php endif; ?>
	<div class="name-position margin-ver-10">
		<span class="name">
			<?php echo get_the_title($em_post_id); ?>
		</span>

		<?php if (get_field('position', $em_post_id)): ?>
			<span class="position">
				- <?php echo get_field('position', $em_post_id); ?>
			</span>
		<?php endif; ?>
	</div>

	<?php if (get_field('company', $em_post_id)): ?>
		<div class="company">
			<?php echo get_field('company', $em_post_id); ?>
		</div>
	<?php endif; ?>

	<div class="statement">
		<?php echo get_field('statement', $em_post_id); ?>
	</div>
</div>