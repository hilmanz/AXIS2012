$(document).ready(function($) {

$(document).on('mouseover','.poolingStar', function(){

	var rate = $(this).attr("node");
			for(var x=1;x<=rate;x++){
				
				$(".node"+x).children("img").attr("src",mobiledomain+"assets/images/icon/stars.png");
			
			}
	$(document).on('mouseleave',".poolingStar", function(){
	var rate = $(this).attr("node");
			for(var x=1;x<=rate;x++){
				
				$(".node"+x).children("img").attr("src",mobiledomain+"assets/images/icon/star.png");
			
			}
	
	});
	
});


$(document).on('click',".poolingStar", function(){
		var rate = $(this).attr("node");
		var cid = $(".rating").attr("content");
		$.post(mobiledomain+'index.php?page=content&act=saveRate',{cid:cid,rate:rate}, function(data){
			if(data){
				for(var x=1;x<=rate;x++){
					
					$(".node"+x).children("img").attr("src",mobiledomain+"assets/images/icon/stars.png");
				
				}
				
			}
		});
		
		$(document).on('mouseleave',".poolingStar", function(){
		var rate = $(this).attr("node");
			for(var x=1;x<=rate;x++){
				
				$(".node"+x).children("img").attr("src",mobiledomain+"assets/images/icon/stars.png");
			
			}
	
		});
	
	});


		$(document).on('click',".postComment", function(){
				$(".msgcomment").hide();
				var cid = $(this).attr('cid');
				var comment = $('.myComment_'+cid).val();
				$.post(mobiledomain+'index.php?page=content&act=sendComment',{cid:cid,comment:comment},function(data){
				if(data){
					var dates = getCalendarDate();
					var times = getClockTime();
					var html ='';
						html+='			 <div class="row">';
						html+='					<div class="thumb">';
						if(userimg) html+='						<a href="#"><img width="55" src="'+mobiledomain+'public_assets/user/photo/'+userimg+'" /></a>';
						else html+='						<img width="55" src="'+socimg+'" /></a>';
						html+='					</div>';
						html+='					<div class="post">';
						html+='						<h3 class="username">'+uname+'</h3>';
						html+='						<p>'+comment+'</p>';
						html+='						<span class="post-date">'+dates+' '+times+'</span>';
						html+='					</div>';
						html+='							<span class="arrows"></span>';
						html+='						</div>';
					 $('.appendComment_'+cid).prepend(html);
					 $('.myComment_'+cid).val("");
				}else {
					
						$(".msgcomment").attr('style','position: absolute; top: 178px; text-align: center; color: red; background-color: white; border: 1px solid; left: 44px; width: 531px;');
					 $(".msgcomment").html(localeentrycomment);
					 $(".msgcomment").show();
					return false;
				}
				});
			
			});
			
			$(".rateVal").each(function(n,i){
				var rate = $(this).attr('rate');
					for(var x=1;x<=rate;x++){
						
						$(".nodes"+x).children("img").attr("src",mobiledomain+"assets/images/icon/stars.png");
					
					}
			});
			
			$(document).on('click',".favorite", function(){
				var contentid = $(this).attr("contentid");
				if(contentid){}else{contentid=0;}
				var countFav = $(".fav-count").attr("countFav");
				var urlFav = $(this).attr("urlcontent");
				var favorite =  $(this);
				$.post(mobiledomain+"index.php?page="+userpage+"&act=addMyFavorite&id="+contentid,{url_fav : urlFav},function(data){
					if(data) {
						countFav++;
						$(".fav-count").html(countFav);
						$(".fav-count").attr("countFav",countFav);
						favorite.attr("contentid",0);
					}else return false;
				});
			
			});
			
			
		$(document).on('click',".locale", function(){
			var locale = $(this).attr('lid');
			$.post(mobiledomain+'index.php?page=locale&country='+locale,function(data){
				if(data) location.reload();
				else return false;
		
			});
			
		});
		

	$(document).on('click',".linkit", function(){ 	window.location=$(this).attr('href'); location.reload();});
		
});

function rateUser(){
			for(var x=1;x<=myRate;x++){
							
							$(".nodeuser"+x).children("img").attr("src",mobiledomain+"assets/images/icon/stars.png");
						
			}
}

function getCalendarDate()
		{
		   var months = new Array(13);
		   months[0]  = "January";
		   months[1]  = "February";
		   months[2]  = "March";
		   months[3]  = "April";
		   months[4]  = "May";
		   months[5]  = "June";
		   months[6]  = "July";
		   months[7]  = "August";
		   months[8]  = "September";
		   months[9]  = "October";
		   months[10] = "November";
		   months[11] = "December";
		   var now         = new Date();
		   var monthnumber = now.getMonth();
		   var monthname   = months[monthnumber];
		   var monthday    = now.getDate();
		   var year        = now.getYear();
			monthnumber = monthnumber + 1;
		   if (monthnumber   < 10)  monthnumber   = "0" + monthnumber; 
			if (monthday   < 10)  monthday   = "0" + monthday;  		   
		   if(year < 2000)  year = year + 1900; 
		   var dateString = monthname +
							' ' +
							monthday +
							', ' +
							year;
			var dateString = monthday+'-'+monthnumber+'-'+year;
		   return dateString;
		}

		function getClockTime()
		{
		   var now    = new Date();
		   var hour   = now.getHours();
		   var minute = now.getMinutes();
		   var second = now.getSeconds();
		   var ap = "AM";
		   if (hour   > 11)  ap = "PM";             
		   if (hour   > 12)  hour = hour - 12;      
		   if (hour   == 0)  hour = 12;             
		   if (hour   < 10)  hour   = "0" + hour;   
		   if (minute < 10)  minute = "0" + minute; 
		   if (second < 10)  second = "0" + second; 
		   var timeString = hour +
							':' +
							minute +
							':' +
							second +
							" " +
							ap;
			var timeString = hour +
							':' +
							minute +
							' ' +
							ap ;
		   return timeString;
		}
		
//load image
function nextload(selector,idx){
		idx++;
		$(selector+idx).attr('src',$(selector+idx).attr("url"));
	}
	
			$(document).on('click','.loginpopup',function(){
				var url = $(this).attr('url');
				
				window.open(url,'','width=850,height=450');
			
			});