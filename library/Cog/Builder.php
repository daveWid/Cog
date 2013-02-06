<?php

namespace Cog;

/**
 * Build the application stack with middleware.
 *
 * @package  Cog
 */
class Builder
{
	/**
	 * @var array  The middleware stack
	 */
	private $middleware;

	/**
	 * @var \Cog\Request  The request environment
	 */
	private $request;

	/**
	 * @var \Cog\Response  The response object to write to the server
	 */
	private $response;

	/**
	 * @var array  Any builder options
	 */
	private $options;

	/**
	 * @param array $environment Environment variables
	 * @param array $options     Builder options
	 */
	public function __construct($environment, $options = array())
	{
		$this->request = new \Cog\Request($environment);
		$this->options = $options;
	}

	/**
	 * Adds some middleware to the stack.
	 *
	 * @param  string $middleware The name of the middleware to use
	 * @return \Cog\Builder
	 */
	public function using($middleware)
	{
		$this->middleware[] = $middleware;
		return $this;
	}

	/**
	 * Run the stack and grab the output.
	 *
	 * @param  mixed $app  The application to run
	 * @return array       [(int) status, (array) headers, (array) body]
	 */
	public function run($app)
	{
		$current = $app;

		if ( ! empty($this->middleware))
		{
			foreach (array_reverse($this->middleware) as $part)
			{
				$current = new $part($current);
			}
		}

		$this->response = $current->call($this->request, new \Cog\Response);
		return $this->response;
	}

}
