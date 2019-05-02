
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
});