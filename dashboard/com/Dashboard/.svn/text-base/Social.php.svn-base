<?php
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/Paginate.php";
include_once APP_PATH."Dashboard/SocialModel.php";
require_once $APP_PATH."Dashboard/helper/wordcloudHelper.php";
class Social extends SQLData{
	var $model;
	function __construct($req){
		parent::SQLData();
		$this->Request = $req;
		$this->View = new BasicView();
		$this->User = new UserManager();
		$this->model = new SocialModel();
	}
	function admin(){
		$id = $this->Request->getParam('id');
		$act = $this->Request->getParam('act');
		$twit = $this->Request->getParam('twitID');
		$_SESSION['twitterID'] = $twit;
		
		//Get Date Range From User
		$startRange = $this->Request->getPost('from');
		$endRange = $this->Request->getPost('to');
		$_SESSION['startRange'] = $startRange;
		$_SESSION['endRange'] = $endRange;
		
		//FB Detail
		$fbDetails = $this->model->getFBPageDetails($id);
		$_SESSION['fbPageName'] = $fbDetails['fbName'];
		
		//Session ID
		if ($id != $_SESSION['project_id']){
			$_SESSION['project_id'] = $id;
		}
		
		$tab = $this->Request->getPost('tab');
		$st = $this->Request->getPost('startDate');
		$end = $this->Request->getPost('endDate');
		$twitID = $this->Request->getPost('twitterID');
		
		if ($id == $_SESSION['project_id'] && $act == null && $twit == null){
			return $this->fbDetail();
		}else if ($id == $_SESSION['project_id'] && $act =="fb"){
			return $this->fbDetail();
		}else if ($id == $_SESSION['project_id'] && $act =="twit"){
			return $this->twitDetail();
		}else if ($id == $_SESSION['project_id'] && $act =="twitterAjax"){
			return $this->twitterAjax($st, $end, $twitID);
		}else if ($id == $_SESSION['project_id'] && $act =="youtube"){
			return $this->youtubeDetail();
		}else if ($id == $_SESSION['project_id'] && $act =="youtubeAjax"){
			return $this->youtubeDailyAjax($tab, $st, $end);
		}else if ($id == $_SESSION['project_id'] && $act =="facebookAjax"){
			return $this->facebookDailyAjax($tab, $st, $end);
		}else if ($id == $_SESSION['project_id'] && $act =="gplus"){
			return $this->gplusDetail();
		}else if ($id == $_SESSION['project_id'] && $act =="gplusAjax"){
			return $this->gplusAjax($st, $end);
		}else if ($id == $_SESSION['project_id'] && $_SESSION['twitterID'] == $twit){
			return $this->popupProfile($id, $twit);
		}
	}

