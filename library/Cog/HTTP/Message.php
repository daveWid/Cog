<?php

namespace Cog\HTTP;

/**
 * Interface for all HTTP messages.
 *
 * @package Cog
 */
interface Message
{
	/**
	 * @return string  The HTTP protocol version (i.e. 1.1).
	 */
	public function getProtocol();

	/**
	 * @param string $protocol HTTP protocol number (i.e 1.1)
	 */
	public function setProtocol($protocol);

	/**
	 * @return array  The headers for the message
	 */
	public function getHeaders();

	/**
	 * Replaces old headers with the passed in headers. If you want to add
	 * please use addHeaders
	 *
	 * @param  array $headers       A list of headers to set
	 * @return \Cog\HTTP\Message    $this (for chaining)
	 */
	public function setHeaders(array $headers);

	/**
	 * Adds headers to the existing headers. If you want to bulk replace use
	 * setHeaders
	 *
	 * @param  array $headers       A list of headers to set
	 * @return \Cog\HTTP\Message    $this (for chaining)
	 */
	public function addHeaders(array $headers);

	/**
	 * @param  string $name     The header name to get
	 * @param  mixed  $default  The default value if the header isn't found
	 * @return mixed            The header value or the specified default value
	 */
	public function getHeader($name, $default = null);

	/**
	 * @param  string $name       The header name
	 * @param  mixed  $value      The header value
	 * @return \Cog\HTTP\Message  $this (for chaining)
	 */
	public function setHeader($name, $value);

	/**
	 * @return string  The body of the HTTP Message
	 */
	public function getBody();

	/**
	 * @param string $body The body of the HTTP Message
	 */
	public function setBody($body);

	/**
	 * @return string  The HTTP message as a string
	 */
	public function __toString();

}
