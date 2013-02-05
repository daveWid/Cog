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
	 * @var array  Get variables
	 */
	private $get;

	/**
	 * @var array  Post variables
	 */
	private $post;

	/**
	 * @var array  Request parameters (GET and POST)
	 */
	private $params;

	public function __construct($environment)
	{
		$this->environment = $environment;
		\parse_str($this->queryString(), $this->get);
		\parse_str($this->environment->param('cog.input'), $this->post);
	}

	/**
	 * @return array|ArrayAccess  The environment variables
	 */
	public function environment()
	{
		return $this->environment;
	}

	/**
	 * @return string
	 */
	public function body()
	{
		return $this->environment->param('cog.input', '');
	}

	/**
	 * @return string
	 */
	public function scriptName()
	{
		return $this->environment->param('SCRIPT_NAME', '');
	}

	/**
	 * @return string
	 */
	public function pathInfo()
	{
		return $this->environment->param('PATH_INFO', '');
	}

	/**
	 * @return string
	 */
	public function requestMethod()
	{
		return $this->environment->param('REQUEST_METHOD', '');
	}

	/**
	 * @return string
	 */
	public function queryString()
	{
		return $this->environment->param('QUERY_STRING', '');
	}

	/**
	 * @return int
	 */
	public function contentLength()
	{
		return $this->environment->param('SCRIPT_NAME', 0);
	}

	/**
	 * @return string
	 */
	public function contentType()
	{
		return $this->environment->param('HTTP_ACCEPT', '');
	}

	/**
	 * @return string
	 */
	public function mediaType()
	{
		list($type) = \explode(";", $this->contentType());
		return \current(\explode(',', $type));
	}

	/**
	 * @return array
	 */
	public function mediaTypeParams()
	{
		list($media) = \explode(':', $this->contentType());
		\array_shift($media);

		$params = array();
		foreach ($meda as $item)
		{
			list($key, $value) = \explode('=', $item);
			$params[$key] = $value;
		}

		return $params;
	}

	/**
	 * @return string|null
	 */
	public function charset()
	{
		$charset = $this->environment->param('HTTP_ACCEPT_CHARSET', null);

		if ($charset === null)
		{
			$params = $this->mediaTypeParams();
			if (\array_key_exists('charset', $params))
			{
				$charset = $params['charset'];
			}
		}

		return $charset;
	}

	/**
	 * @return string
	 */
	public function scheme()
	{
		return $this->environment->param('cog.scheme');
	}

	/**
	 * @return int
	 */
	public function port()
	{
		return (int) $this->environment->param('SERVER_POST', 80);
	}

	/**
	 * @return string
	 */
	public function host()
	{
		return $this->environment->param('HTTP_HOST', 'localhost');
	}

	/**
	 * @return string
	 */
	public function referrer()
	{
		return $this->environment->param('HTTP_REFERER', '');
	}

	/**
	 * @return string
	 */
	public function userAgent()
	{
		return $this->environment->param('HTTP_USER_AGENT', '');
	}

	/**
	 * @return array
	 */
	public function cookies()
	{
		$cookies = array();

		$cookie_string = $this->environment->param('HTTP_COOKIE', '');
		if ( ! empty($cookie_string))
		{
			foreach (\explode(';', $cookie_string) as $item)
			{
				list($key, $value) = \explode('=', $item);
				$cookies[$key] = \urldecode($value);
			}
		}

		return $cookies;
	}

	/**
	 * @return string
	 */
	public function baseUrl()
	{
		$url = $this->scheme().':'.$this->host();
		$port = $this->port();

		if ($port !== 80 || $port !== 443)
		{
			$url .= ':'.$port;
		}

		return $url;
	}

	/**
	 * @return string
	 */
	public function url()
	{
		return $this->baseUrl() . $this->fullPath();
	}

	/**
	 * @return string
	 */
	public function path()
	{
		return $this->scriptName() . $this->pathInfo();
	}

	/**
	 * @return string
	 */
	public function fullPath()
	{
		$path = $this->path();
		$query = $this->queryString();
		if ( ! empty($query))
		{
			$path .= "?".$query;
		}

		return $path;
	}

	/**
	 * @return string
	 */
	public function acceptEncoding()
	{
		$encoding = \explode(',', $this->environment->param('HTTP_ACCEPT_ENCODING', ''));
		return array_map('trim', $encoding);
	}

	/**
	 * @return boolean
	 */
	public function isXHR()
	{
		$header = $this->environment->param('HTTP_X_REQUESTED_WITH', false);
		return $header === "XMLHttpRequest";
	}

	/**
	 * @return boolean
	 */
	public function isSSL()
	{
		return $this->scheme === 'https';
	}

	/**
	 * @return boolean
	 */
	public function isDelete()
	{
		return $this->requestMethod() === "DELETE";
	}

	/**
	 * @return boolean
	 */
	public function isGet()
	{
		return $this->requestMethod() === "GET";
	}

	/**
	 * @return boolean
	 */
	public function isPost()
	{
		return $this->requestMethod() === "POST";
	}

	/**
	 * @return boolean
	 */
	public function isPut()
	{
		return $this->requestMethod() === "PUT";
	}

	/**
	 * Get post data. If the name isn't spcecified, then the full post
	 * array will be returned.
	 *
	 * @param  string $name    The param name
	 * @param  mixed  $default The default value (only if name is given)
	 * @return mixed
	 */
	public function post($name = null, $default = null)
	{
		if ($name !== null)
		{
			return $this->getArrayValue($this->post, $name, $default);
		}

		return $this->post;
	}

	public function query($name = null, $default = null)
	{
		if ($name !== null)
		{
			return $this->getArrayValue($this->get, $name, $default);
		}

		return $this->get;
	}

	/**
	 * Gets the value of the key in the given array, or default if not found.
	 *
	 * @param  array $array    The search array
	 * @param  string $key     The key to search for
	 * @param  mixed $default  The default value if the key isn't found
	 * @return mixed
	 */
	protected function getArrayValue(array $array, $key, $default = null)
	{
		if (\array_key_exists($key, $array))
		{
			$default = $array[$key];
		}

		return $default;
	}

}
