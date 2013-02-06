<?php

class ResponseTest extends PHPUnit_Framework_TestCase
{
	public $response;

	public function setUp()
	{
		$this->response = new \Cog\HTTP\Response;
	}

	public function testBody()
	{
		$text = "Hello World";
		$this->response->body($text);
		$this->assertSame($text, $this->response->body());
	}

	public function testWriteAppends()
	{
		$text = array(
			'Hello World',
			'Yes indeed!'
		);

		$this->response->write($text[0]);
		$this->response->write($text[1]);
		$this->assertSame(join($text), $this->response->body());
	}

	public function testStatusDefault()
	{
		$this->assertSame(200, $this->response->status());
	}

	public function testSetStatus()
	{
		$status = 404;
		$this->response->status($status);
		$this->assertSame($status, $this->response->status());
	}

	public function testBodyUpdatesContentLength()
	{
		$text = "Hello World";
		$this->response->body($text);
		$this->assertSame(11, $this->response->contentLength());
	}

	public function testContentType()
	{
		$this->assertSame(null, $this->response->contentType());
	}

	public function testSetContentType()
	{
		$type = 'application/json';
		$this->response->contentType($type);
		$this->assertSame($type, $this->response->contentType());
	}

	public function testLocation()
	{
		$this->assertSame(null, $this->response->location());
	}

	public function testSetLocation()
	{
		$location = "http://localhost";
		$this->response->location($location);
		$this->assertSame($location, $this->response->location());
	}

	public function testResponseChaining()
	{
		$data = json_encode(array('success' => true));
		$this->response->body($data)->contentType('application/json');

		$this->assertSame($data, $this->response->body());
	}

	public function testHeader()
	{
		$type = "application/json";
		$this->response->contentType($type);
		$this->assertSame($type, $this->response->header('Content-Type'));
	}

	public function testHeaderArrayAccess()
	{
		$server = "Apache";
		$this->response['Server'] = $server;
		$this->assertSame($server, $this->response['Server']);
	}

}
