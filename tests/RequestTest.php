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
		$this->assertSame('text/html', $this->request->mediaType());
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

	/**
	 * %5B is [ and %5D is ]
	 *
	 * I couldn't find a php native function that would encode so I had to
	 * hand encode it for this test.
	 */
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
