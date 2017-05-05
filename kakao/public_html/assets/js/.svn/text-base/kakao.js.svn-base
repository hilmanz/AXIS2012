jQuery(document).ready(function($) {
		/*------------POP UP------------*/	
		$(document).on('click','a.showpopup', function(){
		
			var targetID = jQuery(this).attr('href');
			jQuery(targetID).fadeIn();
			jQuery("#bgpopup").fadeIn();
			$('html, body').animate({scrollTop: '0px'}, 800);
			return false;
		});
		$(document).on('click','#bgpopup', function(){
	
			var targetID = jQuery(this).attr('href');
			jQuery(".popup").fadeOut();
			jQuery("#bgpopup").fadeOut();
			return false;
		});
		 
});