<div class="em-content-repeater">

	<?php $flip=true; foreach ( $items as $item ): ?>
		<div class="row">
			<div class="item col_6 <?php if($flip){ echo 'order-2'; } ?>">
				<?php echo wp_get_attachment_image( $item['image']['ID'], $size ); ?>
			</div>

			<div class="item col_6">
				<div class="">
					<?php echo wp_get_attachment_image( $item['trademark']['ID'], $size ); ?>
					<?php 
					echo $item['bgc'];
					echo $item['fs_bg'];

					$hl_logo = $item['headline_logo'];
					if ( $hl_logo == 'hl' ) {
						echo $item[$hl_logo];
					} else {
						echo wp_get_attachment_image( $item['logo']['ID'], $size );
					}
					echo $item['content'];
					?>
					<a href="<?php echo $item['link']['url']; ?>" target="<?php echo $item['link']['target']; ?>" title="<?php echo $item['link']['title']; ?>" class="btn-line-left"><?php echo $item['link']['title']; ?></a>
				</div>
			</div>
		</div>

		<?php $flip = $flip ? false : true; ?>

	<?php $i++; endforeach; ?>

	</div>
</div>