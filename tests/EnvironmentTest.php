<?php

include_once 'classes/MockServer.php';

class EnvironmentTest extends PHPUnit_Framework_Testcase
{
	public $environment;

	public function setUp()
	{
		$this->environment = MockServer::get();
	}

	public function testArrayAccess()
	{
		$this->assertSame('GET', $this->environment['REQUEST_METHOD']);
	}

	public function testCogVersion()
	{
		$this->assertInternalType('array', $this->environment['cog.version']);
		$this->assertCount(3, $this->environment['cog.version']);
	}

	public function testCogUrlScheme()
	{
		$this->assertSame('http', $this->environment['cog.url_scheme']);
	}

	public function testCogUrlSchemeSecure()
	{
		$environment = MockServer::secure();
		$this->assertSame('https', $environment['cog.url_scheme']);
	}

	public function testInputStream()
	{
		$this->assertInternalType('string', $this->environment['cog.input']);
	}

	public function testErrorStream()
	{
		$this->assertInternalType('resource', $this->environment['cog.errors']);
	}

}
