<?php

namespace Cog;

/**
 * The HTTP Response object
 *
 * @package Cog
 */
class Response extends AbstractMessage implements HTTP\Response, \ArrayAccess
{
	/**
	 * @var int  The body length
	 */
	protected $length = 0;

	/**
	 * @var int  Defaults to 200 (good response)
	 */
	private $status = 200;

	/**
	 * @param string  $body    The response body
	 * @param integer $status  The status code
	 * @param array   $headers Response headers
	 */
	public function __construct($body = null, $status = 200, $headers = array())
	{
		$this->setBody($body);
		$this->setStatus($status);
		$this->setHeaders($headers);
	}

	/**
	 * {@inheritDoc}
	 */
	public function setBody($body)
	{
		$this->body = "";
		$this->appendBody($body);
		return $this;
	}

	/**
	 * @param  string $str Content to append to the body
	 */
	public function appendBody($str)
	{
		$this->body .= $str;
		$this->length = \strlen($this->body);
	}

	/**
	 * @return string   The content type
	 */
	public function getContentType()
	{
		return $this->headers->get('Content-Type');
	}

	/**
	 * @param  string $value   The content type value
	 * @return \Cog\Response   $this
	 */
	public function setContentType($type)
	{
		$this->headers->offsetSet('Content-Type', $type);
		return $this;
	}

	/**
	 * @return int
	 */
	public function getContentLength()
	{
		return (int) $this->length;
	}

	/**
	 * @param  string $path    A new location (for redirects)
	 * @return \Cog\Response   $this (set)
	 */
	public function setLocation($path)
	{
		$this->headers->offsetSet('Location', $path);
		return $this;
	}

/** ====================
    ArrayAccess
    ==================== */

	public function offsetExists($offset)
	{
		return $this->headers->offsetExists($offset);
	}

	public function offsetGet($offset)
	{
		return $this->headers->offsetGet($offset);
	}

	public function offsetSet($offset, $value)
	{
		$this->headers->offsetSet($offset, $value);
	}

	public function offsetUnset($offset)
	{
		$this->headers->offsetUnset($offset);
	}

/** =======================
    \Cog\HTTP\Message
    ======================= */

	/**
	 * {@inheritDoc}
	 */
	public function __toString()
	{
		return ""; // Fix this....
	}

/** =======================
    \Cog\HTTP\Response
    ======================= */

	/**
	 * {@inheritDoc}
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setStatus($code)
	{
		$this->status = $code;
		return $this;
	}

}