	function main(){
		$id = $_SESSION['project_id'];
		$fb = $_SESSION['fbPageName'];
		$this->View->assign('fbPageName', $fb);

		//Buzz volume
		$totalSentiment = $this->model->getTWSentiment($id);
		$totalBuzz = intval($totalSentiment[0]['plus'])+intval($totalSentiment[0]['minus'])+intval($totalSentiment[0]['normal']);
		$this->View->assign("buzzVolume", $totalBuzz);
		
		//Unique People
		$totalPeople = $this->model->getTWCountPeople($id);
		$unique = intval($totalPeople['unik']);
		$this->View->assign("uniquePeople", $unique);
		
		//Sentiment Daily
		unset($category);
		$data = $this->model->getTWSentimentDaily($id);
		foreach ($data as $dat){
			$tgl = substr($dat["tgl"], 8, 2)."/".substr($dat["tgl"], 5, -3);
			$category[] = $tgl;
			$positive[] = intval($dat['plus']);
			$negatif[] = intval($dat['minus']);
			$neutral[] = intval($dat['normal']);
		}
		$senPart = array(
					"category" => $category,
					"positive" => $positive,
					"negatif" => $negatif,
					"neutral" => $neutral
					);
		 // var_dump(json_encode($senPart));exit;
		$this->View->assign("sentiment", json_encode($senPart));
		
		//Sentiment
		unset($category);
		unset($senPart);
		$data = $this->model->getTWSentiment($id);
		foreach ($data as $dat){
			$positives[] = intval($dat['plus']);
			$negatifs[] = intval($dat['minus']);
			$neutrals[] = intval($dat['normal']);
		}
		$senPart = array(
					"positive" => $positives,
					"negatif" => $negatifs,
					"neutral" => $neutrals
					);
		// var_dump(json_encode($folPart));exit;
		$this->View->assign("sentimentoverall", json_encode($senPart));
		
		//Channels
		$data = $this->model->getChannels($id);
		$channel = array(
					"twitter" => intval($data['twitter']),
					"facebook" => intval($data['facebook']),
					"blog" => intval($data['blog'])
					);
		// var_dump($channel);exit;
		$this->View->assign("getChannels", json_encode($channel));			
		
		//Top Countries
		$data = $this->model->getTWTopCountries($id);
		foreach ($data as $dat){
			$countries[$dat['country_name']] = intval($dat['mentions']);
		}
		// var_dump(json_encode($countries));exit;
		$this->View->assign("getCountries", json_encode($countries));	
		
		//Wordcloud
		$data = $this->model->getTWWordcloud($id);
		// var_dump($data);
		$rs = array();
		$m=0;
		foreach($data as $w){
			$m = max($m,intval($w['total']));
			$mm = min($m,intval($w['total']));
			
			if($w['sentiment'] == NULL){
				$w['sentiment'] = 0;
			}
			
			$rs[] = array(
						"txt"=>$w['keyword'],
						"amount"=>intval($w['total']),
						"weight"=>intval($w['total']),
						"url"=>$link,
						"is_main"=>null,
						"sentiment"=>intval($w['sentiment']),
						"title"=> "Click to see detailed analysis"
						);
		}
		
		foreach($rs as $n=>$v){
			
			$weight = ceil(($v['amount']/($m-$mm))*9);
			$rs[$n]['weight'] = $weight;
			$rs[$n]['max'] = $m;
			$rs[$n]['min'] = $mm;
		}
		// print ('<pre>');
		// print_r($rs);exit;
		
		$wordcloud = new wordcloudHelper(470,370);
		$wordcloud->urlto=$link;
		$wordcloud->setHandler('homewordcloud');
		$wordcloud->set_sentiment_style(array("positive"=>"wcstat1","negative"=>"wcstat2","neutral"=>"wcstat0","main_keyword"=>"wcstat3"));
		$this->View->assign("wordcloud",$wordcloud->draw($rs));
		
		//Conversations
		$conversation = $this->model->getTWConversations($id);
		$this->View->assign("conversation", $conversation);
		
		//Keyword
		$keyword = $this->model->getTWKeyword($id);
		$this->View->assign("keyword", $keyword);
		
		//KOL
		$kolPositif = $this->model->getTWKOL($id, 1);
		$this->View->assign("kolPlus", $kolPositif);
		$kolNegatif = $this->model->getTWKOL($id, -1);
				 
		$this->View->assign("kolMinus", $kolNegatif);
		$kolNeutral = $this->model->getTWKOL($id, 0);
		// var_dump($kolNeutral);exit;
		$this->View->assign("kolNetral", $kolNeutral);

		//Last Update
		$this->View->assign('axislastUpdate', $_SESSION['lastUpdateAXIS']);
		
		//Tab
		$this->View->assign("tabSEO", 0);
		$this->View->assign("tabSEM", 0);
		$this->View->assign("tabSOCIAL", 1);
		
		$this->View->assign("userID", $_SESSION['project_id']);
		$this->View->assign("page", "project");
		return $this->View->toString("dashboard/social.html");
	}
	
