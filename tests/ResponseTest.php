<?php

class ResponseTest extends PHPUnit_Framework_TestCase
{
	public $response;

	public function setUp()
	{
		$this->response = new \Cog\Response("Hi", 200);
	}

	public function testAppendingContent()
	{
		$this->response->appendContent(", this is a request");
		$this->assertSame('Hi, this is a request', $this->response->getContent());
	}

}
