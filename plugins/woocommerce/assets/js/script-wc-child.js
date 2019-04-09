
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
});