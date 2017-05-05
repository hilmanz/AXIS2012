/*------------POP UP------------*/	
		var index=0;
		$(document).on('click','h3.ui-accordion-header', function(){
			index = $(this).index();
			if(index==0){index=1;}
			else{index = (index/2)+1;}
		});
		$(document).on('click','.accordion', function(){
			var n1 = ($(this).offset().top - (205-(41*index)));
			$("body,html").animate({scrollTop:n1}, 500);
		});
		jQuery(document).on('click','a.showPopup', function(){
			var targetID = jQuery(this).attr('href');
			jQuery(targetID).fadeIn();
			jQuery(".ui-overlay").fadeIn();
			$('html, body').animate({scrollTop: '0px'}, 800);
			return false;
		});
		jQuery(document).on('click','a.showPopup2', function(){
			var targetID = jQuery(this).attr('href');
			jQuery(targetID).fadeIn();
			jQuery(".ui-overlay").fadeIn();
			return false;
		});
		jQuery(document).on('click','.ui-overlay,.closePopup', function(){
			var targetID = jQuery(this).attr('href');
			jQuery(".popup").fadeOut();
			jQuery(".ui-overlay").fadeOut();
			return false;
		});
		
		$(document).on('mouseover', '#hotPromo .boxPromo,#listStore .boxPromo', function() {
			$(this).addClass("animated tada");
		});
		$(document).on('mouseout', '#hotPromo .boxPromo,#listStore .boxPromo', function() {
			$(this).removeClass("animated tada");
		});
jQuery(document).ready(function($) {
		/*------------TAB STORE------------*/
		jQuery('.tab_content:first-child').addClass("tabActive");	
		jQuery(".tabStore a").click(function(){
			jQuery(".tabStore li").removeClass("active");	
			jQuery(this).parent(".tabStore li").addClass("active");	
			var targetID = jQuery(this).attr('href');
			jQuery(".tab_content").fadeOut();
			jQuery(".tab_content").removeClass("tabActive");
			jQuery(targetID).addClass("tabActive");	
			jQuery(targetID).fadeIn();
			return false;
		});
		/*------------FAQ------------*/	
		jQuery(".listexpander li").click(function(){
			jQuery(".listexpander li").removeClass("active");
			jQuery(".listexpander ul").removeClass("active");	
			jQuery(this).find('ul').addClass("active");	
			jQuery(this).addClass("active");	
			return false;
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
				$('.panduan3,.produk3,.box3').addClass("animated bounceInLeft");
			}
			if($(window).scrollTop()>=450){
				$('.panduan4,.produk4,.box4').addClass("animated bounceInRight");
			}
			if($(window).scrollTop()>=500){
				$('.panduan5').addClass("animated bounceInLeft");
			}
		});
		/*------------RATING------------*/	
		//$('.rating').jRating();
		/*------------SUBMENU------------*/	
		$('#nav li a.submenu').hover(function(){
			$("#subMenu").stop().animate({top:'160'},{queue:false,duration:300});
			$("#subMenu").show();
			$('#nav li a.submenu').addClass("current");
		}, function() {
			$("#subMenu").stop().animate({top:'0'},{queue:false,duration:300});
			$("#subMenu").fadeOut();
			$('#nav li a.submenu').removeClass("current");
		});
		$('#subMenu').hover(function(){
			$("#subMenu").stop().animate({top:'160'},{queue:false,duration:300});
			$("#subMenu").show();
			$('#nav li a.submenu').addClass("current");
		}, function() {
			$("#subMenu").stop().animate({top:'0'},{queue:false,duration:300});
			$("#subMenu").fadeOut();
			$('#nav li a.submenu').removeClass("current");
		});
		$("a.subInternet").hover(function(){
			$(".bannerNav").hide();
			$("#internetBanner").show();
		});
		$("a.subTelepon").hover(function(){
			$(".bannerNav").hide();
			$("#teleponBanner").show();
		});
		$("a.subBundling").hover(function(){
			$(".bannerNav").hide();
			$("#bundlingBanner").show();
		});
		$("a.subKartu").hover(function(){
			$(".bannerNav").hide();
			$("#kartuBanner").show();
		});
		
		 
});
$(document).ready(function(){
	/*------------ADD CLASS DETECT BROWSER------------*/ 
    jQuery('#bannerCarousel').jcarousel({
    	wrap: 'circular'
    });
	jQuery('#newsCarousel').jcarousel({
		scroll: 1
	});
	
});
$(function() {

	$('#da-slider').cslider({
		autoplay	: true,
		bgincrement	: 450
	});
	
	$( ".accordion" ).accordion({
		collapsible: true,
		heightStyle: "content"
	});
	$( "#produkDetailPage,#boxNetworkTab,#storeTab,#tabsingle" ).tabs();
	
	
	//profile tab chooser start custom
	var profileBoxTabIdx = 0;
	var locationhref = location.href;
	 if(locationhref.match(/#ptab/)) {
		var indexOfLocation = locationhref.indexOf("#ptab");
		profileBoxTabIdx = locationhref.substring(indexOfLocation+5,indexOfLocation+6);
		
	 }
	
	
	$("#profileBoxTab").tabs({ selected: profileBoxTabIdx});

	$("#profileBoxTab").bind("tabsselect", function(event, ui) {
		var locationhref = location.href;
		if(locationhref.match(/#ptab/)) {
			var indexOfLocation = locationhref.indexOf("#ptab");
			var profileBoxTabIdx = locationhref.substring(indexOfLocation,indexOfLocation+6);
			location.href = locationhref.replace(profileBoxTabIdx,"#ptab"+ui.index);
		}else location.href = locationhref+"#ptab"+ui.index;
		
	});
	//profile tab end custom
	
	//boxNetworkTab chooser start custom
	
	var profileBoxTabIdx = 0;
	var locationhref = location.href;
	 if(locationhref.match(/#bnettab/)) {
		var indexOfLocation = locationhref.indexOf("#bnettab");
		profileBoxTabIdx = locationhref.substring(indexOfLocation+8,indexOfLocation+9);
		
	 }
	
	
	$("#boxNetworkTab").tabs({ selected: profileBoxTabIdx});

	$("#boxNetworkTab").bind("tabsselect", function(event, ui) {
		var locationhref = location.href;
		if(locationhref.match(/#bnettab/)) {
			var indexOfLocation = locationhref.indexOf("#bnettab");
			var profileBoxTabIdx = locationhref.substring(indexOfLocation,indexOfLocation+9);
			location.href = locationhref.replace(profileBoxTabIdx,"#bnettab"+ui.index);
		}else location.href = locationhref+"#bnettab"+ui.index;
	});
	//boxNetworkTab end custom
	
	$(function(){
		$('.scrollbar').jScrollPane(
			{
				autoReinitialise: true,
				showArrows:false
			}
		);
	});
	 $(function() {
        $( "#popupMap .popupContent" ).draggable();
    });	
});

function shareFB(fb_name,fb_link,fb_img,fb_user,fb_post){
	FB.ui({
		method: 'feed',
		name: fb_name,
		link: fb_link,
		picture: fb_img,
		caption: '@'+fb_user,
		description: fb_post
	});						  
}

function strip_tags (input, allowed) {
  allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); 
  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
    commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
    return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
  });
}
