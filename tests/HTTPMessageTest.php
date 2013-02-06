<?php

include_once 'classes/Message.php';

class HTTPMessageTest extends PHPUnit_Framework_TestCase
{
	public $message;

	public function setUp()
	{
		$this->message = new Message;
	}

	public function testBody()
	{
		$text = "Hello World";
		$this->message->setBody($text);
		$this->assertSame($text, $this->message->getBody());
	}

	public function testHeader()
	{
		$type = "application/json";
		$this->message->setHeader('Content-Type', $type);
		$this->assertSame($type, $this->message->getHeader('Content-Type'));
	}

	public function testProtocolDefault()
	{
		$this->assertSame('1.1', $this->message->getProtocol());
	}

	public function testSettingProtocol()
	{
		$this->message->setProtocol('1.0');
		$this->assertSame('1.0', $this->message->getProtocol());
	}

}