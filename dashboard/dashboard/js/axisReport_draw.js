//=============
// JS axis_report_draw
// @cendekiApp
//=============

function weeklyWinner_row(data){
	var str = '';
	$.each(data, function(x, item) {
		str+='<div class="row">';
		str+='<a class="thumbs" href="#"><img src="https://graph.facebook.com/'+data[x].fb_id+'/picture"></a>';
		str+='<div class="entry">';
		str+='<h4><a href="#">'+data[x].user_name+'</a></h4>';
		str+='<p>Score: '+data[x].score+' || Email: '+data[x].email+' || Nomor AXIS: '+data[x].msisdn+' || Last Update: '+data[x].end_date+'</p>';
		str+='</div>';
		str+='</div>';
	});
	return str;
}

function topItem(data){
	var str = '';
		str+= '<ol>';
	$.each(data, function(x, item) {
		str+= '<li>'+data[x].item_name+'</li>';
	});
		str+= '</ol>';
	return str;
}