	function fbDetail(){
		$id = $_SESSION['project_id'];
		
		//Date
		$date = $this->model->facebook_date();
		
		//Date Hack
		if(strtotime($date['lastUpdate']) != strtotime(date("Y-m-d"))){
			$date['lastUpdate'] = date("Y-m-d");
		}
		
		$lastDateFormat = substr($date['lastUpdate'], 8, 2)."/".substr($date['lastUpdate'], 5, -3)."/".substr($date['lastUpdate'], 0, -6);
		$day7ago = strtotime ( '-6 day' , strtotime ( $date['lastUpdate'] ) ) ;
		$day7ago = date ( 'Y-m-d' , $day7ago );
		
		$startDate = $this->model->project_date($id);
		$sumStartDate = date ( 'Y-m-d' , strtotime ( '-1 day' , strtotime ($startDate) ) );
		
		if(strtotime($day7ago) < strtotime($startDate)){
			$startDate = $day7ago ;
		}

		$this->View->assign('axislastUpdate', $lastDateFormat);
		$this->View->assign('startDate', $startDate);
		$this->View->assign('lastDate', $date['lastUpdate']);
		
		//Summary
		
		$likeSum = $this->model->getFBLike($id);
		$storySum = $this->model->getFBStory($id, $sumStartDate);
		$postSum = $this->model->getFBPosts($id, $sumStartDate);
		$engagement = $this->model->getFBEngagement($id, $sumStartDate);
		$this->View->assign('likes',intval($likeSum));
		$this->View->assign('story',intval($storySum['value']));
		$this->View->assign('postSum',intval($postSum['value']));
		$this->View->assign('LCS', $engagement);
		
		//Volume
		unset($category);
		$volume = $this->model->facebook_like($day7ago, $date['lastUpdate']);

		$this->View->assign("volume", json_encode($volume));
		
		//VISIT
		unset($category);
		$visit = $this->model->getFBVisit($day7ago, $date['lastUpdate']);
		$this->View->assign("visit", json_encode($visit));
		
		//REACH
		$reach = $this->model->facebook_page_reach($day7ago, $date['lastUpdate']);
		
		$this->View->assign("reach", json_encode($reach));
		
		//Demography
		unset($category);
		$demography = $this->model->getFBDemography($id, $sumStartDate);
		// var_dump(json_encode($demography));exit;
		$i=0;
		foreach ($demography as $demog){
			$gender[] = substr($demog['age'],0,1);
			if ($gender[$i] == 'M'){
				$male[] = intval($demog['nilai']);
				$age[] = substr($demog['age'],2,5);
			}else{
				$female[] = intval($demog['nilai']);
			}
			$i++;
		}
		$demogPart = array(
					"category" => $age,
					"female" => $female,
					"male" => $male
					);
		
		$this->View->assign("demog", json_encode($demogPart));
		
		//Location
		unset($category);
		$location = $this->model->getFBLocation($id, $sumStartDate);
		// var_dump(json_encode($locPart));exit;
		$this->View->assign("location", json_encode($location));
		
		//POSTS
		$post = $this->model->getFBPost($id, $sumStartDate);
		// var_dump(json_encode($locPart));exit;
		$this->View->assign("post", $post);
		
		//CITIES
		$cities = $this->model->getFBCity($id, $sumStartDate);
		$this->View->assign("cities", $cities);
		
		//wc
		$wc = $this->fb_wordcloud();
		$this->View->assign("wordcloud", $wc);
		
		$this->View->assign("userID", $_SESSION['project_id']);
		$this->View->assign("page", "project");
		return $this->View->toString("dashboard/fb_detail.html");
	}
	function twitDetail(){
		$id = $_SESSION['project_id'];
		$this->View->assign("userID", $_SESSION['project_id']);
		$fb = $_SESSION['fbPageName'];
		$this->View->assign('fbPageName', $fb);
		
		//TwitterID, initial
		$twitID = $this->model->twitter_id();
		$this->View->assign('twitterList', $twitID);
		$this->View->assign('twitterID', $twitID[0]);
		
		$date = $this->model->twitter_date();
		
		//Date Hack
		if(strtotime($date['lastUpdate']) != strtotime(date("Y-m-d"))){
			$date['lastUpdate'] = date("Y-m-d");
		}
		
		$lastDateFormat = substr($date['lastUpdate'], 8, 2)."/".substr($date['lastUpdate'], 5, -3)."/".substr($date['lastUpdate'], 0, -6);
		$day7ago = strtotime ( '-6 day' , strtotime ( $date['lastUpdate'] ) ) ;
		$day7ago = date ( 'Y-m-d' , $day7ago );
		
		$startDate = $this->model->project_date($id);
		$sumStartDate = date ( 'Y-m-d' , strtotime ( '-1 day' , strtotime ($startDate) ) );
		
		if(strtotime($day7ago) < strtotime($startDate)){
			$startDate = $day7ago;
		}
		
		//Summary
		$summary = $this->model->twitter_summary($date['startDate'],  $date['lastUpdate'], $twitID[0]['twitter_id']);
		$this->View->assign('mentions', intval($summary['mention']));
		$this->View->assign('retweet', intval($summary['rt']));
		$totalImpresi = intval($summary['rt_impressions'])+intval($summary['impressions']);
		$this->View->assign("potentialImpression", $totalImpresi);
		
		//Unique People
		$totalPeople = $this->model->twitter_uniquePeople($date['startDate'],  $date['lastUpdate'], $twitID[0]['twitter_id']);
		$unique = intval($totalPeople['unik']);
		$this->View->assign("uniquePeople", $unique);
		
	
		$this->View->assign('axislastUpdate', $lastDateFormat);
		$this->View->assign('startDate', $startDate);
		$this->View->assign('lastDate', $date['lastUpdate']);
		
		
		$data = $this->model->twitter_daily($day7ago,  $date['lastUpdate'], $twitID[0]['twitter_id']);
		$this->View->assign("volume", json_encode($data));
		
		//Followers
		unset($category);
		$data = $this->model->getTWFollower($id);
		foreach ($data as $dat){
			$category[] = substr($dat["tgl"], 8, 2)."/".substr($dat["tgl"], 5, -3);
			$follower[$dat['author']][] = intval($dat['jml']);
		}
		$folPart = array(
					"category" => $category,
					"follower" => $follower
					);
		// var_dump(json_encode($folPart));exit;
		$this->View->assign("follower", json_encode($folPart));
		
		//Sentiment
		unset($category);
		$data = $this->model->twitter_sentiment($date['startDate'],  $date['lastUpdate'], $twitID[0]['twitter_id']);
		$this->View->assign("sentiment", json_encode($data));
	
		//Wordcloud
		$wc = $this->twitter_wordcloud($twitID[0]['twitter_id']);
		$this->View->assign("wordcloud",$wc);
		
		//Conversations
		$conversation = $this->model->twitter_conversation($twitID[0]['twitter_id']);
		$this->View->assign("conversation", $conversation);
		
		//Countries
		$location = $this->model->getTWCountries($id);
		$this->View->assign("location", $location);
		
		//Tab
		$this->View->assign("tabSEO", 0);
		$this->View->assign("tabSEM", 0);
		$this->View->assign("tabSOCIAL", 1);
		
		$this->View->assign("userID", $_SESSION['project_id']);
		$this->View->assign("page", "project");
		return $this->View->toString("dashboard/twit_detail.html");
	}
	
