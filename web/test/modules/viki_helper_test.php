<?php
global $APP_PATH;
require_once $APP_PATH . APPLICATION . '/helper/VikiHelper.php';
class viki_helper_test extends PHPUnit_Framework_TestCase{
	var $plus;
	
	public function setUp(){
		$this->api = new VikiHelper();
	}
	public function test_videos(){
		//$this->api->authenticate();
		//$this->assertNull($_SESSION['vicky_access_token']);
		$rs = $this->api->movies(1);
		$this->assertArrayHasKey('count', $rs);
		$this->videos = $rs;
		//unset($rs);
	}
	public function test_featured(){
		$rs = $this->api->featured(1);
		$this->assertArrayHasKey('count', $rs);
	}
	public function test_music_videos(){
		$rs = $this->api->music_videos(1);
		$this->assertArrayHasKey('count', $rs);
	}
}
?>