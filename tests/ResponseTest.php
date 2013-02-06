<?php

class ResponseTest extends PHPUnit_Framework_TestCase
{
	public $response;

	public function setUp()
	{
		$this->response = new \Cog\Response;
	}

	public function testBody()
	{
		$text = "Hello World";
		$this->response->setBody($text);
		$this->assertSame($text, $this->response->getBody());
	}

	public function testWriteAppends()
	{
		$text = array(
			'Hello World',
			'Yes indeed!'
		);

		$this->response->appendBody($text[0]);
		$this->response->appendBody($text[1]);
		$this->assertSame(join($text), $this->response->getBody());
	}

	public function testStatusDefault()
	{
		$this->assertSame(200, $this->response->getStatus());
	}

	public function testSetStatus()
	{
		$status = 404;
		$this->response->setStatus($status);
		$this->assertSame($status, $this->response->getStatus());
	}

	public function testBodyUpdatesContentLength()
	{
		$text = "Hello World";
		$this->response->setBody($text);
		$this->assertSame(11, $this->response->getContentLength());
	}

	public function testContentType()
	{
		$this->assertSame(null, $this->response->getContentType());
	}

	public function testSetContentType()
	{
		$type = 'application/json';
		$this->response->setContentType($type);
		$this->assertSame($type, $this->response->getContentType());
	}

	public function testSetLocation()
	{
		$location = "http://localhost";
		$this->response->setLocation($location);
		$this->assertSame($location, $this->response->getHeader('Location'));
	}

	public function testResponseChaining()
	{
		$data = json_encode(array('success' => true));
		$this->response->setBody($data)->getContentType('application/json');

		$this->assertSame($data, $this->response->getBody());
	}

	public function testHeader()
	{
		$type = "application/json";
		$this->response->setContentType($type);
		$this->assertSame($type, $this->response->getHeader('Content-Type'));
	}

	public function testHeaderArrayAccess()
	{
		$server = "Apache";
		$this->response['Server'] = $server;
		$this->assertSame($server, $this->response['Server']);
	}

}
