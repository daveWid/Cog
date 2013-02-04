<?php

namespace Cog;

/**
 * The interface used in Middleware classes
 *
 * @package  Cog
 */
interface Middleware
{
	/**
	 * Calls the part of middleware.
	 *
	 * @param  mixed $request  The request object to process
	 * @param  mixed $response The response object
	 * @return mixed           The response object (modified if necessary)
	 */
	public function call($request, $response);

}
