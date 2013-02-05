<?php

class EnvironmentTest extends PHPUnit_Framework_Testcase
{
	public $server;
	public $environment;

	public function setUp()
	{
		$this->server = array(
			'HTTP_HOST' => 'localhost',
			'HTTP_USER_AGENT' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0',
			'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'HTTP_ACCEPT_LANGUAGE' => 'en-US,en;q=0.5',
			'HTTP_ACCEPT_ENCODING' => 'gzip, deflate',
			'HTTP_COOKIE' => 'testing=true;foo=bar',
			'HTTP_CONNECTION' => 'keep-alive',
			'HTTP_CACHE_CONTROL' => 'max-age=0',
			'PATH' => '/usr/local/bin:/usr/bin:/bin',
			'SERVER_SIGNATURE' => '<address>Apache/2.2.22 (Ubuntu) Server</address>',
			'SERVER_SOFTWARE' => 'Apache/2.2.22 (Ubuntu)',
			'SERVER_NAME' => 'localhost',
			'SERVER_ADDR' => '10.0.2.15',
			'SERVER_PORT' => '80',
			'REMOTE_ADDR' => '10.0.2.2',
			'DOCUMENT_ROOT' => '/var/www/html',
			'SERVER_ADMIN' => '[no address given]',
			'SCRIPT_FILENAME' => '/var/www/html/index.php',
			'REMOTE_PORT' => '50299',
			'GATEWAY_INTERFACE' => 'CGI/1.1',
			'SERVER_PROTOCOL' => 'HTTP/1.1',
			'REQUEST_METHOD' => 'GET',
			'QUERY_STRING' => '',
			'REQUEST_URI' => '/',
			'SCRIPT_NAME' => '/index.php',
			'PHP_SELF' => '/index.php',
			'REQUEST_TIME' => 1360074562
		);

		$this->environment = new \Cog\Environment($this->server);
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

	public function testInputStream()
	{
		$this->assertInternalType('string', $this->environment['cog.input']);
	}

	public function testErrorStream()
	{
		$this->assertInternalType('resource', $this->environment['cog.errors']);
	}

}
