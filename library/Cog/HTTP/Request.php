<?php

namespace Cog\HTTP;

/**
 * Interface for HTTP Requests
 *
 * @package Cog
 */
interface Request extends Message
{
	/**
	 * @return string  The current request method
	 */
	public function getMethod();

	/**
	 * @param  string $method     The request method
	 * @return \Cog\HTTP\Request  $this
	 */
	public function setMethod($method);

}
