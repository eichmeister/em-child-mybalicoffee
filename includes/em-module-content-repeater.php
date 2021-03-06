<div class="em-content-repeater padding-ver-50">

	<?php $flip=false; foreach ( $items as $item ): ?>

		<div class="row<?php if($flip){ echo ' flipped'; } ?><?php if( isset( $item['fs_bg']) && $item['fs_bg'] != false ) { echo ' fs-bg'; } ?>">

			<div class="item item-image col_6 <?php if($flip){ echo 'order-2'; } ?>" data-start="top" style="background-color: <?php echo $item['bgc']; ?>">
				<figure
			    data-bottom-top="transform:translateY(100px);"
			    data-top-bottom="transform:translateY(-30px);"
			    >
					<?php echo wp_get_attachment_image( $item['image']['ID'], 'img_800' ); ?>
					<?php if( isset($item['trademark']['ID']) ) { ?>
						<div class="trademark"><?php echo wp_get_attachment_image( $item['trademark']['ID'], 'img_500' ); ?></div>
					<?php } ?>
				</figure>
			</div>

			<div class="item item-text col_6" <?php if( isset( $item['fs_bg']) && $item['fs_bg'] != false ) { echo 'style="background-color: ' . $item['bgc'] . '"'; } ?>>
				<?php 
				
				echo '<div class="logo-headline">';

				$hl_logo = $item['headline_logo'];
				if ( $hl_logo == 'hl' ) {
					echo '<h4 class="hl4">' . first_line_bold($item[$hl_logo]) . '</h4>';
				} else {
					echo wp_get_attachment_image( $item['logo']['ID'], 'img_500' );
				}

				echo '</div>';

				echo '<div class="content">' . $item['content'] . '</div>';
				?>
				<?php if ( isset($item['link']) && !empty($item['link']) ) { ?>
					<a href="<?php echo $item['link']['url']; ?>" target="<?php echo $item['link']['target']; ?>" title="<?php echo $item['link']['title']; ?>" class="btn-line-left"><?php echo $item['link']['title']; ?></a>
				<?php } ?>
			</div>
		</div>
		<?php $flip = $flip ? false : true; ?>

	<?php endforeach; ?>

</div>