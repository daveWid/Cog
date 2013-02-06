<?php

class MockRequest
{
	public static function defaultRequest()
	{
		return array(
			'headers' => array(
				'HTTP_HOST' => 'localhost',
				'HTTP_USER_AGENT' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0',
				'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8;charset=utf-8',
				'HTTP_ACCEPT_LANGUAGE' => 'en-US,en;q=0.5',
				'HTTP_ACCEPT_ENCODING' => 'gzip, deflate',
				'HTTP_COOKIE' => 'testing=true; foo=bar',
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
				'REQUEST_TIME' => time()
			),
			'cookies' => array(
				'testing' => 'true',
				'foo' => 'bar'
			)
		);
	}

	/**
	 * @return \Cog\Request A "mock" get request.
	 */
	public static function get()
	{
		return new \Cog\Request(self::defaultRequest());
	}

	/**
	 * @return \Cog\Request  A "mock" get request.
	 */
	public static function port()
	{
		$data = self::defaultRequest();
		$data['headers']['SERVER_PORT'] = 81;
		return new \Cog\Request($data);
	}

	/**
	 * @return \Cog\Request
	 */
	public static function getWithQuery()
	{
		$data = self::defaultRequest();
		$data['query'] = array(
			'foo' => 'bar',
			'languages' => array('php', 'ruby')
		);

		return new \Cog\Request($data);
	}

	/**
	 * @return \Cog\Request
	 */
	public static function secure()
	{
		$data = self::defaultRequest();
		$data['headers']['HTTPS'] = "on";

		return new \Cog\Request($data);
	}

	/**
	 * @return \Cog\Request
	 */
	public static function xhr()
	{
		$data = self::defaultRequest();
		$data['headers']['HTTP_X_REQUESTED_WITH'] = "XMLHttpRequest";

		return new \Cog\Request($data);
	}

	/**
	 * @return \Cog\Request
	 */
	public static function post()
	{
		$data = self::defaultRequest();
		$data['headers']['REQUEST_METHOD'] = "POST";

		$post = array(
			'foo' => 'bar',
			'languages' => array('php', 'ruby')
		);

		$data['post'] = $post;
		$data['body'] = http_build_query($post);

		return new \Cog\Request($data);
	}

}
