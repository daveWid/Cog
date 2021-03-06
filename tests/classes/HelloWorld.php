<?php

class HelloWorld implements \Cog\Middleware
{
	private $next;

	public function __construct(\Cog\Middleware $app = null)
	{
		$this->next = $app;
	}

	public function call($request, $response)
	{
		$response = $this->next->call($request, $response);
		$response->setContent("Hello World");

		return $response;
	}

}