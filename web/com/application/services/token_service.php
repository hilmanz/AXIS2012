<?php	
class token_service {
	var $API;

	
	function __construct($API=null){
		$this->API = $API;
	
	}	

	
	function getAccessToken(){
		global $CONFIG;
		$secret_key = strip_tags($this->API->_g('secret_key'));
		$at = get_access_token($secret_key,$CONFIG['SERVICE_KEY']);
		return  $this->API->toJson(1,'access',$at);
	}
	
		
}
?>
