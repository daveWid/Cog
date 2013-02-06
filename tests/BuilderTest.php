<?php

include_once 'classes/App.php';
include_once 'classes/HelloWorld.php';

class BuilderTest extends PHPUnit_Framework_TestCase
{
	public $builder;

	public function setUp()
	{
		$this->builder = new \Cog\Builder();
	}

	public function testApp()
	{
		$response = $this->builder->run(new App);
		$this->assertSame("Hi", $response->getBody());
	}

	public function testMiddlewareInterception()
	{
		$app = new App;
		$response = $this->builder
			->using('HelloWorld')
			->run($app);

		$this->assertSame("Hello World", $response->getBody());
	}
}