	function twitter_wordcloud($twitID){
		//Wordcloud
		$data = $this->model->getTWWordcloud($twitID);
		// var_dump($data);
		$rs = array();
		$m=0;
		foreach($data as $w){
			$m = max($m,intval($w['total']));
			$mm = min($m,intval($w['total']));
			
			$rs[] = array(
						"txt"=>$w['keyword'],
						"amount"=>intval($w['total']),
						"weight"=>intval($w['total']),
						"url"=>$link,
						"is_main"=>null,
						"sentiment"=>intval($w['sentiment']),
						"title"=> "Click to see detailed analysis"
						);
		}
		
		foreach($rs as $n=>$v){
			
			$weight = ceil(($v['amount']/($m-$mm))*9);
			$rs[$n]['weight'] = $weight;
			$rs[$n]['max'] = $m;
			$rs[$n]['min'] = $mm;
		}
		// print ('<pre>');
		// print_r($rs);exit;
		
		$wordcloud = new wordcloudHelper(470,370);
		$wordcloud->urlto=$link;
		$wordcloud->setHandler('homewordcloud');
		$wordcloud->set_sentiment_style(array("positive"=>"wcstat1","negative"=>"wcstat2","neutral"=>"wcstat0","main_keyword"=>"wcstat3"));
		
		return $wordcloud->draw($rs);
	}
	
