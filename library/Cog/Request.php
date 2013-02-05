<?php

namespace Cog;

/**
 * The HTTP Request
 *
 * @package  Cog
 */
class Request
{
	/**
	 * @var array|ArrayAccess  Environment variables
	 */
	private $environment;

	/**
	 * @var array  Request parameters (GET and POST)
	 */
	private $params;

	public function __construct($environment)
	{
		$this->environment = $environment;
	}

	/**
	 * @return array|ArrayAccess  The environment variables
	 */
	public function environment()
	{
		return $this->environment;
	}

	public function body(){}

	public function script_name(){}

	public function path_info(){}

	public function request_method(){}

	public function query_string(){}

	public function content_length(){}

	public function content_type(){}

	public function media_type(){}

	public function media_type_params(){}

	public function charset(){}

	public function scheme(){}

	public function port(){}

	public function referrer(){}

	public function user_agent(){}

	public function cookies(){}

	public function base_url(){}

	public function url(){}

	public function path(){}

	public function full_path(){}

	public function accept_encoding(){}

	public function is_xhr(){}

	public function is_ssl(){}

	public function is_delete(){}

	public function is_get(){}

	public function is_post(){}

	public function is_put(){}

	public function post($name = null, $default = null){}

	public function query($name = null, $default = null){}

	public function param($name, $default = null)
	{
		if (array_key_exists($name, $this->params))
		{
			$default = $this->params[$name];
		}

		return $default;
	}

	public function params()
	{
		return $this->params;
	}

}
