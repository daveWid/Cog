<?php

class ResponseTest extends PHPUnit_Framework_TestCase
{
	public $response;

	public function setUp()
	{
		$this->response = new \Cog\Response("Hi", 200);
	}

	public function testContentLengthIsSetAutomatically()
	{
		// Todo - Test this thing...
	}

}