	function popupProfile($id, $twitID){
		$id = 16;
		$proDetails = $this->model->getTWProfileDetails($id, $twitID);
		$totalImpression = $this->model->getTotalImpression($id);
		$percentage = (intval($proDetails['impression'])/intval($totalImpression['total']))*100;
		
		$peopleRank = $this->model->getTWPeopleRank($id, $twitID);
		
		$response = file_get_contents("https://api.twitter.com/1/users/show.json?screen_name=".$proDetails['author_id']);
		$profile_obj = json_decode($response);
		$author_timezone = $profile_obj->time_zone;
		$author_location = $profile_obj->location;
		$author_about = $profile_obj->description;
		$arr_raw = explode(":",$author_location);
		$arr_loc = @explode(",",$arr_raw[1]);
		if(is_array($arr_loc)){
			$coordinate_x = @trim($arr_loc[0]);
			$coordinate_y = @trim($arr_loc[1]);
		}


		if(floatval($proDetails['coordinate_x'])>0||floatval($proDetails['coordinate_y'])>0){

			//check from our database first
			
			//not found, so we use google.
			$uri = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$proDetails['coordinate_x'].",".$proDetails['coordinate_y']."&sensor=false";
			
			$glmap_response = file_get_contents($uri);

			$map_obj = json_decode($glmap_response);
			
			if($map_obj->status=="OK"){

				$address = $map_obj->results[0]->formatted_address;

				$author_location = $address;
			}else{
				//try our geo database
				$sql = "SELECT country,iso FROM geo_country 
					WHERE {$proDetails['coordinate_x']} BETWEEN y1 AND y2 AND {$proDetails['coordinate_y']}
					BETWEEN x1 AND x2 LIMIT 100";
				$this->open(0);
				$geo = $this->fetch_many($sql,1);
				$this->close();
				if(sizeof($geo)==1){
					$author_location = $geo[0]['country'];
				}
			}

			
		}else if(floatval($coordinate_x)>0||floatval($coordinate_y)>0){
			$uri = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$coordinate_x.",".$coordinate_y."&sensor=false";
			
			$glmap_response = file_get_contents($uri);
			$map_obj = json_decode($glmap_response);
			
			if($map_obj->status=="OK"){
				$address = $map_obj->results[0]->formatted_address;
				$author_location = $address;
			}else{
				//try our geo database
				$sql = "SELECT country,iso FROM smac_data.geo_country 
					WHERE {$coordinate_x} BETWEEN y1 AND y2 AND {$coordinate_y}
					BETWEEN x1 AND x2 LIMIT 100;";
				$this->open(0);
				$geo = $this->fetch_many($sql,1);
				$this->close();

				if(sizeof($geo)==1){
					$author_location = $geo[0]['country'];
				}
			}
		}
		
		
		$data = $proDetails;
		$data['percentage'] = round($percentage,4);
		$data['rank'] = $peopleRank['rank'];
		$data['location'] = $author_location;
		$data['details'] = $author_about;
		$json = json_encode($data);
		echo $json;exit;
	}
	
	function youtubeDetail(){
		$id = $_SESSION['project_id'];
		$date = $this->model->youtube_date();
		
		//Date Hack
		if(strtotime($date['lastUpdate']) != strtotime(date("Y-m-d"))){
			$date['lastUpdate'] = date("Y-m-d");
		}
		
		$lastDateFormat = substr($date['lastUpdate'], 8, 2)."/".substr($date['lastUpdate'], 5, -3)."/".substr($date['lastUpdate'], 0, -6);
		$day7ago = strtotime ( '-6 day' , strtotime ( $date['lastUpdate'] ) ) ;
		$day7ago = date ( 'Y-m-d' , $day7ago );
		
		$startDate = $this->model->project_date($id);
		$sumStartDate = date ( 'Y-m-d' , strtotime ( '-1 day' , strtotime ($startDate) ) );
		
		if(strtotime($day7ago) < strtotime($startDate)){
			$startDate = $day7ago;
		}
		
		$channel = $this->model->youtube_channel();
		$this->View->assign('channelID', $channel['channel_id']);
		$this->View->assign('channelName', $channel['channel_name']);
		
		$stats = $this->model->youtube_stats();
		$total_share = $this->model->youtube_share_total();
		$total_subscriber = $this->model->youtube_subscriber_total();
		$this->View->assign('totalSubscriber',$total_subscriber['total_subscribe']);
		$this->View->assign('totalView',$stats['views']);
		$this->View->assign('uniqueUser',$stats['unik']);
		$this->View->assign('totalComment',$stats['comments']);
		$this->View->assign('totalShare',$total_share['total_share']);
	
		$daily = $this->model->youtube_daily($day7ago, $date['lastUpdate']);
		
		//wc
		$wc = $this->youtube_wordcloud();
		$this->View->assign("wordcloud", $wc);
		
		$this->View->assign('axislastUpdate', $lastDateFormat);
		$this->View->assign('startDate', $startDate);
		$this->View->assign('lastDate', $date['lastUpdate']);
		$this->View->assign('volume', json_encode($daily));
		$this->View->assign("userID", $_SESSION['project_id']);
		
		return $this->View->toString("dashboard/youtube_detail.html");
	}
	
