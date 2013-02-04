<?php

class App implements \Cog\Middleware
{
	public function call($request, $response)
	{
		$response->write('Hi');
		return $response;
	}

}