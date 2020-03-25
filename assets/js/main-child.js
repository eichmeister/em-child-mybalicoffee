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
  
  /* ---------- TEAM MEMBERS ----------*/
  
  (function teamMemberViewer () {
    
    var $teamViewer = $('.teamviewer');
    
    if ($teamViewer) {
      var $team = $teamViewer.find('.col_4');
      var r = $team.length % 3;
      if ( r == 0 ) return;
      var tag = r == 1 ? 'one-last' : 'two-last';
      $teamViewer.addClass(tag);
    }
    
  })();
  
});