	function youtubeDailyAjax($tab, $st, $end){
		switch($tab){
			case "subscribers":
				$result = $this->model->youtube_subscriber($st, $end);
				break;
			case "views":
				$result = $this->model->youtube_daily($st, $end);
				break;
			case "shares":
				$result = $this->model->youtube_share($st, $end);
				break;
			case "comments":
				$result = $this->model->youtube_comment($st, $end);
				break;
			default:
				$result = $this->model->youtube_daily($st, $end);
		}
		echo json_encode($result);exit;
	}
	
	function facebookDailyAjax($tab, $st, $end){
		switch($tab){
			case "likes":
				$result = $this->model->facebook_like($st, $end);
				break;
			case "ptat":
				$result = $this->model->facebook_ptat($st, $end);
				break;
			case "comments":
				$result = $this->model->facebook_comment($st, $end);
				break;
			case "posts":
				$result = $this->model->facebook_post($st, $end);
				break;
			case "shares":
			$result = $this->model->facebook_share($st, $end);
			break;
			default:
				$result = $this->model->facebook_like($st, $end);
		}
		
		$reach = $this->model->facebook_page_reach($st, $end);
		$visit = $this->model->getFBVisit($st, $end);
		$dataCollection = array(
							"dailyVolume" => $result,
							"pageReach" => $reach,
							"visit" => $visit
							);
		
		echo json_encode($dataCollection);exit;
	}
	
	function gplusDetail(){
		$id = $_SESSION['project_id'];
		$this->View->assign("userID", $_SESSION['project_id']);
		$date = $this->model->gplus_date();
		
		//Date Hack
		if(strtotime($date['lastUpdate']) != strtotime(date("Y-m-d"))){
			$date['lastUpdate'] = date("Y-m-d");
		}
		
		$lastDateFormat = substr($date['lastUpdate'], 8, 2)."/".substr($date['lastUpdate'], 5, -3)."/".substr($date['lastUpdate'], 0, -6);
		$day7ago = strtotime ( '-7 day' , strtotime ( $date['lastUpdate'] ) ) ;
		$day7ago = date ( 'Y-m-d' , $day7ago );
		
		$startDate = $this->model->project_date($id);
		$sumStartDate = date ( 'Y-m-d' , strtotime ( '-1 day' , strtotime ($startDate) ) );
		
		if(strtotime($day7ago) < strtotime($startDate)){
			$startDate = $day7ago;
		}
		
		
		$this->View->assign('axislastUpdate', $lastDateFormat);
		$this->View->assign('startDate', $startDate);
		$this->View->assign('lastDate', $date['lastUpdate']);
		
		$summary = $this->model->gplus_summary();
		$this->View->assign("circle", $summary['circle']);
		$this->View->assign("plus1", $summary['total_plus']);
		$this->View->assign("shares", $summary['total_share']);
		$this->View->assign("comments", $summary['total_comment']);
	
		$daily = $this->model->gplus_daily($day7ago, $date['lastUpdate']);
		$this->View->assign('daily', json_encode($daily));
		
		//Post
		$post = $this->model->gplus_post();
		$this->View->assign("post", $post);
		
		//wc
		$wc = $this->gplus_wordcloud();
		$this->View->assign("wordcloud", $wc);
	
		$this->View->assign("userID", $_SESSION['project_id']);
		return $this->View->toString("dashboard/gplus_detail.html");
	}
	
	function gplusAjax($st, $end){
		$daily = $this->model->gplus_daily($st, $end);
		echo json_encode($daily);exit;
	}
	
