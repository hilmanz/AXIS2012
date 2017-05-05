<?php
global $APP_PATH;
require_once $APP_PATH . APPLICATION . '/helper/contentHelper.php';
require_once $APP_PATH . APPLICATION . '/modules/contentModule.php';
class contentHelperTest extends PHPUnit_Framework_TestCase{		
	public function test_getPublicContent(){
		$app = new contentModule(null);
		$app->open(0);
		$obj = new contentHelper($app);
		$foo = $obj->getPublicContent();
		$app->close();
		
		$this->assertGreaterThan(-1,sizeof($foo));
		foreach($foo as $f){
			$this->assertArrayHasKey('id', $f);
			$this->assertArrayHasKey('category', $f);
			$this->assertArrayHasKey('content', $f);
			$this->assertArrayHasKey('brief', $f);
			$this->assertArrayHasKey('title', $f);
			$this->assertArrayHasKey('image', $f);
			$this->assertArrayHasKey('posted_date', $f);
			$this->assertArrayHasKey('categoryid',$f);
		}
		
	}
}
?>