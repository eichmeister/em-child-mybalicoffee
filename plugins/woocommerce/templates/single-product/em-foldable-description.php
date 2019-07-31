<?php

defined( 'ABSPATH' ) || exit;
global $product;

$inner_col = apply_filters( 'product_description_inner_col', 'col_4' );

// CAFE OR OTHER PRODUCT TEMPLATE?
if ( get_field('product_template') == 1 ):

?>

    <div id="em_product_description" class="row">

        <?php if (!empty($em_text_box_1)) { ?>
            <div class="em-foldable active <?php echo $inner_col; ?>">
                <div class="header">
                    <span>Geschmack</span><span class="icon"></span>
                </div>
                <div class="content">
                    <div class="text-full">
                        <?php echo wp_get_attachment_image($em_text_box_1['image']['ID'], $size = 'full' ); ?>
                        <?php echo $em_text_box_1['text']; ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if (!empty($em_text_box_2) ) { ?>
            <div class="em-foldable active <?php echo $inner_col; ?>">
                <div class="header">
                    <span>Herkunft</span><span class="icon"></span>
                </div>
                <div class="content">
                    <div class="text-full">
                        <?php echo wp_get_attachment_image($em_text_box_2['image']['ID'], $size = 'full' ); ?>
                        <?php echo $em_text_box_2['text']; ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if (!empty($em_text_box_3)) { ?>
            <div class="em-foldable active <?php echo $inner_col; ?>">
                <div class="header">
                    <span>Lieferung</span><span class="icon"></span>
                </div>
                <div class="content">
                    <div class="text-full">
                        <?php echo wp_get_attachment_image($em_text_box_3['image']['ID'], $size = 'full' ); ?>
                        <?php echo $em_text_box_3['text']; ?>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

<?php else: ?>

    <?php if ( have_rows('info_accordions') ): ?>

        <?php 

        $rowcount = count(get_field('info_accordions')); 

        if ( $rowcount == 1 ) {
            $wrapper_class = 'wrapper-600';
            $col_class = 'col_12';
        } else if ( $rowcount == 2 ) {
            $wrapper_class = 'wrapper-1200';
            $col_class = 'col_6';
        }  else {
            $wrapper_class = 'wrapper-1200';
            $col_class = 'col_4';
        }

        ?>

        <div class="<?php echo $wrapper_class; ?>">
            <div class="row">

                <?php while ( have_rows('info_accordions') ) : the_row(); ?>

                    <div class="<?php echo $col_class; ?>">
                        
                         <div class="em-foldable <?php if ( $rowcount == 1) echo 'active'; ?>">
                            <div class="header">
                                <span><?php the_sub_field('title'); ?></span><span class="icon"></span>
                            </div>
                            <div class="content">
                                <div class="text-full">
                                    <?php echo wp_get_attachment_image(get_sub_field('image')['ID'], $size = 'landscape_800' ); ?>
                                    <?php the_sub_field('text'); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php endwhile; ?>

            </div>
        </div>

    <?php endif; ?>

<?php endif; ?>