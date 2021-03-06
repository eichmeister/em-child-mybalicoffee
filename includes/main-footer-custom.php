<div id="em-footer-custom" class="wrapper-1200 padding-top-50">
    <div class="row">
        <div class="col_4 address">
            <object data="<?php echo em_theme_info()['logo_footer'] ?>" type="image/svg+xml" class="logo"></object>
            <nav>
                <p><?php the_field('address', 'option'); ?></p>
                <a href="tel:<?php the_field('phone', 'option'); ?>"><?php the_field('phone', 'option'); ?></a>
                <a href="mailto:<?php the_field('email', 'option'); ?>"><?php the_field('email', 'option'); ?></a>
            </nav>
            <?php EM()->Template->social_media_channels(); ?>
        </div>
        <div class="col_3">
            <strong>
                <?php _e('Products', 'eichmeister'); ?>
            </strong>
            <nav>
                <?php 
                wp_nav_menu( array( 
                    'container' => 'footer1',
                    'container_id' => 'footer-menu1',
                    'menu' => 'Footer1'
                )); 
                ?>
            </nav>
        </div>
        <div class="col_3">
            <strong>
                <?php _e('Navigation', 'eichmeister'); ?>
            </strong>
            <nav>
                <?php 
                wp_nav_menu( array( 
                    'container' => 'footer2',
                    'container_id' => 'footer-menu2',
                    'menu' => 'Footer2'
                )); 
                ?>
            </nav>
        </div>
        <div class="col_2">
            <strong>
            </strong>
            <nav>
                <?php 
                wp_nav_menu( array( 
                    'container' => 'footer3',
                    'container_id' => 'footer-menu3',
                    'menu' => 'Footer3'
                )); 
                ?>
            </nav>
        </div>
        <!-- <div class="col_12">
            <?php if( have_rows('payments', 'options') ): ?>
                <div class="payments">
                    <strong>Zahlungsmöglichkeiten</strong>
                    <?php while ( have_rows('payments', 'options') ) : the_row(); ?>
                        <figure>
                            <img src="<?php echo get_sub_field('img', 'options')['sizes']['img_500']; ?>">
                        </figure>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div> -->
    </div>
</div>