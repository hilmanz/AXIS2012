<?php
/**
 * 
 * API base class
 * @author duf , bummi
 *
 */
class API extends Application{
		
	function __construct(){
		parent::__construct();
		$this->isUserOnline();
	}
	
	function main(){
		global $CONFIG;
		if($this->is_authorized()){
			return $this->run();
		}else{
			return $this->toJson(401,'unauthorized access',null);
		}
	}
	function is_authorized(){
		return true;
	}
	function admin(){
		
	}
	function toJson($status,$msg,$data){
		return json_encode(array("status"=>$status,"message"=>$msg,"data"=>$data));
	}
	
	
}
?>