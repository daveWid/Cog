<?php

include_once 'classes/MockServer.php';

class RequestTest extends PHPUnit_Framework_TestCase
{
	public $request;

	public function setUp()
	{
		$this->request = new \Cog\Request(MockServer::get());
	}

	public function testMediaType()
	{
		$this->assertSame(array(
				'text/html',
				'application/xhtml+xml',
				'application/xml'
			),
			$this->request->mediaType()
		);
	}

	public function testMediaTypeParams()
	{
		$this->assertSame(
			array(
				'q' => array('0.9,*/*', '0.8'),
				'charset' => 'utf-8'
			),
			$this->request->mediaTypeParams()
		);
	}

	public function testCharset()
	{
		$this->assertSame('utf-8', $this->request->charset());
	}

	public function testCookies()
	{
		$this->assertSame(
			array(
				'testing' => 'true',
				'foo' => 'bar'
			),
			$this->request->cookies()
		);
	}

	public function testBaseUrl()
	{
		$this->assertSame('http://localhost', $this->request->baseUrl());
	}

	public function testBaseUrlWithPort()
	{
		$request = new \Cog\Request(MockServer::port());
		$this->assertSame('http://localhost:81', $request->baseUrl());
	}

	/**
	 * %5B is [ and %5D is ]
	 *
	 * I couldn't find a php native function that would encode so I had to
	 * hand encode it for this test.
	 */
	public function testUrl()
	{
		$request = new \Cog\Request(MockServer::getWithQuery());
		$expected = 'http://localhost/index.php?foo=bar&languages%5B0%5D=php&languages%5B1%5D=ruby';
		$this->assertSame($expected, $request->url());
	}

	public function testPath()
	{
		$this->assertSame('/index.php', $this->request->path());
	}

	public function testFullPath()
	{
		$request = new \Cog\Request(MockServer::getWithQuery());
		$this->assertSame(
			"/index.php?foo=bar&languages%5B0%5D=php&languages%5B1%5D=ruby",
			$request->fullPath()
		);
	}

	public function testAcceptEncoding()
	{
		$this->assertSame(array('gzip', 'deflate'), $this->request->acceptEncoding());
	}

	public function testNoXHR()
	{
		$this->assertFalse($this->request->isXHR());
	}

	public function testXHR()
	{
		$request = new \Cog\Request(MockServer::xhr());
		$this->assertTrue($request->isXHR());
	}

	public function testNoSSL()
	{
		$this->assertFalse($this->request->isSSL());
	}

	public function testSSL()
	{
		$request = new \Cog\Request(MockServer::secure());
		$this->assertTrue($request->isSSL());
	}

	public function testGetParams()
	{
		$request = new \Cog\Request(MockServer::getWithQuery());
		$this->assertSame(
			array(
				'foo' => 'bar',
				'languages' => array('php',	'ruby')
			),
			$request->query()
		);
	}

	public function testGetRequest()
	{
		$this->assertTrue($this->request->isGet());
		$this->assertFalse($this->request->isPost());
		$this->assertFalse($this->request->isPut());
		$this->assertFalse($this->request->isDelete());
	}

	public function testRawPostData()
	{
		$request = new \Cog\Request(MockServer::post());
		$this->assertSame(
			"foo=bar&languages%5B0%5D=php&languages%5B1%5D=ruby",
			$request->body()
		);
	}

	public function testGetPostData()
	{
		$request = new \Cog\Request(MockServer::post());
		$this->assertSame(
			array(
				'foo' => 'bar',
				'languages' => array('php', 'ruby')
			),
			$request->post()
		);
	}

}
