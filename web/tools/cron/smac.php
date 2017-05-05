<?php
/**
 * a helper class to access SMAC API 
 */
include_once "curl_class.php";
class smac{
	protected $api_key;
	protected $secret;
	protected $curlclass;
	protected $access_token;
	function __construct($api_key,$secret){
		global $SMAC;
		$this->api_key = $api_key;
		$this->secret = $secret;
		$this->config = $SMAC;
		$this->curlclass = new curl_class();	
	}
	public function getApiKey(){
		return $this->api_key;
	}
	public function getSecretKey(){
		return $this->secret;
	}
	public function authenticate(){
		$url = $this->config['callback']."?method=authenticate&api_key={$this->api_key}&request_token={$this->secret}";
		$response = json_decode($this->api_call($url),true);
		if($response['status']==1){
			$this->access_token = $response['data']['access_token'];
			return $response['data']['access_token'];
		}
	}
	public function api_call($url){
		return $this->curlclass->get($url);
	}
	public function api($param){
		if($this->access_token){
			$param['access_token'] = $this->access_token;
			$strQuery = http_build_query($param);
			$url = $this->config['callback']."?".$strQuery;
			print $url.PHP_EOL;
			$response = json_decode($this->curlclass->get($url),true);
			return $response;
		}
	}
}
?>
