$(document).ready(function($) {
$(".poolingStar").mouseover(function(){

	var rate = $(this).attr("node");
			for(var x=1;x<=rate;x++){
				
				$(".node"+x).children("img").attr("src","assets/images/icon/stars.png");
			
			}
	$(".poolingStar").mouseleave(function(){
	var rate = $(this).attr("node");
			for(var x=1;x<=rate;x++){
				
				$(".node"+x).children("img").attr("src","assets/images/icon/star.png");
			
			}
	
	});
	
});


$(".poolingStar").click(function(){
		var rate = $(this).attr("node");
		var cid = $(".rating").attr("content");
		$.post('index.php?page=content&act=saveRate',{cid:cid,rate:rate}, function(data){
		if(data){
			for(var x=1;x<=rate;x++){
				
				$(".node"+x).children("img").attr("src","assets/images/icon/stars.png");
			
			}
		}
		});
		
		$(".poolingStar").mouseleave(function(){
		var rate = $(this).attr("node");
			for(var x=1;x<=rate;x++){
				
				$(".node"+x).children("img").attr("src","assets/images/icon/stars.png");
			
			}
	
		});
	
	});


			$('.postComment').click(function(){
			
				var cid = $(this).attr('cid');
				var comment = $('.myComment_'+cid).val();
				$.post('index.php?page=content&act=sendComment',{cid:cid,comment:comment},function(data){
				if(data){
					var dates = getCalendarDate();
					var times = getClockTime();
					var html ='';
						html+='			 <div class="row">';
						html+='					<div class="thumb">';
						html+='						<a href="#"><img src="https://graph.facebook.com/'+fbid+'/picture?type=square&return_ssl_resources=1" /></a>';
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
				}else return false;
				});
			
			});
			
			$(".rateVal").each(function(n,i){
				var rate = $(this).attr('rate');
					for(var x=1;x<=rate;x++){
						
						$(".nodes"+x).children("img").attr("src","assets/images/icon/stars.png");
					
					}
			});
			
			$(".favorite").click(function(){
				var contentid = $(this).attr("contentid");
				var countFav = $(".fav-count").attr("countFav");
				$.post("index.php?page=user&act=addMyFavorite&id="+contentid,function(data){
					if(data) {
						countFav++;
						$(".fav-count").html(countFav);
						$(".fav-count").attr("countFav",countFav);
					}else return false;
				});
			
			});
			
			
		$(".locale").click(function(){
			var locale = $(this).attr('lid');
			$.post('index.php?page=locale&country='+locale,function(data){
				if(data) location.reload();
				else return false;
		
			});
			
		});
		
		
});

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
		   if (monthnumber   < 10)  monthnumber   = "0" + monthnumber; 
			if (monthday   < 10)  monthday   = "0" + monthday;  		   
		   if(year < 2000)  year = year + 1900; 
		   var dateString = monthname +
							' ' +
							monthday +
							', ' +
							year;
			var dateString = year+'-'+monthnumber+'-'+monthday;
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
							':' +
							second ;
		   return timeString;
		} 