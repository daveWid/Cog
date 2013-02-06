<?php

include_once 'classes/MockRequest.php';

class RequestTest extends PHPUnit_Framework_TestCase
{
	public $request;

	public function setUp()
	{
		$this->request = MockRequest::get();
	}

	public function testMediaType()
	{
		$expected = array(
			'text/html',
			'application/xhtml+xml',
			'application/xml'
		);

		$this->assertSame($expected, $this->request->getMediaType());
	}

	public function testMediaTypeParams()
	{
		$this->assertSame(
			array(
				'q' => array('0.9,*/*', '0.8'),
				'charset' => 'utf-8'
			),
			$this->request->getMediaTypeParams()
		);
	}

	public function testCharset()
	{
		$this->assertSame('utf-8', $this->request->getCharset());
	}

	public function testCookies()
	{
		$this->assertSame(
			array(
				'testing' => 'true',
				'foo' => 'bar'
			),
			$this->request->getCookies()
		);
	}

	public function testBaseUrl()
	{
		$this->assertSame('http://localhost', $this->request->getBaseUrl());
	}

	public function testBaseUrlWithPort()
	{
		$request = MockRequest::port();
		$this->assertSame('http://localhost:81', $request->getBaseUrl());
	}

	/**
	 * %5B is [ and %5D is ]
	 *
	 * I couldn't find a php native function that would encode so I had to
	 * hand encode it for this test.
	 */
	public function testUrl()
	{
		$request = MockRequest::getWithQuery();
		$expected = 'http://localhost/index.php?foo=bar&languages%5B0%5D=php&languages%5B1%5D=ruby';
		$this->assertSame($expected, $request->getUrl());
	}

	public function testPath()
	{
		$this->assertSame('/index.php', $this->request->getPath());
	}

	public function testFullPath()
	{
		$request = MockRequest::getWithQuery();
		$this->assertSame(
			"/index.php?foo=bar&languages%5B0%5D=php&languages%5B1%5D=ruby",
			$request->getFullPath()
		);
	}

	public function testAcceptEncoding()
	{
		$this->assertSame(array('gzip', 'deflate'), $this->request->getAcceptEncoding());
	}

	public function testNoXHR()
	{
		$this->assertFalse($this->request->isXHR());
	}

	public function testXHR()
	{
		$request = MockRequest::xhr();
		$this->assertTrue($request->isXHR());
	}

	public function testNoSSL()
	{
		$this->assertFalse($this->request->isSSL());
	}

	public function testSSL()
	{
		$request = MockRequest::secure();
		$this->assertTrue($request->isSSL());
	}

	public function testQueryParams()
	{
		$request = MockRequest::getWithQuery();
		$this->assertSame(
			array(
				'foo' => 'bar',
				'languages' => array('php',	'ruby')
			),
			$request->getQuery()
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
		$request = MockRequest::post();
		$this->assertSame(
			"foo=bar&languages%5B0%5D=php&languages%5B1%5D=ruby",
			$request->getBody()
		);
	}

	public function testGetPostData()
	{
		$request = MockRequest::post();
		$this->assertSame(
			array(
				'foo' => 'bar',
				'languages' => array('php', 'ruby')
			),
			$request->getPost()
		);
	}

}
