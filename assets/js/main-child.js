jQuery(document).ready(function() {

    var isMobile = window.matchMedia("only screen and (max-width: 768px)").matches;

    if (!isMobile) {
	    /* ---------- PARALLAX / SKROLLR INIT ---------- */
		if ($('html').hasClass('no-touch')) {
	        var s = skrollr.init({forceHeight: false});
	        $(window).on('resize', function() {
	             s.refresh();
	        });
	    }
	}
});