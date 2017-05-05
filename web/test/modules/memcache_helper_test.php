<?php
global $APP_PATH;
require_once $APP_PATH . APPLICATION . '/helper/memcache_helper.php';
class memcache_helper_test extends PHPUnit_Framework_TestCase{
	var $cache;
	public function setUp(){
		$this->cache = new memcache_helper();
	}	
	public function test_connect(){
		$this->assertTrue($this->cache->connect());
	}
	
	public function test_empty_get(){
		$this->cache->connect();
		$name = "myKey2";
		$foo = $this->cache->get($name);
		
		$this->assertEmpty(($foo));
	}
	public function test_set_no_timeout(){
		$name = "myKey";
		$value = "foobar";
		$this->cache->connect();
		$r = $this->cache->set($name,$value);
		$this->assertTrue($r);
	}
	public function test_get(){
		$name = "myKey";
		$this->cache->connect();
		$r = $this->cache->get($name);
		$this->assertEquals('foobar',$r);
	}
	public function test_timeout(){
		$name = "myKey3";
		$value = "foobar";
		$this->cache->connect();
		$r = $this->cache->set($name,$value,10);
		$this->assertTrue($r);
		print "set".PHP_EOL;
		sleep(5);
		$this->assertEquals('foobar',$this->cache->get($name));
		print "get-->{$this->cache->get($name)}".PHP_EOL;
		sleep(5);
		$this->assertEmpty($this->cache->get($name));
		print "get-->{$this->cache->get($name)}".PHP_EOL;
		sleep(3);
		$this->assertEmpty($this->cache->get($name));
		print "get-->{$this->cache->get($name)}".PHP_EOL;
	}
}
?>