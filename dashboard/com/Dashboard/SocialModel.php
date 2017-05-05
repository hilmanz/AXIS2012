<?php
/** MODEL DATA 
 ** @cendekiApp
 **/
global $ENGINE_PATH;
include_once APP_PATH."Dashboard/helper/countryNameHelper.php";

class SocialModel extends SQLData{
	function __construct($req){
		parent::SQLData();
		$this->Request = $req;
		$this->View = new BasicView();
		$this->User = new UserManager();
		$this->countryID = new countryNameHelper();
	}
	
	function getProjectDetail($id){
		$this->open(0);
		$c=	"SELECT *
			FROM tbl_project k
			WHERE k.id = '1';";
		$f=	$this->fetch($c);
		$this->close();
		return $f;
	}
	
	function getFBPageDetails($id){
		$this->open(0);
		$c=	"SELECT *
			FROM fb_page_name
			WHERE proID = '10'";
		$f=	$this->fetch($c);
		$this->close();
		return $f;
	}
	function getFBVolume($start, $end){
		$this->open(0);
		$start= "SELECT c.day AS tgl,c.fans AS likefan,k.value AS story, b.post_count AS post, k.day
			FROM fb_page_fans c 
			LEFT JOIN fb_page_stories_day k ON k.day = c.day
			LEFT JOIN fb_page_posts_summary b ON b.post_date = c.day
			WHERE c.day >= '".$start."' AND c.day <= '".$end."'";
		$c= "SELECT c.day AS tgl,c.fans AS likefan,k.value AS story, b.post_count AS post, k.day
			FROM fb_page_fans c 
			LEFT JOIN fb_page_stories_day k ON k.day = c.day
			LEFT JOIN fb_page_posts_summary b ON b.post_date = c.day
			WHERE c.day >= '".$start."' AND c.day <= '".$end."'
			GROUP BY tgl
			DESC";
		$startData = $this->fetch($start);
		var_dump($start);
		$f = $this->fetch($c,1);
		$this->close();
		$vol = array_reverse($f);
		$temp = $vol;
		foreach($vol as $k=>$v){
			if($k > 0){
				$vol[$k]['likefan'] = (intval($v['likefan']) - intval($temp[$k-1]['likefan']));
				$vol[$k]['post'] = (intval($vol[$k]['post']) + intval($temp[$k]['post']));
			}else{
				$vol[$k]['likefan'] = (intval($v['likefan']) - intval($startData['likefan']));
				$vol[$k]['post'] = (intval($vol[$k]['post']) + intval($startData['post']));
			}
		}
		
		
		// var_dump($f);exit;
		return $vol;
	}
	
	function getFBLike($id){
		$this->open(0);
			$latest= "SELECT fans FROM fb_page_fans 
						WHERE proID = ".$id."
						ORDER BY day DESC LIMIT 1";
			// $start= "SELECT fans FROM fb_page_fans 
						// WHERE proID = ".$id." AND day = '".$sumStartDate."'
						// ORDER BY day DESC LIMIT 1";
			
			// $startData = $this->fetch($start);
			$latestData= $this->fetch($latest);
			// $result = intval($latestData['fans']) - intval($startData['fans']);
			$result = intval($latestData['fans']);
		$this->close();
		return $result;
	}
	
	function getFBStory($id){
		$this->open(0);
			// $c= "SELECT SUM(value) as value FROM fb_page_stories_day WHERE day > '".$sumStartDate."' ORDER BY day DESC LIMIT 1";
			$c= "SELECT SUM(value) as value FROM fb_page_stories_day WHERE 1 ORDER BY day DESC LIMIT 1";
			$f= $this->fetch($c);
		$this->close();
		return $f;
	}
	
	function getFBPosts($id, $sumStartDate){
		$this->open(0);
			// $c = "SELECT SUM(post_count) AS value FROM fb_page_posts_summary
					// WHERE post_date > '".$sumStartDate."'";
			$c = "SELECT SUM(post_count) AS value FROM fb_page_posts_summary
			WHERE 1";
			$f= $this->fetch($c);
		$this->close();
		return $f;
	}
	
	function getFBTotalVolume($id){
		$this->open(0);
		$c= "SELECT SUM(c.fans) AS likefan, SUM(k.value) AS story, SUM(b.value) AS post
			FROM fb_page_fans c 
			LEFT JOIN fb_page_stories_day k ON k.proID = c.proID AND k.day = c.day
			LEFT JOIN fb_page_posts_impressions_day b ON b.proID = c.proID AND b.day = c.day
			WHERE c.proID = '".$id."'";
		$f = $this->fetch($c);
		$this->close();
		// var_dump($f);exit;
		return $f;
	}
	
