<?php

include 'classes/App.php';
include 'classes/HelloWorld.php';

class BuilderTest extends PHPUnit_Framework_TestCase
{
	public $builder;

	public function setUp()
	{
		$this->builder = new \Cog\Builder(array());
	}

	public function testApp()
	{
		$response = $this->builder->run(new App);
		$this->assertSame("Hi", $response->body());
	}

	public function testMiddlewareInterception()
	{
		$app = new App;
		$response = $this->builder
			->using('HelloWorld')
			->run($app);

		$this->assertSame("Hello World", $response->body());
	}
}
