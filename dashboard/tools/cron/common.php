<?php
function extract_url($str){
	$pattern = "((https?|ftp|gopher|telnet|file):((//)|(\\\\))+[\\w\\d:#@%/;$()~_?\\+-=\\\\\\.&]*)";
	$str = preg_replace($pattern,"",$str);
	return $str;
}
/**
 * strip non characters from romanic characters
 * @param $str
 * @return unknown_type
 */
function strip_non_chars($str){
	$pattern = "([\~\!\#|$\%\^\&\*\(\)\?\.\,\=\:\;\"\'\*\\\/\[\]\-\_\r\n]+)";
	$str = preg_replace($pattern," ",$str);
	return $str;
}
/**
 * extract words from romanic charactres
 * @param $str
 * @return unknown_type
 */
function extract_words($str){
	$str = str_replace("RT"," ",$str);
	$str = strtolower($str);
	$str = extract_url($str);
	$str = strip_non_chars($str);
	$arr = explode(" ",$str);
	$s = "";
	$n=0;
	foreach($arr as $a){
		$a = trim($a);
		if(strlen($a)>0){
			if($n==1){
				$s.=",";
			}
			$s.=$a;
			$n=1;
		}
	}
	
	return $s;
}
?>