	function getFBVisit($start, $end){
		$this->open(0);
		$c= "SELECT c.day AS tgl, c.value AS visitAll, k.value AS visitUnique
			FROM fb_page_views_day c
			LEFT JOIN fb_page_views_unique_day k
			ON k.day = c.day AND k.proID = c.proID
			WHERE c.day >= '".$start."' AND c.day <= '".$end."'
			GROUP BY c.day
			DESC";
		$f = $this->fetch($c,1);
		$this->close();
		$data = array_reverse($f);
		
		$datesum = strtotime($end) - strtotime($start);
		$datesum = floor($datesum/(60*60*24));
		$open=0;
		$s=0;
		$tempAll=array();
		$tempUnigue=array();
		$tempTGL=array();
		for($i=0;$i<=$datesum;$i++){
			$data[$i]['tgl'] = date ( 'Y-m-d' , strtotime($data[$i]['tgl']));
			
			if($data[$i]['tgl'] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start))) || $tempTGL[0] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start)))){
				if(sizeof($tempTGL)>0){
					$category[] = $tempTGL[0];
					$all[] = intval($tempAll[0]);
					$uni[] = intval($tempUnigue[0]);
					array_shift($tempTGL);
					array_shift($tempAll);
					array_shift($tempUnigue);
					$i--;
					$datesum--;
				}else{
					$category[] = $data[$i]['tgl'];
					$all[] = intval($data[$i]['visitAll']);
					$uni[] = intval($data[$i]['visitUnique']);
				}
			}else{
				$tempTGL[] = $data[$i]['tgl'];
				$tempAll[] = intval($data[$i]['visitAll']);
				$tempUnigue[] = intval($data[$i]['visitUnique']);
				$datehack = strtotime( '+'.$s.' day' ,strtotime($start));
				$category[] = date ( 'Y-m-d' , $datehack);
				$all[] = 0;
				$uni[] = 0;
			}
			$s++;
		}
		
		$visitPart = array(
					"category" => $category,
					"all" => $all,
					"unique" => $uni
					);
		
		return $visitPart;
	}
	
	function getFBReach($id){
		$this->open(0);
		$c= "SELECT c.day AS tgl, c.value AS organic, k.value AS paid, b.value AS viral  
			FROM fb_page_impressions_organic_unique_day c
			LEFT JOIN fb_page_impressions_paid_unique_day k
			ON k.proID = c.proID AND k.day = c.day
			LEFT JOIN fb_page_impressions_viral_unique_day b
			ON b.proID = c.proID AND b.day = c.day
			WHERE c.proID = '".$id."'
			AND c.day > '2012-07-23'
			GROUP BY tgl
			DESC";
		$f = $this->fetch($c,1);
		$this->close();
		$reach = array_reverse($f);
		  // var_dump($f);exit;
		return $reach;
	}
	
	function getFBReachTotal($id){
		$this->open(0);
		$c= "SELECT SUM(c.value) AS organic, SUM(k.value) AS paid, SUM(b.value) AS viral  
			FROM fb_page_impressions_organic_unique_day c
			LEFT JOIN fb_page_impressions_paid_unique_day k
			ON k.proID = c.proID AND k.day = c.day
			LEFT JOIN fb_page_impressions_viral_unique_day b
			ON b.proID = c.proID AND b.day = c.day
			WHERE c.proID = '".$id."'";
		// $c = "SELECT value FROM fb_page_impressions_unique_day WHERE proID = ".$id." ORDER BY day DESC LIMIT 1";
		$f = $this->fetch($c);
		$this->close();
		 // var_dump($f);exit;
		return $f;
	}
	
	function getFBDemography($id, $sumStartDate){
		$this->open(0);
		// $start= "SELECT c.demografi AS age, c.value AS nilai, c.day
			// FROM fb_page_fans_gender_age c
			// WHERE proID = '".$id."'
			// AND demografi NOT LIKE '%U%'
			// AND c.day = '".$sumStartDate."'";
		$latest= "SELECT c.demografi AS age, c.value AS nilai, c.day
			FROM fb_page_fans_gender_age c
			WHERE proID = '".$id."'
			AND demografi NOT LIKE '%U%'
			AND c.day = (SELECT MAX(f.day) FROM fb_page_fans_gender_age f)";
		// $startData = $this->fetch($start,1);
		$latestData = $this->fetch($latest,1);
		// foreach($latestData as $k=>$v){
			// $latestData[$k]['nilai'] = (intval($latestData[$k]['nilai']) - intval($startData[$k]['nilai']));
		// }
		$this->close();
		// print_r('<pre>');
		// print_r($latestData);exit;
		return $latestData;
	}
	
	function getFBLocation($id, $sumStartDate){
		$this->open(0);
		// $start= "SELECT c.region AS country, c.value AS nilai
			// FROM fb_page_fans_country c
			// WHERE c.proID = '".$id."'
			// AND c.day = '".$sumStartDate."'
			// ORDER BY nilai DESC";
		$latest= "SELECT c.region AS country, c.value AS nilai
			FROM fb_page_fans_country c
			WHERE c.proID = '".$id."'
			AND c.day = (SELECT MAX(f.day) FROM fb_page_fans_country f)
			ORDER BY nilai DESC";
		// $startData = $this->fetch($start,1);
		$latestData = $this->fetch($latest,1);
		$this->close();
		$i=0;
		foreach ($latestData as $k=>$loc){
			if($i < 10){
				// $tempData = intval($loc['nilai']) - intval($startData[$k]['nilai']);
				// if($tempData > 0){
					$location[$i] = $this->countryID->countryName($loc['country']);
					$value[$i] = intval($loc['nilai']);
					// $value[$i] = $tempData;
					$i++;
				// }
			}else{
				$location[$i] = 'Others';
				$value[$i]+= intval($loc['nilai']);
			}
			
		}
		$locPart = array(
					"location" => $location,
					"value" => $value
					);
		 // var_dump($locPart);exit;
		return $locPart;
	}
	
	function getFBEngagement($id, $sumStartDate){
		$this->open(0);
		$c= "SELECT SUM(comment_count) + SUM(like_count) AS reach
				FROM fb_page_posts
				WHERE 1
				ORDER BY reach
				DESC LIMIT 1";
		$f = $this->fetch($c);
		$this->close();
		
		$PTAT = $this->getFBStory($id, $sumStartDate);

		$share = intval($PTAT['value'])- intval($f['reach']);
		$engagement = $share + intval($f['reach']);
		return $engagement;
	}
	
	function getFBPost($id, $sumStartDate){
		$this->open(0);
		$c= "SELECT comment_count + like_count AS reach, message, comment_count AS comments, like_count AS likes
				FROM fb_page_posts
				WHERE 1
				GROUP BY id
				ORDER BY reach
				DESC LIMIT 10";
		$f = $this->fetch($c,1);
		$this->close();
		return $f;
	}
	
	function getFBCity($id, $sumStartDate){
		$this->open(0);
		$c= "SELECT region, SUM(value) AS value
			FROM fb_page_fans_city
			WHERE 1
			GROUP BY region
			ORDER BY value
			DESC LIMIT 10";
		$f = $this->fetch($c,1);
		$this->close();
		 // var_dump($f);exit;
		return $f;
	}
	
	function getTWVolume($id){
		$this->open(0);
		// $c= "SELECT c.published_date AS tgl, c.mentions AS mention, c.people AS person, c.rt AS retwit
			// FROM campaign_daily_summary c
			// WHERE c.campaign_id = '16'
			// AND c.published_date >= DATE_SUB('2011-10-03', INTERVAL 6 DAY)";
		
		//Khusus AXIS
		$c = "SELECT dtreport AS tgl, SUM(total_mention_twitter) AS mention, SUM(total_rt_twitter) AS retwit, SUM(total_people_twitter) AS person
				FROM campaign_rule_volume_history
				WHERE dtreport > '2012-07-23'
				GROUP BY dtreport
				ORDER BY 1
				DESC";
		$f = $this->fetch($c,1);
		$this->close();
		$vol = array_reverse($f);
		 // var_dump($f);exit;
		return $vol;
	}
	
	function getTWVolumeTotal($id){
		$this->open(0);
		// $c=	"SELECT SUM(total_mention_twitter) as mention, SUM(total_rt_twitter) as retwit
			// FROM campaign_rule_volume_history";
		$c = "SELECT SUM(mentions) AS mention, SUM(impressions) AS impressions, SUM(rt_impressions) AS rt_impressions, SUM(rt) AS rt
				FROM tbl_twitter_daily_stats
				WHERE 1 LIMIT 1";
		$f = $this->fetch($c);
		$this->close();
		return $f;
	}
	
	function getTWFollower($id){
		$this->open(0);
		// $c= "SELECT c.published_date AS tgl, c.author_id AS author, c.followers AS jml
			// FROM account_followers c
			// WHERE c.campaign_id = '16'
			// AND c.published_date >= DATE_SUB('2011-09-24', INTERVAL 6 DAY)";
		$c = "SELECT SUM(followers_to_date) AS jml, author_id AS author, dtfeed AS tgl 
				FROM monitor_people_followers
				WHERE author_id = 'AXISgsm'
				AND dtfeed > '2012-07-23'
				GROUP BY dtfeed
				ASC";
		$f = $this->fetch($c,1);
		$this->close();
		 // var_dump($f);exit;
		return $f;
	}
	
	function getTWSentiment($id){
		$this->open(0);
		// $c= "SELECT SUM(c.positive) AS plus, SUM(c.negative) AS minus, SUM(c.neutral) AS normal
			// FROM campaign_sentiment_summary c
			// WHERE c.campaign_id = '16'
			// AND c.published_date >= DATE_SUB('2011-10-03', INTERVAL 6 DAY)";
		$c = "SELECT SUM(total_mention_positive) AS plus, SUM(total_mention_negative) AS minus, dtreport
				FROM daily_campaign_sentiment WHERE dtreport > '2012-07-23' AND channel = '1'";
		$n = "SELECT SUM(total_mention_twitter) AS mention, dtreport
				FROM campaign_rule_volume_history WHERE dtreport > '2012-07-23'";
		$f = $this->fetch($c,1);
		$all = $this->fetch($n,1);
		$this->close();
		 
		$netral = intval($all[0]['mention'])-(intval($f[0]['plus'])+intval($f[0]['minus']));
		
		$f[0]['normal'] = $netral;
		// var_dump($netral."==".$all[0]['mention']."==".$f[0]['plus']."==".$f[0]['minus']);exit;
		return $f;
	}
	
	function getTWSentimentTotal($id){
		$this->open(0);
		$c= "SELECT SUM(c.positive) AS plus, SUM(c.negative) AS minus, SUM(c.neutral) AS normal
			FROM campaign_sentiment_summary c
			WHERE c.campaign_id = '16'";
		$f = $this->fetch($c);
		$this->close();
		 // var_dump($f);exit;
		return $f;
	}
	
	function getTWCountPeople($id){
		$this->open(0);
		$barokah= "SELECT COUNT(id) AS unik
			FROM author_summary_248";
		$berkah = "SELECT COUNT(id) AS unik
					FROM author_summary_249";
		$brk = $this->fetch($barokah);
		$bkh = $this->fetch($berkah);
		$this->close();
		
		$f['unik'] = intval($brk['unik'])+intval($bkh['unik']);
		 // var_dump($f);exit;
		return $f;
	}
	
	function getTWSentimentDaily($id){
		$this->open(0);
		// $c= "SELECT c.published_date AS tgl, c.positive AS plus, c.negative AS minus, c.neutral AS normal
			// FROM campaign_sentiment_summary c
			// WHERE c.campaign_id = '16'";
		$c= "SELECT SUM(total_mention_positive) AS plus, SUM(total_mention_negative) AS minus, dtreport AS tgl
			FROM daily_campaign_sentiment
			WHERE dtreport > '2012-07-23' AND channel = '1'
			GROUP BY dtreport
			DESC";
		$netral = "SELECT SUM(total_mention_twitter) AS mention, dtreport AS tgl
				FROM campaign_rule_volume_history
				WHERE dtreport > '2012-07-23'
				GROUP BY dtreport
				DESC";
		$f = $this->fetch($c,1);
		$net = $this->fetch($netral,1);
		$this->close();
		$i = 0;
		foreach($net as $k=>$v){
			if(strtotime($f[$i]['tgl']) == strtotime($v['tgl'])){
				$net[$k]['normal'] = intval($v['mention']) - (intval($f[$i]['plus'])+intval($f[$i]['minus']));
				$net[$k]['plus'] = intval($f[$i]['plus']);
				$net[$k]['minus'] = intval($f[$i]['minus']);
				$i++;
			}else if(strtotime($f[$i]['tgl']) != strtotime($v['tgl'])){
				$net[$k]['normal'] = intval($v['mention']) - 0;
				$net[$k]['plus'] = 0;
				$net[$k]['minus'] = 0;
			}
		}
		
		$reverse = array_reverse($net);
		// print_r('<pre>');
		// print_r($reverse);exit;
		return $reverse;
	}
	
	function getTWWordcloud($id){
		$this->open(0);
		// $c = "SELECT a.keyword, SUM(a.occurance) AS total, b.weight AS sentiment 
				// FROM top_wordcloud_summary a
				// LEFT JOIN axis_sentiment_setup b
				// ON a.keyword = b.keyword
				// GROUP BY a.keyword
				// ORDER BY a.occurance
				// DESC LIMIT 100";
		$c = "SELECT a.keyword, SUM(a.total) AS total
				FROM tbl_twitter_wordcloud a
				WHERE a.twitter_id = '".$id."'
				GROUP BY a.keyword
				ORDER BY a.total
				DESC LIMIT 50";
		$f = $this->fetch($c,1);
		$this->close();
		 // var_dump($f);exit;
		return $f;
	}
	
	function getTWKeyword($id){
		$this->open(0);
		// $c= "SELECT keyword, total, sentiment
			// FROM top_keywords
			// WHERE campaign_id = '16'
			// GROUP BY keyword
			// ORDER BY total DESC
			// LIMIT 10";
		$c = "SELECT keyword, SUM(occurance) AS total
				FROM top_wordcloud_summary
				WHERE 1
				GROUP BY keyword
				ORDER BY 2
				DESC LIMIT 10";
		$f = $this->fetch($c,1);
		$this->close();
		 // var_dump($f);exit;
		return $f;
	}
	function getTWConversations($id){
		$this->open(0);
		// $c= "SELECT *
			// FROM top_conversations
			// WHERE campaign_id = '16'
			// ORDER BY followers DESC
			// LIMIT 10";
		$c = "SELECT *
				FROM axis_latest_conversation
				WHERE 1
				ORDER BY followers
				DESC LIMIT 10";
		$f = $this->fetch($c,1);
		$this->close();
		 // var_dump($f);exit;
		return $f;
	}
	function getTWCountries($id){
		$this->open(0);
		// $c= "SELECT campaign_id, country_name, mentions
			// FROM top_countries
			// WHERE campaign_id = '16'
			// ORDER BY mentions DESC
			// LIMIT 10";
		$c = "SELECT country_id AS country_name, SUM(total_mention) AS mentions
				FROM daily_country_volume
				WHERE 1
				GROUP BY country_id
				ORDER BY 2
				DESC LIMIT 1";
		$f = $this->fetch($c,1);
		$this->close();
		$f[0]['country_name'] = $this->countryID->countryName($f[0]['country_name']);
		 // var_dump($f);exit;
		return $f;
	}
	
	function getTWKOL($id, $sentiment){
		if($sentiment== 1){
			$table1 = "campaign_ambas_248";
			$table2 = "campaign_ambas_249";

			$order = "DESC";
			$c= "SELECT author_id, author_avatar, sentiment AS total FROM ".$table1."	
				UNION
				SELECT author_id, author_avatar, sentiment AS total FROM ".$table2."
				ORDER BY total ".$order." LIMIT 10";
		}else if($sentiment == -1){
			$table1 = "campaign_trolls_248";
			$table2 = "campaign_trolls_249";
			$tableNot1 = "campaign_ambas_248";
			$tableNot2 = "campaign_ambas_249";		
			$order = "ASC";
			$c= "SELECT author_id, author_avatar, sentiment AS total FROM ".$table1." f
				WHERE author_id NOT IN ('ask_AXIS','AXISgsm')
				UNION
				SELECT author_id, author_avatar, sentiment AS total FROM ".$table2." g
				WHERE author_id NOT IN ('ask_AXIS','AXISgsm')
				ORDER BY total ".$order." LIMIT 10";
		}else{
			$tableNetral1 = "author_summary_248";
			$tableNetral2 = "author_summary_249";
			$table1 = "campaign_trolls_248";
			$table2 = "campaign_trolls_249";
			$tableNot1 = "campaign_ambas_248";
			$tableNot2 = "campaign_ambas_249";		
			$order = "DESC";
			$c= "SELECT author_id, author_avatar, total_impression, 0 AS total FROM ".$tableNetral1." f
				WHERE NOT EXISTS (
					SELECT 1 FROM {$table1} a
					WHERE a.author_id = f.author_id
				)	AND  NOT EXISTS (
					SELECT 1 FROM {$tableNot1} a
					WHERE a.author_id = f.author_id
				)	
				UNION
				SELECT author_id, author_avatar, total_impression, 0 AS total FROM ".$tableNetral2." g
				WHERE NOT EXISTS (
					SELECT 1 FROM {$table2} a WHERE a.author_id = g.author_id
				) AND NOT EXISTS (
					SELECT 1 FROM {$tableNot2} a WHERE a.author_id = g.author_id
				)
				ORDER BY total_impression ".$order." LIMIT 10";
				
		}
		$this->open(0);
		// $c= "SELECT campaign_id, author_id, author_avatar, total, sentiment_type
			// FROM kols
			// WHERE campaign_id = '16'
			// AND sentiment_type = '".$sentiment."'";
		
		$f = $this->fetch($c,1);
		$this->close();
		 // var_dump($f);exit;
		return $f;
	}
	
	function getTWProfileDetails($id, $author){
		$this->open(0);
		$c= "SELECT author_id, author_name, author_avatar, followers, impression, rt_impression, total_mentions, rt_mention, coordinate_x, coordinate_y
			FROM people
			WHERE campaign_id = '16'
			AND author_id = '".$author."'";
		$f = $this->fetch($c);
		$this->close();
		 // var_dump($f);exit;
		return $f;
	}
	function getTotalImpression($id){
		$this->open(0);
		$c= "SELECT SUM(impression) AS total
			FROM people
			WHERE campaign_id = '16'";
		$f = $this->fetch($c);
		$this->close();
		 // var_dump($f);exit;
		return $f;
	}
	function getTWPeopleRank($id, $author){
		$this->open(0);
		$c= "SELECT rank
			FROM people_rank
			WHERE campaign_id = '16'
			AND author_id = '".$author."'";
		$f = $this->fetch($c);
		$this->close();
		 // var_dump($f);exit;
		return $f;
	}
	function getChannels($id){
		$this->open(0);
		$c=	"SELECT SUM(total_mention_twitter) AS twitter, SUM(total_mention_facebook) AS facebook, SUM(total_mention_web) blog
			FROM campaign_rule_volume_history WHERE dtreport > '2012-07-23'";
		$f=	$this->fetch($c);
		$this->close();
		return $f;
	}
	function getTWTopCountries($id){
		$this->open(0);
		// $c=	"SELECT country_name, mentions
			// FROM top_countries
			// WHERE campaign_id = '16'";
			
		$c = "SELECT country_id AS country_name, SUM(total_mention) AS mentions
				FROM daily_country_volume
				WHERE 1
				GROUP BY country_id
				ORDER BY 2
				DESC LIMIT 1";
		$f=	$this->fetch($c,1);
		$f[0][country_name] = $this->countryID->countryName($f[0][country_name]);
		$this->close();
		return $f;
	}
	
	function getTWTotalImpression($id){
		$this->open(0);
		$c=	"SELECT SUM(total_impression_twitter) AS impresi, SUM(total_rt_impression_twitter) AS rt
			FROM campaign_rule_volume_history";
		$f=	$this->fetch($c);
		$this->close();
		return $f;
	}
	
	function youtube_channel(){
		$this->open(0);
		$sql = "SELECT *
				FROM channel_stats WHERE 1 LIMIT 1";
		$rs = $this->fetch($sql);
		$this->close();
		return $rs;
	}
	
	function youtube_date(){
		$this->open(0);
		$sql = "SELECT MAX(DATE) as lastUpdate, MIN(DATE) as startDate
				FROM video_raw 
				WHERE 1 LIMIT 1";
		$rs = $this->fetch($sql);
		$this->close();
		return $rs;
	}
	
	function youtube_daily($start, $end){
		$this->open(0);
		$sql = "SELECT SUM(UNIQUE_USERS) as unik, SUM(views) as total_view, date
				FROM video_raw
				WHERE date >= '".$start."' AND date <= '".$end."'
				GROUP BY date";
		$data = $this->fetch($sql,1);
		$this->close();
		
		$datesum = strtotime($end) - strtotime($start);
		$datesum = floor($datesum/(60*60*24));
		$open=0;
		$s=0;
		$tempTotal=array();
		$tempUnik=array();
		$tempTGL=array();
		for($i=0;$i<=$datesum;$i++){
			$data[$i]["date"] = date ( 'Y-m-d' , strtotime($data[$i]["date"]));
			
			if($data[$i]["date"] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start))) || $tempTGL[0] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start)))){
				if(sizeof($tempTGL)>0){
					$category[] = $tempTGL[0];
					$views[] = intval($tempTotal[0]);
					$unik[] = intval($tempUnik[0]);
					array_shift($tempTGL);
					array_shift($tempTotal);
					array_shift($tempUnik);
					$i--;
					$datesum--;
				}else{
					$category[] = $data[$i]["date"];
					$views[] = intval($data[$i]['total_view']);
					$unik[] = intval($data[$i]['unik']);
				}
			}else{
				$tempTGL[] = $data[$i]["date"];
				$tempTotal[] = intval($data[$i]['total_view']);
				$tempUnik[] = intval($data[$i]['unik']);
				$datehack = strtotime( '+'.$s.' day' ,strtotime($start));
				$category[] = date ( 'Y-m-d' , $datehack);
				$views[] = 0;
				$unik[] = 0;
			}
			$s++;
		}
		
		$volumePart = array(
					"category" => $category,
					"dat" => $views,
					"unik" => $unik,
					"name" => "Views"
					);
		return $volumePart;
	}
	function youtube_daily_total(){
		$this->open(0);
		$sql = "SELECT SUM(views) AS total_view
				FROM video_raw
				WHERE 1 LIMIT 1";
		$rs = $this->fetch($sql);
		$this->close();
		return $rs;
	}
	function youtube_stats(){
		$this->open(0);
		$sql = "SELECT SUM(UNIQUE_USERS) AS unik, SUM(views) AS views, SUM(comments) AS comments 
				FROM video_raw WHERE 1 LIMIT 1";
		$rs = $this->fetch($sql);
		$this->close();
		return $rs;
	}
	function youtube_share($start, $end){
		$this->open(0);
		$sql = "SELECT shares, date
				FROM channel_share 
				WHERE date >= '".$start."' AND date <= '".$end."'
				GROUP BY date";
		$daily = $this->fetch($sql,1);
		$this->close();
		
		return $this->dataHack("Shares", "date", "shares", $start, $end, $daily);
	}
	function youtube_share_total(){
		$this->open(0);
		$sql = "SELECT SUM(shares) AS total_share
				FROM channel_share WHERE 1 LIMIT 1";
		$rs = $this->fetch($sql);
		$this->close();
		return $rs;
	}
	function youtube_subscriber($start, $end){
		$this->open(0);
		$sql = "SELECT subscribe, date
				FROM channel_subscribers 
				WHERE date >= '".$start."' AND date <= '".$end."'
				GROUP BY date";
		$daily = $this->fetch($sql,1);
		$this->close();
		
		return $this->dataHack('Subscribers', "date", "subscribe", $start, $end, $daily);
	}
	function youtube_subscriber_total(){
		$this->open(0);
		$sql = "SELECT SUM(subscribe) AS total_subscribe
				FROM channel_subscribers WHERE 1 LIMIT 1";
		$rs = $this->fetch($sql);
		$this->close();
		return $rs;
	}
	function youtube_unique_visitor_per_day(){
		$this->open(0);
		$sql = "SELECT SUM(UNIQUE_USERS), DATE
				FROM video_raw
				GROUP BY DATE";
		$rs = $this->fetch($sql,1);
		$this->close();
		return $rs;
	}
	function youtube_comment($start, $end){
		$this->open(0);
		$sql = "SELECT SUM(comments) AS comments, date
				FROM video_raw
				WHERE date >= '".$start."' AND date <= '".$end."'
				GROUP BY date";
		$daily = $this->fetch($sql,1);
		$this->close();

		return $this->dataHack("Comments", "date", "comments", $start, $end, $daily);
	}
	
	function facebook_date(){
		$this->open(0);
		$sql = "SELECT MAX(day) as lastUpdate, MIN(day) as startDate
				FROM fb_page_fans 
				WHERE 1 LIMIT 1";
		$rs = $this->fetch($sql);
		$this->close();
		return $rs;
	}
	
	function facebook_like($start, $end){
		$this->open(0);
			$q= "SELECT fans, day 
					FROM fb_page_fans 
					WHERE day >= '".$start."' AND day <= '".$end."'
					ORDER BY day ASC";
			$prev = "SELECT fans 
					FROM fb_page_fans 
					WHERE day < '".$start."' ORDER BY day DESC LIMIT 1";
			$data= $this->fetch($q,1);
			$prevData= $this->fetch($prev);
		$this->close();
		
		$temp = $data;
		$datesum = strtotime($end) - strtotime($start);
		$datesum = floor($datesum/(60*60*24));
		$open=0;
		$s=0;
		$tempData=array();
		$tempTGL=array();
		for($i=0;$i<=$datesum;$i++){
			$data[$i]['day'] = date ( 'Y-m-d' , strtotime($data[$i]['day']));
			
			if($data[$i]['day'] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start))) || $tempTGL[0] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start)))){
				if(sizeof($tempTGL)>0){
					if($i == 0){
						if($prevData['fans']){
							$tempTGL[0] = intval($tempTGL[0]) - $prevData['fans'];
						}else{
							$tempTGL[0] = intval($tempTGL[0]);
						}
					}else{
						$tempTGL[0] = intval($tempTGL[0]) - intval($temp[$i-1]['fans']);
					}
					$category[] = $tempTGL[0];
					$datas[] = intval($tempData[0]);
					array_shift($tempTGL);
					array_shift($tempData);
					$i--;
					$datesum--;
				}else{
					if($i == 0){
						if($prevData['fans']){
							$data[$i]['fans'] = intval($data[$i]['fans']) - $prevData['fans'];
						}else{
							$data[$i]['fans'] = intval($data[$i]['fans']);
						}
					}else{
						$data[$i]['fans'] = intval($data[$i]['fans']) - intval($temp[$i-1]['fans']);
					}
					$category[] = $data[$i]['day'];
					$datas[] = intval($data[$i]["fans"]);
				}
			}else{
				$tempTGL[] = $data[$i]['day'];
				$tempData[] = $data[$i]['fans'];
				$datehack = strtotime( '+'.$s.' day' ,strtotime($start));
				$category[] = date ( 'Y-m-d' , $datehack);
				$datas[] = 0;
			}
			$s++;
		}
		
		$volume = array(
					"category" => $category,
					"dat" => $datas,
					"name" => "Likes"
					);
		return $volume;
	}
	
	function facebook_ptat($start, $end){
		$this->open(0);
			$q= "SELECT value, day 
					FROM fb_page_stories_day 
					WHERE day >= '".$start."' AND day <= '".$end."'
					ORDER BY day ASC";
			$data= $this->fetch($q,1);
		$this->close();

		return $this->dataHack("Talking About This" ,'day', 'value', $start, $end, $data);
	}
	
	function facebook_post($start, $end){
		$this->open(0);
			$q= "SELECT post_count, post_date
					FROM fb_page_posts_summary 
					WHERE post_date >= '".$start."' AND post_date <= '".$end."'
					ORDER BY post_date ASC";
			$data= $this->fetch($q,1);
		$this->close();
		
		return $this->dataHack("Posts" ,'post_date', 'post_count', $start, $end, $data);
	}
	
	function facebook_comment($start, $end){
		$this->open(0);
		$q="SELECT SUM(comment_count) AS comments, DATE_FORMAT(created_time,'%Y-%m-%d') AS tgl
			FROM fb_page_posts
			WHERE DATE_FORMAT(created_time,'%Y-%m-%d') >= '".$start."' 
			AND DATE_FORMAT(created_time,'%Y-%m-%d') <= '".$end."'
			GROUP BY tgl
			ORDER BY tgl
			ASC";
		$data= $this->fetch($q,1);
		$this->close();
		
		return $this->dataHack("Comments" ,'tgl', 'comments', $start, $end, $data);
	}
	
	function facebook_share($start, $end){
		$data[] = $this->facebook_like($start, $end);
		$data[] = $this->facebook_ptat($start, $end);
		$data[] = $this->facebook_comment($start, $end);
		
		$length = 0;
		$i=0;
		foreach($data as $maxLength){
			$tempLength = sizeof($maxLength['category']);
			if($length < $tempLength){
				$length = $tempLength;
				$param = $i;
			}
			$i++;
		}
		$likeIndex = 0;
		$ptatIndex = 0;
		$commentIndex = 0;
		$a = 0;
		foreach($data[$param]['category'] as $dat){
			//Likes
			if($dat == $data[0]['category'][$likeIndex]){
				$like = $data[0]['dat'][$likeIndex];
				$likeIndex++;
			}else{$like = 0;}
			//PTAT
			if($dat == $data[1]['category'][$ptatIndex]){
				$ptat = $data[1]['dat'][$ptatIndex];
				$ptatIndex++;
			}else{$ptat=0;}
			//Comment
			if($dat == $data[2]['category'][$commentIndex]){
				$comment = $data[2]['dat'][$commentIndex];
				$commentIndex++;
			}else{$comment=0;}
			$tempShare = $ptat - ($like+$comment);
			if($tempShare<0) $tempShare = 0;
			$share[] = $tempShare;
			
		}
		$volume = array(
					"category" => $data[$param]['category'],
					"dat" => $share,
					"name" => "Shares"
					);
		
		
		return $volume;
	}
	
	function facebook_page_reach($start, $end){
		$this->open(0);
		$c= "SELECT c.day AS tgl, c.value AS organic, k.value AS paid, b.value AS viral  
			FROM fb_page_impressions_organic_unique_day c
			LEFT JOIN fb_page_impressions_paid_unique_day k
			ON k.proID = c.proID AND k.day = c.day
			LEFT JOIN fb_page_impressions_viral_unique_day b
			ON b.proID = c.proID AND b.day = c.day
			WHERE c.day >= '".$start."' AND c.day <= '".$end."'
			GROUP BY tgl
			ASC";
		$data = $this->fetch($c,1);
		$this->close();
		
		$datesum = strtotime($end) - strtotime($start);
		$datesum = floor($datesum/(60*60*24));
		$s=0;
		$tempOrganic=array();
		$tempPaid=array();
		$tempViral=array();
		$tempTGL=array();
		for($i=0;$i<=$datesum;$i++){
			$data[$i]['tgl'] = date ( 'Y-m-d' , strtotime($data[$i]['tgl']));
			
			if($data[$i]['tgl'] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start))) || $tempTGL[0] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start)))){
				if(sizeof($tempTGL)>0){
					$category[] = $tempTGL[0];
					$organic[] = intval($tempOrganic[0]);
					$paid[] = intval($tempPaid[0]);
					$viral[] = intval($tempViral[0]);
					array_shift($tempTGL);
					array_shift($tempOrganic);
					array_shift($tempPaid);
					array_shift($tempViral);
					$i--;
					$datesum--;
				}else{
					$category[] = $data[$i]['tgl'];
					$organic[] = intval($data[$i]['organic']);
					$paid[] = intval($data[$i]['paid']);
					$viral[] = intval($data[$i]['viral']);
				}
			}else{
				$tempTGL[] = $data[$i]['tgl'];
				$tempOrganic[]= intval($data[$i]['organic']);
				$tempPaid[]= intval($data[$i]['paid']);
				$tempViral[]= intval($data[$i]['viral']);
				$datehack = strtotime( '+'.$s.' day' ,strtotime($start));
				$category[] = date ( 'Y-m-d' , $datehack);
				$organic[] = 0;
				$paid[] = 0;
				$viral[] = 0;
			}
			$s++;
		}
		
		$reachPart = array(
					"category" => $category,
					"organic" => $organic,
					"paid" => $paid,
					"viral" => $viral
					);
		return $reachPart;
	}
	
	function gplus_summary(){
		$this->open(0);
		$sql = "SELECT SUM(share) AS total_share, SUM(comment) AS total_comment, SUM(plusone) AS total_plus
				FROM tbl_gplus_daily WHERE n_status = 1 LIMIT 1";
		$q="SELECT a.circle, a.updateDate
			FROM tbl_gplus_circle a
			WHERE 1";
		$r=$this->fetch($q);
		$rs = $this->fetch($sql);
		$this->close();	
		$rs['circle'] = $r['circle'];
		return $rs;
	}
	
	function gplus_date(){
		$this->open(0);
		$sql = "SELECT MAX(date) as lastUpdate, MIN(date) as startDate
				FROM tbl_gplus_daily 
				WHERE 1 LIMIT 1";
		$rs = $this->fetch($sql);
		$this->close();
		return $rs;
	}
	
	function gplus_daily($start, $end){
		$this->open(0);
			$q= "SELECT share, comment, plusone, date
					FROM tbl_gplus_daily 
					WHERE date >= '".$start."' AND date <= '".$end."' AND n_status = 1
					ORDER BY date ASC";
					
			$circleSQL = "SELECT circle, updateDate
						FROM tbl_gplus_circle
						WHERE updateDate >= '".$start."'
						ORDER BY updateDate ASC";
			$postSQL = "SELECT COUNT(id) AS post, DATE_FORMAT(published_date_time, '%Y-%m-%d') AS perdate
						FROM tbl_gplus_feed
						WHERE DATE_FORMAT(published_date_time, '%Y-%m-%d') >= '".$start."'
						GROUP BY perdate
						ORDER BY perdate ASC";
			$data= $this->fetch($q,1);
			$circleData = $this->fetch($circleSQL,1);
			$postData = $this->fetch($postSQL,1);
	
		$this->close();
		
		$j=0;$k=0;
		$datesum = strtotime($end) - strtotime($start);
		$datesum = floor($datesum/(60*60*24));
		$open=0;
		$s=0;
		$tempDataShare=array();
		$tempDataComment=array();
		$tempDataPlus=array();
		$tempCircleData=array();
		$tempPostData=array();
		$tempTGL=array();
		for($i=0;$i<=$datesum;$i++){
			$data[$i]["date"] = date ( 'Y-m-d' , strtotime($data[$i]["date"]));
			
			if($data[$i]["date"] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start))) || $tempTGL[0] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start)))){
				if(sizeof($tempTGL)>0){				
					$category[] = $tempTGL[0];
					$share[] = intval($tempDataShare[0]);
					$comment[] = intval($tempDataComment[0]);
					$plusone[] = intval($tempDataPlus[0]);
					$circle[] = intval($tempCircleData[0]);				
					$post[] = intval($tempPostData[0]);
					
					array_shift($tempTGL);
					array_shift($tempDataShare);
					array_shift($tempDataComment);
					array_shift($tempDataPlus);
					array_shift($tempCircleData);
					array_shift($tempPostData);
					$k--;
					$j--;
					$i--;
					$datesum--;
				}
				else
				{
					if($k==0){
						$temp = 0;
					}else{
						$temp = intval($circleData[$k-1]['circle']);
					}
					
					$category[] = $data[$i]["date"];
					$share[] = intval($data[$i]["share"]);
					$comment[] = intval($data[$i]["comment"]);
					$plusone[] = intval($data[$i]["plusone"]);
					
					if($circleData[$k]['updateDate'] == $data[$i]['date']){
						$circle[] = intval($circleData[$k]['circle']) - $temp;
						$k++;
					}else{
						$circle[] = 0;
					}
					
					if($postData[$j]['perdate'] == $data[$i]['date']){
						$post[] = intval($postData[$j]['post']);
						$j++;
					}else{
						$post[] = 0;
					}
				}
			}
			else
			{
				if($i==0){
					$temp = 0;
				}else{
					$temp = intval($circleData[$k-1]['circle']);
				}
				
				$tempTGL[] = $data[$i]['date'];
				$tempDataShare[] = intval($data[$i]["share"]);
				$tempDataComment[] = intval($data[$i]["comment"]);
				$tempDataPlus[] = intval($data[$i]["plusone"]);
				
				if($circleData[$k]['updateDate'] == $data[$i]['date']){
					$tempCircleData[] = intval($circleData[$k]['circle']) - $temp;
				}else{
					$tempCircleData[] = 0;
				}
				
				if($postData[$j]['perdate'] == $data[$i]['date']){
					$tempPostData[] = intval($postData[$j]['post']);
				}else{
					$tempPostData[] = 0;
				}
			
				
				$datehack = strtotime( '+'.$s.' day' ,strtotime($start));
				$category[] = date ( 'Y-m-d' , $datehack);
				$share[] = 0;
				$comment[] = 0;
				$plusone[] = 0;
				$post[] = 0;
				$circle[] = 0;
			}
			$s++;
		}
		
		// $i=0;
		// $j=0;
		// foreach ($data as $cat){
			// if($i==0){
				// $temp = 0;
			// }else{
				// $temp = intval($circleData[$i-1]['circle']);
			// }
			
			// $category[] = $cat["date"];
			// $share[] = intval($cat["share"]);
			// $comment[] = intval($cat["comment"]);
			// $plusone[] = intval($cat["plusone"]);
			
			// if($circleData[$i]['updateDate'] == $cat['date']){
				// $circle[] = intval($circleData[$i]['circle']) - $temp;
				// $i++;
			// }else{
				// $circle[] = 0;
			// }
			
			// if($postData[$j]['perdate'] == $cat['date']){
				// $post[] = intval($postData[$j]['post']);
				// $j++;
			// }else{
				// $post[] = 0;
			// }
		// }
		$volume = array(
					"category" => $category,
					"share" => $share,
					"comment" => $comment,
					"plusone" => $plusone,
					"circle" => $circle,
					"post" => $post
					);
		
		return $volume;
	}
	
	function gplus_post(){
		$this->open(0);
		$q="SELECT a.num, b.title, b.url
			FROM tbl_gplus_top_post a
			LEFT JOIN tbl_gplus_feed b 
			ON a.gplus_feeds_id = b.id
			WHERE a.n_status = 1
			ORDER BY a.num DESC";
		$data = $this->fetch($q,1);
		$this->close();
		return $data;
	}
	
	function twitter_date(){
		$this->open(0);
		$sql = "SELECT MAX(post_date) as lastUpdate, MIN(post_date) as startDate
				FROM tbl_twitter_daily_stats 
				WHERE 1 LIMIT 1";
		$rs = $this->fetch($sql);
		$this->close();
		return $rs;
	}
	
	function twitter_id(){
		$this->open(0);
		$sql = "SELECT twitter_id
				FROM tbl_twitter_feeds_job
				WHERE 1";
		$rs = $this->fetch($sql, 1);
		$this->close();
		// print_r('<pre>');
		// var_dump($rs);exit;
		return $rs;
	}
	
	function twitter_daily($start, $end, $twitterID){
		$this->open(0);
		$q="SELECT post_date, mentions, rt, impressions, rt_impressions
			FROM tbl_twitter_daily_stats
			WHERE author_id = '".$twitterID."'
			AND post_date >= '".$start."' AND post_date <= '".$end."'
			ORDER BY post_date ASC";
		$data = $this->fetch($q,1);
		$this->close();
		
		$datesum = strtotime($end) - strtotime($start);
		$datesum = floor($datesum/(60*60*24));
		$open=0;
		$s=0;
		$tempMentions=array();
		$tempImpress=array();
		$tempRTI=array();
		$tempRT=array();
		$tempTGL=array();
		for($i=0;$i<=$datesum;$i++){
			$data[$i]["post_date"] = date ( 'Y-m-d' , strtotime($data[$i]["post_date"]));
			
			if($data[$i]["post_date"] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start))) || $tempTGL[0] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start)))){
				if(sizeof($tempTGL)>0){
					$category[] = $tempTGL[0];
					$mention[] = intval($tempMentions[0]);
					$people[] = intval($tempImpress[0]);
					$rt_impression[] = intval($tempRTI[0]);
					$rt[] = intval($tempRT[0]);
					array_shift($tempTGL);
					array_shift($tempMentions);
					array_shift($tempImpress);
					array_shift($tempRTI);
					array_shift($tempTGL);
					$i--;
					$datesum--;
				}else{
					$category[] = $data[$i]["post_date"];
					$mention[] = intval($data[$i]['mentions']);
					$people[] = intval($data[$i]['impressions']);
					$rt_impression[] = intval($data[$i]['rt_impressions']);
					$rt[] = intval($data[$i]['rt']);
				}
			}else{
				$tempTGL[] = $data[$i]["post_date"];
				$tempMentions[]= intval($data[$i]['mentions']);
				$tempImpress[]= intval($data[$i]['impressions']);
				$tempRTI[] = intval($data[$i]['rt_impressions']);
				$tempTGL[]= intval($data[$i]['rt']);
				$datehack = strtotime( '+'.$s.' day' ,strtotime($start));
				$category[] = date ( 'Y-m-d' , $datehack);
				$mention[] = 0;
				$people[] = 0;
				$rt_impression[] = 0;
				$rt[] = 0;
			}
			$s++;
		}
		$volPart = array(
					"category" => $category,
					"mentions" => $mention,
					"impressions" => $people,
					"rt_impression" => $rt_impression,
					"rts" => $rt
					);

		return $volPart;
	}
	
	function twitter_conversation($twitterID){
		$this->open(0);
		$q="SELECT author_id, content, impression
			FROM tbl_twitter_author_feeds
			WHERE author_id = '".$twitterID."'
			ORDER BY impression DESC LIMIT 10";
		$data=$this->fetch($q,1);
		$this->close();
		return $data;
	}
	
	function gplus_wordcloud(){
		$this->open(0);
		$c = "SELECT a.keyword, SUM(a.total) AS total
				FROM tbl_gplus_wordcloud a
				WHERE 1
				GROUP BY a.keyword
				ORDER BY a.total
				DESC LIMIT 50";
		$f = $this->fetch($c,1);
		$this->close();
		return $f;
	}
	
	function fb_wordcloud(){
		$this->open(0);
		$c = "SELECT a.keyword, SUM(a.total) AS total
				FROM tbl_fb_wordcloud a
				WHERE 1
				GROUP BY a.keyword
				ORDER BY a.total
				DESC LIMIT 50";
		$f = $this->fetch($c,1);
		$this->close();
		return $f;
	}
	
	function youtube_wordcloud(){
		$this->open(0);
		$c = "SELECT a.keyword, SUM(a.total) AS total
				FROM tbl_youtube_wordcloud a
				WHERE 1
				GROUP BY a.keyword
				ORDER BY a.total
				DESC LIMIT 50";
		$f = $this->fetch($c,1);
		$this->close();
		return $f;
	}
	
	function twitter_sentiment($start, $end, $twitterID){
		$this->open(0);
		//jumlah netral
		$n = "SELECT COUNT(sentiment) AS total FROM tbl_twitter_daily_stats 
			WHERE author_id='". $twitterID."' 
			AND sentiment = 0";
		$netral = $this->fetch($n);

		// jumlah positif
		$plus = "SELECT COUNT(sentiment) AS total FROM axis_report_2012.tbl_twitter_daily_stats 
			WHERE author_id='". $twitterID."' 
			AND sentiment > 0";
		$positif = $this->fetch($plus);
		// jumlah negatif
		$min = "SELECT COUNT(sentiment) AS total FROM axis_report_2012.tbl_twitter_daily_stats 
				WHERE author_id='". $twitterID."' 
				AND sentiment < 0";
		$negatif = $this->fetch($min);		
		$this->close();
		 
		$sentiment = array(
				"positive" => intval($plus['total']),
				"negatif" => intval($negatif['total']),
				"neutral" => intval($netral['total'])
		);
		return $sentiment;
	}
	
	function twitter_uniquePeople($start, $end, $twitterID){
		$this->open(0);
		$sql= "SELECT SUM(total) AS unik FROM tbl_twitter_unique_rt_people WHERE twitter_id='". $twitterID."' LIMIT 1";
				// AND dtreport BETWEEN '".$start."' AND '". $end."' LIMIT 1";
		
		$r = $this->fetch($sql);
		$this->close();
		return $r;
	}
	
	function twitter_summary($start, $end, $twitterID){
		$this->open(0);
		$c = "SELECT SUM(mentions) AS mention, SUM(impressions) AS impressions, SUM(rt_impressions) AS rt_impressions, SUM(rt) AS rt
				FROM tbl_twitter_daily_stats
				WHERE author_id='". $twitterID."' LIMIT 1";
				//post_date BETWEEN '".$start."' AND '". $end."' LIMIT 1";
		$f = $this->fetch($c);
		$this->close();
		return $f;
	}
	
	function project_date($id){
		$this->open(0);
		$sql="SELECT start_date
				FROM tbl_project
				WHERE id=".$id."";
		$rs = $this->fetch($sql);
		$this->close();
		return $rs['start_date'];
	}
	
	function dataHack($title, $dateName, $valueName, $start, $end, $data){
		$datesum = strtotime($end) - strtotime($start);
		$datesum = floor($datesum/(60*60*24));
		$open=0;
		$s=0;
		$tempData=array();
		$tempTGL=array();
		for($i=0;$i<=$datesum;$i++){
			$data[$i][$dateName] = date ( 'Y-m-d' , strtotime($data[$i][$dateName]));
			
			if($data[$i][$dateName] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start))) || $tempTGL[0] == date ( 'Y-m-d' , strtotime( '+'.$s.' day' ,strtotime($start)))){
				if(sizeof($tempTGL)>0){
					$category[] = $tempTGL[0];
					$datas[] = intval($tempData[0]);
					array_shift($tempTGL);
					array_shift($tempData);
					$i--;
					$datesum--;
				}else{
					$category[] = $data[$i][$dateName];
					$datas[] = intval($data[$i][$valueName]);
				}
			}else{
				$tempTGL[] = $data[$i][$dateName];
				$tempData[] = $data[$i][$valueName];
				$datehack = strtotime( '+'.$s.' day' ,strtotime($start));
				$category[] = date ( 'Y-m-d' , $datehack);
				$datas[] = 0;
			}
			$s++;
		}
		
		$volume = array(
					"category" => $category,
					"dat" => $datas,
					"name" => $title
					);
		return $volume;
	}
}