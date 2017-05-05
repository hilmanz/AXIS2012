<?php
		include "config.php";


		// STEP 1 fetch video id
		$qvid = "SELECT video_id FROM channel_video_list GROUP BY video_id";
		$sql = mysql_query($qvid);
		while($r = mysql_fetch_object($sql)){
			$arr_vid[] = $r;
		}
		// STEP 2 cek tgl
			
			foreach($arr_vid as $vid){
			$tgl2 = date('Y-m-d',strtotime('-4 days'));
			echo $tgl2.'|'.date('Y-m-d')."
			";
	
				echo $vid->video_id."
				";
				while ($tgl2 < date('Y-m-d',strtotime('-2 days'))){
				$vidid = $vid->video_id;
				$expl2 = explode('-',$tgl2);
				$tgl1 = date('Y-m-d', mktime(0, 0, 0,$expl2[1] , $expl2[2]+1, $expl2[0]));
				$id = $tgl1.$tgl2.$vidid;
				$cek = cekbotact($id);
				
				// JIKA BELUM DILAKUKAN
				if($cek==0){
						$stm = strtotime(date($tgl1.' 02:00:00'))*1000;
						$stm2 = strtotime(date($tgl2.' 02:00:00'))*1000;
						if(bot($id,$tgl1,$tgl2,$stm,$stm2,$vidid)==false){
							echo "Gagal parsing link 
							";
						}else{
						insertbotact($id);
						}
				}
				$expl = explode('-',$tgl2);
				$tgl2 = date('Y-m-d', mktime(0, 0, 0,$expl[1] , $expl[2]+1, $expl[0]));
				echo $tgl2.'|';
				}
				
				}
		 echo '
		 end of process | '.$tgl2;
		 exit;  
	
	
	function cekbotact($id){
		$q = "SELECT COUNT(id) total FROM bot_activity WHERE id='".$id."' LIMIT 1";
		$sql = mysql_query($q);
		$r = mysql_fetch_object($sql);
		return $r->total;
	}
	
	function insertbotact($id){
		$q = "INSERT IGNORE INTO bot_activity (tgl_act,id) VALUES (NOW(), '".$id."')";
		return mysql_query($q);
	}
	
	function bot($id,$tgl1,$tgl2,$stm,$stm2,$vidid){
		set_time_limit(0);
		require_once 'Zend/Loader.php';
		include_once 'ReadCSV.php';
		require_once 'curl_class.php';
		$curl = new curl_class();
		
		Zend_Loader::loadClass('Zend_Gdata_YouTube');
		Zend_Loader::loadClass('Zend_Gdata_AuthSub');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_App_Exception');
			
		$applicationId = "axisInsightVersion1";
		$clientId = "81290576560.apps.googleusercontent.com";
		$developerKey = "AI39si4WQsTGCeFtQrZo6jL1oTbOkToow8YQs-PiSvN_00HQCJZaG6ZI_U2GtmCTHc1RPgQR97ZtYNoiJilEgD4K6EwyZYMj2A";
		
		// Enter your Google account credentials
		$email = 'axisgsm2010@gmail.com';
		$passwd = 'komunikaS1';		
		$client = Zend_Gdata_ClientLogin::getHttpClient($email, $passwd,'youtube');
		// $client = Zend_Gdata_AuthSub::getHttpClient($apiKey);
		
		$yt = new Zend_Gdata_YouTube($client,
		$applicationId, null,
		$developerKey);
		
		$yt->setMajorProtocolVersion(2);
		$feeds = $yt->getVideoEntry($vidid);
		$links = $feeds->getLink();
		foreach($links as $key => $val){
			if($key==8) $insight = $val;
			else continue;
		}
		
		if(!$insight) return false;
		$ls = $insight->getHref();
		
		$name = $vidid.'_'.$tgl2.'_'.$tgl1;
		if($curl->copySecureFile($ls,"temp/".$name.".zip"))
			{
				echo "File transferred successfully. 
				";
				if(!is_dir('csv/'.$name)){
					mkdir('csv/'.$name);
				}
				
				$zip = new ZipArchive;
				 $res = $zip->open('temp/'.$name.'.zip');
				 if ($res === TRUE) {
					 $zip->extractTo('csv/'.$name.'/');
					 $zip->close();
					 @unlink('temp/'.$name.'.zip');
					 echo "unzipped 
					 ";
					 echo "-------------------------------------- 
					 ";
					
					 $globArr = glob('csv/'.$name."/*{_world_views_1}.csv",GLOB_BRACE);
					 $file_csv = $globArr[0];
					 $read = ReadCSV($file_csv);
					 $total = count($read);
					
					 $sukses = 0;
					 $gagal = 0;
					 foreach($read as $i => $r){
						if($i<1)continue;
						$q = "INSERT IGNORE INTO video_raw (date,region,videoID,title,views,unique_users,unique_users_7,unique_users_30,popularity,comments,favorites,rate1,rate2,rate3,rate4,rate5,subscriptions,unsubscriptions) 
								VALUES ('".$r[0]."', '".$r[1]."', '".$r[2]."', '".$r[3]."', '".$r[4]."', '".$r[5]."', '".$r[6]."', '".$r[7]."', '".$r[8]."', '".$r[9]."', '".$r[10]."', 
								'".$r[11]."', '".$r[12]."','".$r[13]."', '".$r[14]."', '".$r[15]."', '".$r[16]."', '".$r[17]."')";
								echo $q." 
								";
						if(mysql_query($q)){
							$sukses = $sukses+1;
						}else{
							$gagal = $gagal+1;
						}
						
					 }
					 
					 echo "  Sukses : ".$sukses." 
					 ";
					 echo "  Gagal : ".$gagal." 
					 ";
					 return true;
				 } else {
					 echo "unzip failed 
					 ";
					 return false;
					 
				 }
				
			}
			else
			{
				echo "File transfer failed. 
				";
				return false;
				
			}	
			return false;
			// exit;
	}
	mysql_close($con);
		// if($tgl2 >= date('Y-m-d'))echo "end process \n ";
?>