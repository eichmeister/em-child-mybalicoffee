<div id="em-footer-custom" class="wrapper-1400 padding-ver-50">
    <div class="row">
        <div class="col_3">
            <strong>
                <?php _e('Navigation', 'eichmeister'); ?>
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
                <?php _e('Products', 'eichmeister'); ?>
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
        <div class="col_3">
            <strong>
                <?php _e('Services', 'eichmeister'); ?>
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
        <div class="col_3 last">
            <strong>
                <?php _e('Contact', 'eichmeister'); ?>
            </strong>
            <div>
                <?php the_field('address_info', 'option'); ?>
            </div>
        </div>
    </div>
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ico_trust.png" class="trust-icon" />
</div>