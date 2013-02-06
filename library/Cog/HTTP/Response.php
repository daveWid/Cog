<?php

namespace Cog\HTTP;

/**
 * Interface for HTTP Response Messages
 *
 * @package  Cog
 */
interface Response extends Message
{
	/**
	 * @return int  The status code for the response
	 */
	public function getStatus();

	/**
	 * @param  $code int           The status to set
	 * @return \Cog\HTTP\Response  $this
	 */
	public function setStatus($code);

}
