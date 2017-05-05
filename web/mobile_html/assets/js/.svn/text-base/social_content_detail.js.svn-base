$(document).ready(function($) {
$(document).on('mouseover',".poolingStarSocial", function(){

	var rate = $(this).attr("node");
			for(var x=1;x<=rate;x++){
				
				$(".node"+x).children("img").attr("src",mobiledomain+"assets/images/icon/stars.png");
			
			}
	$(document).on('mouseleave',".poolingStarSocial", function(){
	var rate = $(this).attr("node");
			for(var x=1;x<=rate;x++){
				
				$(".node"+x).children("img").attr("src",mobiledomain+"assets/images/icon/star.png");
			
			}
	
	});
	
});


$(document).on('click',".poolingStarSocial", function(){
		var rate = $(this).attr("node");
		var cid = $(".rating").attr("content");
		$.post(mobiledomain+'index.php?page=content&act=saveRateSocial',{cid:cid,rate:rate}, function(data){
		if(data){
			for(var x=1;x<=rate;x++){
				
				$(".node"+x).children("img").attr("src",mobiledomain+"assets/images/icon/stars.png");
			
			}
		}
		});
		
		$(document).on('mouseleave',".poolingStarSocial", function(){
		var rate = $(this).attr("node");
			for(var x=1;x<=rate;x++){
				
				$(".node"+x).children("img").attr("src",mobiledomain+"assets/images/icon/stars.png");
			
			}
	
		});
	
	});


			$(document).on('click','.postCommentSocial', function(){
			
				var cid = $(this).attr('cid');
				var comment = $('.myComment_'+cid).val();
				$.post(mobiledomain+'index.php?page=content&act=sendCommentSocial',{cid:cid,comment:comment},function(data){
				if(data){
					var html ='';
						html+='			<li> ';
						html+='					<div class="avatar">';
						if(userimg)  html+='						<a href="#"><img width="55" src="'+mobiledomain+'public_assets/user/photo/'+userimg+'" /></a>';
						else html+='						<img width="55" src="'+socimg+'" /></a>';
						html+='					</div>';
						html+='					 <div class="commentary">';
						html+='						<span class="comment-writer">'+uname+'</span>';
						html+='						 <span class="comment-text">'+comment+' </span>';
						html+='						<span class="post-date">'+Date.now()+'</span>';
						html+='					</div>';
						html+='							<span class="arrows"></span>';
						html+='				</li>';
					 $('.appendComment_'+cid).prepend(html);
					 $('.myComment_'+cid).val("");
				}else return false;
				});
			
			});
			
			$(".rateVal").each(function(n,i){
				var rate = $(this).attr('rate');
					for(var x=1;x<=rate;x++){
						
						$(".nodes"+x).children("img").attr("src",mobiledomain+"assets/images/icon/stars.png");
					
					}
			});
			
			$(document).on('click',".favoriteSocial", function(){
				var contentid = $(this).attr("contentid");
				var countFav = $(".fav-count").attr("countFav");
				$.post(mobiledomain+"index.php?page="+userpage+"&act=addMyFavorite&content=1&id="+contentid,function(data){
					if(data) {
						countFav++;
						$(".fav-count").html(countFav);
						$(".fav-count").attr("countFav",countFav);
					}else return false;
				});
			
			});
			

	
});
		
function rateUserSocial(){

			for(var x=1;x<=myRate;x++){
						
							$(".nodeuser"+x).children("img").attr("src",mobiledomain+"assets/images/icon/stars.png");
						
			}
}	