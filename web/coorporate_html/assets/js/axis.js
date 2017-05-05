var index;
		$(document).on('click','h3.ui-accordion-header', function(){
			index = $(this).index();
			if(index==0){index=1;}
			else{index = (index/2)+1;}
		});
		$(document).on('click','.accordion', function(){
			var n1 = ($(this).offset().top - (205-(41*index)));
			console.log(index);
			$("body,html").animate({scrollTop:n1}, 500);
		});

jQuery(document).ready(function($) {
		/*------------POP UP------------*/	
		jQuery("a.showPopup").click(function(){
			var targetID = jQuery(this).attr('href');
			jQuery(targetID).fadeIn();
			jQuery(targetID).addClass('visible');
			jQuery("#bgPopup").fadeIn();
		});
		/*------------HEADING SCROLL------------*/	
		$(window).scroll(function(){
			//console.log($(window).scrollTop());
			if($(window).scrollTop()<=50){
				$('#head').removeClass('boxShadow');
			}else{
				$('#head').addClass('boxShadow');
			}
			if($(window).scrollTop()>=300){
				$('.panduan1,.produk1,.box1').addClass("animated bounceInLeft");
			}
			if($(window).scrollTop()>=350){
				$('.panduan2,.produk2,.box2').addClass("animated bounceInRight");
			}
			if($(window).scrollTop()>=400){
				$('.panduan3,.produk3').addClass("animated bounceInLeft");
			}
			if($(window).scrollTop()>=450){
				$('.panduan4,.produk4').addClass("animated bounceInRight");
			}
			if($(window).scrollTop()>=500){
				$('.panduan5').addClass("animated bounceInLeft");
			}
		});
		/*------------POP UP------------*/	
		jQuery("a.showPopup").click(function(){
			var targetID = jQuery(this).attr('href');
			jQuery(targetID).fadeIn();
			jQuery(targetID).addClass('visible');
			jQuery("#bgPopup").fadeIn();
		});
		//$('.rating').jRating();
		$('ul#nav').superfish({ 
			delay:       600,
			animation:   {opacity:'show',height:'show'},
			speed:       'fast',
			autoArrows:  true,
			dropShadows: false
		});

		 
});
$(document).ready(function(){
	/*------------ADD CLASS DETECT BROWSER------------*/ 
	$("body").addClass(BrowserDetect.browser); 
	jQuery('#bannerCarousel').jcarousel();
	jQuery('#newsCarousel').jcarousel({
		scroll: 1
	});
	$('.circleThumb a,.circles a img').hover(function(){
		$(this).addClass("animated flip");
	}, function() {
		$(this).removeClass("animated flip");
	});
	$('#hotPromo .boxPromo,#listStore .boxPromo').hover(function(){
		$(this).addClass("animated tada");
	}, function() {
		$(this).removeClass("animated tada");
	});
	
	$("a[rel=galeries]").fancybox({
		live : true,
		helpers : {
				title :{
					type: 'inside'
				}
			}
	});
});

$(function() {

	$('#da-slider').cslider({
		autoplay	: false,
		bgincrement	: 450
	});
	
	$( ".accordion" ).accordion({
		collapsible: true,
		heightStyle: "content"
	});
	$( "#produkDetailPage,#profileBoxTab,#boxNetworkTab" ).tabs();

	$('.scrollbar')
		.jScrollPane(
			{
				showArrows:false
			}
		);
});


function strip_tags (input, allowed) {
  allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); 
  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
    commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
    return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
  });
}