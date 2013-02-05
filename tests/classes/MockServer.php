<?php

class MockServer
{
	public static $request = array(
		'HTTP_HOST' => 'localhost',
		'HTTP_USER_AGENT' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0',
		'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8;charset=utf-8',
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
		'REQUEST_TIME' => 1360000000
	);

	/**
	 * @return \Cog\Environment  A "mock" get request.
	 */
	public static function get()
	{
		return new \Cog\Environment(self::$request);
	}

	/**
	 * A GET Request with query params.
	 *
	 * @return \Cog\Environment
	 */
	public static function getWithQuery()
	{
		$data = self::$request;
		$data['QUERY_STRING'] = http_build_query(array(
			'foo' => 'bar',
			'languages' => array('php', 'ruby')
		));

		return new \Cog\Environment($data);
	}

	/**
	 * @return \Cog\Environment
	 */
	public static function secure()
	{
		$data = self::$request;
		$data['HTTPS'] = "on";

		return new \Cog\Environment($data);
	}

	/**
	 * @return \Cog\Environment
	 */
	public static function post()
	{
		$data = self::$request;
		$data['REQUEST_METHOD'] = "POST";

		$server = new \Cog\Environment($data);

		/** Please don't do this in a real app, only for testing a post request... */
		$server['cog.input'] = http_build_query(array(
			'foo' => 'bar',
			'languages' => array('php', 'ruby')
		));

		return $server;
	}

}
