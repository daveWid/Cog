<?php

namespace Cog;

/**
 * An abstract implementation of the HTTP Message interface
 *
 * @package Cog
 */
abstract class AbstractMessage implements HTTP\Message
{
	/**
	 * @var string  HTTP Protocol version
	 */
	private $protocol = "1.1";

	/**
	 * @var \Cog\Hash  The HTTP Headers
	 */
	protected $headers = null;

	/**
	 * @var string  The HTTP Message body
	 */
	protected $body = "";

/* =====================
   \Cog\HTTP\Message
   ===================== */

   	/**
	 * {@inheritDoc}
	 */
	public function getProtocol()
	{
		return $this->protocol;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setProtocol($protocol)
	{
		$this->protocol = $protocol;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getHeaders()
	{
		return $this->headers->toArray();
	}

	/**
	 * {@inheritDoc}
	 */
	public function setHeaders(array $headers)
	{
		$this->headers = new \Cog\Hash($headers);
		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function addHeaders(array $headers)
	{
		$this->headers->setArray($headers);
		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getHeader($name, $default = null)
	{
		if ($this->headers->offsetExists($name))
		{
			$default = $this->headers->offsetGet($name);
		}

		return $default;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setHeader($name, $value)
	{
		$this->headers->set($name, $value);
		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setBody($body)
	{
		$this->body = $body;
		return $this;
	}

}
