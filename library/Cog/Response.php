<?php

namespace Cog;

/**
 * The HTTP Response object
 *
 * @package Cog
 */
class Response implements \ArrayAccess
{
	/**
	 * @var int  The body length
	 */
	protected $length = 0;

	/**
	 * @var string  The response body
	 */
	private $body;

	/**
	 * @var int  Defaults to 200 (good response)
	 */
	private $status = 200;

	/**
	 * @var array   The response headers
	 */
	private $headers = array();

	/**
	 * @param  string $content  Body content. Overwrites the current content.
	 * @return string           The body content (get)
	 * @return \Cog\Response    $this (set)
	 */
	public function body($content = null)
	{
		if ($content === null)
		{
			return $this->body;
		}

		$this->body = "";
		$this->write($content);
		return $this;
	}

	/**
	 * @param  string $str Content to append to the body
	 */
	public function write($str)
	{
		$this->body .= $str;
		$this->length = \strlen($this->body);
	}

	/**
	 * @param  int $code      The status code (setting)
	 * @return int            The status code (get)
	 * @return \Cog\Response  $this (set)
	 */
	public function status($code = null)
	{
		if ($code === null)
		{
			return $this->status;
		}

		$this->status = (int) $code;
		return $this;
	}

	/**
	 * @param  string $value The content type value
	 * @return string        The content type (get)
	 * @return \Cog\Response $this (set)
	 */
	public function contentType($value = null)
	{
		if ($value === null)
		{
			return $this->header('Content-Type');
		}

		$this->offsetSet('Content-Type', $value);
		return $this;
	}

	/**
	 * @return int
	 */
	public function contentLength()
	{
		return (int) $this->length;
	}

	/**
	 * @param  string $path  A new location (for redirects)
	 * @return string        The current location path or null (get)
	 * @return \Cog\Response $this (set)
	 */
	public function location($path = null)
	{
		if ($path === null)
		{
			return $this->header('Location');
		}

		$this->offsetSet('Location', $path);
		return $this;
	}

	/**
	 * @param  string $name    The header name
	 * @param  mixed  $default The default value to use if the header is not found
	 * @return mixed
	 */
	public function header($name, $default = null)
	{
		if ($this->offsetExists($name))
		{
			$default = $this->offsetGet($name);
		}

		return $default;
	}

	/** Implementing ArrayAccess */

	public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->headers);
	}

	public function offsetGet($offset)
	{
		return $this->headers[$offset];
	}

	public function offsetSet($offset, $value)
	{
		$this->headers[$offset] = $value;
	}

	public function offsetUnset($offset)
	{
		unset($this->headers[$offset]);
	}

}