	function twitterAjax($st, $end, $twitID){
		$summary = $this->model->twitter_summary($st, $end, $twitID);
		$totalPeople = $this->model->twitter_uniquePeople($st, $end, $twitID);
		$sentiment = $this->model->twitter_sentiment($st, $end, $twitID);
		$daily = $this->model->twitter_daily($st, $end, $twitID);
		$conversation = $this->model->twitter_conversation($twitID);
		$wc = $this->twitter_wordcloud($twitID);
		
		$data = array(
				"summary" => $summary,
				"unik" => $totalPeople['unik'],
				"daily" => $daily,
				"sentiment" => $sentiment,
				"conversation" => $conversation,
				"wc" => $wc
				);
		echo json_encode($data);exit;
	}
	function gplus_wordcloud(){
		//Wordcloud
		$data = $this->model->gplus_wordcloud();
		// var_dump($data);
		$rs = array();
		$m=0;
		foreach($data as $w){
			$m = max($m,intval($w['total']));
			$mm = min($m,intval($w['total']));
			
			$rs[] = array(
						"txt"=>$w['keyword'],
						"amount"=>intval($w['total']),
						"weight"=>intval($w['total']),
						"url"=>$link,
						"is_main"=>null,
						"sentiment"=>intval($w['sentiment']),
						"title"=> "Click to see detailed analysis"
						);
		}
		
		foreach($rs as $n=>$v){
			
			$weight = ceil(($v['amount']/($m-$mm))*9);
			$rs[$n]['weight'] = $weight;
			$rs[$n]['max'] = $m;
			$rs[$n]['min'] = $mm;
		}
		// print ('<pre>');
		// print_r($rs);exit;
		
		$wordcloud = new wordcloudHelper(470,370);
		$wordcloud->urlto=$link;
		$wordcloud->setHandler('homewordcloud');
		$wordcloud->set_sentiment_style(array("positive"=>"wcstat1","negative"=>"wcstat2","neutral"=>"wcstat0","main_keyword"=>"wcstat3"));
		
		return $wordcloud->draw($rs);
	}
	
	function fb_wordcloud(){
		//Wordcloud
		$data = $this->model->fb_wordcloud();
		// var_dump($data);
		$rs = array();
		$m=0;
		foreach($data as $w){
			$m = max($m,intval($w['total']));
			$mm = min($m,intval($w['total']));
			
			$rs[] = array(
						"txt"=>$w['keyword'],
						"amount"=>intval($w['total']),
						"weight"=>intval($w['total']),
						"url"=>$link,
						"is_main"=>null,
						"sentiment"=>intval($w['sentiment']),
						"title"=> "Click to see detailed analysis"
						);
		}
		
		foreach($rs as $n=>$v){
			
			$weight = ceil(($v['amount']/($m-$mm))*9);
			$rs[$n]['weight'] = $weight;
			$rs[$n]['max'] = $m;
			$rs[$n]['min'] = $mm;
		}
		// print ('<pre>');
		// print_r($rs);exit;
		
		$wordcloud = new wordcloudHelper(470,370);
		$wordcloud->urlto=$link;
		$wordcloud->setHandler('homewordcloud');
		$wordcloud->set_sentiment_style(array("positive"=>"wcstat1","negative"=>"wcstat2","neutral"=>"wcstat0","main_keyword"=>"wcstat3"));
		
		return $wordcloud->draw($rs);
	}
	function youtube_wordcloud(){
		//Wordcloud
		$data = $this->model->youtube_wordcloud();
		// var_dump($data);
		$rs = array();
		$m=0;
		foreach($data as $w){
			$m = max($m,intval($w['total']));
			$mm = min($m,intval($w['total']));
			
			$rs[] = array(
						"txt"=>$w['keyword'],
						"amount"=>intval($w['total']),
						"weight"=>intval($w['total']),
						"url"=>$link,
						"is_main"=>null,
						"sentiment"=>intval($w['sentiment']),
						"title"=> "Click to see detailed analysis"
						);
		}
		
		foreach($rs as $n=>$v){
			
			$weight = ceil(($v['amount']/($m-$mm))*9);
			$rs[$n]['weight'] = $weight;
			$rs[$n]['max'] = $m;
			$rs[$n]['min'] = $mm;
		}
		// print ('<pre>');
		// print_r($rs);exit;
		
		$wordcloud = new wordcloudHelper(470,370);
		$wordcloud->urlto=$link;
		$wordcloud->setHandler('homewordcloud');
		$wordcloud->set_sentiment_style(array("positive"=>"wcstat1","negative"=>"wcstat2","neutral"=>"wcstat0","main_keyword"=>"wcstat3"));
		
		return $wordcloud->draw($rs);
	}
}