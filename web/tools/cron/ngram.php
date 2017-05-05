<?php
/**
 * ngram analysis class
 */
 class ngram{
 	private $depth;
	private $result;
	private $words;
	private $results;
 	public function __construct($n=1){
 		$this->depth = $n;	
		
 	}
	/**
	 * @param $str the text to be analyzed
	 */
	public function analyze($str){
		$this->words = extract_words($str);
		
		for($i=1;$i<$this->depth+1;$i++){
			
			$this->get_phrases($i);
		}
		
	}
	public function getResults(){
		$rs = array();
		while(sizeof($this->results)>0){
			$kw = array_pop($this->results);
			if(!array_key_exists($kw,$rs)){
				$rs[$kw] = 0;
			}
			$rs[$kw]+= 1;
		}
		return $rs;
	}
	private function get_phrases($n){
		if($n==1){
			foreach($this->words as $word){
				$this->results[] = $word;
			}
		}else{
			$size = sizeof($this->words);
			for($i=0;$i<$size-($n-1);$i++){
				$str = $this->words[$i];
				for($j=0;$j<($n-1);$j++){
					$str.=" ".$this->words[$i+$j+1];
				}
				$this->results[] = $str;
			}
		}
	}
 }
?>