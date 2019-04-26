<?php

//////////////////////////////////////////////////////
// MAGAZINE HEADER
// Logo on the left, Nav & Search on the right
//////////////////////////////////////////////////////

?>

<header id="main-header" class="<?php if (isset($header_class)) { echo $header_class; } ?>">
    
    <?php /* ---------- LOGO & NAV BAR ---------- */ ?>
    
	<div class="logo-nav clearfix">

		<a href="<?php echo get_home_url(); ?>" class="float-left">
			<img src="<?php echo em_theme_info()['logo_header']; ?>" class="logo" />
        </a>
        
        <?php /* ---------- MOBILE NAV MODAL BUTTON (OPEN / CLOSE) ----------*/ ?>
		
		<button class="c-hamburger c-hamburger--htx float-right">
            <span>toggle menu</span>
        </button>
        
        <?php /* ---------- SHOPPING CART BUTTON WITH ITEM COUNT ---------- */ ?>

        <?php if ( EM()->is_woocommerce_installed() ) { ?>

            <a href="<?php echo wc_get_cart_url(); ?>" class="shopping-cart-btn float-right" alt="<?php _e('View shopping cart', 'eichmeister'); ?>" title="<?php _e('View shopping cart', 'eichmeister'); ?>">
                <i class="em-shopping-cart"><span class="cart-item-count"><?php echo WC()->cart->cart_contents_count; ?></span></i>
                <span class="mobile-hide">Warenkorb</span>
                
            </a>

        <?php } ?>

        <?php 
        /**
         * Hook: em_main_header.
         *
         * @hooked em_menu_search - 10
         */
        do_action('em_main_header'); ?>
		
        <?php /* ---------- MOBILE NAV MODAL ---------- */ ?>
       
        <div id="nav-modal" class="float-left clearfix">

            <?php 
            /**
             * Hook: em_nav_modal.
             *
             * @hooked em_menu_wpml - 10
             */
            do_action('em_nav_modal'); ?>
       

            <?php /* ---------- LOGIN BUTTON ---------- */ ?>
           
            <!--
            <a href="#" class="btn-login btn-outline-turquoise open-overlay float-right margin-left-15" data-overlay="reg-login-overlay">
                Login
            </a>
            -->
            
            <?php /* ---------- MAIN HEADER NAV MENU ----------*/ ?>

            <nav id="main-nav" class="float-right">
                <?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
                <?php wp_nav_menu( array( 
                    'container' => 'main',
                    'container_id' => 'main',
                    'menu' => 'main',
                    'menu_class' => 'sf-menu',
                    'theme_location' => 'primary' 
                    )); 
                ?>
            </nav>
            
        </div>
        
	</div>
</header>