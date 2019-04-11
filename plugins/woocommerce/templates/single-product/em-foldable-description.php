<?php
defined( 'ABSPATH' ) || exit;

global $product;

$inner_col = apply_filters( 'product_description_inner_col', 'col_4' );
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