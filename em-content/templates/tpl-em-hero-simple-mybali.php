<div class="em-hero-simple bg-<?php echo $contents['bg_type']; ?> <?php if (!empty($class)) { echo $class; } ?>" <?php if (!empty($style)) { echo $style; } ?> >
	
	<div class="inner-full" id="<?php echo $bg_id; ?>" <?php if ( $contents['bg_type'] == 'photo' ) EM()->load( array('tpl' => 'bg_cover', 'img' => $contents['bg_photo'], 'id' => $bg_id ) ); ?> >

		<?php 

		//////////////////////////////////////////////////////
		// BACKGROUND VIDEO 
		//////////////////////////////////////////////////////

		?>

		<?php if ( $contents['bg_type'] == 'video' ): ?>
			<div class="bg-video-wrapper">
				<input type="hidden" name="bg-video-id" class="bg-video-id" value="<?php echo $video_id; ?>" />
			</div>
		<?php endif; ?>

		<?php if ( $contents['bg_type'] == 'slider' ): ?>

			<?php 

			//////////////////////////////////////////////////////
			// SLIDER 
			//////////////////////////////////////////////////////

			?>

			<div class="em-slider owl-carousel" <?php echo $slider_data_attr; ?> >

				<?php $slide_index=1; foreach ( $slides as $slide ) : ?>
					<?php $slide_id = $bg_id.'-'.$slide_index; ?>

					<?php 

					// Background Image Focus
					$img_id = $slide['bg_photo'];
					$focus_x = get_field('img_focus_x', $img_id['ID']) ? get_field('img_focus_x', $img_id['ID']) : '50%';
	        		$focus_y = get_field('img_focus_y', $img_id['ID']) ? get_field('img_focus_y', $img_id['ID']) : '50%';

	        		// Different background image for Phones, Tablets and Desktops
	        		$detect = new Mobile_Detect;
	        		if ( $detect->isTablet() ){

	        			// Tablet
	        			$img_src = $slide['bg_photo']['sizes']['img_1200'];

	        		} else if( $detect->isMobile() && !$detect->isTablet() ) {

	        			// Phone
	        			$img_src = $slide['bg_photo']['sizes']['img_1200'];

	        		} else {

	        			// Desktop
	        			$img_src = $slide['bg_photo']['sizes']['bg_img'];

	        		}

	        		?>

					<div class="slide owl-lazy" 
						 data-src="<?php echo $img_src; ?>"
						 style="background-position: <?php echo $focus_x.' '.$focus_y; ?>;"
						 id="<?php echo $slide_id; ?>"

						 <?php // EM()->load( array('tpl' => 'bg_cover', 'img' => $slide['bg_photo'], 'id' => $slide_id ) ); ?> 

						 >
						
						<div class="inner-wrapper">

							<<?php echo $hl_tag; ?>>
								<?php if ($slide['headline']): ?>
									<?php $i=1; foreach ($slide['headline'] as $headline): ?>
										<?php if ( $headline['txt'] ): ?>
											<div class="hl hl-<?php echo $i; ?>">
												<?php echo $headline['txt']; ?>
											</div>
										<?php endif; ?>
									<?php $i++; endforeach; ?>
								<?php endif; ?>
							</<?php echo $hl_tag; ?>>

							<?php if (!empty($slide['desc'])): ?>
								<?php $i=1; foreach ($slide['desc'] as $desc): ?>
									<?php if ( $desc['txt'] ): ?>
										<div class="desc desc-<?php echo $i; ?>">
											<?php echo $desc['txt']; ?>
										</div>
									<?php endif; ?>
								<?php $i++; endforeach; ?>
							<?php endif; ?>

							<?php if (!empty($slide['cta'])): ?>
								<div>
									<?php $i=1; foreach ($slide['cta'] as $cta): ?>
										<?php if ( !empty($cta['link']['url']) && !empty($cta['link']['title']) ): ?>
											<a href="<?php echo $cta['link']['url']; ?>" target="<?php echo $cta['link']['target']; ?>" title="<?php echo $cta['link']['title']; ?>" class="cta cta-<?php echo $i; ?>">
												<?php 
												if ($cta['txt']) echo $cta['txt'];
												else echo $cta['link']['title'];
												?>
											</a>
										<?php endif; ?>
									<?php $i++; endforeach; ?>
								</div>
							<?php endif; ?>

						</div>
					</div>
				<?php $slide_index++; endforeach; ?>

			</div>
			
		<?php else: ?>

			<?php 

			//////////////////////////////////////////////////////
			// BACKGROUND PHOTO OR VIDEO CONTENT 
			//////////////////////////////////////////////////////

			?>

			<?php EM()->Template->opacity_overlay( $contents['overlay']['overlay_opacity'], $contents['overlay']['overlay_color'] ); ?>

			<div class="inner-wrapper">

				<<?php echo $hl_tag; ?>>
					<?php if ($contents['headline']): ?>
						<?php $i=1; foreach ($contents['headline'] as $headline): ?>
							<?php if ( $headline['txt'] ): ?>
								<div class="hl hl-<?php echo $i; ?>">
									<?php echo $headline['txt']; ?>
								</div>
							<?php endif; ?>
						<?php $i++; endforeach; ?>
					<?php endif; ?>
				</<?php echo $hl_tag; ?>>

				<?php if (!empty($contents['desc'])): ?>
					<?php $i=1; foreach ($contents['desc'] as $desc): ?>
						<?php if ( $desc['txt'] ): ?>
							<div class="desc desc-<?php echo $i; ?>">
								<?php echo $desc['txt']; ?>
							</div>
						<?php endif; ?>
					<?php $i++; endforeach; ?>
				<?php endif; ?>

				<?php if (!empty($contents['cta'])): ?>
					<div>
						<?php $i=1; foreach ($contents['cta'] as $cta): ?>
							<?php if ( !empty($cta['link']['url']) && !empty($cta['link']['title']) ): ?>
								<a href="<?php echo $cta['link']['url']; ?>" target="<?php echo $cta['link']['target']; ?>" title="<?php echo $cta['link']['title']; ?>" class="cta cta-<?php echo $i; ?>">
									<?php 
									if ($cta['txt']) echo $cta['txt'];
									else echo $cta['link']['title'];
									?>
								</a>
							<?php endif; ?>
						<?php $i++; endforeach; ?>
					</div>
				<?php endif; ?>
				<?php if (!empty($contents['hero_teaser_img'])): ?>
					<div class="hero-teaser">
						<?php echo wp_get_attachment_image( $contents['hero_teaser_img']['ID'], 'img_800' ); ?>
						<?php if (!empty($contents['hero_teaser_link'])): ?>
							<div class="hero-teaser-link btn-line-left">
								<?php printf( '<a href="%s" target="%s">%s</a>', $contents['hero_teaser_link']['url'], $contents['hero_teaser_link']['target'], $contents['hero_teaser_link']['title'] ); ?>
							</div>
						<?php endif; ?>
					</div>

				<?php endif; ?>

			</div>

		<?php endif; ?>

	</div>

</div>