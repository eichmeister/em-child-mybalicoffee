
jQuery(document).ready(function($) {

//////////////////////////////////////////////////////
// 3) SINGLE PRODUCT 
//////////////////////////////////////////////////////

    var singleProduct = {
        init: function() {
            if ($('body.single-product').length) {
                this.singleProductInit();
            }
        },

        singleProductInit: function() {
            // var height = $('div[id^="product-"]').height();
        },
    };

    singleProduct.init();

    /*
    var about = {
        init: function() {
            $('.wpcf7-form .fs-checkbox').on('click', function(e) {
                var $form = $('.wpcf7-form');
                var $submit = $( 'input:submit', $form );

                if ( typeof state !== 'undefined' ) {
                    $submit.prop( 'disabled', ! state );
                    return;
                }

                if ( $form.hasClass( 'wpcf7-acceptance-as-validation' ) ) {
                    return;
                }

                $submit.prop( 'disabled', false );

                $( '.fs-checkbox', $form ).each( function() {
                    var $span = $( this );
                    var $input = $( 'input:checkbox', $span );

                    if ( ! $span.hasClass( 'optional' ) ) {
                        if ( $span.hasClass( 'invert' ) && $input.is( ':checked' )
                        || ! $span.hasClass( 'invert' ) && ! $input.is( ':checked' ) ) {
                            $submit.prop( 'disabled', true );
                            return false;
                        }
                    }
                } );
            } );
        },
    };

    about.init();
    */

    var widgets = {

        // AJAX PHP FUNCTION NAME
        $em_page: '',
        $tr_data: [],
        $elementScrollTo: $('#em-wc-container'),

        // Filters
        $filter:          $('#em-shop-archive-wrapper #em-shop-archive-sidebar a'),

        //mobile 

        init: function() {
            this.$filter.on( 'click', function(e) {
                e.preventDefault();
                if ( ! $(this).hasClass('active') ) {
                    $('#em-shop-archive-wrapper #em-shop-archive-sidebar a').removeClass('active');
                    $(this).addClass('active');
                    widgets.$tr_data = [];
                    widgets.$tr_data.push({
                        type: $(this).data('type'),
                        value: $(this).data('value'),
                    })
                    widgets.triggerAjaxFilter( widgets.$em_page, widgets.$tr_data );
                }
            });
        },

        triggerAjaxFilter: function(em_page, data) {

            $('.em-wc-archive-loader').fadeIn(200);

            var em_data = {};
            em_data['em_page']    = em_page;
            em_data['tr_data']    = data;
            em_data['query']      = emsaq.query;
            em_data['action']     = 'em_shop_archive_filter';

            $.ajax({
                type: 'POST',
                data: em_data,
                url: emsaq.ajaxurl,

                beforeSend: function() {
                    $('#em-shop-archive-wrapper .products-wrapper').html("");

                    $("html, body").animate({
                        scrollTop: widgets.$elementScrollTo.offset().top - 80
                    }, 600);
                },

                success: function(response) {
                    $('.em-wc-archive-loader').fadeOut(200);
                    
                    if ( $('#em-shop-archive-wrapper .products-wrapper').length ) {
                        $('#em-shop-archive-wrapper .products-wrapper').replaceWith(response);
                    } else if( $('#em-shop-archive-wrapper p.woocommerce-info').length ) {
                        $('#em-shop-archive-wrapper p.woocommerce-info').replaceWith(response);
                    }
                    // archive.init();
                    // EmMain.formstone.initFormstone();
                    // quickview.init();
                    // EmMain.lazyLoad.init();
                }

            });
        },
    };

    widgets.init();
});