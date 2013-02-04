<?php

namespace Cog;

/**
 * The HTTP Response object
 *
 * @package Cog
 */
class Response implements \ArrayAccess
{
	protected $length = 0;

	private $body;

	private $status;

	private $headers;

	public function body($content = null)
	{
		if ($content === null)
		{
			return $this->body;
		}

		$this->body = "";
		$this->write($content);
	}

	public function write($str)
	{
		$this->body .= $str;
		$this->length = \strlen($this->body);
	}

	public function content_type(){}

	public function content_length(){}

	public function location(){}

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
